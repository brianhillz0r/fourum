<?php

namespace Fourum\Reporting;

use Fourum\User\UserInterface;
use Illuminate\Support\Collection;

interface ReportRepositoryInterface
{
    /**
     * @param UserInterface $user
     * @param ReportableInterface $reportable
     * @param string $message
     * @return ReportInterface
     */
    public function createAndSave(UserInterface $user, ReportableInterface $reportable, $message = null);

    /**
     * @return Collection
     */
    public function getUnread();

    /**
     * @param ReportInterface $report
     */
    public function save(ReportInterface $report);

    /**
     * @param int $id
     * @return ReportInterface
     */
    public function get($id);

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param ReportableInterface $reportable
     * @return Collection
     */
    public function getByReportable(ReportableInterface $reportable);
}