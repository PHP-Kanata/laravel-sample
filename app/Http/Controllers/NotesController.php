<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNoteRequest;
use App\Http\Requests\GetNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    /**
     * @param GetNoteRequest  $request
     *
     * @return Note[]
     */
    public function index(GetNoteRequest $request)
    {
        return Note::where('user_id', $request->input('user_id'))->get();
    }

    /**
     * @param CreateNoteRequest $request
     *
     * @return Note
     */
    public function store(CreateNoteRequest $request)
    {
        $note = new Note;
        $note->title = $request->input('title');
        $note->content = $request->input('content');
        $note->user_id = $request->input('user_id');
        $note->save();

        return $note;
    }

    /**
     * @param UpdateNoteRequest $request
     *
     * @return Note
     */
    public function update(UpdateNoteRequest $request)
    {
        $note = Note::find($request->input('id'));

        if ($request->has('title')) {
            $note->title = $request->input( 'title' );
        }

        if ($request->has('content')) {
            $note->content = $request->input( 'content' );
        }

        $note->save();

        return $note;
    }
}
