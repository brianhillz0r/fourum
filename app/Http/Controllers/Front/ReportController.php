<?php

namespace Fourum\Http\Controllers\Front;

use Fourum\Http\Controllers\FrontController;
use Fourum\Reporting\ReportRepositoryInterface;
use Fourum\Repository\RepositoryRegistry;
use Illuminate\Http\Request;

class ReportController extends FrontController
{
    /**
     * @param RepositoryRegistry $repos
     * @param string $type
     * @param int $id
     */
    public function report(RepositoryRegistry $repos, $type, $id)
    {
        $repo = $repos->get($type);
        $subject = $repo->get($id);

        return $this->render('report.index', array(
            'subject' => $subject,
            'type' => $type,
            'id' => $id
        ));
    }

    /**
     * @param Request $request
     * @param RepositoryRegistry $repos
     * @param ReportRepositoryInterface $reports
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, RepositoryRegistry $repos, ReportRepositoryInterface $reports)
    {
        $repo = $repos->get($request->get('type'));
        $subject = $repo->get($request->get('id'));

        $reports->createAndSave($this->getUser(), $subject, $request->get('message'));

        return redirect($subject->getUrl());
    }
}
