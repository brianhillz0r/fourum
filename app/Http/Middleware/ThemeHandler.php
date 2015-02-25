<?php

namespace Fourum\Http\Middleware;

use Closure;
use Fourum\Application\ApplicationContainer;
use Fourum\Setting\Manager;
use Fourum\Theme\Theme;

class ThemeHandler
{
	/**
	 * @var Theme
	 */
	protected $theme;

	/**
	 * @var ApplicationContainer
	 */
	protected $application;

	/**
	 * @var Manager
	 */
	protected $settings;

	/**
	 * @param ApplicationContainer $application
	 * @param Theme $theme
	 * @param Manager $settings
	 */
	public function __construct(ApplicationContainer $application, Theme $theme, Manager $settings)
	{
		$this->theme = $theme;
		$this->application = $application;
		$this->settings = $settings;
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
		$this->theme->setApplication($this->application->getApplication());

		if ($this->application->isAdmin()) {
			$this->theme->setTheme($this->settings->get('theme.admin_current'));
			$this->theme->setColourScheme($this->settings->get('theme.admin_scheme'));
		} else {
			$this->theme->setTheme($this->settings->get('theme.current'));
			$this->theme->setColourScheme($this->settings->get('theme.scheme'));
		}

		return $next($request);
	}
}
