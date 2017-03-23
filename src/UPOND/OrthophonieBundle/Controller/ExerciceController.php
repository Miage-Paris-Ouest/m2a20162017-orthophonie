<?php
/**
 * Created by PhpStorm.
 * User: davidlou
 * Date: 02/05/2016
 * Time: 14:36
 */

namespace UPOND\OrthophonieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use UPOND\OrthophonieBundle\Entity\Multimedia;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use UPOND\OrthophonieBundle\Repository\PartieRepository;
use UPOND\OrthophonieBundle\Repository\PatientRepository;


class ExerciceController extends Controller
{
    public function selectPartieAction(Request $request)
    {
        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class);

        // On ajoute les champs que l'on veut à notre formulaire
        $formBuilder
            ->add('Partie', 'entity', array(
                'class'    => 'UPONDOrthophonieBundle:Partie',
                'property' => 'idPartieAndDateCreation',
                'multiple' => false,
                'query_builder' => function(PartieRepository $er) {
                    $em = $this
                        ->getDoctrine()
                        ->getManager();
                    $repositoryPatient = $em
                        ->getRepository('UPONDOrthophonieBundle:Patient')
                    ;
                    $utilisateur = $this->container->get('security.context')->getToken()->getUser();
                    $patient = $repositoryPatient->findOneByUtilisateur($utilisateur);

                    return $er->createQueryBuilder('partie')
                        ->where('partie.patient = :patient')
                        ->setParameter('patient', $patient);

                    },
            ))
            ->add('Lancer', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-success')));

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();


        // si on valide le formulaire
        if ($form->handleRequest($request)->isValid()) {

            $em = $this
                ->getDoctrine()
                ->getManager();

            $repository = $em
                ->getRepository('UPONDOrthophonieBundle:Strategie')
            ;

            $donneesForm = $form->getData();
            $session = $request->getSession();
            // stocker une variable de session pour la partie
            $session->set('partie', $donneesForm['Partie']);
            // on créé une variable session pour savoir si on doit afficher toutes les etapes jusqu'a une etape précise, ou bien juste une seule étape
            $session->set('AfficherToutesEtapes', false);
            
            // on stocke aussi la stratégie utilisée en récupérant l'entité stratégie en fonction du nom
            $strategie = $repository->findOneByNom($request->attributes->get('strategie'));
            $session->set('strategie', $strategie);


            if($request->attributes->get('phase') != null) {
                // on stocke la phase (pour la phase de transfert et entrainement niveau 2 uniquement puisque route directement ici)
                $repositoryPhase = $em
                    ->getRepository('UPONDOrthophonieBundle:Phase')
                ;
                $phase = $repositoryPhase->findOneByNom($request->attributes->get('phase'));
                $session->set('phase', $phase);
                $session->set('niveau', $request->attributes->get('niveau'));

            }

            if($session->get('phase')->getNom() == "Apprentissage" && $session->get('niveau') == "1")
            {
                $session->set('afficherSon', true);
            } else {
                $session->set('afficherSon', false);
            }


            $session->set('TypeAffichage', "Nom");

            return $this->redirect($this->generateUrl('upond_orthophonie_exercice'));

        }

        return $this->render('UPONDOrthophonieBundle:Partie:selectPartie.html.twig', array( 'form' => $form->createView()));
    }

    public function afficherExerciceAction(Request $request)
    {
        $session = $request->getSession();

        // on recupere l'exercice associée a la strategie, la phase, le niveau et la partie
        $em = $this->getDoctrine()->getManager();
        $ExerciceRepository = $em->getRepository('UPONDOrthophonieBundle:Exercice');
        $EtapeRepository = $em->getRepository('UPONDOrthophonieBundle:Etape');
        $MultimediaRepository = $em->getRepository('UPONDOrthophonieBundle:Multimedia');
        $PauseVideoRepository = $em->getRepository('UPONDOrthophonieBundle:PauseVideo');

        $exercice = $ExerciceRepository->getExerciceByPartiePhaseStrategieNiveau($session->get('partie'), $session->get('phase'), $session->get('strategie'), $session->get('niveau'));

        // on recupere l'etape courante de l'exercice
        $etapeCourante = $exercice->getEtapeCourante();
        // on recupere les multimedias de l'etape courante
        $multimedias = $etapeCourante->getMultimedias();

        // on recupere le numero de l'etape de l'etape courante
        $numeroEtape = $etapeCourante->getNumEtape();

        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class);

        // On ajoute les champs que l'on veut à notre formulaire
        $formBuilder
            ->add('MauvaiseReponse', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-danger')))
            ->add('BonneReponse', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-success')));


        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();
        // si on clique un des deux boutons de validation, on ajoute la bonne/mauvaise réponse dans la base
        if ($form->handleRequest($request)->isValid()) {


            // si c'est le bouton "Bonne réponse", on passe a l'etape suivante
            if ($form->get('BonneReponse')->isClicked()) {
                // si la variable de session est PauseVideo
                if ($session->get('TypeAffichage') == "PauseVideo")
                {
                    
                    $session->set('TypeAffichage', "Exercice");
                    return $this->render('UPONDOrthophonieBundle:Exercice:exercice.html.twig', array('multimedias' => $multimedias, 'exercice' => $exercice, 'TypeAffichage' => $session->get('TypeAffichage'), 'afficherSon' => $session->get('afficherSon'), 'form' => $form->createView()));

                }
                // on a 13 etapes maximum
                if ($numeroEtape < 13) {

                    if ($session->get('TypeAffichage') == "Exercice") {
                        // on recupere l'etape suivante
                        $etape_suivante = $EtapeRepository->getEtapeByExerciceAndNumEtape($exercice, $numeroEtape + 1);
                        $exercice->setEtapeCourante($etape_suivante);
                        $exercice->setNbBonneReponse($exercice->getNbBonneReponse()+1);
                        $exercice->setNbQuestionValidee($exercice->getNbQuestionValidee()+1);

                        // on recupere le multimedia de l'etape suivante
                        $multimedias = $etape_suivante->getMultimedias();
                        // on met a jour l'etape courante (bonne réponse)
                        $etapeCourante->setBonneReponse(true);
                        $em->persist($etapeCourante);
                        $em->flush();
                        // on met a jour l'exercice en cours
                        $em->persist($exercice);
                        $em->flush();

                        $session->set('TypeAffichage', "Nom");

                        return $this->render('UPONDOrthophonieBundle:Exercice:exercice.html.twig', array('multimedias' => $multimedias, 'exercice' => $exercice, 'TypeAffichage' => $session->get('TypeAffichage'), 'afficherSon' => $session->get('afficherSon'), 'form' => $form->createView()));

                    }
                    elseif ($session->get('TypeAffichage') == "Nom") {
                        // on recupere le multimedia de l'etape courante
                        $multimedias = $etapeCourante->getMultimedias();
                        $session->set('TypeAffichage', "PauseVideo");

                        // si on doit afficher la pause video
                        // en phase d'entrainement => durée 0 à 5 min
                        if($session->get('phase')->getNom() == "Entrainement" || $session->get('phase')->getNom() == "Apprentissage")
                        {
                            // on recupere une video aleatoire entre 0 et 7 min
                            $pauseVideo = $PauseVideoRepository->getVideoAleatoire(1, 420);
                        }
                        // en phase de transfert => durée 10 à 20 min
                        if($session->get('phase')->getNom() == "Transfert")
                        {
                            // on recupere une video aleatoire entre 7 et 30 min
                            $pauseVideo = $PauseVideoRepository->getVideoAleatoire(1, 1800);
                        }


                    }
                    return $this->render('UPONDOrthophonieBundle:Exercice:exercice.html.twig', array('multimedias' => $multimedias, 'exercice' => $exercice, 'PauseVideo'=> $pauseVideo, 'TypeAffichage' => $session->get('TypeAffichage'), 'afficherSon' => $session->get('afficherSon'), 'form' => $form->createView()));

                }

                // on a 13 etapes maximum, l'exercice est fini
                if ($numeroEtape == 13) {

                    if ($session->get('TypeAffichage') == "Exercice") {
                        // on recupere l'etape suivante
                        $etape_suivante = $EtapeRepository->getEtapeByExerciceAndNumEtape($exercice, $numeroEtape);
                        $exercice->setEtapeCourante($etape_suivante);
                        $exercice->setNbBonneReponse($exercice->getNbBonneReponse()+1);
                        $exercice->setNbQuestionValidee($exercice->getNbQuestionValidee()+1);
                        // on met a jour l'etape courante (bonne réponse)
                        $etape_suivante->setBonneReponse(true);

                        $em->persist($etape_suivante);
                        $em->flush();
                        // on met a jour l'exercice en cours
                        $em->persist($exercice);
                        $em->flush();
                        $session->set('TypeAffichage', "Nom");
                        echo "Exercice terminé.";
                        return $this->redirect($this->generateUrl('upond_orthophonie_home'));
                    }
                    elseif ($session->get('TypeAffichage') == "Nom") {
                        // on recupere le multimedia de l'etape courante
                        $multimedias = $etapeCourante->getMultimedias();
                        $session->set('TypeAffichage', "PauseVideo");

                        // si on doit afficher la pause video
                        // en phase d'entrainement => durée 0 à 5 min
                        if($session->get('phase')->getNom() == "Entrainement" || $session->get('phase')->getNom() == "Apprentissage")
                        {
                            // on recupere une video aleatoire entre 0 et 7 min
                            $pauseVideo = $PauseVideoRepository->getVideoAleatoire(1, 420);
                        }
                        // en phase de transfert => durée 10 à 20 min
                        if($session->get('phase')->getNom() == "Transfert")
                        {
                            // on recupere une video aleatoire entre 7 et 30 min
                            $pauseVideo = $PauseVideoRepository->getVideoAleatoire(420, 1800);
                        }
                    }
                    return $this->render('UPONDOrthophonieBundle:Exercice:exercice.html.twig', array('multimedias' => $multimedias, 'exercice' => $exercice, 'PauseVideo'=> $pauseVideo, 'TypeAffichage' => $session->get('TypeAffichage'), 'afficherSon' => $session->get('afficherSon'), 'form' => $form->createView()));

                }


            }

            // si c'est le bouton "Mauvaise réponse", on passe a l'etape précédente
            if ($form->get('MauvaiseReponse')->isClicked()) {
                // on affiche la pause video
                if ($session->get('TypeAffichage') == "PauseVideo")
                {
                    // si on doit afficher la pause video
                    // on recupere une video aleatoire
                    $session->set('TypeAffichage', "Nom");
                    return $this->render('UPONDOrthophonieBundle:Exercice:exercice.html.twig', array('multimedias' => $multimedias, 'exercice' => $exercice, 'TypeAffichage' => $session->get('TypeAffichage'), 'afficherSon' => $session->get('afficherSon'), 'form' => $form->createView()));

                }
                // si on est la premiere etape et que le patient donne une mauvaise réponse, on reste a la premiere etape

                // on a 13 etapes maximum
                if ($numeroEtape <= 13 && $numeroEtape > 1) {
                    // on recupere l'etape précédente
                    $etape_precedente = $EtapeRepository->getEtapeByExerciceAndNumEtape($exercice, $numeroEtape - 1);
                    // on recupere le multimedia de l'etape suivante
                    $multimedias = $etape_precedente->getMultimedias();

                    if ($session->get('TypeAffichage') == "Exercice") {
                        $exercice->setEtapeCourante($etapeCourante);
                        $exercice->setNbQuestionValidee($exercice->getNbQuestionValidee()+1);
                        $multimedias = $etapeCourante->getMultimedias();
                        // on met a jour l'etape courante (mauvaise réponse)
                        $etapeCourante->setBonneReponse(false);
                        $em->persist($etapeCourante);
                        $em->flush();
                        // on met a jour l'exercice en cours
                        $em->persist($exercice);
                        $em->flush();

                        $session->set('TypeAffichage', "Nom");
                    }
                    elseif ($session->get('TypeAffichage') == "Nom") {
                        $exercice->setEtapeCourante($etape_precedente);
                        // on met a jour l'exercice en cours
                        $em->persist($exercice);
                        $em->flush();
                        $session->set('TypeAffichage', "Exercice");
                    }
                    return $this->render('UPONDOrthophonieBundle:Exercice:exercice.html.twig', array('multimedias' => $multimedias, 'exercice' => $exercice, 'TypeAffichage' => $session->get('TypeAffichage'), 'afficherSon' => $session->get('afficherSon'), 'form' => $form->createView()));

                }

                // si on est a l'etape 1, on reste a l'etape 1 (on peut pas aller plus bas)
                if ($numeroEtape == 1) {
                    // on recupere l'etape courante (la premiere)
                    $etape_precedente = $EtapeRepository->getEtapeByExerciceAndNumEtape($exercice, $numeroEtape);

                    // on recupere le multimedia de l'etape
                    $multimedias = $etape_precedente->getMultimedias();

                    if ($session->get('TypeAffichage') == "Exercice") {
                        $exercice->setEtapeCourante($etape_precedente);
                        $exercice->setNbQuestionValidee($exercice->getNbQuestionValidee()+1);
                        // on met a jour l'etape courante (mauvaise réponse)
                        $etape_precedente->setBonneReponse(false);
                        $em->persist($etape_precedente);
                        $em->flush();
                        // on met a jour l'exercice en cours
                        $em->persist($exercice);
                        $em->flush();

                        $session->set('TypeAffichage', "Nom");
                    }
                    elseif ($session->get('TypeAffichage') == "Nom") {
                        $session->set('TypeAffichage', "Exercice");
                    }
                    return $this->render('UPONDOrthophonieBundle:Exercice:exercice.html.twig', array('multimedias' => $multimedias, 'exercice' => $exercice, 'TypeAffichage' => $session->get('TypeAffichage'), 'afficherSon' => $session->get('afficherSon'), 'form' => $form->createView()));

                }
            }
        }

        return $this->render('UPONDOrthophonieBundle:Exercice:exercice.html.twig', array('multimedias' => $multimedias, 'exercice' => $exercice, 'TypeAffichage' => $session->get('TypeAffichage'), 'afficherSon' => $session->get('afficherSon'), 'form' => $form->createView()));

    }

}