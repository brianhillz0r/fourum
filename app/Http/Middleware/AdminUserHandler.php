<?php

namespace Fourum\Http\Middleware;

use Closure;
use Fourum\Permission\Checker\CheckerInterface;
use Fourum\Permission\Eloquent\GroupPermissionRepository;
use Fourum\Permission\PermissibleInterface;
use Fourum\User\UserInterface;
use Illuminate\Contracts\Auth\Guard;

class AdminUserHandler
{
	protected $permission;

	protected $auth;

	public function __construct(CheckerInterface $permission, Guard $auth)
	{
		$this->permission = $permission;
		$this->auth = $auth;
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
		if (! $this->permission->checkHard(GroupPermissionRepository::CAN_ADMINISTRATE, $this->getUser())) {
			return redirect('/');
		}

		return $next($request);
	}

	/**
	 * @return UserInterface|PermissibleInterface
	 */
	protected function getUser()
	{
		return $this->auth->getUser();
	}
}
