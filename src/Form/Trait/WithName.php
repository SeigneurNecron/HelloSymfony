<?php

namespace App\Form\Trait;

use App\Form\Attribute\BuildFormMethod;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\String\Slugger\AsciiSlugger;

trait WithName {

    #[BuildFormMethod]
    protected function buildFormWithName(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('name', options: ['attr' => ['autofocus' => true]])
            ->add('slug', options: ['required' => false])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->preSubmitWithName(...));
    }

    private function preSubmitWithName(PreSubmitEvent $event): void {
        $data = $event->getData();

        if(empty($data['slug'])) {
            $slugger = new AsciiSlugger();
            $data['slug'] = $slugger->slug($data['name'], '');
            $event->setData($data);
        }
    }

}
