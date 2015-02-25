<?php

namespace Fourum\Setting\Type;

use Fourum\Setting\SettingInterface;

class Text implements TypeInterface
{
    /**
     * @param SettingInterface $setting
     * @return string
     */
    public function render(SettingInterface $setting)
    {
        return "<input
        type=\"text\"
        class=\"form-control\"
        name=\"{$setting->getNamespace()}-{$setting->getName()}\"
        id=\"{$setting->getName()}\"
        value=\"{$setting->getValue()}\"
        >";
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'text';
    }
}