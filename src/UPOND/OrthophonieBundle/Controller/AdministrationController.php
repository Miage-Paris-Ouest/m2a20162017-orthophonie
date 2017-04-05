<?php
/**
 * Created by PhpStorm.
 * User: d0ud0o
 * Date: 28/04/2016
 * Time: 23:42
 */

namespace UPOND\OrthophonieBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\SubmitButton;
use UPOND\OrthophonieBundle\Entity\Medecin;
use UPOND\OrthophonieBundle\Entity\Multimedia;
use UPOND\OrthophonieBundle\Entity\Patient;
use UPOND\OrthophonieBundle\Entity\Utilisateur;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use UPOND\OrthophonieBundle\Form\UserSearchType;
use UPOND\OrthophonieBundle\Repository\StrategieRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class AdministrationController extends Controller
{
    public function patientsAction(Request $request)
    {
        dump($this->get('security.token_storage')->getToken());
        $request = $this->container->get('request');
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        // on recupere l'exercice associée a la strategie, la phase, le niveau et la partie
        $em = $this->getDoctrine()->getManager();
        $UtilisateurRepository = $em->getRepository('UPONDOrthophonieBundle:Utilisateur');
        $PatientRepository = $em->getRepository('UPONDOrthophonieBundle:Patient');
        $MedecinRepository = $em->getRepository('UPONDOrthophonieBundle:Medecin');

        $listUtilisateurs = $UtilisateurRepository->findAll();

        $listMedecins = $MedecinRepository->findAll();
        //id de l'utilisateur en session
        $idUser = $this->container->get('security.context')->getToken()->getUser()->getId();
        $idMedecinUser = $MedecinRepository->findBy(array('utilisateur' => $idUser));


        if ($request->getMethod() == 'POST') {
            // on recupere l'id utilisateur via le formulaire POST précédent
            $idPatient = $_POST['idPatient'];
            //recuperation du patient
            $patient = $PatientRepository->find($idPatient);

            $idMed = $_POST['idMedecin'];

            foreach ($listMedecins as $medecin) {
                if ($medecin->getIdMedecin() == $idMed) {
                    $patient->addMedecin($medecin);
                }

            }
            $em->flush();
        }
        //listes des patients non affectés
        $listPatients = $PatientRepository->findUnaffectedPatient();
        //listes des patients du medecin en qui se connecte
        $myPatient = $MedecinRepository->findPatientByMedecin($idMedecinUser);
        return $this->render('UPONDOrthophonieBundle:Administration:patients.html.twig', array('listPatients' => $listPatients, 'listUtilisateurs' => $listUtilisateurs, 'ListMedecins' => $listMedecins, 'ListMyPatient' => $myPatient));
    }

    public function patientsRetireAction(Request $request)
    {
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        $em = $this->getDoctrine()->getManager();
        $UtilisateurRepository = $em->getRepository('UPONDOrthophonieBundle:Utilisateur');
        $PatientRepository = $em->getRepository('UPONDOrthophonieBundle:Patient');
        $MedecinRepository = $em->getRepository('UPONDOrthophonieBundle:Medecin');

        $listUtilisateurs = $UtilisateurRepository->findAll();

        $listMedecins = $MedecinRepository->findAll();
        //id de l'utilisateur en session
        $idUser = $this->container->get('security.context')->getToken()->getUser()->getId();

        $idMedecinUser = $MedecinRepository->findBy(array('utilisateur' => $idUser));


        if ($request->getMethod() == 'POST') {

            // on recupere l'id utilisateur via le formulaire POST précédent
            $idPatient = $_POST['idPatient'];
            // on récupère le patient
            $patient = $PatientRepository->find($idPatient);
            $utilisateur = $UtilisateurRepository->find($idUser);
            $idMedecin = $MedecinRepository->findIdMedecinByRef($utilisateur);

            foreach ($patient->getMedecins() as $medecin) {
                //if ($medecin->getIdMedecin()== (int)$idMedecin){
                if ($medecin->getIdMedecin() == $idMedecin->getIdMedecin()) {
                    $patient->removeMedecin($medecin);
                }
            }

            $em->flush();
        }
        //listes des patients non affectés
        $listPatients = $PatientRepository->findUnaffectedPatient();
        //liste des patients du medecin qui se connecte
        $myPatient = $MedecinRepository->findPatientByMedecin($idMedecinUser);
        return $this->render('UPONDOrthophonieBundle:Administration:patients.html.twig', array('listPatients' => $listPatients, 'listUtilisateurs' => $listUtilisateurs, 'ListMedecins' => $listMedecins, 'ListMyPatient' => $myPatient));
    }

    public function medecinsAction(Request $request)
    {
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        // on recupere l'exercice associée a la strategie, la phase, le niveau et la partie
        $em = $this->getDoctrine()->getManager();
        $UtilisateurRepository = $em->getRepository('UPONDOrthophonieBundle:Utilisateur');
        $PatientRepository = $em->getRepository('UPONDOrthophonieBundle:Patient');
        $MedecinRepository = $em->getRepository('UPONDOrthophonieBundle:Medecin');

        $listUtilisateurs = $UtilisateurRepository->findAll();
        $listPatients = $PatientRepository->findAll();
        $listMedecins = $MedecinRepository->findAll();

        return $this->render('UPONDOrthophonieBundle:Administration:medecins.html.twig', array('listPatients' => $listPatients, 'listUtilisateurs' => $listUtilisateurs, 'listMedecins' => $listMedecins));
    }

    public function medecinsAjoutAction(Request $request)
    {
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        // on recupere l'exercice associée a la strategie, la phase, le niveau et la partie
        $em = $this->getDoctrine()->getManager();
        $UtilisateurRepository = $em->getRepository('UPONDOrthophonieBundle:Utilisateur');
        $PatientRepository = $em->getRepository('UPONDOrthophonieBundle:Patient');
        $MedecinRepository = $em->getRepository('UPONDOrthophonieBundle:Medecin');


        if ($request->getMethod() == 'POST') {
            // on recupere l'id utilisateur via le formulaire POST précédent
            $idUtilisateur = $_POST['idUtilisateur'];
            // on recupere l'entité de l'utilisateur
            $user = $UtilisateurRepository->findOneById($idUtilisateur);

            // on supprime le patient
            $patient = $PatientRepository->findOneByUtilisateur($user);
            $em->remove($patient);

            // on l'ajoute dans les medecins
            $medecin = new Medecin();
            $medecin->setUtilisateur($user);
            $em->persist($medecin);
            $em->flush();

        }

        $listUtilisateurs = $UtilisateurRepository->findAll();
        $listPatients = $PatientRepository->findAll();
        $listMedecins = $MedecinRepository->findAll();

        return $this->render('UPONDOrthophonieBundle:Administration:medecins.html.twig', array('listPatients' => $listPatients, 'listUtilisateurs' => $listUtilisateurs, 'listMedecins' => $listMedecins));
    }

    public function medecinsRetirerAction(Request $request)
    {
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        // on recupere l'exercice associée a la strategie, la phase, le niveau et la partie
        $em = $this->getDoctrine()->getManager();
        $UtilisateurRepository = $em->getRepository('UPONDOrthophonieBundle:Utilisateur');
        $PatientRepository = $em->getRepository('UPONDOrthophonieBundle:Patient');
        $MedecinRepository = $em->getRepository('UPONDOrthophonieBundle:Medecin');


        if ($request->getMethod() == 'POST') {
            // on recupere l'id utilisateur via le formulaire POST précédent
            $idUtilisateur = $_POST['idUtilisateur'];
            // on recupere l'entité de l'utilisateur
            $user = $UtilisateurRepository->findOneById($idUtilisateur);

            // on supprime le patient
            $medecin = $MedecinRepository->findOneByUtilisateur($user);
            $em->remove($medecin);

            // on l'ajoute dans les medecins
            $patient = new Patient();
            $patient->setUtilisateur($user);
            $em->persist($patient);
            $em->flush();

        }

        $listUtilisateurs = $UtilisateurRepository->findAll();
        $listPatients = $PatientRepository->findAll();
        $listMedecins = $MedecinRepository->findAll();

        return $this->render('UPONDOrthophonieBundle:Administration:medecins.html.twig', array('listPatients' => $listPatients, 'listUtilisateurs' => $listUtilisateurs, 'listMedecins' => $listMedecins));
    }

    public function exercicesAction()
    {
        $request = $this->container->get('request');
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        // on recupere l'exercice associée a la strategie, la phase, le niveau et la partie
        $em = $this->getDoctrine()->getManager();
        $MultimediaRepository = $em->getRepository('UPONDOrthophonieBundle:Multimedia');

        $listMultimedias = $MultimediaRepository->findAll();
        return $this->render('UPONDOrthophonieBundle:Administration:exercices.html.twig', array('listMultimedias' => $listMultimedias));
    }

    public function exercicesAjouterAction(Request $request)
    {
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        // on recupere l'exercice associée a la strategie, la phase, le niveau et la partie
        $em = $this->getDoctrine()->getManager();
        $MultimediaRepository = $em->getRepository('UPONDOrthophonieBundle:Multimedia');
        if ($request->getMethod() == 'POST') {
            // on redirige vers un autre controller
            $response = $this->forward('UPONDOrthophonieBundle:Administration:exerciceForm');

            return $response;
        }
        $listMultimedias = $MultimediaRepository->findAll();
        return $this->render('UPONDOrthophonieBundle:Administration:exercices.html.twig', array('listMultimedias' => $listMultimedias));
    }

    public function exercicesModifierAction(Request $request)
    {
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        // on recupere l'exercice associée a la strategie, la phase, le niveau et la partie
        $em = $this->getDoctrine()->getManager();
        $MultimediaRepository = $em->getRepository('UPONDOrthophonieBundle:Multimedia');

        if ($request->getMethod() == 'POST') {
            // on recupere l'id multimedia via le formulaire POST précédent
            $idMultimedia = $_POST['idMultimedia'];
            $session = $request->getSession();
            $session->set('idMultimedia', $idMultimedia);
            $response = $this->forward('UPONDOrthophonieBundle:Administration:exerciceUpdateForm');

            return $response;
            //return $this->render('UPONDOrthophonieBundle:Administration:exercice_form.html.twig', array('form' => $form->createView(),'multimedia' => $multimedia));
        }

        $listMultimedias = $MultimediaRepository->findAll();
        return $this->render('UPONDOrthophonieBundle:Administration:exercices.html.twig', array('listMultimedias' => $listMultimedias));
    }

    public function exercicesSupprimerAction(Request $request)
    {
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        // on recupere l'exercice associée a la strategie, la phase, le niveau et la partie
        $em = $this->getDoctrine()->getManager();
        $MultimediaRepository = $em->getRepository('UPONDOrthophonieBundle:Multimedia');

        if ($request->getMethod() == 'POST') {
            // on recupere l'id multimedia via le formulaire POST précédent
            $idMultimedia = $_POST['idMultimedia'];
            // on recupere l'entité du multimedia
            $multimedia = $MultimediaRepository->findOneByIdMultimedia($idMultimedia);

            // on supprime l'image et le son du multimedia du site
            if (!unlink(__DIR__ . '/../../../../web/' . $multimedia->getImage())) {
                echo("Erreur lors de la suppression du fichier " . $multimedia->getImage());
            } else {
                // fichier supprimé
            }
            if (!unlink(__DIR__ . '/../../../../web/' . $multimedia->getSon())) {
                echo("Erreur lors de la suppression du fichier " . $multimedia->getSon());
            } else {
                // fichier supprimé
            }
            // on supprime le multimedia
            $em->remove($multimedia);
            $em->flush();
        }

        $listMultimedias = $MultimediaRepository->findAll();
        return $this->render('UPONDOrthophonieBundle:Administration:exercices.html.twig', array('listMultimedias' => $listMultimedias));
    }

    public function exerciceFormAction(Request $request)
    {
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        $multimedia = new Multimedia();
        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder('form', $multimedia);
        // On ajoute les champs que l'on veut à notre formulaire
        $formBuilder
            ->add('Strategie', 'entity', array(
                'class' => 'UPONDOrthophonieBundle:Strategie',
                'property' => 'Nom',
                'multiple' => false,
                'query_builder' => function (StrategieRepository $er) {

                    return $er->createQueryBuilder('strategie')
                        ->where("strategie.nom != 'Aléatoire'");

                },
            ))
            ->add('Nom', TextType::class)
            ->add('Image', FileType::class)
            ->add('Son', FileType::class)
            ->add('Ajouter', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-success')));

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // si on valide le formulaire
        if ($form->handleRequest($request)->isValid()) {

            $em = $this
                ->getDoctrine()
                ->getManager();
            $MultimediaRepository = $em->getRepository('UPONDOrthophonieBundle:Multimedia');
            // on upload l'image dans le site
            // on recupere le chemin du repertoire web/Banques images et sons
            $dir = __DIR__ . '/../../../../web/' . "Banque images et sons/Images/";
            // on recupere le nom original du fichier
            $file = $form['Image']->getData();
            $nomOldFichier = $file->getClientOriginalName();
            // on crée un nom random pour plus de sécurité
            $extension = $file->guessExtension();

            if (!$extension) {
                // l'extension n'est pas reconnu
                $extension = 'bin';
            }
            $nomFichier = $nomOldFichier . rand(1, 999) . '.' . $extension;
            $file->move($dir, $nomFichier);
            $cheminImage = "/Banque images et sons/Images/" . $nomFichier;

            // on upload le son dans le site
            // on recupere le chemin du repertoire web/Banques images et sons
            $dir = __DIR__ . '/../../../../web/' . "Banque images et sons/Sons/";
            // on recupere le nom original du fichier
            $file = $form['Son']->getData();
            $nomOldFichier = $file->getClientOriginalName();
            // on crée un nom random pour plus de sécurité
            $extension = $file->guessExtension();

            if (!$extension) {
                // l'extension n'est pas reconnu
                $extension = 'bin';
            }
            $nomFichier = $nomOldFichier . rand(1, 999) . '.' . $extension;
            $file->move($dir, $nomFichier);
            $cheminSon = "/Banque images et sons/Sons/" . $nomFichier;

            $multimedia->setImage($cheminImage);
            $multimedia->setIndiceApprentissage($cheminSon);
            // on ajoute le nouveau multimedia dans la base
            $em->persist($multimedia);
            $em->flush();

            $listMultimedias = $MultimediaRepository->findAll();
            return $this->render('UPONDOrthophonieBundle:Administration:exercices.html.twig', array('listMultimedias' => $listMultimedias));
        }
        return $this->render('UPONDOrthophonieBundle:Administration:exercice_ajouter_form.html.twig', array('form' => $form->createView()));
    }

    public function exerciceUpdateFormAction(Request $request)
    {

        $em = $this
            ->getDoctrine()
            ->getManager();

        $MultimediaRepository = $em->getRepository('UPONDOrthophonieBundle:Multimedia');
        $session = $request->getSession();
        $idMultimedia = $session->get('idMultimedia');
        $multimedia = $MultimediaRepository->findOneByIdMultimedia($idMultimedia);
        // On crée le FormBuilder grâce au service form factory
        $formBuilder = $this->get('form.factory')->createBuilder('form', $multimedia);
        // On ajoute les champs que l'on veut à notre formulaire
        $formBuilder
            ->add('Strategie', 'entity', array(
                'class' => 'UPONDOrthophonieBundle:Strategie',
                'property' => 'Nom',
                'multiple' => false,
                'query_builder' => function (StrategieRepository $er) {

                    return $er->createQueryBuilder('strategie')
                        ->where("strategie.nom != 'Aléatoire'");

                },
            ))
            ->add('Nom', TextType::class)
            ->add('Image', TextType::class)
            ->add('Son', TextType::class)
            ->add('Modifier', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-success')))
            ->setAction($this->generateUrl('upond_orthophonie_administration_exercice_update_form'));

        // À partir du formBuilder, on génère le formulaire
        $form = $formBuilder->getForm();

        // si on valide le formulaire
        if ($form->handleRequest($request)->isValid()) {

            $em->persist($multimedia);
            $em->flush();

            $listMultimedias = $MultimediaRepository->findAll();
            return $this->render('UPONDOrthophonieBundle:Administration:exercices.html.twig', array('listMultimedias' => $listMultimedias));
        }
        return $this->render('UPONDOrthophonieBundle:Administration:exercice_modifier_form.html.twig', array('form' => $form->createView()));
    }
}