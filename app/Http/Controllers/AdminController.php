<?php

namespace Fourum\Http\Controllers;

use Fourum\Menu\Item\LinkItem;
use Fourum\Menu\SimpleMenu;
use Fourum\Setting\Formatter\HtmlFormatter;
use Fourum\Setting\Manager;
use Fourum\Theme\Theme;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    /**
     * @param Manager $settings
     */
    public function __construct(Manager $settings)
    {
        parent::__construct($settings);

        $this->middleware('auth');
        $this->middleware('admin.auth');

        if (Config::get('app.debug')) {
            $theme = App::make(Theme::class);
            $theme->compile();
        }

        /**
         * Header
         */
        View::composer('header', function($view) {
            $menu = new SimpleMenu(array(
                new LinkItem('settings', '/admin/settings'),
                new LinkItem('forums', '/admin/forums'),
                new LinkItem('users', '/admin/users'),
                new LinkItem('groups', '/admin/groups'),
                new LinkItem('themes', '/admin/themes'),
                new LinkItem('rules', '/admin/rules'),
                new LinkItem('reports', '/admin/reports'),
                new LinkItem('packages', '/admin/packages')
            ));

            Event::fire('admin.menu.top.created', array($menu));

            $view->with('menu', $menu);
        });

        /**
         * Dashboard Sidebar
         */
        View::composer('dashboard.sidebar', function($view) {
            $menu = new SimpleMenu(array(
                new LinkItem('dashboard', '/admin')
            ));

            Event::fire('admin.dashboard.sidebar.created', array($menu));

            $view->with('menu', $menu);
        });

        /**
         * Settings Sidebar
         */
        View::composer('settings.sidebar', function($view) {
            $menu = new SimpleMenu(array(
                new LinkItem('general', '/admin/settings'),
                new LinkItem('themes', '/admin/settings/themes'),
                new LinkItem('suspensions &amp; banning', '/admin/settings/banning')
            ));

            Event::fire('admin.settings.sidebar.created', array($menu));

            $view->with('menu', $menu);
        });

        /**
         * Settings Form
         */
        View::composer('settings.form', function($view) {
            $view->with('formatter', new HtmlFormatter());
        });
    }
}