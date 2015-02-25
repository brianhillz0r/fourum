<?php

namespace Fourum\Notification;

use Fourum\User\UserInterface;

interface NotifierInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getForeignKey();

    /**
     * @return UserInterface
     */
    public function getAuthor();

    /**
     * @return string
     */
    public function getEntityName();

    /**
     * @return string
     */
    public function getUrl();
}