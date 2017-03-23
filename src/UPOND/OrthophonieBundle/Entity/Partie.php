<?php
/**
 * Created by PhpStorm.
 * User: davidlou
 * Date: 01/05/2016
 * Time: 21:28
 */

namespace UPOND\OrthophonieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Partie
 *
 * @ORM\Table(name="partie")
 * @ORM\Entity(repositoryClass="UPOND\OrthophonieBundle\Repository\PartieRepository")
 */
class Partie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_partie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPartie;

    /**
     * @ORM\ManyToOne(targetEntity="UPOND\OrthophonieBundle\Entity\Patient", inversedBy="parties")
     * @ORM\JoinColumn(name="id_patient", referencedColumnName="id_patient")
     */
    private $patient;

    /**
     * @ORM\OneToMany(targetEntity="UPOND\OrthophonieBundle\Entity\Exercice", mappedBy="partie", cascade={"remove"}, orphanRemoval=true)
     */
    private $exercices;

    /**
     * @var Date
     *
     * @ORM\Column(name="dateCreation", type="date", nullable=true)
     */
    private $dateCreation;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->exercices = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idPartie
     *
     * @return integer
     */
    public function getIdPartie()
    {
        return $this->idPartie;
    }

    /**
     * Set patient
     *
     * @param \UPOND\OrthophonieBundle\Entity\Patient $patient
     *
     * @return Partie
     */
    public function setPatient(\UPOND\OrthophonieBundle\Entity\Patient $patient = null)
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * Get patient
     *
     * @return \UPOND\OrthophonieBundle\Entity\Patient
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * Add exercice
     *
     * @param \UPOND\OrthophonieBundle\Entity\Exercice $exercice
     *
     * @return Partie
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

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Partie
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    public function getIdPartieAndDateCreation()
    {
        return 'n°'.$this->idPartie.' datant du '.$this->dateCreation->format('d-m-Y');
    }
}
