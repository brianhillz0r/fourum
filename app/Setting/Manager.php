<?php

namespace Fourum\Setting;

use Fourum\Setting\Eloquent\SettingRepository as EloquentSettingRepository;
use Fourum\Setting\Filesystem\SettingRepository as FilesystemSettingRepository;

/**
 * Settings Manager
 *
 * Managers the retrieving, saving and updating of
 * settings across File and DB repositories.
 */
class Manager
{
    /**
     * @var EloquentSettingRepository
     */
    protected $db;

    /**
     * @var FilesystemSettingRepository
     */
    protected $file;

    /**
     * @param EloquentSettingRepository $db
     * @param FilesystemSettingRepository $file
     */
    public function __construct(EloquentSettingRepository $db, FilesystemSettingRepository $file)
    {
        $this->db = $db;
        $this->file = $file;
    }

    /**
     * @return FilesystemSettingRepository
     */
    public function getFileRepository()
    {
        return $this->file;
    }

    /**
     * @return EloquentSettingRepository
     */
    public function getDatabaseRepository()
    {
        return $this->db;
    }

    /**
     * @param string $namespace
     * @param string $name
     * @param string $value
     * @return SettingInterface
     */
    public function set($namespace, $name, $value)
    {
        $setting = $this->getByNamespaceAndName($namespace, $name);

        if ($setting->getValue() != $value) {
            $setting->setValue($value);

            // we currently only persist in the DB
            $this->db->save($setting);
        }

        return $setting;
    }

    /**
     * Get the settings for a given namespace.
     *
     * @param string $namespace
     * @return array
     */
    public function getByNamespace($namespace)
    {
        $dbSettings = $this->db->getByNamespace($namespace);
        $fileSettings = $this->file->getByNamespace($namespace);

        $settings = array_merge($fileSettings ? $fileSettings : array(), $dbSettings ? $dbSettings : array());
        $settings = $this->loadOptions($settings);

        return $settings;
    }

    /**
     * @param array $settings
     * @return array
     */
    protected function loadOptions(array $settings)
    {
        foreach ($settings as $setting) {
            if ($setting->getOptions()) {
                $option = $setting->getOptions();

                switch ($option) {
                    case '@themes':
                        $setting->setOptions(theme()->getThemes('front'));
                        break;

                    case '@schemes':
                        $setting->setOptions(theme()->getSchemes('front'));
                        break;

                    case '@admin.themes':
                        $setting->setOptions(theme()->getThemes('admin'));
                        break;

                    case '@admin.schemes':
                        $setting->setOptions(theme()->getSchemes('admin'));
                        break;
                }
            }
        }

        return $settings;
    }

    /**
     * Get the setting for a given namespace and name.
     *
     * @param string $namespace
     * @param string $name
     * @return mixed
     */
    public function getByNamespaceAndName($namespace, $name)
    {
        $dbSetting = $this->db->getByNamespaceAndName($namespace, $name);

        if ($dbSetting) {
            return $dbSetting;
        }

        $fileSetting = $this->file->getByNamespaceAndName($namespace, $name);

        if ($fileSetting) {
            return $fileSetting;
        }
    }

    /**
     * Get the value of a setting.
     *
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        $value = $this->db->get($name);

        if ($value) {
            return $value;
        }

        return $this->file->get($name);
    }

    /**
     * @return array
     */
    public function getAllNamespaces()
    {
        $dbNamespaces = $this->db->getAllNamespaces();
        $fileNamespaces = $this->file->getAllNamespaces();

        return array_unique(array_merge($fileNamespaces, $dbNamespaces));
    }
}
