<?php

namespace Yormy\ReferralSystem\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralAward extends Model
{
    protected $fillable = [
        'user_id',
        "referrer_id",
        "action_id"
    ];

    public function user() {
        return $this->belongsTo(config('referral-system.models.referring_user_model'));
    }
}
