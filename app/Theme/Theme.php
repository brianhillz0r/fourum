<?php

namespace Fourum\Theme;

use Fourum\View\FileViewFinder;
use Illuminate\Filesystem\Filesystem;

class Theme
{
    /**
     * Instance for setting view paths
     *
     * @var FileViewFinder
     */
    protected $finder;

    /**
     * The name of the current application, 'front' or 'admin'
     *
     * @var string
     */
    protected $application;

    /**
     * The current theme name
     *
     * @var string
     */
    protected $theme;

    /**
     * The current colour scheme for the current theme
     *
     * @var string
     */
    protected $colourScheme;

    /**
     * @var Filesystem
     */
    private $file;

    /**
     * Set me up with a Fourum\View\FileViewFinder instance.
     *
     * @param FileViewFinder $finder
     * @param Filesystem $file
     */
    public function __construct(FileViewFinder $finder, Filesystem $file)
    {
        $this->finder = $finder;
        $this->file = $file;
    }

    /**
     * Set the application we're currently in, 'front' or 'admin'
     *
     * @param string $dir
     */
    public function setApplication($dir)
    {
        $this->application = $dir;

        $this->setup();
    }

    /**
     * Set the name of the current theme
     *
     * @param string $name
     */
    public function setTheme($name)
    {
        $this->theme = $name;

        $this->setup();
    }

    /**
     * Sets the colour scheme for the current theme.
     *
     * @param string $name
     */
    public function setColourScheme($name)
    {
        $this->colourScheme = $name;
    }

    /**
     * Get the current application
     * @return string
     * @throws \Exception
     */
    public function getApplication()
    {
        if (! $this->application) {
            throw new \Exception("Theme: Application Not Set");
        }

        return $this->application;
    }

    /**
     * Get the current theme name
     *
     * @return string
     */
    public function getTheme()
    {
        return $this->theme ? $this->theme : 'default';
    }

    /**
     * Gets the name of the current colour scheme for the current theme.
     *
     * @return string
     */
    public function getColourScheme()
    {
        return $this->colourScheme ? $this->colourScheme : 'default';
    }

    /**
     * Get the path for a certain asset
     *
     * @param  string $path
     * @return string
     */
    public function getAssetPath($path)
    {
        return public_path("themes/{$this->getApplication()}/{$this->getTheme()}/{$path}");
    }

    /**
     * Output the asset path for a CSS file.
     *
     * @param  string $path
     * @return string
     */
    public function css($path)
    {
        return asset("themes/{$this->getApplication()}/{$this->getTheme()}/stylesheets/css/{$path}");
    }

    /**
     * Output the asset path for a JavaScript file.
     *
     * @param  string $path
     * @return string
     */
    public function js($path)
    {
        return asset("themes/{$this->getApplication()}/{$this->getTheme()}/js/{$path}");
    }

    /**
     * @param string $path
     * @return string
     */
    public function asset($path)
    {
        return asset("themes/{$this->getApplication()}/{$this->getTheme()}/{$path}");
    }

    /**
     * Get filesystem paths for all stylesheets in the current theme.
     *
     * @param  string $type
     * @return array
     */
    public function getStylesheets($type = null)
    {
        if ('less' === $type) {
            return $this->file->files($this->getThemeDir().'/stylesheets/less');
        }
        else  {
            return $this->file->files($this->getThemeDir().'/stylesheets/css');
        }
    }

    /**
     * Return the "themes" directory.
     *
     * @return string
     */
    public function getThemesDir()
    {
        return public_path("themes");
    }

    /**
     * Return the directory of the current application (admin, front).
     *
     * @return string
     */
    public function getApplicationDir()
    {
        return $this->getThemesDir().'/'.$this->getApplication();
    }

    /**
     * Return the current theme directory.
     *
     * @return string
     */
    public function getThemeDir()
    {
        return $this->getApplicationDir().'/'.$this->getTheme();
    }

    /**
     * Return the "stylesheets" directory for the current theme.
     *
     * @return string
     */
    public function getStylesheetsDir()
    {
        return $this->getThemeDir().'/stylesheets';
    }

    /**
     * Return the "less" directory for the current theme.
     *
     * @return string
     */
    public function getLessDir()
    {
        return $this->getStylesheetsDir().'/less';
    }

    /**
     * Return the "css" directory for the current theme.
     *
     * @return string
     */
    public function getCssDir()
    {
        return $this->getStylesheetsDir().'/css';
    }

    public function getSchemesDir()
    {
        return $this->getLessDir() . '/schemes';
    }

    /**
     * Compile any files in the theme that require it.
     *
     * @return void
     */
    public function compile()
    {
        $compiler = new Compiler($this, $this->file, array('css/bootstrap.css'));
        $compiler->compile();
    }

    /**
     * @param string $application
     * @return array
     * @throws \Exception
     */
    public function getThemes($application = 'front')
    {
        $oldApplication = $this->getApplication();
        $this->setApplication($application);

        $directories = $this->file->directories($this->getApplicationDir());

        $themes = array();

        foreach ($directories as $directory) {
            $pathBits = explode('/', $directory);
            $themes[] = end($pathBits);
        }

        $this->setApplication($oldApplication);

        return $themes;
    }

    /**
     * @param string $application
     * @return array
     * @throws \Exception
     */
    public function getSchemes($application = 'front')
    {
        $oldApplication = $this->getApplication();
        $this->setApplication($application);

        $files = $this->file->files($this->getSchemesDir());

        $schemes = array();

        foreach ($files as $file) {
            $schemes[] = $this->getFilenameFromPath($file);
        }

        $this->setApplication($oldApplication);

        return $schemes;
    }

    /**
     * Return a file name from a path.
     *
     * i.e. 'path/to/a/name.less' -> 'name'
     *
     * @param  string $path
     * @return string
     */
    private function getFilenameFromPath($path)
    {
        $pathBits = explode('/', $path);
        $file = end($pathBits);
        $fileBits = explode('.', $file);
        $filename = $fileBits[0];

        return $filename;
    }

    /**
     * Inject the current view path (themes/<application>/<theme>/views) into
     * the instance of FileViewFinder
     */
    private function setup()
    {
        $paths = array(
            $this->getThemeDir().'/views',
            $this->getApplicationDir().'/default/views'
        );

        $this->finder->setPaths($paths);
    }
}