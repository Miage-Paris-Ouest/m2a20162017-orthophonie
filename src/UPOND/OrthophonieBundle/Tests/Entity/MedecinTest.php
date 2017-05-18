<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 17:30
 */

namespace UPOND\OrthophonieBundle\Tests\Entity;

use UPOND\OrthophonieBundle\Entity\Medecin;
use PHPUnit\Framework\TestCase;
use UPOND\OrthophonieBundle\Entity\Utilisateur;

class MedecinTest extends TestCase
{
    public function testsetUtilisateur()
    {
        $utiliateur = new Utilisateur();
        $medecin = new Medecin();
        $medecin->setUtilisateur($utiliateur);
        $this->assertEquals($utiliateur, $medecin->getUtilisateur());


    }


}
