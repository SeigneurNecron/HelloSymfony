<?php

namespace App\Entity\Final;

use App\Constant\UserRole as UR;
use App\Entity\Base\AbstractEntity;
use App\Repository\Final\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('username', message: "This username is already in use.")]
#[UniqueEntity('email', message: "This email is already in use.")]
class User extends AbstractEntity implements UserInterface, PasswordAuthenticatedUserInterface {

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "Please provide a username.")]
    #[Assert\Length(max: 180, maxMessage: "That username is too long.")]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message: "Please provide a valid email address.")]
    #[Assert\Length(max: 255, maxMessage: "That email is too long.")]
    #[Assert\Email(message: "Please provide a valid email address.")]
    private ?string $email = null;

    #[ORM\Column]
    private bool $isVerified = false;

    public function getUsername(): ?string {
        return $this->username;
    }

    public function setUsername(?string $username): static {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string {
        return (string) $this->username;
    }

    /**
     * @return list<string>
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles   = $this->roles;
        $roles[] = UR::ROLE_USER;
        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string {
        return $this->password;
    }

    public function setPassword(?string $password): static {
        $this->password = $password;

        return $this;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): static {
        $this->email = $email;

        return $this;
    }

    public function isVerified(): bool {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified): static {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function __toString() {
        return $this->username;
    }

}
