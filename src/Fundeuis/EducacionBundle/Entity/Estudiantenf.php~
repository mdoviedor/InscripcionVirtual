<?php

namespace Fundeuis\EducacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estudiantenf
 *
 * @ORM\Table(name="estudiantenf", indexes={@ORM\Index(name="u_estudianteenf_idx", columns={"user"}), @ORM\Index(name="u_rol_idx", columns={"rol"}), @ORM\Index(name="autor_estudiantenf_idx", columns={"autor"}), @ORM\Index(name="p_estudiantenf_idx", columns={"programaAcademico"}), @ORM\Index(name="tdi_estudiantenf_idx", columns={"tipoDocumentoIdentidad"}), @ORM\Index(name="c_estudiantenf_idx", columns={"ciudad"}), @ORM\Index(name="co_estudiantenf_idx", columns={"conocimiento"})})
 * @ORM\Entity(repositoryClass="Fundeuis\EducacionBundle\Entity\EstudiantenfRepository")
 */
class Estudiantenf {

    /**
     * @var integer
     *
     * @ORM\Column(name="idusuario", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idusuario;

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
     * @var string
     *
     * @ORM\Column(name="edad", type="string", length=2, nullable=false)
     */
    private $edad;

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
     * @var string
     *
     * @ORM\Column(name="estrato", type="string", length=1, nullable=false)
     */
    private $estrato;

    /**
     * @var string
     *
     * @ORM\Column(name="universidad", type="string", length=200, nullable=false)
     */
    private $universidad;

    /**
     * @var string
     *
     * @ORM\Column(name="colegio", type="string", length=200, nullable=false)
     */
    private $colegio;

    /**
     * @var string
     *
     * @ORM\Column(name="nombresAcudiente", type="string", length=80, nullable=false)
     */
    private $nombresacudiente;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidosAcudiente", type="string", length=80, nullable=false)
     */
    private $apellidosacudiente;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonoAcudiente", type="string", length=15, nullable=false)
     */
    private $telefonoacudiente;

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
     * @var \Programaacademico
     *
     * @ORM\ManyToOne(targetEntity="Programaacademico")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="programaAcademico", referencedColumnName="idprogramaAcademico")
     * })
     */
    private $programaacademico;

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
     * @var \Ciudad
     *
     * @ORM\ManyToOne(targetEntity="Ciudad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ciudad", referencedColumnName="idciudad")
     * })
     */
    private $ciudad;

    /**
     * @var \Conocimiento
     *
     * @ORM\ManyToOne(targetEntity="Conocimiento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="conocimiento", referencedColumnName="idconocimiento")
     * })
     */
    private $conocimiento;

    /**
     * Get idusuario
     *
     * @return integer 
     */
    public function getId() {
        return $this->idusuario;
    }

    /**
     * Set documentoidentidad
     *
     * @param string $documentoidentidad
     * @return Estudiantenf
     */
    public function setDocumentoidentidad($documentoidentidad) {
        $this->documentoidentidad = $documentoidentidad;

        return $this;
    }

    /**
     * Get documentoidentidad
     *
     * @return string 
     */
    public function getDocumentoidentidad() {
        return $this->documentoidentidad;
    }

    /**
     * Set nombres
     *
     * @param string $nombres
     * @return Estudiantenf
     */
    public function setNombres($nombres) {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres() {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     * @return Estudiantenf
     */
    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos() {
        return $this->apellidos;
    }

    /**
     * Set edad
     *
     * @param string $edad
     * @return Estudiantenf
     */
    public function setEdad($edad) {
        $this->edad = $edad;

        return $this;
    }

    /**
     * Get edad
     *
     * @return string 
     */
    public function getEdad() {
        return $this->edad;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Estudiantenf
     */
    public function setTelefono($telefono) {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono() {
        return $this->telefono;
    }

    /**
     * Set celular
     *
     * @param string $celular
     * @return Estudiantenf
     */
    public function setCelular($celular) {
        $this->celular = $celular;

        return $this;
    }

    /**
     * Get celular
     *
     * @return string 
     */
    public function getCelular() {
        return $this->celular;
    }

    /**
     * Set estrato
     *
     * @param string $estrato
     * @return Estudiantenf
     */
    public function setEstrato($estrato) {
        $this->estrato = $estrato;

        return $this;
    }

    /**
     * Get estrato
     *
     * @return string 
     */
    public function getEstrato() {
        return $this->estrato;
    }

    /**
     * Set universidad
     *
     * @param string $universidad
     * @return Estudiantenf
     */
    public function setUniversidad($universidad) {
        $this->universidad = $universidad;

        return $this;
    }

    /**
     * Get universidad
     *
     * @return string 
     */
    public function getUniversidad() {
        return $this->universidad;
    }

    /**
     * Set colegio
     *
     * @param string $colegio
     * @return Estudiantenf
     */
    public function setColegio($colegio) {
        $this->colegio = $colegio;

        return $this;
    }

    /**
     * Get colegio
     *
     * @return string 
     */
    public function getColegio() {
        return $this->colegio;
    }

    /**
     * Set nombresacudiente
     *
     * @param string $nombresacudiente
     * @return Estudiantenf
     */
    public function setNombresacudiente($nombresacudiente) {
        $this->nombresacudiente = $nombresacudiente;

        return $this;
    }

    /**
     * Get nombresacudiente
     *
     * @return string 
     */
    public function getNombresacudiente() {
        return $this->nombresacudiente;
    }

    /**
     * Set apellidosacudiente
     *
     * @param string $apellidosacudiente
     * @return Estudiantenf
     */
    public function setApellidosacudiente($apellidosacudiente) {
        $this->apellidosacudiente = $apellidosacudiente;

        return $this;
    }

    /**
     * Get apellidosacudiente
     *
     * @return string 
     */
    public function getApellidosacudiente() {
        return $this->apellidosacudiente;
    }

    /**
     * Set telefonoacudiente
     *
     * @param string $telefonoacudiente
     * @return Estudiantenf
     */
    public function setTelefonoacudiente($telefonoacudiente) {
        $this->telefonoacudiente = $telefonoacudiente;

        return $this;
    }

    /**
     * Get telefonoacudiente
     *
     * @return string 
     */
    public function getTelefonoacudiente() {
        return $this->telefonoacudiente;
    }

    /**
     * Set user
     *
     * @param \Fundeuis\EducacionBundle\Entity\User $user
     * @return Estudiantenf
     */
    public function setUser(\Fundeuis\EducacionBundle\Entity\User $user = null) {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Fundeuis\EducacionBundle\Entity\User 
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * Set rol
     *
     * @param \Fundeuis\EducacionBundle\Entity\Rol $rol
     * @return Estudiantenf
     */
    public function setRol(\Fundeuis\EducacionBundle\Entity\Rol $rol = null) {
        $this->rol = $rol;

        return $this;
    }

    /**
     * Get rol
     *
     * @return \Fundeuis\EducacionBundle\Entity\Rol 
     */
    public function getRol() {
        return $this->rol;
    }

    /**
     * Set autor
     *
     * @param \Fundeuis\EducacionBundle\Entity\Administrador $autor
     * @return Estudiantenf
     */
    public function setAutor(\Fundeuis\EducacionBundle\Entity\Administrador $autor = null) {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return \Fundeuis\EducacionBundle\Entity\Administrador 
     */
    public function getAutor() {
        return $this->autor;
    }

    /**
     * Set programaacademico
     *
     * @param \Fundeuis\EducacionBundle\Entity\Programaacademico $programaacademico
     * @return Estudiantenf
     */
    public function setProgramaacademico(\Fundeuis\EducacionBundle\Entity\Programaacademico $programaacademico = null) {
        $this->programaacademico = $programaacademico;

        return $this;
    }

    /**
     * Get programaacademico
     *
     * @return \Fundeuis\EducacionBundle\Entity\Programaacademico 
     */
    public function getProgramaacademico() {
        return $this->programaacademico;
    }

    /**
     * Set tipodocumentoidentidad
     *
     * @param \Fundeuis\EducacionBundle\Entity\Tipodocumentoidentidad $tipodocumentoidentidad
     * @return Estudiantenf
     */
    public function setTipodocumentoidentidad(\Fundeuis\EducacionBundle\Entity\Tipodocumentoidentidad $tipodocumentoidentidad = null) {
        $this->tipodocumentoidentidad = $tipodocumentoidentidad;

        return $this;
    }

    /**
     * Get tipodocumentoidentidad
     *
     * @return \Fundeuis\EducacionBundle\Entity\Tipodocumentoidentidad 
     */
    public function getTipodocumentoidentidad() {
        return $this->tipodocumentoidentidad;
    }

    /**
     * Set ciudad
     *
     * @param \Fundeuis\EducacionBundle\Entity\Ciudad $ciudad
     * @return Estudiantenf
     */
    public function setCiudad(\Fundeuis\EducacionBundle\Entity\Ciudad $ciudad = null) {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return \Fundeuis\EducacionBundle\Entity\Ciudad 
     */
    public function getCiudad() {
        return $this->ciudad;
    }

    /**
     * Set conocimiento
     *
     * @param \Fundeuis\EducacionBundle\Entity\Conocimiento $conocimiento
     * @return Estudiantenf
     */
    public function setConocimiento(\Fundeuis\EducacionBundle\Entity\Conocimiento $conocimiento = null) {
        $this->conocimiento = $conocimiento;

        return $this;
    }

    /**
     * Get conocimiento
     *
     * @return \Fundeuis\EducacionBundle\Entity\Conocimiento 
     */
    public function getConocimiento() {
        return $this->conocimiento;
    }

    /**
     * Get idusuario
     *
     * @return integer 
     */
    public function getIdusuario() {
        return $this->idusuario;
    }

}
