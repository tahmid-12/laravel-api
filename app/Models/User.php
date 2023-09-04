<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Crypt;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'retype_password',
        'api_token',
        'address',
        'phone_number'
    ];

    public static function createUser($data)
    {
        return self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Crypt::encryptString($data['password']),
            'api_token' => $data['api_token'],
            'address' => $data['address'],
            'phone_number' => $data['phone_number']
        ]);
    }

    public static function authenticateUser($data)
    {

        $user = self::where('email', $data['email'])->first();

        if (!$user) {
            return false; // User not found
        }

        $decryptedPassword = Crypt::decryptString($user->password);

        if ($data['password'] === $decryptedPassword) {
            return $user; // Return the user instance
        }

        return null;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
