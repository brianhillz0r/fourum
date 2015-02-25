<?php

namespace Fourum\Menu\Item;

interface ItemInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @return string
     */
    public function getTarget();

    /**
     * @return array
     */
    public function getData();
}