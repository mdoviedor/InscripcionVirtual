<?php

namespace Fundeuis\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProfesorCurso
 *
 * @ORM\Table(name="profesor_curso", indexes={@ORM\Index(name="fk_profesor_curso_1_idx", columns={"profesor"}), @ORM\Index(name="fk_profesor_curso_2_idx", columns={"curso"})})
 * @ORM\Entity
 */
class ProfesorCurso
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idprofesor_curso", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprofesorCurso;

    /**
     * @var \Profesor
     *
     * @ORM\ManyToOne(targetEntity="Profesor")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profesor", referencedColumnName="idprofesor")
     * })
     */
    private $profesor;

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
     * Get idprofesorCurso
     *
     * @return integer 
     */
    public function getIdprofesorCurso()
    {
        return $this->idprofesorCurso;
    }

    /**
     * Set profesor
     *
     * @param \Fundeuis\UsuarioBundle\Entity\Profesor $profesor
     * @return ProfesorCurso
     */
    public function setProfesor(\Fundeuis\UsuarioBundle\Entity\Profesor $profesor = null)
    {
        $this->profesor = $profesor;

        return $this;
    }

    /**
     * Get profesor
     *
     * @return \Fundeuis\UsuarioBundle\Entity\Profesor 
     */
    public function getProfesor()
    {
        return $this->profesor;
    }

    /**
     * Set curso
     *
     * @param \Fundeuis\UsuarioBundle\Entity\Curso $curso
     * @return ProfesorCurso
     */
    public function setCurso(\Fundeuis\UsuarioBundle\Entity\Curso $curso = null)
    {
        $this->curso = $curso;

        return $this;
    }

    /**
     * Get curso
     *
     * @return \Fundeuis\UsuarioBundle\Entity\Curso 
     */
    public function getCurso()
    {
        return $this->curso;
    }
}
