<?php

namespace ExoPetsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Maitre
 *
 * @ORM\Table(name="maitre")
 * @ORM\Entity(repositoryClass="ExoPetsBundle\Repository\MaitreRepository")
 */
class Maitre
{
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
     * @ORM\OneToMany(targetEntity="ExoPetsBundle\Entity\Animal", mappedBy="maitre", cascade={"persist"})
     */
    private $animal;

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
     * @return Maitre
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
     * Constructor
     */
    public function __construct()
    {
        $this->animal = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add animal
     *
     * @param \ExoPetsBundle\Entity\Animal $animal
     *
     * @return Maitre
     */
    public function addAnimal(\ExoPetsBundle\Entity\Animal $animal)
    {
        $this->animal[] = $animal;
        $animal->setMaitre($this);
        return $this;
    }

    /**
     * Remove animal
     *
     * @param \ExoPetsBundle\Entity\Animal $animal
     */
    public function removeAnimal(\ExoPetsBundle\Entity\Animal $animal)
    {
        $this->animal->removeElement($animal);
    }

    /**
     * Get animal
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnimal()
    {
        return $this->animal;
    }

    public function __toString() {
        return $this->getNom();
    }
}
