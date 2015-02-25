<?php

namespace Fourum\Http\Middleware;

use Closure;
use Fourum\Application\ApplicationContainer;

class ApplicationHandler
{
	/**
	 * @var ApplicationContainer
	 */
	protected $applicationContainer;

	/**
	 * @param ApplicationContainer $applicationContainer
	 */
	public function __construct(ApplicationContainer $applicationContainer)
	{
		$this->applicationContainer = $applicationContainer;
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
		$this->applicationContainer->setApplication('front');

		if ($request->is('admin') || $request->is('admin/*')) {
			$this->applicationContainer->setApplication('admin');
		}

		return $next($request);
	}
}
