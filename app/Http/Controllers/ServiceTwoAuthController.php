<?php
namespace App\Http\Controllers;

use App\User;
use App\UserMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class ServiceTwoAuthController extends Controller
{
    /** @var string */
    const SERVICE_TWO_META_KEY = 'service-two-meta-key';

    /**
     * @return RedirectResponse
     */
    public function redirectToProvider()
    {
        return Socialite::driver('passport')->redirect();
    }

    public function handleProviderCallback()
    {
        $userPassport = Socialite::driver('passport')->user();

        // $user->token;
        $userQuery = User::query();
        $user = $userQuery
            ->where('email', $userPassport->email)
            ->first();
        if ($user === null) {
            $user = new User;
            $user->name = $userPassport->name;
            $user->email = $userPassport->email;
            $user->password = Hash::make('fb824f84b383g802' . rand(0, 10000));
            $user->save();
        }

        $userMetaQuery = UserMeta::query();
        $userMeta = $userMetaQuery
            ->where('user_id', $user->id)
            ->first();
        if ($userMeta === null) {
            $userMeta = new UserMeta;
            $userMeta->name = self::SERVICE_TWO_META_KEY;
            $userMeta->value = json_encode([
                'token' => $userPassport->token,
                'refreshToken' => $userPassport->refreshToken,
                'id' => $userPassport->id,
                'name' => $userPassport->name,
                'email' => $userPassport->email,
            ]);
            $userMeta->user_id = $user->id;
            $userMeta->save();
        }

        Auth::login($user);

        return redirect()->route('home');
    }
}
