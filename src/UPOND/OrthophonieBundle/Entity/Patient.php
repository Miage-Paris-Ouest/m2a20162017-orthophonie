<?php

namespace UPOND\OrthophonieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Patient
 *
 * @ORM\Table(name="patient")
 * @ORM\Entity(repositoryClass="UPOND\OrthophonieBundle\Repository\PatientRepository")
 */
class Patient
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id_patient", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPatient;


    /**
     * @ORM\OneToOne(targetEntity="UPOND\OrthophonieBundle\Entity\Utilisateur")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToMany(targetEntity="UPOND\OrthophonieBundle\Entity\Medecin")
     * @ORM\JoinTable(name="patient_medecin",
     *      joinColumns={@JoinColumn(name="id_patient", referencedColumnName="id_patient", onDelete="CASCADE")},
     *      inverseJoinColumns={@JoinColumn(name="id_medecin", referencedColumnName="id_medecin", onDelete="CASCADE")}
     *      )
     */
    private $medecins;

    /**
     * @ORM\OneToMany(targetEntity="UPOND\OrthophonieBundle\Entity\Partie", mappedBy="patient", cascade={"persist"}, orphanRemoval=true)
     */
    private $parties;

    public function __construct()
    {
        $this->medecins = new ArrayCollection();
        $this->parties = new ArrayCollection();
    }


    /**
     * Get idPatient
     *
     * @return integer
     */
    public function getIdPatient()
    {
        return $this->idPatient;
    }

    /**
     * Set idPatient
     *
     * @param string $idPatient
     * @return integer
     */
    public function setIdPatient($idPatient)
    {
        $this->idPatient = $idPatient;
        return $this;
    }



    /**
     * Set utilisateur
     *
     * @param \UPOND\OrthophonieBundle\Entity\Utilisateur $utilisateur
     *
     * @return Patient
     */
    public function setUtilisateur(\UPOND\OrthophonieBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \UPOND\OrthophonieBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Add medecin
     *
     * @param \UPOND\OrthophonieBundle\Entity\Medecin $medecin
     *
     * @return Patient
     */
    public function addMedecin(\UPOND\OrthophonieBundle\Entity\Medecin $medecin)
    {
        $this->medecins[] = $medecin;

        return $this;
    }

    /**
     * Remove medecin
     *
     * @param \UPOND\OrthophonieBundle\Entity\Medecin $medecin
     */
    public function removeMedecin(\UPOND\OrthophonieBundle\Entity\Medecin $medecin)
    {
        $this->medecins->removeElement($medecin);
    }

    /**
     * Get medecins
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMedecins()
    {
        return $this->medecins;
    }

    /**
     * Add exercice
     *
     * @param \UPOND\OrthophonieBundle\Entity\Exercice $exercice
     *
     * @return Patient
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
     * Add party
     *
     * @param \UPOND\OrthophonieBundle\Entity\Partie $party
     *
     * @return Patient
     */
    public function addParty(\UPOND\OrthophonieBundle\Entity\Partie $party)
    {
        $this->parties[] = $party;

        return $this;
    }

    /**
     * Remove party
     *
     * @param \UPOND\OrthophonieBundle\Entity\Partie $party
     */
    public function removeParty(\UPOND\OrthophonieBundle\Entity\Partie $party)
    {
        $this->parties->removeElement($party);
    }

    /**
     * Get parties
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParties()
    {
        return $this->parties;
    }

    public function getNomEtPrenom() {
        return $this->utilisateur->getNom().' '.$this->utilisateur->getPrenom();
    }
}
