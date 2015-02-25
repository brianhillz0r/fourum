<?php

namespace Fourum\Setting\Formatter;

use Fourum\Setting\SettingInterface;

interface FormatterInterface
{
    /**
     * @param SettingInterface $setting
     * @return string
     */
    public function format(SettingInterface $setting);
}