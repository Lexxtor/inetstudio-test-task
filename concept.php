<?php

interface SecretKeyStorageInterface
{
    public function getSecretKey():string;
}

class SecretKeyFileStorage implements SecretKeyStorageInterface
{
    public function getSecretKey():string
    {
        return 'SecretKeyFileStorage KEY';
    }
}

class SecretKeyDBStorage implements SecretKeyStorageInterface
{
    public function getSecretKey():string
    {
        return 'SecretKeyDB KEY';
    }
}

class SecretKeyCloudStorage implements SecretKeyStorageInterface
{
    public function getSecretKey():string
    {
        return 'SecretKeyCloud KEY';
    }
}

class Concept {
    private $client;
    private $secretKeyStorage;

    public function __construct(SecretKeyStorageInterface $secretKeyStorage, \GuzzleHttp\Client $client) {
        $this->secretKeyStorage = $secretKeyStorage;
        $this->client = $client;
    }

    public function getUserData() {
        $params = [
            'auth' => ['user', 'pass'],
            'token' => $this->secretKeyStorage->getSecretKey()
        ];

        $request = new \Request('GET', 'https://api.method', $params);
        $promise = $this->client->sendAsync($request)->then(function ($response) {
            $result = $response->getBody();
        });

        $promise->wait();
    }
}