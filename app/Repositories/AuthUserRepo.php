<?php

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class AuthUserRepo
{

    private $query;

    public function __construct()
    {
        $this->query = User::query();
    }

    public function registerUser($request)
    {


        $user = $this->query->create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password),
        ]);


        return $user;

    }

    public function updateUser($request, $user)
    {

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::delete("public/images/users/" . $user->image);
            }

            $imagePath = Carbon::now()->microsecond . '.' . $request->image->extension();
            $request->image->storeAs('images/users', $imagePath, 'public');
        }

        $this->query->where("id", $user->id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "image" => $request->has("image") ? $imagePath : $user->image,
            "password" => isset($request->password) ? bcrypt($request->password) : $user->password,
        ]);

        if ($request->has('verify')) {
            $user->markEmailAsVerified();
        }


    }

    public function deleteUser($user)
    {

        if ($user->image) {
            Storage::delete("public\\images\\users\\" . $user->image);
        }

        $user->delete();
    }

}
