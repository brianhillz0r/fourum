<?php

namespace Fourum\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property string rule
 */
class Rule extends Model
{
    /**
     * @var string
     */
    protected $table = 'rules';

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return int
     */
    public function getId()
    {
        return (int) $this->id;
    }

    /**
     * @return string
     */
    public function getRule()
    {
        return $this->rule;
    }
}