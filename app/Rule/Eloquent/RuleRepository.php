<?php

namespace Fourum\Rule\Eloquent;

use Fourum\Model\Rule;
use Fourum\Rule\RuleRepositoryInterface;

class RuleRepository implements RuleRepositoryInterface
{
    /**
     * @param int $id
     * @return Rule
     */
    public function get($id)
    {
        return Rule::find($id);
    }

    /**
     * @return array
     */
    public function getAll()
    {
        return Rule::all()->all();
    }

    /**
     * @param array $input
     * @return Rule
     */
    public function createAndSave(array $input)
    {
        return Rule::create($input);
    }
}