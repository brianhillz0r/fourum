<?php

namespace Fourum\Setting;

use Fourum\Setting\Formatter\FormatterInterface;
use Fourum\Setting\Type\TypeInterface;

class Setting implements SettingInterface
{
    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var TypeInterface
     */
    protected $type;

    /**
     * @var string
     */
    protected $options;

    /**
     * @param string $fullName
     * @param string $title
     * @param string $description
     * @param TypeInterface $type
     * @param string $options
     * @param string $value
     */
    public function __construct(
        $fullName,
        $title,
        $description,
        TypeInterface $type,
        $options = null,
        $value = null
    ) {
        $nameBits = explode('.', $fullName);

        $this->namespace = $nameBits[0];
        $this->name = $nameBits[1];
        $this->title = $title;
        $this->value = $value;
        $this->description = $description;
        $this->type = $type;
        $this->options = $options;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return TypeInterface
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param $options
     */
    public function setOptions($options)
    {
        $this->options = $options;
    }

    /**
     * @param FormatterInterface $formatter
     * @return string
     */
    public function render(FormatterInterface $formatter)
    {
        return $formatter->format($this);
    }
}