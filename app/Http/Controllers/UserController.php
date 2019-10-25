<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

// usual implementation
//use App\Services\UserSyncService;

// realtime facade
use \Facades\App\Services\UserSyncService;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     *
     * @return UserResource
     */
    public function show(Request $request, $id): UserResource
    {
        $user = collect(User::find($id));
        return new UserResource($user);
    }

    /**
     * @param Request $request
     * @param $name
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request, $name)
    {
        $userSample = factory(User::class)->make([
            'name' => $name,
        ]);

        // usual implementation
        // $userSynced = (new UserSyncService)->sync($userSample);

        // realtime facade
        $userSynced = UserSyncService::sync($userSample);

        return response()->json($userSynced);
    }

}
