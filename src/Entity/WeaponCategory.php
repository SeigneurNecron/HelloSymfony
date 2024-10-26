<?php

namespace App\Entity;

use App\Entity\Base\AbstractNamedEntity;
use App\Entity\Base\AdminEntityCUD;
use App\Repository\WeaponCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeaponCategoryRepository::class)]
class WeaponCategory extends AbstractNamedEntity implements AdminEntityCUD {

    /**
     * @var Collection<int, Character>
     */
    #[ORM\OneToMany(targetEntity: Character::class, mappedBy: 'weaponCategory')]
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
            $character->setWeaponCategory($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): static {
        if($this->characters->removeElement($character)) {
            if($character->getWeaponCategory() === $this) {
                $character->setWeaponCategory(null);
            }
        }

        return $this;
    }

}
