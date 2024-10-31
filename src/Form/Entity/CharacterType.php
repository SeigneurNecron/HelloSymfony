<?php

namespace App\Form\Entity;

use App\Entity\Final\Character;
use App\Entity\Final\Element;
use App\Entity\Final\Region;
use App\Entity\Final\WeaponCategory;
use App\Enum\Genre;
use App\Enum\Size;
use App\Form\Base\AbstractEntityType;
use App\Form\Field\NameAndSlugType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @template-extends AbstractEntityType<Character>
 */
class CharacterType extends AbstractEntityType {

    public function __construct() {
        parent::__construct(Character::class);
    }

    protected function doBuildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add(
                'nameAndSlug', NameAndSlugType::class,
            )
            ->add(
                'rare', ChoiceType::class, options: [
                'choices' => ["No" => false, "Yes" => true],
            ],
            )
            ->add(
                'element', EntityType::class, options: [
                'class'        => Element::class,
                'choice_label' => 'name',
            ],
            )
            ->add(
                'weaponCategory', EntityType::class, options: [
                'class'        => WeaponCategory::class,
                'choice_label' => 'name',
            ],
            )
            ->add(
                'region', EntityType::class, options: [
                'class'        => Region::class,
                'choice_label' => 'name',
            ],
            )
            ->add(
                'genre', EnumType::class, options: [
                'class' => Genre::class,
            ],
            )
            ->add(
                'size', EnumType::class, options: [
                'class' => Size::class,
            ],
            )
            ->add(
                'releaseDate', options: [
                'widget' => 'single_text',
            ],
            )
            ->add(
                'version',
            );
    }

}
