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
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\User\UserInterface;
use Synth\NotificationBundle\Model\NotificationManager as BaseNotificationManager;
use Synth\NotificationBundle\Model\NotificationInterface;

class NotificationManager extends BaseNotificationManager
{
    protected $em;
    protected $class;
    protected $repository;

    /**
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

	/**
     * @param NotificationInterface[] $notifications
     */
    public function deleteNotifications(array $notifications)
    {
        foreach ($notifications as $notification) {
            $this->deleteNotification($notification);
        }
    }

    public function persistNotification(NotificationInterface $notification, $andFlush = true)
    {
        $this->em->persist($notification);
        if ($andFlush) {
            $this->em->flush();
        }
    }

	public function flushNotifcations()
	{
		$this->em->flush();
	}

    public function findNotificationBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    public function findNotificationByForUser(UserInterface $owner, array $criteria)
    {
        $criteria = array_merge($criteria, array(
            "owner" => $owner->getId()
        ));

        return $this->repository->findOneBy($criteria);
    }

    public function findNotificationsForUser(UserInterface $owner, array $order = array("createdAt" => "DESC"))
    {
        $criteria = array(
            "owner" => $owner->getId()
        );
        return $this->repository->findBy($criteria, $order);
    }

    public function findNotificationsForUserByType(UserInterface $owner, $type, array $order = array("createdAt" => "DESC"))
    {
        $criteria = array(
            "owner" => $owner->getId(),
            "type" => $type
        );
        return $this->repository->findBy($criteria, $order);
    }

    public function findNotificationsForUserExcludingType(UserInterface $owner, array $types, array $order = array("createdAt" => "DESC"), $excludeOwner = false)
    {
        $queryBuilder = $this->repository->createQueryBuilder("synth_notification");
        $queryBuilder
            ->where("synth_notification.owner = {$owner->getId()}");

        foreach ($types as $type) {
            $queryBuilder->andWhere("synth_notification.type <> {$type}");
        }

        if ($excludeOwner) {
            $queryBuilder->andWhere("synth_notification.fromUser <> {$owner->getId()}");
        }

        foreach ($order as $orderField => $orderDirection) {
            $queryBuilder->orderBy("synth_notification.{$orderField}", $orderDirection);
        }

        return $queryBuilder->getQuery()->getResult();
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
                ->andWhere("synth_notification.isRead = false");
        }

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function markNotificationsAsRead(UserInterface $owner, $type = null)
    {
        $queryBuilder = $this->createQueryBuilder();
        $queryBuilder
            ->update()
            ->set("synth_notification.isRead", '?1')
            ->Where("synth_notification.owner = {$owner->getId()}")
            ->setParameter(1, true);

        if ($type) {
            $queryBuilder
            ->andWhere("synth_notification.type = {$type}");
        }

        $queryBuilder->getQuery()->getResult();
    }

    public function markNotificationAsRead(NotificationInterface $notification)
    {
        $notification->setRead(true);

        $this->updateNotification($notification);
    }


    /**
     * @return QueryBuilder
     */
    public function createQueryBuilder()
    {
        return $this->repository->createQueryBuilder("synth_notification");
    }

    /**
     * @inheritdoc
     */
    public function getClass()
    {
        return $this->class;
    }
}