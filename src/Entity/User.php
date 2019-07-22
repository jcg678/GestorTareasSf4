<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="role", type="string", length=50, nullable=true)
     */
    private $role;

    /**
     * @var string|null
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     * @Assert\NotBlank
     * @Assert\Regex("/[a-zA-Z]+/")
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="surname", type="string", length=200, nullable=true)
     * @Assert\NotBlank
     * @Assert\Regex("/[a-zA-Z]+/")
     */
    private $surname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     * @Assert\Email(message="El email no es valido")
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     * @Assert\NotBlank
     */
    private $password;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="create_at", type="datetime", nullable=true)
     */
    private $createAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="user")
     */
    private $tasks;

    public function __construct(){
        $this->task = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole(string $role)
    {
        $this->role = $role;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname(string $surname)
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    public function getCreateAt()
    {
        return $this->createAt;
    }

    public function setCreateAt( $createAt)
    {
        $this->createAt = $createAt;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks(){
        return $this->tasks;
    }



    public function getUsername(){
        return $this->email;
    }

    public function getSalt(){
        return null;
    }

    public function getRoles(){
        return array('ROLE_USER');
    }

    public function eraseCredentials(){

    }
}
