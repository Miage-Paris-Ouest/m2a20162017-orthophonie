<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 17:32
 */

namespace UPOND\OrthophonieBundle\Entity;


class UtilisateurTest extends \PHPUnit_Framework_TestCase
{
    public function testsetNom()
    {
        $patient = new Utilisateur();
        $patient->setNom("id");
        $this->assertEquals("id", $patient->getNom());

    }


    public function testsetPrenom()
    {
        $patient = new Utilisateur();
        $patient->setPrenom("id");
        $this->assertEquals("id", $patient->getPrenom());

    }
}
