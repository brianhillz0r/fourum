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
    }

    /**
     * General Settings.15
     */
    public function index()
    {
        $settings = $this->settings->getByNamespace('general');

        $data['settings'] = $settings;

        return view('settings.general', $data);
    }

    /**
     * Banning settings.
     */
    public function banning()
    {
        $settings = $this->settings->getByNamespace('banning');

        $data['settings'] = $settings;

        return view('settings.banning', $data);
    }

    public function themes()
    {
        $settings = $this->settings->getByNamespace('theme');

        $data['settings'] = $settings;

        return view('settings.themes', $data);
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
