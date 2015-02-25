<?php

namespace Fourum\Reporting;

use Fourum\User\UserInterface;

interface ReportableInterface
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
    public function getUrl();
}