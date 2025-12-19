<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'firstname',
        'name',
        'email',
        'password',
        'organization',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permissions()
    {
        return $this->role
            ? $this->role->permissions
            : collect();
    }

    public function hasPermission(string $slug): bool
    {
        return $this->permissions()->contains('slug', $slug);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(
            new \App\Notifications\CustomResetPassword($token)
        );
    }
}
