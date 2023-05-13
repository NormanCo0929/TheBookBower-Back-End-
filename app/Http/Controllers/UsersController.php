<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Hash;

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

    public function search($users)
    {
        return UserResource::collection(User::where('name', 'like','%'.$users.'%')->get()); 
    }

    public function show(string $id)
    {
        return response(UserResource::make(User::find($id)), 200);
    }

    public function store(StoreUserRequest $request)
    {
        $request->validated($request->all());

        $user = User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_name' => $request->role_name,
        ]);

        return response($user, 201);
    }

    public function update(Request $request, string $id)
    {
        $fields = $request->validate([
            'name' => 'nullable|string',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'email' => 'nullable|string',
        ]);

        $user = User::find($id);
        $user->update($request->all());

        return response($user, 200);
    }

    public function destroy(string $id)
    {
        User::destroy($id);

        $response = [
            'message' => 'User has been deleted'
        ];

        return response($response, 200);
    }
}
