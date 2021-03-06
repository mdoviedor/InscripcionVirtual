<?php

namespace Fundeuis\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conocimiento
 *
 * @ORM\Table(name="conocimiento")
 * @ORM\Entity
 */
class Conocimiento
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idconocimiento", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idconocimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=200, nullable=false)
     */
    private $descripcion;



    /**
     * Get idconocimiento
     *
     * @return integer 
     */
    public function getIdconocimiento()
    {
        return $this->idconocimiento;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Conocimiento
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
}
