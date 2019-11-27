<?php

namespace Tests\Unit;

use App\Repositories\NotesRepository;
use App\Services\ServiceTwoAssets\NoteItem;
use App\Services\ServiceTwoService;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use League\CommonMark\CommonMarkConverter;
use Tests\TestCase;

class NotesRepositoryTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function can_get_notes_and_respond_with_proper_format()
    {
        $user = factory( User::class )->create();

        $serviceTwoService = \Mockery::mock( ServiceTwoService::class );
        $serviceTwoService->shouldReceive( 'getUserNotes' )
                          ->andReturn( $this->prepareNotes( $user ) ); // this is the mock hell version
//                          ->andReturn( $this->getNotes() ); // this is the serialized version

        $mdConverter = new CommonMarkConverter();

        $notesRepository = new NotesRepository( $mdConverter, $serviceTwoService );
        $notes           = $notesRepository->getNotes( $user );

        $m1 = null;
        $m2 = null;
        preg_match("/<[^<]+>/",$notes->where('id', 1)->first()->content,$m1);
        preg_match("/<[^<]+>/",$notes->where('id', 4)->first()->content,$m2);
        $this->assertEquals($m1[0], '<p>');
        $this->assertEquals($m2[0], '<h1>');
    }

    // -----------------------------------
    // Test with object serialized
    // -----------------------------------

    /**
     * @return Collection - NoteItem[]
     */
    private function getNotes(): Collection
    {
        return unserialize(base64_decode( 'TzoyOToiSWxsdW1pbmF0ZVxTdXBwb3J0XENvbGxlY3Rpb24iOjE6e3M6ODoiACoAaXRlbXMiO2E6NDp7aTowO086Mzg6IkFwcFxTZXJ2aWNlc1xTZXJ2aWNlVHdvQXNzZXRzXE5vdGVJdGVtIjo2OntzOjI6ImlkIjtpOjE7czo1OiJ0aXRsZSI7czozMDoiVm9sdXB0YXRlbSBkZWJpdGlzIGRpc3RpbmN0aW8uIjtzOjc6ImNvbnRlbnQiO3M6MTMyOiI8cD5SZXJ1bSBjb21tb2RpIG9tbmlzIHF1YWVyYXQgZHVjaW11cyBkb2xvciBxdWFlIHF1aXNcbiBub24gZGVzZXJ1bnQgY29uc2VxdWF0dXIgcmVjdXNhbmRhZSBhdXRlbSBxdWlhIGlsbHVtIG5hdHVzIGRvbG9yZW1xdWUuPC9wPgoiO3M6NzoidXNlcl9pZCI7aToxO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMTktMTEtMjYgMTU6NTE6MjkiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMTktMTEtMjYgMTU6NTE6MjkiO31pOjE7TzozODoiQXBwXFNlcnZpY2VzXFNlcnZpY2VUd29Bc3NldHNcTm90ZUl0ZW0iOjY6e3M6MjoiaWQiO2k6MjtzOjU6InRpdGxlIjtzOjc6IlF1aSB1dC4iO3M6NzoiY29udGVudCI7czoxNDA6IjxwPlZvbHVwdGF0ZW0gbW9sbGl0aWEgZXZlbmlldCBtb2xlc3RpYWUgY29uc2VxdWF0dXIgdm9sdXB0YXMgc2FlcGUgZXNzZSB0ZW1wb3JhIG5paGlsIG1vZGkgY29uc2VxdWF0dXIgaWQgdmVsaXQgaW4gdGVtcG9yZSB2b2x1cHRhdHVtLjwvcD4KIjtzOjc6InVzZXJfaWQiO2k6MTtzOjEwOiJjcmVhdGVkX2F0IjtzOjE5OiIyMDE5LTExLTI2IDE1OjUxOjMwIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjE5OiIyMDE5LTExLTI2IDE1OjUxOjMwIjt9aToyO086Mzg6IkFwcFxTZXJ2aWNlc1xTZXJ2aWNlVHdvQXNzZXRzXE5vdGVJdGVtIjo2OntzOjI6ImlkIjtpOjM7czo1OiJ0aXRsZSI7czoxMToiVmVsaXQgcXVpYS4iO3M6NzoiY29udGVudCI7czoxNDU6IjxwPkFwZXJpYW0gZnVnYSBpZCBub24gYmVhdGFlIHZvbHVwdGF0ZSBkb2xvcnVtIGVzdCBtb2xlc3RpYWUgZG9sb3JlbSBleCBhcmNoaXRlY3RvIHNpbWlsaXF1ZSBuYXR1cyBzYWVwZSBhc3Blcm5hdHVyIHV0IGlwc2EgbmloaWwgaWxsbyBxdW8uPC9wPgoiO3M6NzoidXNlcl9pZCI7aToxO3M6MTA6ImNyZWF0ZWRfYXQiO3M6MTk6IjIwMTktMTEtMjYgMTU6NTE6MzEiO3M6MTA6InVwZGF0ZWRfYXQiO3M6MTk6IjIwMTktMTEtMjYgMTU6NTE6MzEiO31pOjM7TzozODoiQXBwXFNlcnZpY2VzXFNlcnZpY2VUd29Bc3NldHNcTm90ZUl0ZW0iOjY6e3M6MjoiaWQiO2k6NDtzOjU6InRpdGxlIjtzOjE0OiJFcnJvciBlb3Mgbm9uLiI7czo3OiJjb250ZW50IjtzOjQxOiI8aDE+dGl0bGU8L2gxPgo8cD5Db250ZW50IHNlbnRlbmNlIDE8L3A+CiI7czo3OiJ1c2VyX2lkIjtpOjE7czoxMDoiY3JlYXRlZF9hdCI7czoxOToiMjAxOS0xMS0yNiAxNTo1MTozMSI7czoxMDoidXBkYXRlZF9hdCI7czoxOToiMjAxOS0xMS0yNyAwMDo1MzoyOCI7fX19'));
    }

    // ----------------------
    // Mock Hell
    // ----------------------

    private function prepareNotes( User $user ): Collection
    {
        $notes = [];

        // create simple notes
        for ( $i = 1; $i < 4; $i ++ ) {
            $data['id']         = $i;
            $data['title']      = $this->faker->sentence( 4 );
            $data['content']    = $this->faker->sentence( 12 );
            $data['user_id']    = $user->id;
            $data['created_at'] = Carbon::now();
            $data['updated_at'] = Carbon::now();

            $notes[] = new NoteItem( $data );
        }

        // create notes with heading
        $heading = "# title here\n\n";

        $data['id']         = $i;
        $data['title']      = $this->faker->sentence( 4 );
        $data['content']    = $heading . $this->faker->sentence( 12 );
        $data['user_id']    = $user->id;
        $data['created_at'] = Carbon::now();
        $data['updated_at'] = Carbon::now();

        $notes[] = new NoteItem( $data );

        return collect( $notes );
    }
}
