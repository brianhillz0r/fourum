<?php

namespace Fourum\Application;

class ApplicationContainer
{
    /**
     * @var string
     */
    protected $application;

    /**
     * @param string $application
     */
    public function setApplication($application)
    {
        $this->application = $application;
    }

    /**
     * @return string
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->application === 'admin';
    }

    /**
     * @return bool
     */
    public function isFront()
    {
        return $this->application === 'front';
    }
}