<?php

namespace Fourum\Notification;

use Carbon\Carbon;

class Mention implements NotificationInterface
{
    const TYPE = 'mention';

    /**
     * @var NotifierInterface
     */
    protected $notifier;

    /**
     * @var NotifiableInterface
     */
    protected $notifiable;

    /**
     * @var bool
     */
    protected $read;

    /**
     * @var Carbon
     */
    protected $timestamp;

    /**
     * @param NotifierInterface $notifier
     * @param NotifiableInterface $notifiable
     * @param bool $read
     * @param Carbon $timestamp
     */
    public function __construct(NotifierInterface $notifier, NotifiableInterface $notifiable, $read = false, Carbon $timestamp = null)
    {
        $this->notifier = $notifier;
        $this->notifiable = $notifiable;
        $this->read = $read;
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return "<a href=\"".url("/user/{$this->notifier->getAuthor()->getUsername()}")."\">{$this->notifier->getAuthor()->getUsername()}</a> mentioned you in a <a href=\"{$this->notifier->getUrl()}\">{$this->notifier->getEntityName()}</a>";
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->notifier->getUrl();
    }

    /**
     * @return NotifiableInterface
     */
    public function getNotifiable()
    {
        return $this->notifiable;
    }

    /**
     * @return NotifierInterface
     */
    public function getNotifier()
    {
        return $this->notifier;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return static::TYPE;
    }

    /**
     * @return bool
     */
    public function isRead()
    {
        return (bool) $this->read;
    }

    /**
     * @return Carbon
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function markAsRead()
    {
        $this->read = true;
    }
}