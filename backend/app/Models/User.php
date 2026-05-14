<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name','email','password','phone','avatar','role'];
    protected $hidden = ['password','remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public const ROLE_ADMIN = 'admin';
    public const ROLE_MANAGER = 'manager';
    public const ROLE_SUPPORT = 'support';
    public const ROLE_CUSTOMER = 'customer';

    public static function roleOptions(): array
    {
        return [
            self::ROLE_ADMIN => 'Admin',
            self::ROLE_MANAGER => 'Manager',
            self::ROLE_SUPPORT => 'Support',
            self::ROLE_CUSTOMER => 'Customer',
        ];
    }

    public static function rolePermissions(): array
    {
        return [
            self::ROLE_ADMIN => ['Full dashboard access', 'Manage products', 'Manage categories', 'Manage orders', 'Manage users and roles'],
            self::ROLE_MANAGER => ['Dashboard access', 'Manage products', 'Manage categories', 'Manage orders'],
            self::ROLE_SUPPORT => ['Dashboard access', 'View products', 'View categories', 'Manage orders', 'View customers'],
            self::ROLE_CUSTOMER => ['Storefront account', 'Cart and wishlist', 'Checkout and order history'],
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function canAccessAdmin(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_MANAGER, self::ROLE_SUPPORT], true);
    }
}
