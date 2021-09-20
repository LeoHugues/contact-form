<?php

namespace App\EventSubscriber;

use App\Entity\ContactRequest;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

class DatabaseActivitySubscriber implements EventSubscriberInterface
{
    public function getSubscribedEvents() : array
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof ContactRequest) {
            $this->createJsonFile($entity);
        }
    }

    private function createJsonFile(ContactRequest $contactRequest): void
    {
            $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

            $encoder = new JsonEncoder();
            $normalizer = new ObjectNormalizer($classMetadataFactory);
            $serializer = new Serializer([$normalizer], [$encoder]);

            $serializedContactRequest = $serializer->serialize($contactRequest, 'json', ['groups' => 'export']);

            $filesystem = new Filesystem();
            $path = '../jsonfiles/contactRequest-' . $contactRequest->getCreateDateToString();

            $filesystem->dumpFile($path, $serializedContactRequest);
    }
}
