<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'table_id',
        'reservation_datetime',
        'party_size',
        'special_requests',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'reservation_datetime' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function canBeCancelled()
    {
        return $this->status === 'confirmed' && 
               $this->reservation_datetime > now()->addHours(2);
    }
}
