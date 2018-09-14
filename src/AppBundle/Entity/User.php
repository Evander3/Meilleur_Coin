<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use AppBundle\Entity\Role;

/**
* @ORM\Table(name="app_users")
* @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
*/
class User implements UserInterface, \Serializable
{
    /**
    * @ORM\Column(type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
    * @ORM\Column(type="string", length=25, unique=true)
    */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $surName;

    /**
    * @ORM\Column(type="string", length=64)
    */
    private $password;

    /**
    * @ORM\Column(type="string", length=254, unique=true)
    */
    private $email;

    /**
     * @ORM\Column(type="integer", length=1, unique=true)
     * @ManyToOne(targetEntity="Role")
     * @JoinColumn(name="role_name", referencedColumnName="id")
     */
    private $role;

    /**
     * @ORM\Column(type="integer", length=1, unique=false)
     * @ManyToOne(targetEntity="Locale")
     * @JoinColumn(name="locale_name", referencedColumnName="id")
     */
    private $user_locale;

    /**
    * @ORM\Column(name="is_active", type="boolean")
    */
    private $isActive;

    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid('', true));
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    public function getFirstname()
    {
        return $this->firstName;
    }
    public function setFirstname($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getSurname()
    {
        return $this->surName;
    }
    public function setSurname($surName)
    {
        $this->surName = $surName;

        return $this;
    }

    public function getFullname()
    {
        return "$this->firstName.$this->surName";
    }

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles()
    {
        return $this->Role->getRoleName();
    }
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    public function getUserLocale()
    {
        return $this->user_locale;
    }
    public function setUserLocale($user_locale)
    {
        $this->user_locale = $user_locale;

        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
    }
}