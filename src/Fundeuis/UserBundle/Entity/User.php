<?php
namespace Fundeuis\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity()
 */
class User extends BaseUser {

    /**
     * @var bigint
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct() {
        parent::__construct();
// your own logic
    }

    /**
     * Get id
     *
     * @return bigint
     */
    public function getId() {
        return $this->id;
    }

    public function r($r) {
        $this->roles = array($r);
    }

}
