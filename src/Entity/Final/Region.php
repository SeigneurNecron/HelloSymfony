<?php

namespace App\Entity\Final;

use App\Entity\Base\AbstractNamedEntity;
use App\Entity\Base\AdminEntityCUD;
use App\Repository\Final\RegionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegionRepository::class)]
class Region extends AbstractNamedEntity implements AdminEntityCUD {

    /**
     * @var Collection<int, Character>
     */
    #[ORM\OneToMany(targetEntity: Character::class, mappedBy: 'region')]
    private Collection $characters;

    public function __construct() {
        $this->characters = new ArrayCollection();
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
            $character->setRegion($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): static {
        if($this->characters->removeElement($character)) {
            if($character->getRegion() === $this) {
                $character->setRegion(null);
            }
        }

        return $this;
    }

}
