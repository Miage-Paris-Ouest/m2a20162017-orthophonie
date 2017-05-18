<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 17:32
 */

namespace UPOND\OrthophonieBundle\Entity;


class StrategieTest extends \PHPUnit_Framework_TestCase
{
    public function testsetNom()
    {
        $patient = new Strategie();
        $patient->setNom("id");
        $this->assertEquals("id", $patient->getNom());

    }


    public function testsetNomSimple()
    {
        $patient = new Strategie();
        $patient->setNomSimple("id");
        $this->assertEquals("id", $patient->getNomSimple());

    }


}
