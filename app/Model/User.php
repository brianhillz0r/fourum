<?php

namespace Fourum\Model;

use Carbon\Carbon;
use Fourum\Notification\NotifiableInterface;
use Fourum\Permission\PermissibleInterface;
use Fourum\User\UserInterface;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Hash;

/**
 * @property string email
 * @property string password
 * @property string username
 * @property Carbon birthdate
 * @property int id
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract, UserInterface, PermissibleInterface, NotifiableInterface
{
    use Authenticatable, CanResetPassword;

    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var array
     */
    protected $fillable = ['username', 'email', 'password'];

    /**
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return array
     */
    public function getGroups()
    {
        return $this->belongsToMany('Fourum\Model\Group', 'user_groups')->withTimestamps()->get()->all();
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param Carbon $date
     */
    public function setBirthDate(Carbon $date)
    {
        $this->birthdate = $date;
    }

    /**
     * @return Carbon
     */
    public function getBirthDate()
    {
        return $this->birthdate;
    }

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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getForeignKey()
    {
        return 'user_id';
    }
}
