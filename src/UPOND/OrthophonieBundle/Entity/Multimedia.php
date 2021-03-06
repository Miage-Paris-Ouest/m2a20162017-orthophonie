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
     * @ORM\Column(name="indice_apprentissage", type="string", length=150, nullable=true)
     */
    private $indice_apprentissage;
    /**
     * @var string
     *
     * @ORM\Column(name="indice_entrainement", type="string", length=150, nullable=true)
     */
    private $indice_entrainement;

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
     * @return string
     */
    public function getIndiceApprentissage()
    {
        return $this->indice_apprentissage;
    }

    /**
     * @param string $indice_apprentissage
     */
    public function setIndiceApprentissage($indice_apprentissage)
    {
        $this->indice_apprentissage = $indice_apprentissage;
    }

    /**
     * @return string
     */
    public function getIndiceEntrainement()
    {
        return $this->indice_entrainement;
    }

    /**
     * @param string $indice_entrainement
     */
    public function setIndiceEntrainement($indice_entrainement)
    {
        $this->indice_entrainement = $indice_entrainement;
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
