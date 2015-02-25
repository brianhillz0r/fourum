<?php

namespace Fourum\Repository;

interface RepositoryInterface
{
    /**
     * @param int $id
     * @return mixed
     */
    public function get($id);

    /**
     * @return mixed
     */
    public function getAll();

    /**
     * @param array $input
     * @return mixed
     */
    public function createAndSave(array $input);
}