<?php

namespace UPOND\OrthophonieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="UPOND\OrthophonieBundle\Repository\UtilisateurRepository")
 */
class Utilisateur extends BaseUser
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=20, nullable=true)
     */
    protected $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=20, nullable=true)
     */
    protected $prenom;

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Utilisateur
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
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
}
