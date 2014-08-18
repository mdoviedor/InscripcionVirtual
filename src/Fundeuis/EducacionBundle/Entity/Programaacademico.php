<?php

namespace Fundeuis\EducacionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Programaacademico
 *
 * @ORM\Table(name="programaAcademico")
 * @ORM\Entity
 */
class Programaacademico
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idprogramaAcademico", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idprogramaacademico;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     */
    private $nombre;



    /**
     * Get idprogramaacademico
     *
     * @return integer 
     */
    public function getIdprogramaacademico()
    {
        return $this->idprogramaacademico;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Programaacademico
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
