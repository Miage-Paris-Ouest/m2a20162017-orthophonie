<?php
/**
 * Created by PhpStorm.
 * User: davidlou
 * Date: 01/05/2016
 * Time: 12:39
 */

namespace UPOND\OrthophonieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Strategie
 *
 * @ORM\Table(name="strategie")
 * @ORM\Entity(repositoryClass="UPOND\OrthophonieBundle\Repository\StrategieRepository")
 */
class Strategie
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id_strategie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idStrategie;


    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_simple", type="string", nullable=true)
     */
    private $nom_simple;

    /**
     * @ORM\OneToMany(targetEntity="UPOND\OrthophonieBundle\Entity\Exercice", mappedBy="strategie")
     */
    private $exercices;

    /**
     * @ORM\OneToMany(targetEntity="UPOND\OrthophonieBundle\Entity\Multimedia", mappedBy="strategie")
     */
    private $multimedias;

    public function __construct()
    {
        $this->exercices = new ArrayCollection();
        $this->multimedias = new ArrayCollection();
    }


    /**
     * Get idStrategie
     *
     * @return integer
     */
    public function getIdStrategie()
    {
        return $this->idStrategie;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Strategie
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
     * Set nom_simple
     *
     * @param string $nom_simple
     *
     * @return Strategie
     */
    public function setNomSimple($nomsimple)
    {
        $this->nom_simple = $nomsimple;

        return $this;
    }

    /**
     * Get nom_simple
     *
     * @return string
     */
    public function getNomSimple()
    {
        return $this->nom_simple;
    }
    /**
     * Add exercice
     *
     * @param \UPOND\OrthophonieBundle\Entity\Exercice $exercice
     *
     * @return Strategie
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
     * Add multimedia
     *
     * @param \UPOND\OrthophonieBundle\Entity\Multimedia $multimedia
     *
     * @return Strategie
     */
    public function addMultimedia(\UPOND\OrthophonieBundle\Entity\Multimedia $multimedia)
    {
        $this->multimedias[] = $multimedia;

        return $this;
    }

    /**
     * Remove multimedia
     *
     * @param \UPOND\OrthophonieBundle\Entity\Multimedia $multimedia
     */
    public function removeMultimedia(\UPOND\OrthophonieBundle\Entity\Multimedia $multimedia)
    {
        $this->multimedias->removeElement($multimedia);
    }

    /**
     * Get multimedias
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMultimedias()
    {
        return $this->multimedias;
    }
}
