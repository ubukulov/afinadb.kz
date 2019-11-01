<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeadResource;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function getUser($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            UserResource::withoutWrapping();
            return new UserResource($user);
        }

        return false;
    }

    public function createUser(Request $request)
    {
        $data = $request->all();
        $data['api_token'] = hash('sha256', Str::random(60));

        $user = User::create($data);
        if ($user) {
            return response('Account has successfully updated!');
        }

        return response('Account has successfully updated!');
    }

    public function updateUser(Request $request)
    {
        $id = $request->input('id');
        $user = User::findOrFail($id);
        if ($user) {
            $user->update($request->all());
            $user->save();
            return response('Account has successfully updated!');
        }

        return response('Account has successfully updated!');
    }

    public function getUsers()
    {
        $users = User::orderBy('id', 'DESC')->paginate(20);
        UserResource::withoutWrapping();
        return new UserResource($users);
    }

    // List of Leads
    public function leads()
    {
        $leads = Lead::getLeads();
        return LeadResource::collection($leads);
    }

    // List of Free Leads
    public function getLeadsOfFree($user_id)
    {
        LeadResource::withoutWrapping();
        return LeadResource::collection(Lead::getLeadsOfFree($user_id));
    }

    // List of Managers
    public function managers()
    {
        return UserResource::collection(User::getAllManagers());
    }
}
