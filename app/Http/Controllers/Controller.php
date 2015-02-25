<?php

namespace Fourum\Http\Controllers;

use Fourum\Notification\NotifiableInterface;
use Fourum\Permission\PermissibleInterface;
use Fourum\Setting\Manager;
use Fourum\User\UserInterface;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use DispatchesCommands, ValidatesRequests;

    /**
     * @var Manager
     */
    private $settings;

    /**
     * @param Manager $settings
     */
    public function __construct(Manager $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function getSetting($name)
    {
        return $this->settings->get($name);
    }

    /**
     * @return UserInterface|PermissibleInterface|NotifiableInterface
     */
    public function getUser()
    {
        return Auth::user();
    }
}
