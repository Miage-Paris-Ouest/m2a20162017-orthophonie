<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 18/05/2016
 * Time: 15:07
 */

namespace UPOND\OrthophonieBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('nom','text')
            ->add('prenom','text')
            ->add('Lancer la recherche', 'submit')
        ;
    }

    public function getName()
    {
        return 'Utilisateur';
    }
}