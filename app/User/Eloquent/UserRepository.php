<?php

namespace Fourum\User\Eloquent;

use Fourum\Model\User;
use Fourum\User\UserInterface;
use Fourum\User\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll()
    {
        return User::all();
    }

    /**
     * @param int $id
     * @return UserInterface
     */
    public function get($id)
    {
        return User::find($id);
    }

    /**
     * @param array $input
     * @return UserInterface
     */
    public function createAndSave(array $input)
    {
        return User::create($input);
    }

    /**
     * @param UserInterface $user
     * @return UserInterface
     */
    public function save(UserInterface $user)
    {
        return $user->save();
    }

    /**
     * @param string $username
     * @return UserInterface
     */
    public function getByUsername($username)
    {
        return User::where('username', $username)->first();
    }

    /**
     * @param string $username
     * @return Collection
     */
    public function getLikeUsername($username)
    {
        return User::where('username', 'like', $username . '%')->get();
    }
}