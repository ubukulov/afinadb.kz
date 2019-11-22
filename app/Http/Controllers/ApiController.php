<?php

namespace App\Http\Controllers;

use App\Http\Resources\LeadResource;
use App\Models\Lead;
use App\Models\ManagerLead;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\DB;
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
        return UserResource::collection($users);
    }

    // List of Leads
    public function leads()
    {
        $leads = Lead::getLeads();
        return LeadResource::collection($leads);
    }

    // получить список лидов по выбранному городу
    public function getLeadsOfCity(Request $request)
    {
        return Lead::getLeadsOfCity($request->input('city_id'));
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

    public function destroyUser(Request $request)
    {
        $id = $request->input('id');
        $user = User::findOrFail($id);
        if ($user) {
            User::destroy($id);
            return response('Пользовател успешно удален');
        } else {
            return response('Ошибка: Пользовател не найден', 422);
        }
    }

    public function deleteManager(Request $request)
    {
        $id = $request->input('id');
        $manager_id = $request->input('manager_id');
        $user = User::findOrFail($id);
        if ($user) {
            if (count($user->leads) > 0) {
                DB::beginTransaction();
                try {
                    DB::update("UPDATE manager_leads SET manager_id='$manager_id' WHERE manager_id='$id'");
                    DB::update("UPDATE rejected_leads SET manager_id='$manager_id' WHERE manager_id='$id'");
                    User::destroy($id);
                    DB::commit();
                } catch (\Exception $exception) {
                    DB::rollBack();
                    return response("Ошибка сервера: $exception", 500);
                }
            } else {
                User::destroy($id);
                return response("Пользовател успешно удален", 200);
            }
        }

        return response("Ошибка сервера: Не найден пользовател", 404);
    }
}
