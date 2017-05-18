<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 17:31
 */

namespace UPOND\OrthophonieBundle\Entity;


class PartieTest extends \PHPUnit_Framework_TestCase
{
    public function setPatient(\UPOND\OrthophonieBundle\Entity\Patient $patient = null)
    {
        $patient = new Patient();
        $partieTest = new PartieTest();
        $partieTest->setPatient($patient);
        $this->assertEquals($patient, $partieTest->getPatient());

    }




    public function setDateCreation($dateCreation)
    {
        $partieTest = new PartieTest();
        $partieTest->setDateCreation("11/11/11");
        $this->assertEquals("11/11/11", $partieTest->getDateCreation());

    }


}
