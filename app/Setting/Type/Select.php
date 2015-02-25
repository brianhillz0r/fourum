<?php

namespace Fourum\Setting\Type;

use Fourum\Setting\SettingInterface;

class Select implements TypeInterface
{
    /**
     * @param SettingInterface $setting
     * @return string
     */
    public function render(SettingInterface $setting)
    {
        $html = "<select name=\"{$setting->getNamespace()}-{$setting->getName()}\" class=\"form-control\">";

        foreach ($setting->getOptions() as $option) {
            $optionDisplay = ucwords($option);
            $selected = '';

            if ($setting->getValue() === $option) {
                $selected = "selected=\"selected\"";
            }

            $html .= "<option {$selected} value=\"{$option}\">
                {$optionDisplay}
            </option>";
        }

        $html .= "</select>";

        return $html;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'select';
    }
}