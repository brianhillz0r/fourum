<?php

namespace Fourum\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PackageMakeCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'make:package';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new skeleton Fourum package.';

	/**
	 * @var Filesystem
	 */
	protected $filesystem;

	/**
	 * Create a new command instance.
	 * @param Filesystem $filesystem
	 */
	public function __construct(Filesystem $filesystem)
	{
		parent::__construct();
		$this->filesystem = $filesystem;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// setup package skeleton in given location
		// symlink into packages/
		$name = $this->argument('name');
		$path = $this->argument('path');

		$directories = [
			$path,
			$path . "/src"
		];

		// create package and src directories
		foreach ($directories as $dir) {
			if (! $this->filesystem->isDirectory($dir)) {
				$this->filesystem->makeDirectory($dir);
			}
		}

		// setup basic composer.json
		$this->filesystem->put($path . "/composer.json", $this->getComposerJsonBody($name));

		// setup basic service provider
		$providerName = $this->getServiceProviderName($name);
		$providerBody = $this->getServiceProviderBody($name);
		$this->filesystem->put($path . "/src/" . $providerName . ".php", $providerBody);

		$this->line("");
		$this->comment("Name: " . $name);
		$this->comment("Namespace: " . $this->getNamespaceFromName($name));
		$this->comment("Location: " . $path);
		$this->line("");
		$this->info("Package created!");
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['name', InputArgument::REQUIRED, 'The name of the package, must be in format vendor/package (e.g. fourum/message)'],
			['path', InputArgument::REQUIRED, 'The path of the package on your system (e.g. ~/git/fourum/packages/fourum-message)'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['git', null, InputOption::VALUE_OPTIONAL, 'Initialise package as a git repository', null],
		];
	}

	protected function getComposerJsonBody($name)
	{
		$body = <<<JSON
{
    "name": "%s",
    "description": "My Fourum package.",
    "authors": [
        {
            "name": "",
            "email": ""
        }
    ],

    "autoload": {
        "psr-4": {
            "%s": "src/"
        }
    },
    "require": {
        "fourum/support": "dev-master"
    }
}
JSON;
		$namespace = $this->getNamespaceFromName($name);
		return sprintf($body, $name, $this->getComposerNamespaceFromNamespace($namespace));
	}

	/**
	 * @param string $name
	 * @return string
	 */
	protected function getServiceProviderBody($name)
	{
		$body = <<<'PHP'
<?php

namespace %s;

use Fourum\Support\ServiceProvider;

class %s extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (! $this->checkPackageEnabled()) {
            return;
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * The human readable name of the package.
     *
     * @return string
     */
    public function getPackageName()
    {
        return '%s';
    }

    /**
     * @return bool
     */
    public function isPackage()
    {
        return true;
    }

    /**
     * The human readable description of the package.
     *
     * @return string
     */
    public function getPackageDescription()
    {
        return 'My Fourum package.';
    }
}
PHP;
		$namespace = $this->getNamespaceFromName($name);
		$providerName = $this->getServiceProviderName($name);
		return sprintf($body, $namespace, $providerName, $name);
	}

	/**
	 * @param string $namespace
	 * @return string
	 */
	protected function getComposerNamespaceFromNamespace($namespace)
	{
		$namespace = str_replace("\\", "\\\\", $namespace);
		return $namespace . "\\\\";
	}

	/**
	 * @param string $name
	 * @return string
	 */
	protected function getNamespaceFromName($name)
	{
		if (strpos($name, '/')) {
			$nameBits = explode('/', $name);
			$nameBits = array_map(function ($val) {
				return ucwords($val);
			}, $nameBits);
			return implode('\\', $nameBits);
		}

		return 'My\Package';
	}

	/**
	 * @param string $name
	 * @return string
	 */
	protected function getServiceProviderName($name)
	{
		$namespaceBits = explode('/', $name);
		$providerName = $namespaceBits[1];
		return ucwords($providerName) . "ServiceProvider";
	}
}
