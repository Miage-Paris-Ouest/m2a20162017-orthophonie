<?php
namespace UPOND\OrthophonieBundle\Tests\Controller;

use UPOND\OrthophonieBundle\Entity\Exercice;

class ExerciceTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $ec = new Exercice();
        
        $ec->setTempsExercice(1);
                $result = ec->getTempsExercice(1);
                $this->assertEquals(1, $result);


        
    }
}
