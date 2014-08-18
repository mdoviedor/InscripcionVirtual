<?php

namespace Fundeuis\EducacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsuarioCurso
 *
 * @ORM\Table(name="usuario_curso", indexes={@ORM\Index(name="fk_usuario_curso_1_idx", columns={"curso"}), @ORM\Index(name="fk_usuario_curso_2_idx", columns={"estudiantenf"})})
 * @ORM\Entity
 */
class UsuarioCurso
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idusuario_curso", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idusuarioCurso;

    /**
     * @var boolean
     *
     * @ORM\Column(name="estado", type="boolean", nullable=true)
     */
    private $estado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaRegistro", type="datetime", nullable=false)
     */
    private $fecharegistro;

    /**
     * @var \Curso
     *
     * @ORM\ManyToOne(targetEntity="Curso")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="curso", referencedColumnName="idcurso")
     * })
     */
    private $curso;

    /**
     * @var \Estudiantenf
     *
     * @ORM\ManyToOne(targetEntity="Estudiantenf")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estudiantenf", referencedColumnName="idusuario")
     * })
     */
    private $estudiantenf;



    /**
     * Get idusuarioCurso
     *
     * @return integer 
     */
    public function getIdusuarioCurso()
    {
        return $this->idusuarioCurso;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     * @return UsuarioCurso
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set fecharegistro
     *
     * @param \DateTime $fecharegistro
     * @return UsuarioCurso
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
     * Set curso
     *
     * @param \Fundeuis\EducacionBundle\Entity\Curso $curso
     * @return UsuarioCurso
     */
    public function setCurso(\Fundeuis\EducacionBundle\Entity\Curso $curso = null)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return \Fundeuis\EducacionBundle\Entity\Curso 
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * Set estudiantenf
     *
     * @param \Fundeuis\EducacionBundle\Entity\Estudiantenf $estudiantenf
     * @return UsuarioCurso
     */
    public function setEstudiantenf(\Fundeuis\EducacionBundle\Entity\Estudiantenf $estudiantenf = null)
    {
        $this->estudiantenf = $estudiantenf;

        return $this;
    }

    /**
     * Get estudiantenf
     *
     * @return \Fundeuis\EducacionBundle\Entity\Estudiantenf 
     */
    public function getEstudiantenf()
    {
        return $this->estudiantenf;
    }
}
