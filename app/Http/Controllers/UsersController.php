<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Resources\UserResource;
use App\Models\User;

class UsersController extends Controller
{
    use HttpResponses;

    public function index(Request $request)
    {
        $order =$request->query('order') ? $request->query('order') : 'desc';

        return UserResource::collection(User::select('id', 'name', 'phone_number', 'address', 'email', 'email_verified_at', 'role_name')
            ->orderBy('created_at', $order)
            ->paginate(10));
    }
}
