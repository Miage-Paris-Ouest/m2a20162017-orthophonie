<?php
/**
 * Created by PhpStorm.
 * User: davidlou
 * Date: 24/04/2016
 * Time: 14:55
 */

namespace UPOND\OrthophonieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UPOND\OrthophonieBundle\Entity\Etape;
use UPOND\OrthophonieBundle\Entity\Exercice;
use UPOND\OrthophonieBundle\Entity\Multimedia;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use UPOND\OrthophonieBundle\Repository\EtapeRepository;
use UPOND\OrthophonieBundle\Repository\ExerciceRepository;
use UPOND\OrthophonieBundle\Repository\MultimediaRepository;
use UPOND\OrthophonieBundle\Repository\PatientRepository;
use UPOND\OrthophonieBundle\Entity\Partie;

class PartieController extends Controller
{

    public function indexAction()
    {
        return $this->render('UPONDOrthophonieBundle::index.html.twig');
    }


    public function startAction(Request $request)
    {

        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class);

        // On ajoute les champs que l'on veut à notre formulaire
        $formBuilder
            ->add('Patient', 'entity', array(
                'class'    => 'UPONDOrthophonieBundle:Patient',
                'property' => 'NomEtPrenom',
                'multiple' => false,
                'attr' => array('class' => 'form-control')
            ))
            ->add('TempsEntrainement', TimeType::class, array(
                'input' => 'datetime',
                'widget' => 'choice',
                'with_minutes' => 'true',
                'with_seconds' => 'true',
                'attr' => array('class' => 'form-control')
            ))
            ->add('TempsTransfert', TimeType::class, array(
                'input' => 'datetime',
                'widget' => 'choice',
                'with_minutes' => 'true',
                'with_seconds' => 'true',
                'attr' => array('class' => 'form-control')
            ))
            ->add('Valider', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-primary')));


        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();


        // si on valide le formulaire
        if ($form->handleRequest($request)->isValid()) {


            //transformer la saisie heure/min/secondes en secondes uniquement
            $donneesForm = $form->getData();
            sscanf($donneesForm['TempsEntrainement']->format('H:i:s'), "%d:%d:%d", $hours, $minutes, $seconds);

            $time_seconds_entrainement = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

            sscanf($donneesForm['TempsTransfert']->format('H:i:s'), "%d:%d:%d", $hours, $minutes, $seconds);

            $time_seconds_transfert = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

            // on initalise nos repositories
            $em = $this
                ->getDoctrine()
                ->getManager();

            $repositoryPhase = $em
                ->getRepository('UPONDOrthophonieBundle:Phase');
            $repositoryStrategie = $em
                ->getRepository('UPONDOrthophonieBundle:Strategie');

            // on récupere l'entité du patient
            $patient = $donneesForm['Patient'];

            // on créé une nouvelle partie
            $partie = new Partie();
            $partie->setPatient($patient);
            $partie->setDateCreation(new \DateTime());

            // on ajoute la partie dans la bdd
            $em = $this->getDoctrine()->getManager();
            $em->persist($partie);
            $em->flush();

            // on va créer des exercices et les lier à la partie

            //phase d'apprentissage
            $phase = $repositoryPhase->findOneByNom("Apprentissage");
            // niveau 1
            $niveau = 1;
            //strategie: Metiers
            $strategie = $repositoryStrategie->findOneByNom("Métier");

            $exerciceApprentissage = new Exercice();
            $exerciceApprentissage = $this->initializeExerciceApprentissage($exerciceApprentissage, $phase, $strategie, $partie, $niveau);

            $em->persist($exerciceApprentissage);

            $em->flush();

            //strategie: Morphologie
            $strategie = $repositoryStrategie->findOneByNom("Morphologie");

            $exerciceApprentissage = new Exercice();
            $exerciceApprentissage = $this->initializeExerciceApprentissage($exerciceApprentissage, $phase, $strategie, $partie, $niveau);

            $em->persist($exerciceApprentissage);
            $em->flush();
            //strategie: Morphologie inverse
            $strategie = $repositoryStrategie->findOneByNom("Morphologie inverse");

            $exerciceApprentissage = new Exercice();
            $exerciceApprentissage = $this->initializeExerciceApprentissage($exerciceApprentissage, $phase, $strategie, $partie, $niveau);

            $em->persist($exerciceApprentissage);
            $em->flush();

            //strategie: Association d'idées
            $strategie = $repositoryStrategie->findOneByNom("Association d'idées");

            $exerciceApprentissage = new Exercice();
            $exerciceApprentissage = $this->initializeExerciceApprentissage($exerciceApprentissage, $phase, $strategie, $partie, $niveau);

            $em->persist($exerciceApprentissage);
            $em->flush();

            //strategie: Phoneme
            $strategie = $repositoryStrategie->findOneByNom("Phoneme");

            $exerciceApprentissage = new Exercice();
            $exerciceApprentissage = $this->initializeExerciceApprentissage($exerciceApprentissage, $phase, $strategie, $partie, $niveau);

            $em->persist($exerciceApprentissage);
            $em->flush();

            // phase d'apprentissage niveau 2
            // on reprend la fonction d'initalisation d'exercice d'entrainement
            $niveau = 2;
                
            //strategie: Metiers
            $strategie = $repositoryStrategie->findOneByNom("Métier");

            $exerciceApprentissage = new Exercice();
            $exerciceApprentissage = $this->initializeExerciceApprentissageNiveau2($exerciceApprentissage, $phase, $strategie, $partie, $niveau);

            $em->persist($exerciceApprentissage);

            $em->flush();

            //strategie: Morphologie
            $strategie = $repositoryStrategie->findOneByNom("Morphologie");

            $exerciceApprentissage = new Exercice();
            $exerciceApprentissage = $this->initializeExerciceApprentissageNiveau2($exerciceApprentissage, $phase, $strategie, $partie, $niveau);

            $em->persist($exerciceApprentissage);
            $em->flush();

            //strategie: Morphologie inverse
            $strategie = $repositoryStrategie->findOneByNom("Morphologie inverse");

            $exerciceApprentissage = new Exercice();
            $exerciceApprentissage = $this->initializeExerciceApprentissageNiveau2($exerciceApprentissage, $phase, $strategie, $partie, $niveau);

            $em->persist($exerciceApprentissage);
            $em->flush();

            //strategie: Association d'idées
            $strategie = $repositoryStrategie->findOneByNom("Association d'idées");

            $exerciceApprentissage = new Exercice();
            $exerciceApprentissage = $this->initializeExerciceApprentissageNiveau2($exerciceApprentissage, $phase, $strategie, $partie, $niveau);

            $em->persist($exerciceApprentissage);
            $em->flush();

            //strategie: Phoneme
            $strategie = $repositoryStrategie->findOneByNom("Phoneme");

            $exerciceApprentissage = new Exercice();
            $exerciceApprentissage = $this->initializeExerciceApprentissageNiveau2($exerciceApprentissage, $phase, $strategie, $partie, $niveau);

            $em->persist($exerciceApprentissage);
            $em->flush();
            

            //phase d'entrainement, on recupere les questions de la phase d'apprentissage
            // niveau 1
            $niveau = 1;
            $phase = $repositoryPhase->findOneByNom("Entrainement");
            //strategie: Metiers
            $strategie = $repositoryStrategie->findOneByNom("Métier");

            $exerciceEntrainement = new Exercice();
            $exerciceEntrainement = $this->initializeExerciceEntrainement($exerciceEntrainement, $phase, $strategie, $partie, $time_seconds_entrainement, $niveau);

            $em->persist($exerciceEntrainement);
            $em->flush();

            //strategie: Morphologie
            $strategie = $repositoryStrategie->findOneByNom("Morphologie");

            $exerciceEntrainement = new Exercice();
            $exerciceEntrainement = $this->initializeExerciceEntrainement($exerciceEntrainement, $phase, $strategie, $partie, $time_seconds_entrainement, $niveau);

            $em->persist($exerciceEntrainement);
            $em->flush();

            //strategie: Morphologie inverse
            $strategie = $repositoryStrategie->findOneByNom("Morphologie inverse");

            $exerciceEntrainement = new Exercice();
            $exerciceEntrainement = $this->initializeExerciceEntrainement($exerciceEntrainement, $phase, $strategie, $partie, $time_seconds_entrainement, $niveau);

            $em->persist($exerciceEntrainement);
            $em->flush();

            //strategie: Association d'idées
            $strategie = $repositoryStrategie->findOneByNom("Association d'idées");

            $exerciceEntrainement = new Exercice();
            $exerciceEntrainement = $this->initializeExerciceEntrainement($exerciceEntrainement, $phase, $strategie, $partie, $time_seconds_entrainement, $niveau);

            $em->persist($exerciceEntrainement);
            $em->flush();

            //strategie: Phoneme
            $strategie = $repositoryStrategie->findOneByNom("Phoneme");

            $exerciceEntrainement = new Exercice();
            $exerciceEntrainement = $this->initializeExerciceEntrainement($exerciceEntrainement, $phase, $strategie, $partie, $time_seconds_entrainement, $niveau);

            $em->persist($exerciceEntrainement);
            $em->flush();
            

            // faire une phase d'entrainement en mélangeant les stratégies

            $strategie = $repositoryStrategie->findOneByNom("Aléatoire");
            $niveau = 2;
            $exerciceEntrainement = new Exercice();
            $exerciceEntrainement = $this->initializeExerciceEntrainementAleatoire($exerciceEntrainement, $phase, $strategie, $partie, $time_seconds_entrainement, $niveau);

            $em->persist($exerciceEntrainement);
            $em->flush();


            // phase de transfert
            $phase = $repositoryPhase->findOneByNom("Transfert");
            // strategie random
            $strategie = $repositoryStrategie->findOneByNom("Aléatoire");

            $exerciceTransfert = new Exercice();
            $exerciceTransfert = $this->initializeExerciceTransfert($exerciceTransfert, $phase, $strategie, $partie, $time_seconds_transfert);

            $em->persist($exerciceTransfert);
            $em->flush();


            return $this->redirect($this->generateUrl('upond_orthophonie_home'));
        }

        // À ce stade :
        // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - Soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau
        return $this->render('UPONDOrthophonieBundle:Partie:partie.html.twig', array(
            'form' => $form->createView(),
        ));

    }



    public function initializeExerciceApprentissage($exercice, $phase, $strategie, $partie, $niveau)
    {

        $em = $this->getDoctrine()->getManager();
        $MultimediaRepository = $em->getRepository('UPONDOrthophonieBundle:Multimedia');

        $exercice->setNbBonneReponse(0);
        $exercice->setNbQuestionValidee(0);
        $exercice->setPartie($partie);
        $exercice->setStrategie($strategie);
        $exercice->setNiveau($niveau);
        $exercice->setPhase($phase);
        $exercice->setDateCreation(new \DateTime());
        $i = 1;

        $listMultimedia = $MultimediaRepository->get7MultimediaAleatoire($strategie);
        foreach($listMultimedia as $multimedia)
        {
            if ($i%2 == 0)
            {
                //on ajoute le multimedia seul
                $etape = new Etape();
                $etape->setExercice($exercice);
                $etape->setBonneReponse(false);
                $etape->addMultimedia($multimedia);

                $etape->setNumEtape($i);
                $em->persist($etape);
                $exercice->addEtape($etape);
                $i++;


                //on ajoute une nouvelle etape avec les multimedias du début jusqu'au multimedia courant
                $etape2 = new Etape();
                $etape2->setExercice($exercice);
                $etape2->setBonneReponse(false);
                foreach($listMultimedia as $multimedia2) {
                    $etape2->addMultimedia($multimedia2);
                    if ($multimedia2 == $multimedia)
                    {
                        break;
                    }
                }

                $etape2->setNumEtape($i);
                $em->persist($etape2);
                $exercice->addEtape($etape2);
                $i++;
            }
            // on ajoute le multimedia
            // si on est a la premiere etape, on ajoute que la premiere image
            if ($i == 1)
            {
                $etape = new Etape();
                $etape->setExercice($exercice);
                $etape->setBonneReponse(false);

                $etape->addMultimedia($multimedia);
                $exercice->setEtapeCourante($etape);

                $etape->setNumEtape($i);
                $em->persist($etape);
                $exercice->addEtape($etape);
                $i++;
            }


        }
        return $exercice;
    }


    public function initializeExerciceApprentissageNiveau2($exercice, $phase, $strategie, $partie, $niveau)
    {

        $em = $this->getDoctrine()->getManager();
        $ExerciceRepository = $em->getRepository('UPONDOrthophonieBundle:Exercice');

        $exercice->setNbBonneReponse(0);
        $exercice->setNbQuestionValidee(0);
        $exercice->setPartie($partie);
        $exercice->setStrategie($strategie);
        $exercice->setNiveau($niveau);
        $exercice->setPhase($phase);
        $exercice->setDateCreation(new \DateTime());
        $i = 1;

        $exerciceTemporaire = $ExerciceRepository->getExerciceByStrategieAndPartieAndNiveau($strategie, $partie, 1);

        foreach($exerciceTemporaire->getEtapes() as $etapeTemporaire)
        {
            $multimedias = $etapeTemporaire->getMultimedias();

            $etape = new Etape();
            $etape->setExercice($exercice);
            foreach($multimedias as $multimedia)
            {
                $etape->addMultimedia($multimedia);
            }
            $etape->setBonneReponse(false);
            $etape->setNumEtape($i);

            $em->persist($etape);

            if ($i == 1 )
            {
                $exercice->setEtapeCourante($etape);
            }

            $exercice->addEtape($etape);
            $i++;
        }
        return $exercice;
    }
    
    public function initializeExerciceEntrainement($exercice, $phase, $strategie, $partie, $temps, $niveau)
    {

        $em = $this->getDoctrine()->getManager();
        $ExerciceRepository = $em->getRepository('UPONDOrthophonieBundle:Exercice');

        $exercice->setNbBonneReponse(0);
        $exercice->setNbQuestionValidee(0);
        $exercice->setPartie($partie);
        $exercice->setStrategie($strategie);
        $exercice->setNiveau($niveau);
        $exercice->setPhase($phase);
        $exercice->setTempsExercice($temps);
        $exercice->setTempsEcoule(0);
        $exercice->setDateCreation(new \DateTime());
        $i = 1;
        $exerciceTemporaire = $ExerciceRepository->getExerciceByStrategieAndPartieAndNiveau($strategie, $partie, 1);

        foreach($exerciceTemporaire->getEtapes() as $etapeTemporaire)
        {
            $multimedias = $etapeTemporaire->getMultimedias();

            $etape = new Etape();
            $etape->setExercice($exercice);
            foreach($multimedias as $multimedia)
            {
                $etape->addMultimedia($multimedia);
            }
            $etape->setBonneReponse(false);
            $etape->setNumEtape($i);

            $em->persist($etape);

            if ($i == 1 )
            {
                $exercice->setEtapeCourante($etape);
            }

            $exercice->addEtape($etape);
            $i++;
        }
        return $exercice;
    }

    public function initializeExerciceEntrainementAleatoire($exercice, $phase, $strategie, $partie, $temps, $niveau)
    {
        $em = $this->getDoctrine()->getManager();
        $MultimediaRepository = $em->getRepository('UPONDOrthophonieBundle:Multimedia');

        $exercice->setNbBonneReponse(0);
        $exercice->setNbQuestionValidee(0);
        $exercice->setPartie($partie);
        $exercice->setStrategie($strategie);
        $exercice->setNiveau($niveau);
        $exercice->setPhase($phase);
        $exercice->setTempsExercice($temps);
        $exercice->setTempsEcoule(0);
        $exercice->setDateCreation(new \DateTime());
        $i=1;

        $phaseApprentissage = $em->getRepository('UPONDOrthophonieBundle:Phase')->findByNom("Apprentissage");
        $multimedias = $MultimediaRepository->getIdMultimediaFromPartieAndPhase($partie->getIdPartie(), $phaseApprentissage);

        // on prend un id aléatoire parmi les résultats
        $idMultimedia = array_rand($multimedias, 7);
        $arrayMultimedia = array();
        foreach($idMultimedia as $element)
        {
            $arrayMultimedia[] = $multimedias[$element];
        }

        $listMultimedias = $MultimediaRepository->getMultimediaInArrayOfIdMultimedia($arrayMultimedia);

        foreach($listMultimedias as $multimedia) {
            if ($i % 2 == 0) {
                //on ajoute le multimedia seul
                $etape = new Etape();
                $etape->setExercice($exercice);
                $etape->setBonneReponse(false);
                $etape->addMultimedia($multimedia);

                $etape->setNumEtape($i);
                $em->persist($etape);
                $exercice->addEtape($etape);
                $i++;


                //on ajoute une nouvelle etape avec les multimedias du début jusqu'au multimedia courant
                $etape2 = new Etape();
                $etape2->setExercice($exercice);
                $etape2->setBonneReponse(false);
                foreach ($listMultimedias as $multimedia2) {
                    $etape2->addMultimedia($multimedia2);
                    if ($multimedia2 == $multimedia) {
                        break;
                    }
                }

                $etape2->setNumEtape($i);
                $em->persist($etape2);
                $exercice->addEtape($etape2);
                $i++;
            }
            // on ajoute le multimedia
            // si on est a la premiere etape, on ajoute que la premiere image
            if ($i == 1) {
                $etape = new Etape();
                $etape->setExercice($exercice);
                $etape->setBonneReponse(false);

                $etape->addMultimedia($multimedia);
                $exercice->setEtapeCourante($etape);

                $etape->setNumEtape($i);
                $em->persist($etape);
                $exercice->addEtape($etape);
                $i++;
            }
        }

        return $exercice;
    }

    public function initializeExerciceTransfert($exercice, $phase, $strategie, $partie, $temps)
    {
        $em = $this->getDoctrine()->getManager();
        $MultimediaRepository = $em->getRepository('UPONDOrthophonieBundle:Multimedia');

        $exercice->setNbBonneReponse(0);
        $exercice->setNbQuestionValidee(0);
        $exercice->setPartie($partie);
        $exercice->setStrategie($strategie);
        $exercice->setNiveau(0);
        $exercice->setPhase($phase);
        $exercice->setTempsExercice($temps);
        $exercice->setTempsEcoule(0);
        $exercice->setDateCreation(new \DateTime());
        $i=1;

        $phaseApprentissage = $em->getRepository('UPONDOrthophonieBundle:Phase')->findByNom("Apprentissage");
        $multimedias = $MultimediaRepository->getIdMultimediaFromPartieAndPhase($partie->getIdPartie(), $phaseApprentissage);

        // on récupere l'entité de l'ID
        $listMultimedias= $MultimediaRepository->getMultimediaNotInArrayOfIdMultimedia($multimedias);

        // on prend un id aléatoire parmi les résultats
        $idMultimediaRandom = array_rand($listMultimedias, 7);
        $arrayMultimedia = array();
        foreach($idMultimediaRandom as $element)
        {
            $arrayMultimedia[] = $listMultimedias[$element];
        }

        // on récupere l'entité de l'ID
        $listMultimediasRandom = $MultimediaRepository->getMultimediaInArrayOfIdMultimedia($arrayMultimedia);

        foreach($listMultimediasRandom as $multimedia) {
            if ($i % 2 == 0) {
                //on ajoute le multimedia seul
                $etape = new Etape();
                $etape->setExercice($exercice);
                $etape->setBonneReponse(false);
                $etape->addMultimedia($multimedia);

                $etape->setNumEtape($i);
                $em->persist($etape);
                $exercice->addEtape($etape);
                $i++;


                //on ajoute une nouvelle etape avec les multimedias du début jusqu'au multimedia courant
                $etape2 = new Etape();
                $etape2->setExercice($exercice);
                $etape2->setBonneReponse(false);
                foreach ($listMultimediasRandom as $multimedia2) {
                    $etape2->addMultimedia($multimedia2);
                    if ($multimedia2 == $multimedia) {
                        break;
                    }
                }

                $etape2->setNumEtape($i);
                $em->persist($etape2);
                $exercice->addEtape($etape2);
                $i++;
            }
            // on ajoute le multimedia
            // si on est a la premiere etape, on ajoute que la premiere image
            if ($i == 1) {
                $etape = new Etape();
                $etape->setExercice($exercice);
                $etape->setBonneReponse(false);

                $etape->addMultimedia($multimedia);
                $exercice->setEtapeCourante($etape);

                $etape->setNumEtape($i);
                $em->persist($etape);
                $exercice->addEtape($etape);
                $i++;
            }
        }

        return $exercice;
    }
}