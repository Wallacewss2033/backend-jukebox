<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Firevel\FirebaseAuthentication\FirebaseAuthenticable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use FirebaseAuthenticable, Notifiable;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'provider',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'task_id');
    }
}
