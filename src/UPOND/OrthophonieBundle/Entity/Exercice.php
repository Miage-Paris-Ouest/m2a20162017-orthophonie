<?php

namespace UPOND\OrthophonieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Exercice
 *
 * @ORM\Table(name="exercice")
 * @ORM\Entity(repositoryClass="UPOND\OrthophonieBundle\Repository\ExerciceRepository")
 */
class Exercice
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_exercice", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idExercice;

    /**
     * @var integer
     *
     * @ORM\Column(name="temps_exercice", type="integer", nullable=true)
     */
    private $temps_exercice;

    /**
     * @var integer
     *
     * @ORM\Column(name="temps_ecoule", type="integer", nullable=true)
     */
    private $temps_ecoule;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_bonne_reponse", type="integer", nullable=true)
     */
    private $nbBonneReponse;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_question_validee", type="integer", nullable=true)
     */
    private $nbQuestionValidee;
    /**
     * @var integer
     *
     * @ORM\Column(name="niveau", type="integer", nullable=true)
     */
    private $niveau;
    /**
     * @ORM\ManyToOne(targetEntity="UPOND\OrthophonieBundle\Entity\Phase", inversedBy="exercices")
     * @ORM\JoinColumn(name="id_phase", referencedColumnName="id_phase")
     */
    private $phase;

    /**
     * @ORM\ManyToOne(targetEntity="UPOND\OrthophonieBundle\Entity\Partie", inversedBy="exercices")
     * @ORM\JoinColumn(name="id_partie", referencedColumnName="id_partie")
     */
    private $partie;

    /**
     * @ORM\ManyToOne(targetEntity="UPOND\OrthophonieBundle\Entity\Strategie", inversedBy="exercices")
     * @ORM\JoinColumn(name="id_strategie", referencedColumnName="id_strategie")
     */
    private $strategie;

    /**
     * @var Date
     *
     * @ORM\Column(name="dateCreation", type="date", nullable=true)
     */
    private $dateCreation;

    /**
     * @ORM\OneToOne(targetEntity="UPOND\OrthophonieBundle\Entity\Etape")
     * @ORM\JoinColumn(name="id_etape", referencedColumnName="id_etape", onDelete="CASCADE")
     */
    private $etapeCourante;

    /**
     * @ORM\OneToMany(targetEntity="UPOND\OrthophonieBundle\Entity\Etape", mappedBy="exercice", cascade={"remove"}, orphanRemoval=true)
     */
    private $etapes;

    public function __construct()
    {
        $this->etapes = new ArrayCollection();
    }

    

    /**
     * Get idExercice
     *
     * @return integer
     */
    public function getIdExercice()
    {
        return $this->idExercice;
    }

    /**
     * Set tempsExercice
     *
     * @param integer $tempsExercice
     *
     * @return Exercice
     */
    public function setTempsExercice($tempsExercice)
    {
        $this->temps_exercice = $tempsExercice;

        return $this;
    }

    /**
     * Get tempsExercice
     *
     * @return integer
     */
    public function getTempsExercice()
    {
        return $this->temps_exercice;
    }

    /**
     * Set tempsEcoule
     *
     * @param integer $tempsEcoule
     *
     * @return Exercice
     */
    public function setTempsEcoule($tempsEcoule)
    {
        $this->temps_ecoule = $tempsEcoule;

        return $this;
    }

    /**
     * Get tempsEcoule
     *
     * @return integer
     */
    public function getTempsEcoule()
    {
        return $this->temps_ecoule;
    }

    /**
     * Set nbBonneReponse
     *
     * @param integer $nbBonneReponse
     *
     * @return Exercice
     */
    public function setNbBonneReponse($nbBonneReponse)
    {
        $this->nbBonneReponse = $nbBonneReponse;

        return $this;
    }

    /**
     * Get nbBonneReponse
     *
     * @return integer
     */
    public function getNbBonneReponse()
    {
        return $this->nbBonneReponse;
    }


    /**
     * Set phase
     *
     * @param string $phase
     *
     * @return Exercice
     */
    public function setPhase($phase)
    {
        $this->phase = $phase;

        return $this;
    }

    /**
     * Get phase
     *
     * @return string
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Exercice
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

    /**
     * Set patient
     *
     * @param \UPOND\OrthophonieBundle\Entity\Patient $patient
     *
     * @return Exercice
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
     * Set strategie
     *
     * @param \UPOND\OrthophonieBundle\Entity\Strategie $strategie
     *
     * @return Exercice
     */
    public function setStrategie(\UPOND\OrthophonieBundle\Entity\Strategie $strategie = null)
    {
        $this->strategie = $strategie;

        return $this;
    }

    /**
     * Get strategie
     *
     * @return \UPOND\OrthophonieBundle\Entity\Strategie
     */
    public function getStrategie()
    {
        return $this->strategie;
    }

    /**
     * Set etapeCourante
     *
     * @param \UPOND\OrthophonieBundle\Entity\Etape $etapeCourante
     *
     * @return Exercice
     */
    public function setEtapeCourante(\UPOND\OrthophonieBundle\Entity\Etape $etapeCourante = null)
    {
        $this->etapeCourante = $etapeCourante;

        return $this;
    }

    /**
     * Get etapeCourante
     *
     * @return \UPOND\OrthophonieBundle\Entity\Etape
     */
    public function getEtapeCourante()
    {
        return $this->etapeCourante;
    }

    /**
     * Add etape
     *
     * @param \UPOND\OrthophonieBundle\Entity\Etape $etape
     *
     * @return Exercice
     */
    public function addEtape(\UPOND\OrthophonieBundle\Entity\Etape $etape)
    {
        $this->etapes[] = $etape;

        return $this;
    }

    /**
     * Remove etape
     *
     * @param \UPOND\OrthophonieBundle\Entity\Etape $etape
     */
    public function removeEtape(\UPOND\OrthophonieBundle\Entity\Etape $etape)
    {
        $this->etapes->removeElement($etape);
    }

    /**
     * Get etapes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtapes()
    {
        return $this->etapes;
    }

    /**
     * Set partie
     *
     * @param \UPOND\OrthophonieBundle\Entity\Partie $partie
     *
     * @return Exercice
     */
    public function setPartie(\UPOND\OrthophonieBundle\Entity\Partie $partie = null)
    {
        $this->partie = $partie;

        return $this;
    }

    /**
     * Get partie
     *
     * @return \UPOND\OrthophonieBundle\Entity\Partie
     */
    public function getPartie()
    {
        return $this->partie;
    }

    /**
     * Set niveau
     *
     * @param integer $niveau
     *
     * @return Exercice
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return integer
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set nbQuestionValidee
     *
     * @param integer $nbQuestionValidee
     *
     * @return Exercice
     */
    public function setNbQuestionValidee($nbQuestionValidee)
    {
        $this->nbQuestionValidee = $nbQuestionValidee;

        return $this;
    }

    /**
     * Get nbQuestionValidee
     *
     * @return integer
     */
    public function getNbQuestionValidee()
    {
        return $this->nbQuestionValidee;
    }
}
