<?php

namespace App\Http\Controllers;

use App\Services\ServiceTwoService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        $httpClient = new Client();
        $serviceTwo = new ServiceTwoService($httpClient);
        $notes = $serviceTwo->getUserNotes($user);

        return view('home', [
            'notes' => $notes,
        ]);
    }
}
