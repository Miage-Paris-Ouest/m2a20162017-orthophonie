<?php

namespace UPOND\OrthophonieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Multimedia
 *
 * @ORM\Table(name="multimedia")
 * @ORM\Entity(repositoryClass="UPOND\OrthophonieBundle\Repository\MultimediaRepository")
 */
class Multimedia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_multimedia", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMultimedia;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=50, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="son", type="string", length=100, nullable=true)
     */
    private $son;

    /**
     * @ORM\ManyToOne(targetEntity="UPOND\OrthophonieBundle\Entity\Strategie", inversedBy="multimedias")
     * @ORM\JoinColumn(name="id_strategie", referencedColumnName="id_strategie")
     */
    private $strategie;


    public function __construct()
    {
        $this->etapes = new ArrayCollection();
    }


    /**
     * Get idMultimedia
     *
     * @return integer
     */
    public function getIdMultimedia()
    {
        return $this->idMultimedia;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Multimedia
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
     * Set image
     *
     * @param string $image
     *
     * @return Multimedia
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set son
     *
     * @param string $son
     *
     * @return Multimedia
     */
    public function setSon($son)
    {
        $this->son = $son;

        return $this;
    }

    /**
     * Get son
     *
     * @return string
     */
    public function getSon()
    {
        return $this->son;
    }

    /**
     * Set strategie
     *
     * @param \UPOND\OrthophonieBundle\Entity\Strategie $strategie
     *
     * @return Multimedia
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
     * Add etape
     *
     * @param \UPOND\OrthophonieBundle\Entity\Etape $etape
     *
     * @return Multimedia
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

   
}
