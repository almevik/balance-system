<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Transaction
 *
 * @property int         $id
 * @property int         $user_id
 * @property float       $amount
 * @property string|null $description
 * @property Carbon      $transaction_date
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 *
 * @property-read User   $user
 */
class Transaction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
        'description',
        'transaction_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
