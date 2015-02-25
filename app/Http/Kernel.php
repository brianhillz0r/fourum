<?php namespace Fourum\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{

    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
        'Illuminate\Cookie\Middleware\EncryptCookies',
        'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
        'Illuminate\Session\Middleware\StartSession',
        'Illuminate\View\Middleware\ShareErrorsFromSession',
        'Fourum\Http\Middleware\VerifyCsrfToken',
        'Fourum\Http\Middleware\ApplicationHandler',
        'Fourum\Http\Middleware\ThemeHandler',
        'Fourum\Http\Middleware\CanViewPermission'
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => 'Fourum\Http\Middleware\Authenticate',
        'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
        'guest' => 'Fourum\Http\Middleware\RedirectIfAuthenticated',
        'admin.auth' => 'Fourum\Http\Middleware\AdminUserHandler',
    ];
}
