<?php

namespace Fundeuis\EducacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profesor
 *
 * @ORM\Table(name="profesor", indexes={@ORM\Index(name="fk_profesor_1_idx", columns={"rol"}), @ORM\Index(name="fk_profesor_2_idx", columns={"tipoDocumentoIdentidad"}), @ORM\Index(name="fk_profesor_3_idx", columns={"user"}), @ORM\Index(name="fk_profesor_4_idx", columns={"autor"})})
 * @ORM\Entity
 */
class Profesor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idprofesor", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprofesor;

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
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=15, nullable=true)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="celular", type="string", length=15, nullable=true)
     */
    private $celular;

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
     * @var \Administrador
     *
     * @ORM\ManyToOne(targetEntity="Administrador")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="autor", referencedColumnName="idadministrador")
     * })
     */
    private $autor;



    /**
     * Get idprofesor
     *
     * @return integer 
     */
    public function getIdprofesor()
    {
        return $this->idprofesor;
    }

    /**
     * Set documentoidentidad
     *
     * @param string $documentoidentidad
     * @return Profesor
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
     * @return Profesor
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
     * Set fecharegistro
     *
     * @param \DateTime $fecharegistro
     * @return Profesor
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
     * Set telefono
     *
     * @param string $telefono
     * @return Profesor
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Profesor
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Set rol
     *
     * @param \Fundeuis\EducacionBundle\Entity\Rol $rol
     * @return Profesor
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
     * Set tipodocumentoidentidad
     *
     * @param \Fundeuis\EducacionBundle\Entity\Tipodocumentoidentidad $tipodocumentoidentidad
     * @return Profesor
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
     * @return Profesor
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
     * Set autor
     *
     * @param \Fundeuis\EducacionBundle\Entity\Administrador $autor
     * @return Profesor
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
