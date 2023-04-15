<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vouchers';

    protected $attributes = [
        'available' => 0
    ];

    protected $fillable = [
        'name',
        'code',
        'quantity',
        'description',
        'discount',
        'start_day',
        'exp',
        'available',
        'allow_multi',
        'admin_created',
        'admin_updated'
    ];

    public function customers()
    {
        return $this->belongsToMany(Customer::class)
            ->withPivot('email_status', 'admin_created', 'admin_updated')
            ->withTimestamps();
    }
}
