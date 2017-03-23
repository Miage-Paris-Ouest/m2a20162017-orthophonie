<?php
/**
 * Created by PhpStorm.
 * User: davidlou
 * Date: 19/04/2016
 * Time: 23:23
 */

namespace UPOND\OrthophonieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UPOND\OrthophonieBundle\Entity\Exercice;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use UPOND\OrthophonieBundle\Entity\Partie;
use UPOND\OrthophonieBundle\Entity\Patient;


class PhasesController extends Controller
{

    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $em = $this->getDoctrine()->getManager();
            $request = $this->container->get('request');
            $idUser = $this->container->get('security.context')->getToken()->getUser()->getId();
            $MedecinRepository = $em->getRepository('UPONDOrthophonieBundle:Medecin');
            $idMedecinUser = $MedecinRepository->findBy(array('utilisateur' => $idUser));
            $session = $request->getSession();
            if (isset($idMedecinUser) && !empty($idMedecinUser)) {
                $session->set('role', 'medecin');
            } else {
                $session->set('role', 'patient');
            }

        }
        return $this->render('UPONDOrthophonieBundle::index.html.twig');
        /*else{
            http_redirect($this->generateUrl('fos_user_security_login'));
        }*/

    }

    public function phasesAction()
    {
        return $this->render('UPONDOrthophonieBundle:Phases:phases.html.twig');
    }

    public function transfertAction(Request $request)
    {

        return $this->render('UPONDOrthophonieBundle:Phases:transfert.html.twig');
    }

    public function statsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $utilisateur = $this->container->get('security.context')->getToken()->getUser();
        $graphs = array();

        if ($request->getSession()->get('role') != 'patient') {
            $patient = $em->getRepository(Patient::class)->findOneBy(['utilisateur' => $utilisateur]);
            $parties = $em->getRepository(Partie::class)->findBy(['patient' => $patient]);

            $query = $em->getRepository(Exercice::class)->createQueryBuilder('n');
            $exos = $query->where($query->expr()->in('n.partie', ':parties'))->setParameter('parties', $parties)->getQuery()->getResult();

            // Generation du tableau pour le graphe //
            $graph = [];
            foreach ($exos as $exo) {
                $time = $exo->getDateCreation()->getTimestamp();
                if($exo->getNbQuestionValidee() == 0)
                    continue;
                if(!array_key_exists($time, $graph)) {
                    $graph[$time] = [$exo->getNbBonneReponse() / $exo->getNbQuestionValidee()];
                } else {
                    array_push($graph[$time], $exo->getNbBonneReponse() / $exo->getNbQuestionValidee());
                }
            }
            $graph = array_map(function($o) {return array_sum($o) / count($o);}, $graph);
           $graphs[$utilisateur] = $graph;
        }
        elseif($request->getSession()->get('role') != 'medecin'){
            $patient = $em->getRepository(Patient::class)->findOneBy(['utilisateur' => $utilisateur]);
            $parties = $em->getRepository(Partie::class)->findBy(['patient' => $patient]);

            $query = $em->getRepository(Exercice::class)->createQueryBuilder('n');
            $exos = $query->where($query->expr()->in('n.partie', ':parties'))->setParameter('parties', $parties)->getQuery()->getResult();

            // Generation du tableau pour le graphe //
            $graph = [];
            foreach ($exos as $exo) {
                $time = $exo->getDateCreation()->getTimestamp();
                if($exo->getNbQuestionValidee() == 0)
                    continue;
                if(!array_key_exists($time, $graph)) {
                    $graph[$time] = [$exo->getNbBonneReponse() / $exo->getNbQuestionValidee()];
                } else {
                    array_push($graph[$time], $exo->getNbBonneReponse() / $exo->getNbQuestionValidee());
                }
            }
            $graph = array_map(function($o) {return array_sum($o) / count($o);}, $graph);
            $graphs[$patient->getUtilisateur()->getNom()] = $graph;
        }

        print_r($graphs);
        return $this->render('UPONDOrthophonieBundle:Stats:stats.html.twig', 
            ['exercices' => $exos,
             'graph' => $graphs]);
    }

    /**
     * @Route("/exercice", name="upond_orthophonie_exercice")
     */
    public function exerciceAction(Request $request)
    {
        // on récupere tous les ID de la table Question
        $em = $this
            ->getDoctrine()
            ->getManager();
        $query = $em->createQuery(
            'SELECT q.idQuestion
            FROM UPONDOrthophonieBundle:Question q'
        );

        $questions = $query->getResult();

        $repository = $em
            ->getRepository('UPONDOrthophonieBundle:Question')
        ;
        // on prend un id aléatoire parmi les résultats
        $idQuestion = array_rand($questions);
        // on récupere l'entité de l'ID
        $question = $repository->findOneByIdQuestion($idQuestion);
        // on récupere le multimedia associé
        $multimedia = $question->getMultimedia();

        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class);

        // On ajoute les champs que l'on veut à notre formulaire
        $formBuilder
            ->add('BonneReponse', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-success')))
            ->add('MauvaiseReponse', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-danger')));

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // si on clique un des deux boutons de validation, on ajoute la bonne/mauvaise réponse dans la base
        if ($form->handleRequest($request)->isValid()) {

            // si c'est le bouton "Bonne réponse"
            if ($form->get('BonneReponse')->isClicked()) {
                $request->getSession()->getFlashBag()->add('reponse', 'Bonne réponse.');
            }

            // si c'est le bouton "Mauvaise réponse"
            if ($form->get('MauvaiseReponse')->isClicked()) {
                $request->getSession()->getFlashBag()->add('reponse', 'Mauvaise réponse.');
            }
        }
        
        return $this->render('UPONDOrthophonieBundle:Phases:exercice.html.twig', array('question' => $question, 'multimedia' => $multimedia, 'form' => $form->createView()));
    }
}