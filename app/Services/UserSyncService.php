<?php

namespace App\Services;

use GuzzleHttp\Client;

/**
 * Sample Service that will make a request to the Application 2
 *
 * @package App\Services
 */
class UserSyncService
{

    public function sync(\App\User $user)
    {
        $client = new Client();
        $response = $client->request('POST', 'http://localhost:8383/api/users', [
            'form_params' => $user->toArray(),
        ]);
        $parsedResult = json_decode($response->getBody()->getContents());

        return $parsedResult->data;
  }
}
