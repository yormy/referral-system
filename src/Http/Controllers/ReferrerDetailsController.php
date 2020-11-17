<?php

namespace Yormy\ReferralSystem\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReferrerDetailsController extends Controller
{
    public function show()
    {
        return view('referral-system::user.details');
    }
}
