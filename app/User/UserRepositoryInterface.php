<?php

namespace Fourum\User;

use Fourum\Repository\RepositoryInterface;
use Illuminate\Support\Collection;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * @param UserInterface $user
     * @return UserInterface
     */
    public function save(UserInterface $user);

    /**
     * @param string $username
     * @return UserInterface
     */
    public function getByUsername($username);

    /**
     * @param string $username
     * @return Collection
     */
    public function getLikeUsername($username);
}