<?php

namespace App\Http\Controllers;

use App\Repositories\NotesRepository;
use App\Services\ServiceTwoService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    /** @var NotesRepository */
    protected $notesRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(NotesRepository $notesRepository)
    {
        $this->notesRepository = $notesRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        $notes = $this->notesRepository->getNotes($user);

        return view('home', [
            'notes' => $notes,
        ]);
    }

    /**
     * @param Request $request
     * @param $note_id
     *
     * @return View
     */
    public function show(Request $request, $note_id)
    {
        $user = auth()->user();

        $note = $this->notesRepository->getNote($user, $note_id);

        return view('home', [
            'note' => $note,
        ]);
    }
}
