<?php

namespace Fourum\Setting\Type;

class TypeFactory
{
    /**
     * @param string $type
     * @return TypeInterface
     */
    public function build($type)
    {
        switch ($type) {

            case 'text':
                return new Text();
                break;

            case 'select':
                return new Select();
                break;
        }
    }
}