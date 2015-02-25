<?php

namespace Fourum\Menu;

interface MenuInterface
{
    /**
     * @return array
     */
    public function getItems();

    /**
     * @return bool
     */
    public function hasItems();
}