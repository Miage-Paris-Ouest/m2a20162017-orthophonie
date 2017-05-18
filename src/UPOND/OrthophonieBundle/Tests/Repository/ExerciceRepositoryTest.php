<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 19:59
 */

namespace UPOND\OrthophonieBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class ExerciceRepositoryTest extends KernelTestCase
{
    private $em;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testSearchByCategoryName()
    {
        $products = $this->em
            ->getRepository('UPONDOrthophonieBundle:Exercice')
            ->findby(array('idExercice' => 1));

        $this->assertCount(1, $products);
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}
