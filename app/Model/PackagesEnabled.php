<?php

namespace Fourum\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PackagesEnabled extends Model
{
    protected $table = 'packages_enabled';
    protected $fillable = ['name'];
    public $timestamps = false;

    public static function add($packageName)
    {
        self::create(['name' => sha1($packageName)]);
    }

    public static function remove($packageName)
    {
        DB::table('packages_enabled')->where('name', '=', sha1($packageName))->delete();
    }

    public static function isEnabled($packageName)
    {
        return (bool) self::where('name', '=', sha1($packageName))->count();
    }
}