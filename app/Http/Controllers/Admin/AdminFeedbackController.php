<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\User;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    public function index()
    {
        $feedbacks = Feedback::orderBy('reviewed', 'ASC')->latest()->paginate();

        return view('admin.feedbacks.index', [
            'feedbacks' => $feedbacks
        ]);
    }

    public function update(Request $request, Feedback $feedback)
    {
        $feedback->update(['reviewed' => $request->reviewed]);
        return back()->with('success_messsage', 'Feedback revisado');
    }
}
