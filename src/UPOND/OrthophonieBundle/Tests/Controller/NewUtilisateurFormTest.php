<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 16:24
 */

namespace UPOND\OrthophonieBundle\Form;

use UPOND\OrthophonieBundle\Entity\Utilisateur;
use UPOND\OrthophonieBundle\Form\NewUtilisateurForm;

use Symfony\Component\Form\Test\TypeTestCase;


class NewUtilisateurFormTest extends TypeTestCase
{

    public function testSubmitValidData()
    {
        $formData = array(
            'login' => 'mktotoy',
            'password' => 'toto',
        );

        $form = $this->factory->create(NewUtilisateurForm::class);


        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
