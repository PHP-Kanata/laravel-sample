<?php

namespace App\Services;

use App\Http\Controllers\ServiceTwoAuthController;
use App\Services\ServiceTwoAssets\NoteItem;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class ServiceTwoService
{
    /** @var Client */
    protected $httpClient;

    /** @var string */
    protected $serviceUrl;

    public function __construct( Client $httpClient )
    {
        $this->httpClient = $httpClient;
        $this->serviceUrl = env( 'SERVICE_TWO_URL' );
    }

    protected function getAccessToken()
    {
        $response = $this->httpClient->post( $this->serviceUrl . '/oauth/token', [
            'form_params' => [
                'grant_type'    => 'client_credentials',
                'client_id'     => env( 'SERVICE_TWO_CLIENT_ID' ),
                'client_secret' => env( 'SERVICE_TWO_CLIENT_SECRET' ),
                'scope'         => '',
            ],
        ] );

        return json_decode( (string) $response->getBody(), true )['access_token'];
    }

    /**
     * @param User $user
     *
     * @return Collection
     */
    public function getUserNotes( User $user ): Collection
    {
        $accessToken = $this->getAccessToken();

        $userId = json_decode( $user->metas->filter( function ( $meta ) {
            return $meta->name === ServiceTwoAuthController::SERVICE_TWO_META_KEY;
        } )->first()->value )->id;

        $response = $this->httpClient->get( $this->serviceUrl . '/notes?user_id=' . $userId, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ]
        ] );

        $notes = json_decode( $response->getBody()->getContents(), true );
        $notes = array_map( function ( $note ) {
            return new NoteItem( $note );
        }, $notes );

        return collect( $notes );
    }
}
