<?php

namespace Fourum\Http\Middleware;

use Closure;
use Fourum\Permission\Checker\CheckerInterface;
use Fourum\Permission\PermissibleInterface;
use Fourum\User\UserInterface;
use Illuminate\Auth\Guard;

class CanViewPermission
{
	protected $auth;

	protected $permission;

	public function __construct(Guard $auth, CheckerInterface $permission)
	{
		$this->auth = $auth;
		$this->permission = $permission;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		/**
		 * Ban Checking
		 */
		if ($this->getUser() && ! $this->permission->check('can-view', $this->getUser()) && ! $request->is('auth/*')) {
			return redirect('/auth/banned');
		}

		return $next($request);
	}

	/**
	 * @return \Illuminate\Contracts\Auth\Authenticatable|UserInterface|PermissibleInterface
	 */
	protected function getUser()
	{
		return $this->auth->user();
	}
}
