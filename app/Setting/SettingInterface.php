<?php

namespace Fourum\Setting;

interface SettingInterface
{
    /**
     * @return string
     */
    public function getNamespace();

    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     * @return mixed
     */
    public function setValue($value);

    /**
     * @return string
     */
    public function getDescription();

    public function getType();

    public function getOptions();
}