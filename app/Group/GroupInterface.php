<?php

namespace Fourum\Group;

interface GroupInterface
{
    /**
     * @return array
     */
    public function getUsers();

    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);
}