<?php

namespace Fourum\Menu\Item;

class LinkItem implements ItemInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $target;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param string $name
     * @param string $target
     */
    public function __construct($name, $target, array $data = [])
    {
        $this->name = $name;
        $this->target = $target;
        $this->data = $data;
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
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}