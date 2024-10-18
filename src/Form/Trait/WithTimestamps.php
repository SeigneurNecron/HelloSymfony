<?php

namespace App\Form\Trait;

use App\Form\Attribute\BuildFormMethod;
use DateTimeImmutable;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;

trait WithTimestamps {

    #[BuildFormMethod]
    protected function buildFormWithTimestamps(FormBuilderInterface $builder, array $options): void {
        $builder
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->preSubmitWithTimestamps(...));
    }

    private function preSubmitWithTimestamps(PreSubmitEvent $event): void {
        $data = $event->getData();

        if(empty($data['id'])) {
            $data['dateCreated'] = new DateTimeImmutable();
        }

        $data['dateModified'] = new DateTimeImmutable();
        $event->setData($data);
    }

}
