<?php

namespace Fourum\Condition;

class ConditionRegistry
{
    /**
     * @var array
     */
    protected $conditions;

    /**
     * @param array $conditions
     */
    public function __construct(array $conditions = [])
    {
        foreach ($conditions as $condition) {
            $this->addCondition($condition);
        }
    }

    /**
     * @param ConditionInterface $condition
     */
    public function addCondition(ConditionInterface $condition)
    {
        $this->conditions[$condition->getInternalName()] = $condition;
    }

    /**
     * @param string $name
     * @return ConditionInterface
     */
    public function get($name)
    {
        return $this->conditions[$name];
    }
}