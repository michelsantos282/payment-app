<?php

namespace App\Models;

use App\Enums\TransactionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'payer_id',
        'payee_id',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => TransactionStatusEnum::class,
        ];
    }

    public function sender(): HasOne
    {
        return $this->hasOne('App\User','id', 'payer_id');
    }

    public function receiver(): HasOne
    {
        return $this->hasOne('App\User', 'id', 'payee_id');
    }
}
