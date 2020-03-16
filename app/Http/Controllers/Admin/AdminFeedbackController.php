<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Mydnic\Kustomer\Feedback;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::all()->map(function ($feedback) {
            $user = User::find($feedback->user_info['user_id']);
            $feedback->user = $user;
            return $feedback;
        });

        return view('admin.feedbacks.index', [
            'feedbacks' => $feedbacks
        ]);
    }
}
