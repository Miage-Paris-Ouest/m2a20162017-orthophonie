<?php
/**
 * Created by PhpStorm.
 * User: davidlou
 * Date: 28/04/2016
 * Time: 15:46
 */

namespace UPOND\UserBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        // add your custom field
        $builder->add('Nom', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'width: 250px')));
        $builder->add('Prenom', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'width: 250px')));
    }


    public function getBlockPrefix()
    {
        return 'upond_user_profile';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }
}