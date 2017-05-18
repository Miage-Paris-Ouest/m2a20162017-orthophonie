<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 17:30
 */

namespace UPOND\OrthophonieBundle\Tests\Entity;

use UPOND\OrthophonieBundle\Entity\Etape;
use PHPUnit\Framework\TestCase;
use UPOND\OrthophonieBundle\Entity\Exercice;


class EtapeTest extends TestCase
{


    public function testSetNumEtape()
    {
        $etape = new Etape();
        $etape->setNumEtape('etape1');
        $this->assertEquals('etape1', $etape->getNumEtape());
    }




    public function testSetBonneReponse()
    {
        $etape = new Etape();
        $etape->setBonneReponse('true');
        $this->assertEquals('true', $etape->getBonneReponse());

    }



    public function testSetExercice()
    {
        $exercice=new Exercice();
        $etape = new Etape();
        $etape->setExercice($exercice);
        $this->assertEquals($exercice, $etape->getExercice());

    }








}
