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
        return [
            'user_id' => $this->user_id,
            'actionName' => $this->action->name,
            'points' => $this->action->points,
            'paid' => $this->payment_id ? true : false,
            'created_at' => $this->created_at->format(config('referral-system.datetime_format')),
//            'person.email' => $this->person->email,
//            'hash' => $this->hash,
//            'recipient' => $this->recipient,
//            'subject' => $this->subject,
//            'content' => $this->content,
//            'opens' => $this->opens,
//            'clicks' => $this->clicks,
//            'created_at' => DateHelper::formatDateTimeForUser($this->created_at),
//            'dummy' => '@',
        ];
    }

}
