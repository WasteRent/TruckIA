<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AuthProfileController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        return view($user->role . '.profile', [
            'user' => Auth::user()
        ]);
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $request->request->add([
            'password' => Hash::make($request->input('password'))
        ]);

        $user->update($request->toArray());
        
        if ($request->avatar) {
            if ($user->avatar) {
                $file = $user->avatar;
                $file->removeFile();
                $user->update(['avatar_file_id' => null]);
                $file->delete();
            }

            $file = File::storeFile($request->avatar, $user->id.',avatar');

            $user->update(['avatar_file_id' => $file->id]);
        }

        return back()->with('success_message', 'Perfil actualizado');
    }
}
