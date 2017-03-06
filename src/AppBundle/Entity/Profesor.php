<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 */
class Profesor implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @var string
     */
    private $dni;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $clave;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $nombre;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $apellidos;

    /**
     * @ORM\OneToMany(targetEntity="Parte", mappedBy="profesor")
     */
    private $partes;

    /**
     * @ORM\OneToOne(targetEntity="Grupo", mappedBy="tutor")
     */
    private $tutoria;

    /**
     * @ORM\ManyToMany(targetEntity="Grupo", inversedBy="profesorado")
     */
    private $grupos;

    /**
     * Convierte el profesor en una cadena de texto
     */
    public function __toString()
    {
        return $this->getApellidos() . ', ' . $this->getNombre();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->partes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->grupos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dni
     *
     * @param string $dni
     *
     * @return Profesor
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Profesor
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     *
     * @return Profesor
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Add parte
     *
     * @param Parte $parte
     *
     * @return Profesor
     */
    public function addParte(Parte $parte)
    {
        $this->partes[] = $parte;

        return $this;
    }

    /**
     * Remove parte
     *
     * @param Parte $parte
     */
    public function removeParte(Parte $parte)
    {
        $this->partes->removeElement($parte);
    }

    /**
     * Get partes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPartes()
    {
        return $this->partes;
    }

    /**
     * Set tutoria
     *
     * @param Grupo $tutoria
     *
     * @return Profesor
     */
    public function setTutoria(Grupo $tutoria = null)
    {
        $this->tutoria = $tutoria;

        return $this;
    }

    /**
     * Get tutoria
     *
     * @return Grupo
     */
    public function getTutoria()
    {
        return $this->tutoria;
    }

    /**
     * Add grupo
     *
     * @param Grupo $grupo
     *
     * @return Profesor
     */
    public function addGrupo(Grupo $grupo)
    {
        $this->grupos[] = $grupo;

        return $this;
    }

    /**
     * Remove grupo
     *
     * @param Grupo $grupo
     */
    public function removeGrupo(Grupo $grupo)
    {
        $this->grupos->removeElement($grupo);
    }

    /**
     * Get grupos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGrupos()
    {
        return $this->grupos;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
