<?php

namespace App\Http\Controllers;

use App\Models\infoUser;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUser(Request $request)
    {

        $validate = $request->validate([
            'id' => 'required'
        ]);


        $user = User::with('roles')->findOrFail($validate['id']);


        return response()->json(['status' => 'success', 'user' => $user]);

    }

    public function createInfo(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'type' => 'required',
        ]);

        $info = new infoUser();

        $info->user_id = $validate['user_id'];
        $info->address = $validate['address'];
        $info->phone = $validate['phone'];
        $info->city = $validate['city'];
        $info->type = $validate['type'];

        $info->save();

        return response()->json(['status' => 'success', 'info' => $info]);
    }
}
