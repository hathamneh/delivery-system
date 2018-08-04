<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
    public function isAuthorized($roles, $accessLevel = null)
    {
        return $this->template->authorizeRoles($roles, $accessLevel);
    }

    public function isAdmin()
    {
        return $this->template->name == "admin";
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
}
