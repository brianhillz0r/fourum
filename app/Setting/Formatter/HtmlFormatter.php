<?php

namespace Fourum\Setting\Formatter;

use Fourum\Setting\SettingInterface;

class HtmlFormatter implements FormatterInterface
{
    /**
     * @param SettingInterface $setting
     * @return string
     */
    public function format(SettingInterface $setting)
    {
        $html = "<div class=\"form-group\">";
        $html .= "<label for=\"{$setting->getName()}\">{$setting->getTitle()}</label>";
        $html .= "<p>{$setting->getDescription()}</p>";

        $html .= $setting->getType()->render($setting);

        $html .= "</div>";

        return $html;
    }
}