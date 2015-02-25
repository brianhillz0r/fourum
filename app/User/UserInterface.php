<?php

namespace Fourum\User;

interface UserInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return array
     */
    public function getGroups();
}