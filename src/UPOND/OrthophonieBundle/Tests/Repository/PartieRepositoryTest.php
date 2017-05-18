<?php
/**
 * Created by PhpStorm.
 * User: laurentmourer
 * Date: 18/05/2017
 * Time: 20:02
 */

namespace UPOND\OrthophonieBundle\Repository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;


class PartieRepositoryTest extends KernelTestCase
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
            ->getRepository('UPONDOrthophonieBundle:Partie')
            ->findby(array('idPartie' => 153));

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
