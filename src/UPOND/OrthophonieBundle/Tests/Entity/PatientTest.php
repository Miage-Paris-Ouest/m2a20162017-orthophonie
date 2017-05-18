<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 17:31
 */

namespace UPOND\OrthophonieBundle\Entity;


class PatientTest extends \PHPUnit_Framework_TestCase
{
    public function testgetIdPatient()
    {
        $patient = new Patient();
        $patient->setIdPatient("id");
        $this->assertEquals("id", $patient->getIdPatient());
    }


    public function setUtilisateur(\UPOND\OrthophonieBundle\Entity\Utilisateur $utilisateur = null)
    {
        $utilisateur = new Utilisateur();
        $patient = new Patient();
        $patient->setUtilisateur($utilisateur);
        $this->assertEquals($utilisateur, $patient->getUtilisateur());

    }


}
