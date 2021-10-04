<?php


namespace App\Services;


use App\Repositories\UserRepository;
use App\Traits\paginatorTrait;

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
        $ldap = $this->ldapLogin($request);

        if(!$user || !$ldap) {
            return 'gagal login';
        }

        return [
            'data' => ''
        ];
    }

    public function ldapLogin($request)
    {
        $encodedCredential = base64_encode($request->username.':'.$request->password);
        $client = new \GuzzleHttp\Client(
            ['headers' =>
                [
                    'Authorization' => 'Basic '.$encodedCredential,
                    'Content-Type'  => 'application/json'
                ]
            ]
        );

        $request = $client->request('POST', 'http://192.168.29.71:12103/EnterpriseAuthentication/AuthenticateUserV2');

        return $request;

    }
}
