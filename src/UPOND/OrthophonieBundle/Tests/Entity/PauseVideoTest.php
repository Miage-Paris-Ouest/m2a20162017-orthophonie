<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 17:32
 */

namespace UPOND\OrthophonieBundle\Entity;


class PauseVideoTest extends \PHPUnit_Framework_TestCase
{

    public function testsetURL()
    {
        $patient = new PauseVideo();
        $patient->setURL("id");
        $this->assertEquals("id", $patient->getURL());

    }




    /**
     * Set duree
     *
     * @param integer $duree
     *
     * @return PauseVideo
     */
    public function testsetDuree()
    {
        $patient = new PauseVideo();
        $patient->setDuree("id");
        $this->assertEquals("id", $patient->getDuree());

    }
}
