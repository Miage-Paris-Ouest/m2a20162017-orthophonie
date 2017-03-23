<?php
/**
 * Created by PhpStorm.
 * User: davidlou
 * Date: 17/04/2016
 * Time: 11:47
 */
namespace UPOND\OrthophonieBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav');
        // gestion manuel du template dans layout principal -> app/resources/view
        /* $menu->addChild('Accueil', array('route' => 'upond_orthophonie_home'))
            ->setAttribute('icon', 'icon-home');

        if($this->container->get('security.authorization_checker')->isGranted(array('ROLE_ADMIN', 'ROLE_USER'))) { // Check if the visitor has any authenticated roles
            $username = $this->container->get('security.token_storage')->getToken()->getUser(); // Get username of the current logged in user


            $menu->addChild('User', array('label' => 'Bienvenue '.$username))
                ->setAttribute('dropdown', true)
                ->setAttribute('icon', 'icon-user');

            $menu['User']->addChild('Modifier votre profil', array('route' => 'fos_user_profile_edit'))
                ->setAttribute('icon', 'icon-edit');

            $menu['User']->addChild('Modifier votre mot de passe', array('route' => 'fos_user_change_password'))
                ->setAttribute('icon', 'icon-edit');

            $menu['User']->addChild('Se déconnecter', array('route' => 'fos_user_security_logout'))
                ->setAttribute('icon', 'icon-remove');


            $menu->addChild('Phases', array('route' => 'upond_orthophonie_phases'))
                ->setAttribute('icon', 'icon-group');

            $menu->addChild('Exercice (test)', array('route' => 'upond_orthophonie_exercice'))
                ->setAttribute('icon', 'icon-group');

            $menu->addChild('Démarrer une partie', array('route' => 'upond_orthophonie_start'))
                ->setAttribute('icon', 'icon-group');

            $menu->addChild('Statistiques', array('route' => 'upond_orthophonie_stats'))
                ->setAttribute('icon', 'glyphicon glyphicon-stats');

        }
        else
        {
            $menu->addChild('Connexion', array('route' => 'fos_user_security_login'))
                ->setAttribute('icon', 'icon-user');

            $menu->addChild('Inscription', array('route' => 'fos_user_registration_register'))
                ->setAttribute('icon', 'icon-user');
        }*/


        return $menu;
    }


}