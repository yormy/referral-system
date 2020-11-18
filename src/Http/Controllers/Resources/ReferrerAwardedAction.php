<?php

namespace Yormy\ReferralSystem\Http\Controllers\Resources;

use App\Libraries\DateHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use LiranCo\NotificationSubscriptions\Models\NotificationSubscription;

class ReferrerAwardedAction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $modelIdColumn = config('referral-system.models.referring_user_public_column');
        return [
            'user_id' => $this->user->{$modelIdColumn},
            'actionName' => $this->action->name,
            'points' => $this->action->points,
            'paid' => $this->payment_id ? true : false,
            'paidSearchable' => $this->payment_id ? "#paid" : "#unpaid",
            'created_at' => $this->created_at->format(config('referral-system.datetime_format')),
        ];
    }

}
