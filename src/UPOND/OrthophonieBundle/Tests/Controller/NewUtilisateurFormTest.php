<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 16:24
 */

namespace UPOND\OrthophonieBundle\Form;

use UPOND\OrthophonieBundle\Form\NewUtilisateurForm;

use Symfony\Component\Form\Test\TypeTestCase;


class NewUtilisateurFormTest extends TypeTestCase
{

    public function testSubmitValidData()
    {
        $formData = array(
            'login' => '1',
            'password' => 'prenom',
        );

        $form = $this->factory->create(NewUtilisateurForm::class);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
    }
}
