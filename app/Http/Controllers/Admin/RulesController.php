<?php

namespace Fourum\Http\Controllers\Admin;

use Fourum\Http\Controllers\AdminController;
use Fourum\Rule\RuleRepositoryInterface;
use Fourum\Setting\Manager;
use Illuminate\Http\Request;

class RulesController extends AdminController
{
    /**
     * @var RuleRepositoryInterface
     */
    protected $rules;

    /**
     * @param Manager $settings
     * @param RuleRepositoryInterface $rules
     */
    public function __construct(Manager $settings, RuleRepositoryInterface $rules)
    {
        parent::__construct($settings);

        $this->rules = $rules;
    }

    public function index()
    {
        return view('rules.index', ['rules' => $this->rules->getAll()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        $this->rules->createAndSave([
            'rule' => $request->get('rule')
        ]);

        return redirect('/admin/rules');
    }
}
