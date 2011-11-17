<?php

/**
 * This file is part of the Synth Notification Bundle.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Dom Udall <dom@synthmedia.co.uk>
 */

namespace Synth\NotificationBundle\Entity;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Synth\NotificationBundle\Model\NotificationManager as BaseNotificationManager;
use Synth\NotificationBundle\Model\NotificationInterface;

class NotificationManager extends BaseNotificationManager
{
    protected $em;
    protected $class;
    protected $repository;

    /**
     * Constructor.
     *
     * @param EntityManager           $em
     * @param string                  $class
     */
    public function __construct(EntityManager $em, $class)
    {
        $this->em = $em;
        $this->repository = $em->getRepository($class);

        $metadata = $em->getClassMetadata($class);
        $this->class = $metadata->name;
    }

    public function deleteNotification(NotificationInterface $notification)
    {
        $this->em->remove($notification);
        $this->em->flush();
    }

    public function updateNotification(NotificationInterface $notification, $andFlush = true)
    {
        $this->em->persist($notification);
        if ($andFlush) {
            $this->em->flush();
        }
    }

    public function findNotificationBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function findNotificationsForUser(UserInterface $owner)
    {
        $criteria = array(
            "owner" => $owner->getId()
        );
        return $this->repository->findBy($criteria);
    }

    public function findNotificationsForUserByType(UserInterface $owner, $type)
    {
        $criteria = array(
            "owner" => $owner->getId(),
            "type" => $type
        );
        return $this->repository->findBy($criteria);
    }

    public function getTotalNotifications(UserInterface $owner, $onlyUnread = true)
    {
        return $this->getNotificationCount($owner, null, $onlyUnread);
    }

    public function getTotalNotificationsForType(UserInterface $owner, $type, $onlyUnread = true)
    {
        return $this->getNotificationCount($owner, $type, $onlyUnread);
    }

    protected function getNotificationCount(UserInterface $owner, $type = null, $onlyUnread = null) {
        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder
            ->select($queryBuilder->expr()->count("synth_notification.id"))
            ->Where("synth_notification.owner = {$owner->getId()}");

        if ($type) {
            $queryBuilder
                ->andWhere("synth_notification.type = {$type}");
        }

        if ($onlyUnread) {
            $queryBuilder
                ->andWhere("synth_notification.read = false");
        }

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @return QueryBuilder
     */
    public function createQueryBuilder()
    {
        return $this->repository->createQueryBuilder("synth_notification");
    }

    public function getClass()
    {
        return $this->class;
    }
}