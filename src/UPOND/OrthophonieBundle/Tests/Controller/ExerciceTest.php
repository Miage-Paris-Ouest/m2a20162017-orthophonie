<?php
namespace UPOND\OrthophonieBundle\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\TestCase;
use OrthophonieBundle/Entity/Exercice;

class DefaultControllerTest extends TestCase{
    public function setUp(){
      $ex = new Exercice();
    }
	
	private function testGet(){
    $ex->setIdExercice(1)
      $this->assertEquals(1, $ex->getIdExercice());
       
    }

}
