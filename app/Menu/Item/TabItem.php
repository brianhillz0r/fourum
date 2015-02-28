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
     * @var string
     */
    protected $target;

    /**
     * @param string $name
     * @param $target
     * @param string $viewPath
     * @param array $data
     */
    public function __construct($name, $target, $viewPath, array $data = [])
    {
        $this->name = $name;
        $this->viewPath = $viewPath;
        $this->data = $data;
        $this->target = $target;
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

    /**
     * @return string
     */
    public function getViewPath()
    {
        return $this->viewPath;
    }
}