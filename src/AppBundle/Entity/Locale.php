<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Locale
 *
 * @ORM\Table(name="locales")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocaleRepository")
 */
class Locale
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
     * @ORM\Column(name="locale_name", type="string", length=255, unique=true)
     */
    private $locale_name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $locale_desc;

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
     * Set locale_name
     *
     * @param string $locale_name
     *
     * @return Locale
     */
    public function setName($locale_name)
    {
        $this->locale_name = $locale_name;

        return $this;
    }

    /**
     * Get locale_name
     *
     * @return string
     */
    public function getName()
    {
        return $this->locale_name;
    }

    /**
     * Set locale_desc
     *
     * @param string $locale_desc
     *
     * @return Locale
     */
    public function setDescription($locale_desc)
    {
        $this->locale_desc = $locale_desc;

        return $this;
    }

    /**
     * Get locale_desc
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->locale_desc;
    }

    /**
     * To string if it's called
     *
     * @return string
     */
    public function __toString()
    {
        return ucfirst($this->locale_desc);
    }
}

