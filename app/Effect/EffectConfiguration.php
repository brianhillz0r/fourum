<?php

namespace Fourum\Effect;

use Carbon\Carbon;

class EffectConfiguration
{
    const UNIT_HOURS    = 'hours';
    const UNIT_DAYS     = 'days';
    const UNIT_WEEKS    = 'weeks';
    const UNIT_MONTHS   = 'months';
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

    /**
     * @return Carbon
     */
    public function getExpiry()
    {
        $now = new Carbon();

        switch ($this->getUnit()) {
            case self::UNIT_HOURS:
                $now->addHours($this->getLength());
                break;
            case self::UNIT_DAYS:
                $now->addDays($this->getLength());
                break;
            case self::UNIT_WEEKS:
                $now->addWeeks($this->getLength());
                break;
            case self::UNIT_MONTHS:
                $now->addMonths($this->getLength());
                break;
            case self::UNIT_YEARS:
                $now->addYears($this->getLength());
                break;
        }

        return $now;
    }
}
