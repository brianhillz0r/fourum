<?php

namespace Fourum\Notification;

use Carbon\Carbon;
use Closure;
use Fourum\Repository\RepositoryFactory;

class NotificationFactory
{
    /**
     * @var RepositoryFactory
     */
    protected $repoFactory;

    /**
     * @var array
     */
    protected $types = [];

    /**
     * @param RepositoryFactory $repoFactory
     */
    public function __construct(RepositoryFactory $repoFactory)
    {
        $this->repoFactory = $repoFactory;
    }

    /**
     * @param int $type
     * @param string $foreignKey
     * @param int $foreignId
     * @param NotifiableInterface $notifiable
     * @param int $read
     * @param Carbon $timestamp
     * @return NotificationInterface
     */
    public function build($type, $foreignKey, $foreignId, NotifiableInterface $notifiable, $read, Carbon $timestamp)
    {
        $repo = $this->repoFactory->build($foreignKey);
        $notifier = $repo->get($foreignId);

        $notification = null;

        switch ($type) {
            case Mention::TYPE:
                $notification = new Mention($notifier, $notifiable, $read, $timestamp);
                break;

            default:
                foreach ($this->types as $key => $callback) {
                    if ($key == $type) {
                        $notification = $callback($notifier, $notifiable, $read, $timestamp);
                        break;
                    }
                }

                break;
        }

        return $notification;
    }

    /**
     * @param int $type
     * @param callable $callback
     */
    public function addType($type, Closure $callback)
    {
        $this->types[$type] = $callback;
    }
}
