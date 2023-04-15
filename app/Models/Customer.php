<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "customers";
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'admin_created',
        'admin_updated'
    ];

    public function admin()
    {
        return $this->hasOne(User::class, 'id', 'admin_created');
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class)
            ->withPivot('email_status', 'admin_created', 'admin_updated')
            ->withTimestamps();
    }
}
