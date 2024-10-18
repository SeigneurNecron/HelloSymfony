<?php

namespace App\Form\Trait;

use App\Form\Attribute\BuildFormMethod;
use DateTimeImmutable;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;

trait WithTimestamps {

    #[BuildFormMethod]
    protected function buildFormWithTimestamps(FormBuilderInterface $builder, array $options): void {
        $builder
            ->addEventListener(FormEvents::SUBMIT, $this->submitWithTimestamps(...));
    }

    private function submitWithTimestamps(SubmitEvent $event): void {
        $data = $event->getData();

        if(empty($data->getId())) {
            $data->setDateCreated(new DateTimeImmutable());
        }

        $data->setDateModified(new DateTimeImmutable());
    }

}
