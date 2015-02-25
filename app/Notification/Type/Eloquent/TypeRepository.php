<?php

namespace Fourum\Notification\Type\Eloquent;

use Fourum\Model\Notification\Type;
use Fourum\Notification\Type\TypeRepositoryInterface;

class TypeRepository implements TypeRepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function get($id)
    {
        return Type::find($id);
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return Type::all();
    }

    /**
     * @param array $input
     * @return mixed
     */
    public function createAndSave(array $input)
    {
        return Type::create($input);
    }

    /**
     * @param string $name
     * @return Type
     */
    public function getByName($name)
    {
        return Type::where('name', '=', $name)->first();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasType($name)
    {
        return (bool) $this->getByName($name);
    }
}