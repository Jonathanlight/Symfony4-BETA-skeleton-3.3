<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class Users
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    public $username;
    /**
     * @ORM\Column(type="string", length=100)
     */
    public $email;
    /**
     * @ORM\Column(type="string", length=255)
     */
    public $password;
    /**
     * @ORM\Column(type="string", length=255)
     */
    public $roles;
}