<?php

namespace Fourum\Reporting;

use Carbon\Carbon;
use Fourum\User\UserInterface;

interface ReportInterface
{
    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return UserInterface
     */
    public function getUser();

    /**
     * @return ReportableInterface
     */
    public function getReportable();

    public function markAsRead();

    /**
     * @return int
     */
    public function getId();

    /**
     * @return Carbon
     */
    public function getCreatedAt();
}