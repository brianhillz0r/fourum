<?php

namespace Fourum\Notification\Eloquent;

use Fourum\Model\Notification;
use Fourum\Notification\NotificationFactory;
use Fourum\Notification\NotificationInterface;
use Fourum\Notification\NotificationRepositoryInterface;
use Fourum\Notification\Type\TypeRepositoryInterface;
use Fourum\User\UserInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    /**
     * @var NotificationFactory
     */
    protected $factory;

    /**
     * @var TypeRepositoryInterface
     */
    protected $types;

    /**
     * @param NotificationFactory $factory
     * @param TypeRepositoryInterface $types
     */
    public function __construct(NotificationFactory $factory, TypeRepositoryInterface $types)
    {
        $this->factory = $factory;
        $this->types = $types;
    }

    /**
     * @param NotificationInterface $notification
     * @return NotificationInterface
     */
    public function createAndSave(NotificationInterface $notification)
    {
        $type = $this->types->getByName($notification->getType());

        Notification::create(array(
            'user_id' => $notification->getNotifiable()->getId(),
            'type' => $type->getId(),
            'foreign_key' => $notification->getNotifier()->getForeignKey(),
            'foreign_id' => $notification->getNotifier()->getId()
        ));
    }

    /**
     * @param UserInterface $user
     * @return array
     */
    public function getUnread(UserInterface $user)
    {
        $notifications = Notification::where('user_id', $user->getId())
            ->where('read', 0)
            ->orderBy('created_at', 'desc')
            ->get()
            ->all();

        return $this->normaliseAll($notifications, $user);
    }

    /**
     * @param UserInterface $user
     * @return array
     */
    public function getAll(UserInterface $user)
    {
        $notifications = Notification::where('user_id', $user->getId())
            ->orderBy('created_at', 'desc')
            ->get()
            ->all();

        return $this->normaliseAll($notifications, $user);
    }

    /**
     * @param UserInterface $user
     */
    public function markAllRead(UserInterface $user)
    {
        $notifications = Notification::where('user_id', $user->getId())
            ->where('read', 0)
            ->get()
            ->all();

        foreach ($notifications as $notification) {
            $notification->markAsRead();
            $notification->save();
        }
    }

    /**
     * @param array $notifications
     * @param UserInterface $user
     * @return array
     */
    protected function normaliseAll(array $notifications, UserInterface $user)
    {
        $normalised = array();

        foreach ($notifications as $notification) {
            $normalised[] = $this->normalise($notification, $user);
        }

        return $normalised;
    }

    /**
     * @param Notification $notification
     * @param UserInterface $user
     * @return mixed
     */
    protected function normalise(Notification $notification, UserInterface $user)
    {
        $n = $this->factory->build(
            $notification->getType()->getName(),
            $notification->getForeignKey(),
            $notification->getForeignId(),
            $user,
            $notification->isRead(),
            $notification->getCreatedAt()
        );

        return $n;
    }
}