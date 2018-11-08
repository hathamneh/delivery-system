<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/**
 * @property UserTemplate template
 * @property string username
 * @property string email
 * @property int id
 * @property string password
 * @property Client client
 * @property Courier courier
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function template()
    {
        return $this->belongsTo(UserTemplate::class, 'user_template_id');
    }

    /**
     * @param string|array $roles
     * @param int|null $accessLevel
     * @return bool
     */
    public function isAuthorized($roles, $accessLevel = Role::UT_READ)
    {
        return $this->template->authorizeRoles($roles, $accessLevel);
    }

    /**
     * @param string|array $roles
     * @param int|null $accessLevel
     * @return bool
     */
    public function isAuthorizedAny($roles, $accessLevel = Role::UT_READ)
    {
        foreach ($roles as $role) {
            if ($this->template->authorizeRoles($role, $accessLevel)) return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->template->name == "admin";
    }

    /**
     * @return bool
     */
    public function isClient()
    {
        return !is_null($this->client);
    }

    /**
     * @return bool
     */
    public function isCourier()
    {
        return !is_null($this->courier);
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'identifier', 'account_number');
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class, 'identifier', 'id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function getDisplayNameAttribute()
    {
        if($this->isClient())
            return $this->client->trade_name;
        elseif($this->isCourier())
            return $this->courier->name;
        else
            return $this->username;
    }

    /**
     * @param string $newPass
     * @return bool
     */
    public function changePassword(string $newPass)
    {
        return $this->fill([
            'password' => Hash::make($newPass)
        ])->save();
    }

    /**
     * Generate random password for user
     * @param int $len
     * @return string
     */
    public static function generatePassword($len = 6)
    {

        if (($len % 2) !== 0) { // Length paramenter must be a multiple of 2
            $len++;
        }
        $length = $len - 2;
        $conso = array('b', 'c', 'd', 'f', 'g', 'h', 'k', 'l', 'm', 'n', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z');
        $vocal = array('a', 'e', 'i', 'o', 'u');
        $password = '';
        //srand((double)microtime() * 1000000);
        $max = $length / 2;
        for ($i = 1; $i <= $max; $i++) {
            $password .= $conso[rand(0, 17)];
            $password .= $vocal[rand(0, 4)];
        }
        $password .= rand(100, 999);
        $newpass = $password;
        return $newpass;
    }

    /**
     * @param string $string
     * @return string
     */
    public static function sanitize_auto_username(string $string, $post = 1)
    {
        $string = preg_replace('/\s/', '_', $string);
        $string = preg_replace('/[-]/', '_', $string);
        $string = preg_replace('/[^\x{0600}-\x{06FF}A-Za-z0-9_]/u', '', $string);
        if (static::where('username', $string)->count()) {
            $new_username = $string . "_" . $post;
            return self::sanitize_auto_username($new_username, ++$post);
        }
        return strtolower($string);
    }

    public static function routes()
    {
        Route::resource('users/roles', "UserTemplatesController");
        Route::resource('users', "UsersController");
    }

}
