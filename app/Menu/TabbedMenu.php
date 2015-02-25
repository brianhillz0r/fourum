<?php

namespace Fourum\Menu;

use Fourum\Menu\Item\TabItem;

class TabbedMenu implements MenuInterface
{
    /**
     * @var array
     */
    protected $items;

    /**
     * @param array $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->addItem($item);
        }
    }

    /**
     * @param TabItem $item
     */
    public function addItem(TabItem $item)
    {
        $this->items[$item->getName()] = $item;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return bool
     */
    public function hasItems()
    {
        return count($this->getItems()) > 0;
    }
}