<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 17:32
 */

namespace UPOND\OrthophonieBundle\Entity;


class PhaseTest extends \PHPUnit_Framework_TestCase
{

    public function testsetNom()
    {
        $partieTest = new Phase();
        $partieTest->setNom("nom");
        $this->assertEquals("nom", $partieTest->getNom());

    }


}
