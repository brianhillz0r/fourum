<?php

namespace Fourum\Setting\Eloquent;

use Fourum\Model\Setting;
use Fourum\Setting\SaveableRepositoryInterface;
use Fourum\Setting\SettingInterface;
use Fourum\Setting\SettingRepositoryInterface;
use Fourum\Setting\Type\TypeFactory;
use Illuminate\Support\Collection;

class SettingRepository implements SettingRepositoryInterface, SaveableRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll()
    {
         return Setting::all();
    }

    /**
     * @param string $namespace
     * @return Collection
     */
    public function getByNamespace($namespace)
    {
        $dbSettings = Setting::where('namespace', $namespace)->get()->all();

        if ($dbSettings) {
            return $this->normaliseSettings($namespace, $dbSettings);
        }
    }

    /**
     * @param string $namespace
     * @param string $name
     * @return SettingInterface
     */
    public function getByNamespaceAndName($namespace, $name)
    {
        $setting = Setting::where('namespace', $namespace)->where('name', $name)->first();

        if ($setting) {
            return $this->normaliseSetting($namespace, $setting);
        }
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
     * @param SettingInterface $setting
     * @return SettingInterface
     */
    public function save(SettingInterface $setting)
    {
        if ($this->getByNamespaceAndName($setting->getNamespace(), $setting->getName())) {
            return $this->update($setting);
        } else {
            return $this->create($setting);
        }
    }

    /**
     * @param array $input
     * @return mixed
     */
    public function createAndSave(array $input)
    {
    }

    /**
     * @param SettingInterface $setting
     * @return SettingInterface
     */
    private function update(SettingInterface $setting)
    {
        $dbSetting = Setting::where('namespace', $setting->getNamespace())
            ->where('name', $setting->getName())
            ->first();

        $dbSetting->value = $setting->getValue();
        $dbSetting->save();

        return $this->normaliseSetting($setting->getNamespace(), $dbSetting);
    }

    /**
     * @param SettingInterface $setting
     * @return Setting
     */
    private function create(SettingInterface $setting)
    {
        $dbSetting = Setting::create(array(
            'namespace' => $setting->getNamespace(),
            'name' => $setting->getName(),
            'title' => $setting->getTitle(),
            'value' => $setting->getValue(),
            'type' => $setting->getType()->getName(),
            'description' => $setting->getDescription(),
            'options' => $setting->getOptions()
        ));

        return $this->normaliseSetting($setting->getNamespace(), $dbSetting);
    }

    /**
     * @param string $namespace
     * @param Setting $setting
     * @return SettingInterface
     */
    private function normaliseSetting($namespace, Setting $setting)
    {
        $settings = $this->normaliseSettings($namespace, array($setting));
        return reset($settings);
    }

    /**
     * @param string $namespace
     * @param array $settings
     * @return array
     */
    private function normaliseSettings($namespace, array $settings)
    {
        $normalisedSettings = array();

        foreach ($settings as $dbSetting) {
            $factory = new TypeFactory();

            $setting = new \Fourum\Setting\Setting(
                $namespace.'.'.$dbSetting->name,
                $dbSetting->title,
                $dbSetting->description,
                $factory->build($dbSetting->type),
                $dbSetting->options,
                $dbSetting->value
            );

            $normalisedSettings[$setting->getName()] = $setting;
        }

        return $normalisedSettings;
    }
}