<?php

namespace App\EventSubscriber;

use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminSubscriberAdminPasswordChange implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher)
    {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['addAdmin'],
            BeforeEntityUpdatedEvent::class => ['updateAdmin'],
        ];
    }

    public function updateAdmin(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Admin)) {
            return;
        }
        $this->setPassword($entity);
    }


    public function addAdmin(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Admin)) {
            return;
        }
        $this->setPassword($entity);
    }

    public function setPassword(Admin $entity): void
    {
        $pass = $entity->getPassword();

        $entity->setPassword(
            $this->passwordHasher->hashPassword(
                $entity,
                $pass
            )
        );

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
