<?php

namespace Fourum\Menu\Item;

class TabItem implements ItemInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $viewPath;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param string $name
     * @param string $viewPath
     * @param array $data
     */
    public function __construct($name, $viewPath, array $data = [])
    {
        $this->name = $name;
        $this->viewPath = $viewPath;
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
        return $this->viewPath;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}