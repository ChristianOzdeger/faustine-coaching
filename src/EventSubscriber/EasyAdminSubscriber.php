<?php

namespace App\EventSubscriber;

use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setPasswordEncoded'],
            BeforeEntityUpdatedEvent::class => ['EncodPassword']
        ];
    }

    public function EncodPassword(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if(isset($entity->getPlainPassword)){

            if(empty($entity->getPlainPassword())){
                return;
            }
            
            $entity->setPassword($this->passwordEncoder->encodePassword($entity, $entity->getPlainPassword()));
        }
     }



    public function setPasswordEncoded(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Utilisateur)) {
            return;
        }

        $entity->setPassword($this->passwordEncoder->encodePassword($entity, $entity->getPassword()));

    }
}
