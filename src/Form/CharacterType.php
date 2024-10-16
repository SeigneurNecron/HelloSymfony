<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\Element;
use App\Entity\Region;
use App\Entity\WeaponCategory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('name')
            ->add('rare')
            ->add('element', EntityType::class, [
                'class' => Element::class,
                'choice_label' => 'id',
            ])
            ->add('weaponCategory', EntityType::class, [
                'class' => WeaponCategory::class,
                'choice_label' => 'id',
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'id',
            ])
            ->add('genre')
            ->add('size')
            ->add('version')
            ->add('releaseDate', null, [
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }

}
