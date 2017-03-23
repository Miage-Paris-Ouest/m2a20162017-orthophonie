<?php
/**
 * Created by PhpStorm.
 * User: davidlou
 * Date: 01/05/2016
 * Time: 12:26
 */

namespace UPOND\OrthophonieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PauseVideo
 *
 * @ORM\Table(name="pausevideo")
 * @ORM\Entity(repositoryClass="UPOND\OrthophonieBundle\Repository\PauseVideoRepository")
 */
class PauseVideo
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id_pause_video", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPauseVideo;


    /**
     * @var string
     *
     * @ORM\Column(name="URL", type="string", nullable=true)
     */
    private $URL;

    /**
     * @var integer
     *
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    private $duree;


    /**
     * Get idPauseVideo
     *
     * @return integer
     */
    public function getIdPauseVideo()
    {
        return $this->idPauseVideo;
    }

    /**
     * Set uRL
     *
     * @param string $uRL
     *
     * @return PauseVideo
     */
    public function setURL($uRL)
    {
        $this->URL = $uRL;

        return $this;
    }

    /**
     * Get uRL
     *
     * @return string
     */
    public function getURL()
    {
        return $this->URL;
    }



    /**
     * Set duree
     *
     * @param integer $duree
     *
     * @return PauseVideo
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;

        return $this;
    }

    /**
     * Get duree
     *
     * @return integer
     */
    public function getDuree()
    {
        return $this->duree;
    }
}
