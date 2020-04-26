<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Illuminate\Http\Request;

class AlertLinkingController extends Controller
{
    public function index(Alert $alert)
    {
        if ($alert->action_url) {
            $alert->update(['dismissed' => 1]);
            return redirect(url($alert->action_url));
        }
        return back()->with('error_message', 'Ha ocurrido un error');
    }
}
