<?php

namespace Fourum\Notification;

use Fourum\User\UserInterface;

interface NotificationRepositoryInterface
{
    /**
     * @param NotificationInterface $notification
     * @return NotificationInterface
     */
    public function createAndSave(NotificationInterface $notification);

    /**
     * @param UserInterface $user
     * @return array
     */
    public function getUnread(UserInterface $user);

    /**
     * @param UserInterface $user
     * @return array
     */
    public function getAll(UserInterface $user);

    /**
     * @param UserInterface $user
     */
    public function markAllRead(UserInterface $user);
}