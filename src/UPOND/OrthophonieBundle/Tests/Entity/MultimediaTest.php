<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 17:31
 */

namespace UPOND\OrthophonieBundle\Entity;


class MultimediaTest extends \PHPUnit_Framework_TestCase
{

    public function testsetNom()
    {
        $multimedia = new Multimedia();
        $multimedia->setNom("nom");
        $this->assertEquals("nom", $multimedia->getNom());

    }


    public function testsetImage()
    {
        $multimedia = new Multimedia();
        $multimedia->setImage("image");
        $this->assertEquals("image", $multimedia->getImage());
    }


    public function testgetIndiceApprentissage()
    {
        $multimedia = new Multimedia();
        $multimedia->setIndiceApprentissage("nom");
        $this->assertEquals("nom", $multimedia->getIndiceApprentissage());    }


    public function testgetIndiceEntrainement()
    {
        $multimedia = new Multimedia();
        $multimedia->setIndiceEntrainement("nom");
        $this->assertEquals("nom", $multimedia->getIndiceEntrainement());    }


    public function testsetStrategie(\UPOND\OrthophonieBundle\Entity\Strategie $strategie = null)
    {
        $strategie = new Strategie();
        $multimedia = new Multimedia();
        $multimedia->setStrategie($strategie);
        $this->assertEquals($strategie, $multimedia->getStrategie());
    }





}
