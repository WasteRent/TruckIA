<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $user->update($request->toArray());

        if ($request->avatar) {
            if ($user->avatar) {
                Storage::delete($user->avatar->getPath());
                $user->update(['avatar_file_id' => null]);
                $user->avatar->delete();
            }

            $request->avatar->store(File::PATH);

            $file = new File([
                'description' => $user->id.',avatar',
                'filename' => $request->avatar->hashName(),
                'content_type' => $request->avatar->getMimeType(),
                'size' => $request->avatar->getSize()
            ]);
            $file->save();

            Storage::setVisibility($file->getPath(), 'public');
            $user->update(['avatar_file_id' => $file->id]);
        }

        return back()->with('success_message', 'Perfil actualizado');
    }
}
