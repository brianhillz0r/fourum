<?php

namespace Fourum\Http\Controllers\Admin;

use Fourum\Http\Controllers\AdminController;
use Fourum\Reporting\ReportRepositoryInterface;
use Fourum\Setting\Manager;

class ReportsController extends AdminController
{
    /**
     * @var ReportRepositoryInterface
     */
    protected $reports;

    /**
     * @param Manager $settings
     * @param ReportRepositoryInterface $reports
     */
    public function __construct(Manager $settings, ReportRepositoryInterface $reports)
    {
        parent::__construct($settings);

        $this->reports = $reports;
    }

    public function index()
    {
        $reports = $this->reports->getUnread();

        return view('reports.index', ['reports' => $reports]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markRead($id)
    {
        $report = $this->reports->get($id);
        $report->markAsRead();

        $this->reports->save($report);

        return redirect('admin/reports');
    }
}
