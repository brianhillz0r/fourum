<?php

namespace Fourum\Setting;

interface SaveableRepositoryInterface
{
    /**
     * @param SettingInterface $setting
     */
    public function save(SettingInterface $setting);
}