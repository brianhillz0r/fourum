<?php

namespace Fourum\Http\Controllers\Admin;

use Fourum\Http\Controllers\AdminController;
use Fourum\Setting\Manager;
use Illuminate\Http\Request;

/**
 * Settings Controller
 */
class SettingsController extends AdminController
{
    /**
     * @var Manager
     */
    protected $settings;

    /**
     * @param Manager $settings
     */
    public function __construct(Manager $settings)
    {
        parent::__construct($settings);

        $this->settings = $settings;
        $this->setTitle('Settings');
    }

    /**
     * General Settings
     */
    public function index()
    {
        $settings = $this->settings->getByNamespace('general');

        $data['settings'] = $settings;
        $data['namespace'] = 'general';
        $data['activeTab'] = '';

        return view('settings.view', $data);
    }

    /**
     * @param $namespace
     */
    public function view($namespace)
    {
        $this->addTitle(ucwords($namespace));
        $settings = $this->settings->getByNamespace($namespace);
        return view('settings.view', [
            'settings' => $settings,
            'namespace' => $namespace,
            'activeTab' => $namespace
        ]);
    }

    /**
     * @param Request $request
     */
    public function save(Request $request)
    {
        $newSettings = $request->except('_token');

        foreach ($newSettings as $namespaceAndName => $value) {
            list($namespace, $name) = explode('-', $namespaceAndName);

            $this->settings->set($namespace, $name, $value);
        }

        return redirect()->back()->with('message', '<strong>Saved!</strong> your settings have been saved.');
    }
}
