<?php

namespace ExoPetsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Animal
 *
 * @ORM\Table(name="animal")
 * @ORM\Entity(repositoryClass="ExoPetsBundle\Repository\AnimalRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Animal
{
    /**
     * @ORM\ManyToOne(targetEntity="ExoPetsBundle\Entity\Maitre", inversedBy="animal", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $maitre;

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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="poids", type="smallint")
     */
    private $poids;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNais", type="datetime")
     */
    private $dateNais;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Animal
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
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function corrigeNom() {
        $this->nom = ucfirst(strtolower($this->nom));
    }

    /**
     * Set poids
     *
     * @param integer $poids
     *
     * @return Animal
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;

        return $this;
    }

    /**
     * Get poids
     *
     * @return int
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     * Set dateNais
     *
     * @param \DateTime $dateNais
     *
     * @return Animal
     */
    public function setDateNais($dateNais)
    {
        $this->dateNais = new \DateTime("now");

        return $this;
    }

    /**
     * Get dateNais
     *
     * @return \DateTime
     */
    public function getDateNais()
    {
    	$dateString = $this->dateNais->format('d-m-Y');
        return $dateString;
    }



    /**
     * Set maitre
     *
     * @param \ExoPetsBundle\Entity\Maitre $maitre
     *
     * @return Animal
     */
    public function setMaitre(\ExoPetsBundle\Entity\Maitre $maitre = null)
    {
        $this->maitre = $maitre;

        return $this;
    }

    /**
     * Get maitre
     *
     * @return \ExoPetsBundle\Entity\Maitre
     */
    public function getMaitre()
    {
        return $this->maitre;
    }
}
