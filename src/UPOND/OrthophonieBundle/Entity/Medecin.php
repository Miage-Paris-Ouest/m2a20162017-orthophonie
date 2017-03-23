<?php

namespace UPOND\OrthophonieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Medecin
 *
 * @ORM\Table(name="medecin")
 * @ORM\Entity(repositoryClass="UPOND\OrthophonieBundle\Repository\MedecinRepository")
 */
class Medecin
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_medecin", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMedecin;
    
    /**
     * @var \Utilisateur
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_medecin", referencedColumnName="id")
     * })
     */

    /**
     * @ORM\OneToOne(targetEntity="UPOND\OrthophonieBundle\Entity\Utilisateur")
     */
    private $utilisateur;



    /**
     * Get idMedecin
     *
     * @return integer
     */
    public function getIdMedecin()
    {
        return $this->idMedecin;
    }

    /**
     * Set utilisateur
     *
     * @param \UPOND\OrthophonieBundle\Entity\Utilisateur $utilisateur
     *
     * @return Medecin
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

    
}
