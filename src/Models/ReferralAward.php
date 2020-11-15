<?php

namespace Yormy\ReferralSystem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferralAward extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        "referrer_id",
        "action_id",
    ];

    public function user()
    {
        return $this->belongsTo(config('referral-system.models.referring_user_model'));
    }
}
