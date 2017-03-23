<?php
/**
 * Created by PhpStorm.
 * User: davidlou
 * Date: 01/05/2016
 * Time: 21:25
 */

namespace UPOND\OrthophonieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Phase
 *
 * @ORM\Table(name="phase")
 * @ORM\Entity(repositoryClass="UPOND\OrthophonieBundle\Repository\PhaseRepository")
 */
class Phase
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id_phase", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPhase;


    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", nullable=true)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="UPOND\OrthophonieBundle\Entity\Exercice", mappedBy="phase")
     */
    private $exercices;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->exercices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idPhase
     *
     * @return integer
     */
    public function getIdPhase()
    {
        return $this->idPhase;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Phase
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Add exercice
     *
     * @param \UPOND\OrthophonieBundle\Entity\Exercice $exercice
     *
     * @return Phase
     */
    public function addExercice(\UPOND\OrthophonieBundle\Entity\Exercice $exercice)
    {
        $this->exercices[] = $exercice;

        return $this;
    }

    /**
     * Remove exercice
     *
     * @param \UPOND\OrthophonieBundle\Entity\Exercice $exercice
     */
    public function removeExercice(\UPOND\OrthophonieBundle\Entity\Exercice $exercice)
    {
        $this->exercices->removeElement($exercice);
    }

    /**
     * Get exercices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getExercices()
    {
        return $this->exercices;
    }
}
