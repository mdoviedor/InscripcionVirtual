<?php

namespace Fundeuis\EducacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Administrador
 *
 * @ORM\Table(name="administrador", indexes={@ORM\Index(name="tdi_administrador_idx", columns={"tipoDocumentoIdentidad"}), @ORM\Index(name="u_administrador_idx", columns={"user"}), @ORM\Index(name="r_administrador_idx", columns={"rol"}), @ORM\Index(name="a_administrador_idx", columns={"autor"})})
 * @ORM\Entity
 */
class Administrador
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idadministrador", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idadministrador;

    /**
     * @var string
     *
     * @ORM\Column(name="documentoIdentidad", type="string", length=20, nullable=false)
     */
    private $documentoidentidad;

    /**
     * @var string
     *
     * @ORM\Column(name="nombres", type="string", length=80, nullable=false)
     */
    private $nombres;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=80, nullable=false)
     */
    private $apellidos;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaRegistro", type="datetime", nullable=false)
     */
    private $fecharegistro;

    /**
     * @var \Tipodocumentoidentidad
     *
     * @ORM\ManyToOne(targetEntity="Tipodocumentoidentidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoDocumentoIdentidad", referencedColumnName="idtipoDocumentoIdentidad")
     * })
     */
    private $tipodocumentoidentidad;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user", referencedColumnName="id")
     * })
     */
    private $user;

    /**
     * @var \Rol
     *
     * @ORM\ManyToOne(targetEntity="Rol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rol", referencedColumnName="idrol")
     * })
     */
    private $rol;

    /**
     * @var \Administrador
     *
     * @ORM\ManyToOne(targetEntity="Administrador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="autor", referencedColumnName="idadministrador")
     * })
     */
    private $autor;



    /**
     * Get idadministrador
     *
     * @return integer 
     */
    public function getIdadministrador()
    {
        return $this->idadministrador;
    }

    /**
     * Set documentoidentidad
     *
     * @param string $documentoidentidad
     * @return Administrador
     */
    public function setDocumentoidentidad($documentoidentidad)
    {
        $this->documentoidentidad = $documentoidentidad;

        return $this;
    }

    /**
     * Get documentoidentidad
     *
     * @return string 
     */
    public function getDocumentoidentidad()
    {
        return $this->documentoidentidad;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return Administrador
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Administrador
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
     * Set fecharegistro
     *
     * @param \DateTime $fecharegistro
     * @return Administrador
     */
    public function setFecharegistro($fecharegistro)
    {
        $this->fecharegistro = $fecharegistro;

        return $this;
    }

    /**
     * Get fecharegistro
     *
     * @return \DateTime 
     */
    public function getFecharegistro()
    {
        return $this->fecharegistro;
    }

    /**
     * Set tipodocumentoidentidad
     *
     * @param \Fundeuis\EducacionBundle\Entity\Tipodocumentoidentidad $tipodocumentoidentidad
     * @return Administrador
     */
    public function setTipodocumentoidentidad(\Fundeuis\EducacionBundle\Entity\Tipodocumentoidentidad $tipodocumentoidentidad = null)
    {
        $this->tipodocumentoidentidad = $tipodocumentoidentidad;

        return $this;
    }

    /**
     * Get tipodocumentoidentidad
     *
     * @return \Fundeuis\EducacionBundle\Entity\Tipodocumentoidentidad 
     */
    public function getTipodocumentoidentidad()
    {
        return $this->tipodocumentoidentidad;
    }

    /**
     * Set user
     *
     * @param \Fundeuis\EducacionBundle\Entity\User $user
     * @return Administrador
     */
    public function setUser(\Fundeuis\EducacionBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Fundeuis\EducacionBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set rol
     *
     * @param \Fundeuis\EducacionBundle\Entity\Rol $rol
     * @return Administrador
     */
    public function setRol(\Fundeuis\EducacionBundle\Entity\Rol $rol = null)
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return \Fundeuis\EducacionBundle\Entity\Rol 
     */
    public function getRol()
    {
        return $this->rol;
    }

    /**
     * Set autor
     *
     * @param \Fundeuis\EducacionBundle\Entity\Administrador $autor
     * @return Administrador
     */
    public function setAutor(\Fundeuis\EducacionBundle\Entity\Administrador $autor = null)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return \Fundeuis\EducacionBundle\Entity\Administrador 
     */
    public function getAutor()
    {
        return $this->autor;
    }
}
