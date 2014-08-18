<?php

namespace Fundeuis\UsuarioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nombrecurso
 *
 * @ORM\Table(name="nombreCurso")
 * @ORM\Entity
 */
class Nombrecurso
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idnombreCurso", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idnombrecurso;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     */
    private $nombre;



    /**
     * Get idnombrecurso
     *
     * @return integer 
     */
    public function getIdnombrecurso()
    {
        return $this->idnombrecurso;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Nombrecurso
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
}
