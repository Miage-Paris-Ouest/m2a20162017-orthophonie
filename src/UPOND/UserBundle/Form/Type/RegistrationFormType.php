<?php
/**
 * Created by PhpStorm.
 * User: davidlou
 * Date: 23/04/2016
 * Time: 19:20
 */

namespace UPOND\UserBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\AbstractType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('Nom', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'width: 250px', 'placeholder'=>'Nom')));
        $builder->add('Prenom', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'width: 250px', 'placeholder'=>'Prénom')));
    }


    public function getBlockPrefix()
    {
        return 'upond_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }
}