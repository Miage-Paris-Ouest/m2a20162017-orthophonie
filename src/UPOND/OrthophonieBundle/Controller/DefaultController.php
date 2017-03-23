<?php

namespace UPOND\OrthophonieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use UPOND\OrthophonieBundle\Entity\Utilisateur;

class DefaultController extends Controller
{
    public function indexAction()
    {
//        $em = $this->container->get('doctrine')->getEntityManager();
//
//        $user = new Utilisateur();
//        $user->setLogin('toto');
//        $user->setPassword('123');
//        $em->persist($user);
//
//        $em->flush();

        $message = 'Message transmis !';


        return $this->render('UPONDOrthophonieBundle:Default:index.html.twig', array('message' => $message));
    }
}
