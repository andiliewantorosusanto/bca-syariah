<?php


namespace App\Services;


use App\Repositories\UserRepository;
use App\Traits\paginatorTrait;
use Illuminate\Support\Facades\Log;

use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthService
{
    use paginatorTrait;

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login($request)
    {

        $user = $this->userRepository->getByUsername($request->username);
        if(!$user) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'username'   => 'Username does not exists'
            ]);
        }

        // $ldap = $this->ldapLogin($request);
        // if(!$ldap) {
        //     throw \Illuminate\Validation\ValidationException::withMessages([
        //         'password'   => 'Ldap login failed',
        //     ]);
        // }

        $token = $user->createToken(env('APP_TOKEN_KEY'))->plainTextToken;

        return [
            'token'     => $token,
            'user'      => $user
        ];
    }

    public function ldapLogin($request)
    {
        $encodedCredential = base64_encode(env('LDAP_USERNAME').':'.env('LDAP_PASSWORD'));
        $client = new \GuzzleHttp\Client(
            [
                'headers' =>
                [
                    'Authorization' => 'Basic '.$encodedCredential,
                    'Content-Type'  => 'application/json'
                ],
                'body' =>
                '
                    {
                    "TrxId" : "112",
                    "Credentials" : {
                      "UserId" : "'.$request->username.'",
                      "UserName" : null,
                      "Password" : "'.$request->password.'"
                    }
                  }
                '
            ]
        );

        $response = $client->request('POST', env('LDAP_URL'));

        $response = (json_decode($response->getBody()->getContents()));

        if(empty($response->ResponseHeader) || $response->ResponseHeader->ErrorDescription === "Failed") {
            return false;
        } else {
            return $response->UserInfo;
        }
    }
}
