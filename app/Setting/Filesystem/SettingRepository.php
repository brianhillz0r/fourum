<?php

namespace Fourum\Setting\Filesystem;

use Fourum\Setting\Setting;
use Fourum\Setting\SettingInterface;
use Fourum\Setting\SettingRepositoryInterface;
use Fourum\Setting\Type\TypeFactory;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Yaml\Parser;

class SettingRepository implements SettingRepositoryInterface
{
    /**
     * @var array
     */
    protected $settingDirectories = array();

    /**
     * @var Filesystem
     */
    protected $file;

    /**
     * @var Parser
     */
    protected $parser;

    /**
     * @param Filesystem $file
     * @param Parser $parser
     */
    public function __construct(Filesystem $file, Parser $parser)
    {
        $this->file = $file;
        $this->parser = $parser;

        $this->settingDirectories[] = config_path("settings");
    }

    /**
     * @return array
     */
    public function getAll()
    {
        $settings = array();

        foreach ($this->settingDirectories as $dir) {
            $namespaceFiles = $this->file->files($dir);

            foreach ($namespaceFiles as $file) {
                $namespace = $this->getFilenameFromPath($file);
                $namespaceSettings = $this->getSettingsFromFile($file);

                $settings[$namespace] = $this->normaliseSettings($namespace, $namespaceSettings);
            }
        }

        return $settings;
    }

    /**
     * @param string $name (namespace.name)
     * @return mixed
     */
    public function get($name)
    {
        list($namespace, $name) = explode('.', $name);

        $setting = $this->getByNamespaceAndName($namespace, $name);

        if ($setting) {
            return $setting->getValue();
        }
    }

    /**
     * @param string $namespace
     * @return array
     */
    public function getByNamespace($namespace)
    {
        $namespaceFile = "{$namespace}.yml";

        if ($this->getSettingsFromFile($namespaceFile)) {
            return $this->normaliseSettings($namespace, $this->getSettingsFromFile($namespaceFile));
        }
    }

    /**
     * @param string $namespace
     * @param string $name
     * @return SettingInterface
     */
    public function getByNamespaceAndName($namespace, $name)
    {
        $settings = $this->getByNamespace($namespace);

        if (isset($settings[$name])) {
            return $settings[$name];
        }
    }

    /**
     * @param string $path
     */
    public function addPath($path)
    {
        $this->settingDirectories[] = $path;
    }

    /**
     * @param array $input
     * @return mixed
     */
    public function createAndSave(array $input)
    {
    }

    /**
     * Return a file name from a path.
     *
     * i.e. 'path/to/a/name.less' -> 'name'
     *
     * @param string $path
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
     * @param string $namespace
     * @param array $settings
     * @return array
     */
    private function normaliseSettings($namespace, array $settings)
    {
        $normalisedSettings = array();

        foreach ($settings as $name => $values) {
            $factory = new TypeFactory();

            $setting = new Setting(
                $namespace.'.'.$name,
                $values['title'],
                $values['description'],
                $factory->build($values['type']),
                isset($values['options']) ? $values['options'] : null,
                $values['value']
            );

            $normalisedSettings[$name] = $setting;
        }

        return $normalisedSettings;
    }

    /**
     * @param string $filename
     * @return array
     */
    private function getSettingsFromFile($filename)
    {
        if ($this->file->exists($filename)) {
            return $this->parseFile($filename);
        }

        foreach ($this->settingDirectories as $dir) {
            $filePath = $dir . "/" . $filename;

            if ($this->file->exists($filePath)) {
                return $this->parseFile($filePath);
            }
        }
    }

    /**
     * @param string $filePath
     * @return array
     */
    private function parseFile($filePath)
    {
        return $this->parser->parse($this->file->get($filePath));
    }

    /**
     * @return array
     */
    public function getAllNamespaces()
    {
        $namespaces = [];

        foreach ($this->settingDirectories as $dir) {
            $namespaceFiles = $this->file->files($dir);

            foreach ($namespaceFiles as $file) {
                $namespaces[] = $this->getFilenameFromPath($file);
            }
        }

        return $namespaces;
    }
}