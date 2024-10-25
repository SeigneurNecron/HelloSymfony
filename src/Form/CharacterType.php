<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\Element;
use App\Entity\Region;
use App\Entity\WeaponCategory;
use App\Enum\Genre;
use App\Enum\Size;
use App\Form\Base\AbstractEntityType;
use App\Form\Trait\WithName;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @template-extends AbstractEntityType<Character>
 */
class CharacterType extends AbstractEntityType {

    use WithName;

    public function __construct() {
        parent::__construct(Character::class);
    }

    protected function doBuildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('rare', ChoiceType::class, options: [
                'choices' => ["No" => false, "Yes" => true]
            ])
            ->add('element', EntityType::class, options: [
                'class' => Element::class,
                'choice_label' => 'name',
            ])
            ->add('weaponCategory', EntityType::class, options: [
                'class' => WeaponCategory::class,
                'choice_label' => 'name',
            ])
            ->add('region', EntityType::class, options: [
                'class' => Region::class,
                'choice_label' => 'name',
            ])
            ->add('genre', EnumType::class, options: [
                'class' => Genre::class,
            ])
            ->add('size', EnumType::class, options: [
                'class' => Size::class,
            ])
            ->add('releaseDate', options: [
                'widget' => 'single_text',
            ])
            ->add('version');
    }

}
