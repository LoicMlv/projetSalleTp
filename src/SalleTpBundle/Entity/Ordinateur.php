<?php

namespace SalleTpBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ordinateur
 *
 * @ORM\Table(name="ordinateur")
 * @ORM\Entity(repositoryClass="SalleTpBundle\Repository\OrdinateurRepository")
 */
class Ordinateur
{
    /**
     * @ORM\ManyToOne(targetEntity="SalleTpBundle\Entity\Salle", inversedBy="ordinateurs", cascade={"persist"})
     */
    private $salle;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255, unique=true)
     */
    private $ip;

    /**
     * @var int
     *
     * @ORM\Column(name="numero", type="integer")
     */
    private $numero;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Ordinateur
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set numero
     *
     * @param integer $numero
     *
     * @return Ordinateur
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set salle
     *
     * @param \SalleTpBundle\Entity\Salle $salle
     *
     * @return Ordinateur
     */
    public function setSalle(\SalleTpBundle\Entity\Salle $salle = null)
    {
        $this->salle = $salle;

        return $this;
    }

    /**
     * Get salle
     *
     * @return \SalleTpBundle\Entity\Salle
     */
    public function getSalle()
    {
        return $this->salle;
    }
}
