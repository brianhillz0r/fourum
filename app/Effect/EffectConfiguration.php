<?php

namespace Fourum\Effect;

class EffectConfiguration
{
    const UNIT_HOURS    = 'hours';
    const UNIT_DAYS     = 'days';
    const UNIT_WEEKS    = 'weeks';
    const UNIT_YEARS    = 'years';

    /**
     * @var array
     */
    protected $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param int $length
     * @param string $unit
     */
    public function setLength($length, $unit)
    {
        $this->config['length'] = $length;
        $this->config['unit'] = $unit;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->config['length'];
    }

    /**
     * @return string
     */
    public function getUnit()
    {
        return $this->config['unit'];
    }
}
