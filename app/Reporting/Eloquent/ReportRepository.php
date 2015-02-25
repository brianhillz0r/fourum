<?php

namespace Fourum\Reporting\Eloquent;

use Fourum\Model\Report;
use Fourum\Reporting\ReportableInterface;
use Fourum\Reporting\ReportInterface;
use Fourum\Reporting\ReportRepositoryInterface;
use Fourum\User\UserInterface;
use Illuminate\Support\Collection;

class ReportRepository implements ReportRepositoryInterface
{
    /**
     * @param UserInterface $user
     * @param ReportableInterface $reportable
     * @param string $message
     * @return ReportInterface
     */
    public function createAndSave(UserInterface $user, ReportableInterface $reportable, $message = null)
    {
        return Report::create(array(
            'message' => $message,
            'user_id' => $user->getId(),
            'foreign_id' => $reportable->getId(),
            'foreign_key' => $reportable->getForeignKey()
        ));
    }

    /**
     * @param ReportInterface $report
     */
    public function save(ReportInterface $report)
    {
        $report->save();
    }

    /**
     * @return Collection
     */
    public function getUnread()
    {
        return Report::where('read', 0)->get()->all();
    }

    /**
     * @param int $id
     * @return Report
     */
    public function get($id)
    {
        return Report::find($id);
    }

    /**
     * @return Collection
     */
    public function getAll()
    {
        return Report::all();
    }

    /**
     * @param ReportableInterface $reportable
     * @return Collection
     */
    public function getByReportable(ReportableInterface $reportable)
    {
        return Report::where('foreign_id', $reportable->getId())
            ->where('foreign_key', $reportable->getForeignKey())
            ->get()
            ->all();
    }
}