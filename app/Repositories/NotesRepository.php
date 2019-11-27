<?php

namespace App\Repositories;

use App\Services\ServiceTwoAssets\NoteItem;
use App\Services\ServiceTwoService;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use League\CommonMark\CommonMarkConverter;

class NotesRepository
{
    /** @var CommonMarkConverter */
    protected $mdConverter;

    /** @var ServiceTwoService */
    protected $serviceTwoService;

    public function __construct(
        CommonMarkConverter $mdConverter,
        ServiceTwoService $serviceTwoService
    ) {
        $this->mdConverter = $mdConverter;
        $this->serviceTwoService = $serviceTwoService;
    }

    public function getNotes( User $user ): Collection
    {
        $notes = $this->serviceTwoService->getUserNotes( $user );

        $notes = $notes->map( function ( $note ) {
            $note->content = $this->mdConverter->convertToHtml( $note->content );

            return $note;
        } );

        return $notes;
    }

    public function getNote( User $user, int $note_id ): NoteItem
    {
        $note = $this->serviceTwoService->getUserNote( $user, $note_id );

        $note->content = $this->mdConverter->convertToHtml( $note->content );

        return $note;
    }
}
