<?php
namespace UPOND\OrthophonieBundle\Tests\Entity;

use UPOND\OrthophonieBundle\Entity\Etape;
use UPOND\OrthophonieBundle\Entity\Exercice;
use UPOND\OrthophonieBundle\Entity\Partie;
use UPOND\OrthophonieBundle\Entity\Phase;
use UPOND\OrthophonieBundle\Entity\Patient;

use PHPUnit\Framework\TestCase;
use UPOND\OrthophonieBundle\Entity\Strategie;

class ExerciceTest extends TestCase
{
    public function testGetIdExercice()
    {
        $exercice = new Exercice();
        $exercice->setDateCreation('etape1');
        $this->assertEquals('etape1', $exercice->getDateCreation());

    }


    public function testSetTempsExercice()
    {
        $exercice = new Exercice();
        $exercice->setTempsExercice('1minute');
        $this->assertEquals('1minute', $exercice->getTempsExercice());
    }


    public function testSetTempsEcoule()
    {
        $exercice = new Exercice();
        $exercice->setTempsEcoule('etape1');
        $this->assertEquals('etape1', $exercice->getTempsEcoule());
    }


    public function testSetNbBonneReponse()
    {
        $exercice = new Exercice();
        $exercice->setNbBonneReponse('10');
        $this->assertEquals('10', $exercice->getNbBonneReponse());
    }



    public function testSetPhase()
    {
        $phase = new Phase();
        $exercice = new Exercice();
        $exercice->setPhase($phase);
        $this->assertEquals($phase, $exercice->getPhase());
    }


    public function testSetDateCreation()
    {
        $exercice = new Exercice();
        $exercice->setDateCreation('11/01/2017');
        $this->assertEquals('11/01/2017', $exercice->getDateCreation());
    }




    public function testGetPatient()
    {
        $patient = new Patient();
        $exercice = new Exercice();
        $exercice->setPatient($patient);
        $this->assertEquals($patient, $exercice->getPatient());    }


    public function testSetStrategie()
    {
        $strategie = new Strategie();
        $exercice = new Exercice();
        $exercice->setStrategie($strategie);
        $this->assertEquals($strategie, $exercice->getStrategie());
    }


    public function testSetEtapeCourante()
    {
        $etape = new Etape();
        $exercice = new Exercice();
        $exercice->setEtapeCourante($etape);
        $this->assertEquals($etape, $exercice->getEtapeCourante());
    }







    public function testsetPartie()
    {
        $partie=new Partie();
        $exercice = new Exercice();
        $exercice->setPartie($partie);
        $this->assertEquals($partie, $exercice->getPartie());
    }


    public function testsetNiveau()
    {
        $exercice = new Exercice();
        $exercice->setNiveau('lvl1');
        $this->assertEquals('lvl1', $exercice->getNiveau());
    }


    public function testsetNbQuestionValidee()
    {
        $exercice = new Exercice();
        $exercice->setNbQuestionValidee('5');
        $this->assertEquals('5', $exercice->getNbQuestionValidee());
    }
}
