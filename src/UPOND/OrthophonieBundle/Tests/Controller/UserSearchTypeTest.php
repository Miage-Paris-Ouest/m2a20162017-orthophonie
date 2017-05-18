<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 18:55
 */

namespace UPOND\OrthophonieBundle\Form;


class UserSearchTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'nom' => 'mourer',
            'prenom' => 'laurent',
            'Lancer la recherche' => 'toto',
        );


        $form = $this->factory->create(UserSearchType::class);


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
