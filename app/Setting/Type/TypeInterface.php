<?php

namespace Fourum\Setting\Type;

use Fourum\Setting\SettingInterface;

interface TypeInterface
{
    /**
     * @param SettingInterface $setting
     * @return string
     */
    public function render(SettingInterface $setting);

    /**
     * @return string
     */
    public function getName();
}