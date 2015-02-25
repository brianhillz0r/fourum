<?php

namespace Fourum\Notification;

use Carbon\Carbon;

interface NotificationInterface
{
    /**
     * @return string
     */
    public function getUrl();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return NotifiableInterface
     */
    public function getNotifiable();

    /**
     * @return NotifierInterface
     */
    public function getNotifier();

    /**
     * @return int
     */
    public function getType();

    /**
     * @return bool
     */
    public function isRead();

    public function markAsRead();

    /**
     * @return Carbon
     */
    public function getTimestamp();
}