<?php
/**
 * Created by PhpStorm.
 * User: davidlou
 * Date: 14/04/2016
 * Time: 21:32
 */

namespace UPOND\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        // Si le visiteur est déjà identifié, on le redirige vers l'accueil
       if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirectToRoute('upond_orthophonie_home');
        }

        // Le service authentication_utils permet de récupérer le nom d'utilisateur
        // et l'erreur dans le cas où le formulaire a déjà été soumis mais était invalide
        // (mauvais mot de passe par exemple)
        $authenticationUtils = $this->get('security.authentication_utils');




        return $this->render('UPONDUserBundle:Security:login.html.twig', array(
            'last_username' => $authenticationUtils->getLastUsername(),
            'error'         => $authenticationUtils->getLastAuthenticationError(),
        ));
    }
}