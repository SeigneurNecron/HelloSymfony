<?php

namespace App\Entity;

use App\Entity\Base\AbstractNamedEntity;
use App\Entity\Base\AdminEntityCUD;
use App\Repository\ElementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ElementRepository::class)]
class Element extends AbstractNamedEntity implements AdminEntityCUD {

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Please provide a color.")]
    #[Assert\Length(max: 255, maxMessage: "That color is too long.")]
    private ?string $color = null;

    /**
     * @var Collection<int, Character>
     */
    #[ORM\OneToMany(targetEntity: Character::class, mappedBy: 'element')]
    private Collection $characters;

    public function __construct() {
        $this->characters = new ArrayCollection();
    }

    public function getColor(): ?string {
        return $this->color;
    }

    public function setColor(string $color): static {
        $this->color = trim($color);

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getCharacters(): Collection {
        return $this->characters;
    }

    public function addCharacter(Character $character): static {
        if(!$this->characters->contains($character)) {
            $this->characters->add($character);
            $character->setElement($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): static {
        if($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if($character->getElement() === $this) {
                $character->setElement(null);
            }
        }

        return $this;
    }

}
