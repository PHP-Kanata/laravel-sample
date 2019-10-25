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
        // here we are intentionally using the database factory
        // with the method "make", this happened to facilitate
        // the construction of this example, that was actually
        // persisting in the database only in the Application 2.
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
