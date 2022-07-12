<?php

namespace App\Http\Controllers;

use App\Models\Alert;

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
