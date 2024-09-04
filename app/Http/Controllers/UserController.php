<?php

namespace App\Http\Controllers;

use App\Models\ServerToken;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function index()
    {

        do {

            $serverToken = ServerToken::where('status', 'active')->first();
            if (!$serverToken) {
                $tokenRequestClient = new Client;

                $response = $tokenRequestClient->post('http://127.0.0.1:8000/oauth/token', [
                    'form_params' => [
                        'grant_type' => 'client_credentials',
                        'client_id' => '4',
                        'client_secret' => '8Hul1rqrPc6zhQ2ZaKloF7T7HG65kEQudYXjPHxl',
                    ],
                ]);
                $token = json_decode((string) $response->getBody(), true);
                $serverToken = new ServerToken;
                $serverToken->token = $token['access_token'];
                $serverToken->save();
            }

            try {
                $token = $serverToken->token;

                $client = new Client([
                    'verify' => false,
                ]);

                $response = $client->Request('GET', 'http://127.0.0.1:8000/api/getallusers', [
                    'headers' => [
                        'Accept' => 'application/json',
                        'Authorization' => 'Bearer ' . $token
                    ]
                ]);

                $success = true;

            } catch (\Throwable $th) {
                if($th->getCode()==401){
                    $serverToken->status = 'inactive';
                    $serverToken->save();
                    $success = false;
                };
            }

        } while ($success == false);


        echo $response->getBody();
    }
}
