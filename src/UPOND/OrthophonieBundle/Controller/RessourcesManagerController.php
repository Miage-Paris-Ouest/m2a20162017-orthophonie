<?php
/**
 * Created by IntelliJ IDEA.
 * User: thaonzo
 * Date: 14/02/2017
 * Time: 14:53
 */

namespace UPOND\OrthophonieBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UPOND\OrthophonieBundle\Entity\Multimedia;
use Symfony\Component\HttpFoundation\Request;
use UPOND\OrthophonieBundle\Entity\PauseVideo;

class RessourcesManagerController extends Controller
{
    public function imagesEditAction(Request $request){

        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }

        $em = $this->getDoctrine()->getManager();
        $MultimediaRepository = $em->getRepository('UPONDOrthophonieBundle:Multimedia');
        $StrategieRepository= $em->getRepository('UPONDOrthophonieBundle:Strategie');

        $listMultimedia = $MultimediaRepository->findBy(
            array(),        // $where
            array('idMultimedia'=>'ASC'),    // $orderBy
           null,                        // $limit
          null                         // $offset
        );

        $listStrategie = $StrategieRepository->findAll();
        //print_r(var_dump($MultimediaRepository));
        return $this->render('UPONDOrthophonieBundle:RessourceManager:medias_list.html.twig', array('listMultimedias' => $listMultimedia,'listStrategie'=>$listStrategie));
    }

    public function imagesCreateAction(Request $request){

        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        // on recupere l'exercice associ�e a la strategie, la phase, le niveau et la partie
         $em = $this->getDoctrine()->getManager();
        $strategie = $em->getRepository('UPONDOrthophonieBundle:Strategie');
        $list_strategie= $strategie->findAll();
        //print_r(var_dump($MultimediaRepository));
        return $this->render('UPONDOrthophonieBundle:RessourceManager:media_create_update.html.twig',
            array("action" => "Create",
                "strategies_opt" => $list_strategie,
                "action_path" => "upond_orthophonie_ressources_manager_images_create_do"
            ));
    }

    public function imagesCreateDoAction(Request $request){

        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }

        $em = $this->getDoctrine()->getManager();
        $strategie = $em->getRepository('UPONDOrthophonieBundle:Strategie');
        $list_strategie= $strategie->findAll();

        //TEST SI FICHIERS CONFORMES
        $error_tab= array(
            UPLOAD_ERR_NO_FILE => "fichier manquant",
            UPLOAD_ERR_INI_SIZE => "fichier dépassant la taille maximale autorisée par PHP.",
            UPLOAD_ERR_FORM_SIZE => "fichier dépassant la taille maximale autorisée par le formulaire.",
            UPLOAD_ERR_PARTIAL => "fichier transféré partiellement."
        );

        if ($_FILES['img']['error'] > 0)
            return $this->render('UPONDOrthophonieBundle:RessourceManager:media_create_update.html.twig',
                array("action" => "Create",
                    "strategies_opt" => $list_strategie,
                    "erreur_img" => $error_tab[$_FILES['img']['error']],
                    "action_path" => "upond_orthophonie_ressources_manager_images_create_do"
                ));
        
      


        $img_extensions_valides = array( 'jpg' , 'jpeg' , 'png');
       
        //1. strrchr renvoie l'extension avec le point (« . »).
        //2. substr(chaine,1) ignore le premier caractère de chaine.
        //3. strtolower met l'extension en minuscules.
        $img_extension_upload = strtolower(  substr(  strrchr($_FILES['img']['name'], '.')  ,1)  );

        if ( !in_array($img_extension_upload,$img_extensions_valides) )
            return $this->render('UPONDOrthophonieBundle:RessourceManager:media_create_update.html.twig',
                array("action" => "Create",
                    "strategies_opt" => $list_strategie,
                    "erreur_img" => "Extension non valide",
                    "action_path" => "upond_orthophonie_ressources_manager_images_create_do"
                ));
       
        $obj_strategie= $strategie->findBy(
            array('idStrategie' => $_POST['strategie']))[0];

        $success_message="";
        $image = "Banque images et sons/Images/".$obj_strategie->getNomSimple()."/".$_POST['nom'].".".$img_extension_upload;
        $resultat_img = move_uploaded_file($_FILES['img']['tmp_name'],$image);
        if ($resultat_img) $success_message.= "ajout image réussi<br>";

        // ajout de l'utilisateur dans la table patient
        $multimedia = new Multimedia();
        $multimedia->setImage($image);
        $multimedia->setNom($_POST['nom']);
        $multimedia->setStrategie($obj_strategie);
        $multimedia->setIndiceApprentissage($_POST['apprentissage']);
        $multimedia->setIndiceEntrainement($_POST['entrainement']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($multimedia);
        $em->flush();

        $success_message.= "Multimedia resussi";
        //FIN TEST FICHIERS CONFORMES
        return $this->render('UPONDOrthophonieBundle:RessourceManager:media_create_update.html.twig',
            array("action" => "Create",
                "strategies_opt" => $list_strategie,
                "success_message"=>$success_message,
                "action_path" => "upond_orthophonie_ressources_manager_images_create_do"
            ));
    }

    public function imagesUpdateAction(Request $request){

        if ($request->getSession()->get('role') != 'medecin')
            return $this->redirectToRoute('upond_orthophonie_home');
        if($request->query->get('media_id')==null)
            return $this->redirectToRoute('upond_orthophonie_home');

        // on recupere l'exercice associ�e a la strategie, la phase, le niveau et la partie
        $em = $this->getDoctrine()->getManager();
        $strategie = $em->getRepository('UPONDOrthophonieBundle:Strategie');
        $list_strategie= $strategie->findAll();
        //print_r(var_dump($MultimediaRepository));
        $multimedia = $em->getRepository('UPONDOrthophonieBundle:Multimedia');
        $obj_multimedia= $multimedia->findOneBy(array('idMultimedia' => $request->query->get('media_id')));

        return $this->render('UPONDOrthophonieBundle:RessourceManager:media_create_update.html.twig',
            array("action" => "Update",
                "strategies_opt" => $list_strategie,
                "obj_multimedia" => $obj_multimedia,
                "action_path" => "upond_orthophonie_ressources_manager_images_update_do"
                ));
    }

    public function imagesUpdateDoAction(Request $request){

        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }

        $em = $this->getDoctrine()->getManager();
        $strategie = $em->getRepository('UPONDOrthophonieBundle:Strategie');
        $list_strategie= $strategie->findAll();

        $multimedia = $em->getRepository('UPONDOrthophonieBundle:Multimedia');
        $obj_multimedia= $multimedia->findOneBy(array('idMultimedia' => $request->request->get('media_id')));

        //TEST SI FICHIERS CONFORMES
        $error_tab= array(
            UPLOAD_ERR_NO_FILE => "fichier manquant",
            UPLOAD_ERR_INI_SIZE => "fichier dépassant la taille maximale autorisée par PHP.",
            UPLOAD_ERR_FORM_SIZE => "fichier dépassant la taille maximale autorisée par le formulaire.",
            UPLOAD_ERR_PARTIAL => "fichier transféré partiellement."
        );

        if ($_FILES['img']['error'] == UPLOAD_ERR_INI_SIZE ||
            $_FILES['img']['error'] == UPLOAD_ERR_FORM_SIZE ||
            $_FILES['img']['error'] == UPLOAD_ERR_PARTIAL
        )
            return $this->render('UPONDOrthophonieBundle:RessourceManager:media_create_update.html.twig',
                array("action" => "Update",
                    "strategies_opt" => $list_strategie,
                    "erreur_img" => $error_tab[$_FILES['img']['error']],
                    "action_path" => "upond_orthophonie_ressources_manager_images_update_do",
                    "obj_multimedia" => $obj_multimedia));

        $obj_strategie= $strategie->findBy(
            array('idStrategie' => $request->request->get('strategie')))[0];
        $success_message="";
        if($request->request->get('nom'))
            $obj_multimedia->setNom($request->request->get('nom'));
        if($request->request->get('strategie'))
            $obj_multimedia->setStrategie($obj_strategie);
        if($request->request->get('apprentissage'))
          	$obj_multimedia->setIndiceApprentissage($request->request->get('apprentissage'));
        if($request->request->get('entrainement'))
          	$obj_multimedia->setIndiceApprentissage($request->request->get('entrainement'));
            
        if($_FILES['img']['error'] != UPLOAD_ERR_NO_FILE){
            $img_extensions_valides = array( 'jpg' , 'jpeg' , 'png');
            //1. strrchr renvoie l'extension avec le point (« . »).
            //2. substr(chaine,1) ignore le premier caractère de chaine.
            //3. strtolower met l'extension en minuscules.
            $img_extension_upload = strtolower(  substr(  strrchr($_FILES['img']['name'], '.')  ,1)  );
            if ( !in_array($img_extension_upload,$img_extensions_valides) )
                return $this->render('UPONDOrthophonieBundle:RessourceManager:media_create_update.html.twig',
                    array("action" => "Update",
                        "strategies_opt" => $list_strategie,
                        "erreur_img" => "Extension non valide",
                        "action_path" => "upond_orthophonie_ressources_manager_images_update_do",
                        "obj_multimedia" => $obj_multimedia));

            $image = "Banque images et sons/Images/".$obj_strategie->getNomSimple()."/".$obj_multimedia->getNom().".".$img_extension_upload;
            $resultat_img = move_uploaded_file($_FILES['img']['tmp_name'],$image);
            if ($resultat_img) $success_message.= "Modification Image réussi<br>";
        }
   
        $success_message.= "Multimedia resussi";
        //FIN TEST FICHIERS CONFORMES
        return $this->render('UPONDOrthophonieBundle:RessourceManager:media_create_update.html.twig',
            array("action" => "Update",
                "strategies_opt" => $list_strategie,
                "success_message"=>$success_message,
                "action_path" => "upond_orthophonie_ressources_manager_images_update_do",
                "obj_multimedia" => $obj_multimedia
                ));
    }
    
    public function imagesEditUpdateSimpleAction(Request $request){
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        if($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();
            $MultimediaRepository = $em->getRepository('UPONDOrthophonieBundle:Multimedia');
            // on recupere l'id utilisateur via le formulaire POST pr�c�dent
            $idMultimedias = $_POST['image'];
            $idApprentissage = $_POST['apprentissage'];
            $idEntrainement = $_POST['entrainement'];
            $textmedia = $_POST['text'];
            // on r�cup�re le patient
            foreach($idMultimedias as $k=>$idm){
                $actualmedia = $MultimediaRepository->find($idm);
                $actualmedia->setNom($textmedia[$k]);
                $actualmedia->setIndiceApprentissage($idApprentissage[$k]);
                $actualmedia->setIndiceEntrainement($idEntrainement[$k]);
            }

            $em->flush();
        }
        return $this->forward("UPONDOrthophonieBundle:RessourcesManager:imagesEdit");
    }

    public function imagesDeleteAction(Request $request){
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        $em = $this->getDoctrine()->getManager();
        $multimedia = $em->getRepository('UPONDOrthophonieBundle:Multimedia');
        $obj_multimedia= $multimedia->find(array('idMultimedia' => $request->query->get('media_id')));
        $em->remove($obj_multimedia);
        $em->flush();

        return $this->forward("UPONDOrthophonieBundle:RessourcesManager:imagesEdit");
    }

    public function videosEditAction(Request $request){
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }

        $em = $this->getDoctrine()->getManager();
        $PauseVideoRepository = $em->getRepository('UPONDOrthophonieBundle:PauseVideo');


        $listVideos = $PauseVideoRepository->findBy(
            array(),        // $where
            array('idPauseVideo'=>'ASC'),    // $orderBy
            null,                        // $limit
            null                         // $offset
        );
        return $this->render('UPONDOrthophonieBundle:RessourceManager:videos_list.html.twig', array('listVideos' => $listVideos));
    }

    public function videosEditUpdateSimpleAction(Request $request){
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        if($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getManager();
            $PauseVideoRepository = $em->getRepository('UPONDOrthophonieBundle:PauseVideo');
            // on recupere l'id utilisateur via le formulaire POST pr�c�dent
            $idVideo = $_POST['video'];
            $urls = $_POST['url'];
            $durees = $_POST['duree'];


            // on r�cup�re le patient
            foreach($idVideo as $k=>$idm){
                $actualVideo = $PauseVideoRepository->find($idm);
                $actualVideo->setURL($urls[$k]);
                $actualVideo->setDuree($durees[$k]);
            }

            $em->flush();
        }
        return $this->forward("UPONDOrthophonieBundle:RessourcesManager:videosEdit");
    }

    public function videosCreateAction(Request $request){
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        //print_r(var_dump($MultimediaRepository));
        return $this->render('UPONDOrthophonieBundle:RessourceManager:video_create.html.twig');
    }

    public function videosCreateDoAction(Request $request){

        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        // ajout de l'utilisateur dans la table patient
        $video = new PauseVideo();
        $video->setURL($_POST['url']);
        $video->setDuree($_POST['duree']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($video);
        $em->flush();
        //FIN TEST FICHIERS CONFORMES
        return $this->render('UPONDOrthophonieBundle:RessourceManager:video_create.html.twig');
    }

    public function videosDeleteAction(Request $request){
        if ($request->getSession()->get('role') != 'medecin') {
            return $this->redirectToRoute('upond_orthophonie_home');
        }
        $em = $this->getDoctrine()->getManager();
        $PauseVideo = $em->getRepository('UPONDOrthophonieBundle:PauseVideo');
        $obj_PauseVideo= $PauseVideo->find(array('idPauseVideo' => $request->query->get('video_id')));
        $em->remove($obj_PauseVideo);
        $em->flush();

        return $this->forward("UPONDOrthophonieBundle:RessourcesManager:videosEdit");
    }
}