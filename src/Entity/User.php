<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface,\Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    /**
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {  
        return ['ROLE_ADMIN'];
    }

    /**
     * @return string|null The salt
     */
    public function getSalt()
    {
        
        return null;
    }

    public function eraseCredentials()
    {

    }

    /**
     * @return string the string representation
     * @since 5.1.0
     */
    public function serialize()
    {

        return serialize([
            $this->id,
            $this->username,
            $this->password
        ]);
    }

    /**
     * @param string $serialized <p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
  
        list(
            $this->id,
            $this->username,
            $this->password,
        )=unserialize($serialized, ['allowed_classes'=>false]);

    }
}
