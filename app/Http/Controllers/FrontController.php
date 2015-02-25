<?php

namespace Fourum\Http\Controllers;

use Fourum\Menu\Item\LinkItem;
use Fourum\Menu\SimpleMenu;
use Fourum\Notification\NotificationRepositoryInterface;
use Fourum\Setting\Manager;
use Fourum\Theme\Theme;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;

class FrontController extends Controller
{
    /**
     * @var string
     */
    protected $layout = 'layouts.master';

    /**
     * @param Manager $settings
     */
    public function __construct(Manager $settings)
    {
        parent::__construct($settings);

        if (Config::get('app.debug')) {
            $theme = App::make(Theme::class);
            $theme->compile();
        }

        /**
         * Header
         */
        $user = $this->getUser();
        $notifications = App::make(NotificationRepositoryInterface::class);
        View::composer('header', function($view) use ($user, $notifications) {
            $menuLoggedIn = new SimpleMenu();

            $menuLoggedOut = new SimpleMenu(array(
                new LinkItem('create account', 'register')
            ));

            Event::fire('header.menu.loggedout.created', array($menuLoggedOut));

            if (Auth::check()) {
                Event::fire('header.menu.loggedin.created', array($menuLoggedIn, $user));

                $unread = $notifications->getUnread($user);
                $count = count($unread);
                $countText = '';

                if ($count > 0) {
                    $countText = " ({$count})";
                }

                $menuLoggedIn->addItem(
                    new LinkItem("notifications{$countText}", '/notifications')
                );

                $view->with('notifications', $unread);
            }


            $menuLoggedIn->addItem(
                new LinkItem('logout', '/auth/logout')
            );

            $view->with('menuLoggedIn', $menuLoggedIn);
            $view->with('menuLoggedOut', $menuLoggedOut);
        });
    }

    /**
     * @param string $view
     * @param array $data
     */
    protected function render($view, array $data = array())
    {
        return view($this->layout)->nest('content', $view, $data);
    }
}