<?php
/**
 * Created by PhpStorm.
 * User: davidlou
 * Date: 01/05/2016
 * Time: 12:44
 */

namespace UPOND\OrthophonieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * Etape
 *
 * @ORM\Table(name="etape")
 * @ORM\Entity(repositoryClass="UPOND\OrthophonieBundle\Repository\EtapeRepository")
 */
class Etape
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id_etape", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEtape;


    /**
     * @var integer
     *
     * @ORM\Column(name="num_etape", type="integer", nullable=true)
     */
    private $numEtape;

    /**
     * @ORM\ManyToOne(targetEntity="UPOND\OrthophonieBundle\Entity\Exercice", inversedBy="etapes")
     * @ORM\JoinColumn(name="id_exercice", referencedColumnName="id_exercice", onDelete="CASCADE")
     */
    private $exercice;

    /**
     * @ORM\ManyToMany(targetEntity="UPOND\OrthophonieBundle\Entity\Multimedia")
     * @ORM\JoinTable(name="etape_multimedia",
     *      joinColumns={@JoinColumn(name="id_etape", referencedColumnName="id_etape", onDelete="CASCADE")},
     *      inverseJoinColumns={@JoinColumn(name="id_multimedia", referencedColumnName="id_multimedia", onDelete="CASCADE")}
     *      )
     */
    private $multimedias;

    /**
     * @var boolean
     *
     * @ORM\Column(name="bonne_reponse", type="boolean", nullable=false)
     */
    private $bonneReponse;


    public function __construct()
    {
        $this->multimedias = new ArrayCollection();
    }


    /**
     * Get idEtape
     *
     * @return integer
     */
    public function getIdEtape()
    {
        return $this->idEtape;
    }

    /**
     * Set numEtape
     *
     * @param integer $numEtape
     *
     * @return Etape
     */
    public function setNumEtape($numEtape)
    {
        $this->numEtape = $numEtape;

        return $this;
    }

    /**
     * Get numEtape
     *
     * @return integer
     */
    public function getNumEtape()
    {
        return $this->numEtape;
    }

    /**
     * Set bonneReponse
     *
     * @param boolean $bonneReponse
     *
     * @return Etape
     */
    public function setBonneReponse($bonneReponse)
    {
        $this->bonneReponse = $bonneReponse;

        return $this;
    }

    /**
     * Get bonneReponse
     *
     * @return boolean
     */
    public function getBonneReponse()
    {
        return $this->bonneReponse;
    }

    /**
     * Set exercice
     *
     * @param \UPOND\OrthophonieBundle\Entity\Exercice $exercice
     *
     * @return Etape
     */
    public function setExercice(\UPOND\OrthophonieBundle\Entity\Exercice $exercice = null)
    {
        $this->exercice = $exercice;

        return $this;
    }

    /**
     * Get exercice
     *
     * @return \UPOND\OrthophonieBundle\Entity\Exercice
     */
    public function getExercice()
    {
        return $this->exercice;
    }


    /**
     * Add multimedia
     *
     * @param \UPOND\OrthophonieBundle\Entity\Multimedia $multimedia
     *
     * @return Etape
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
