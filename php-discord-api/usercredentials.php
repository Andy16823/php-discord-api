<?php

class UserCredentials
{
    public String $clientId;
    public String $clientSecret;
    public String $publicKey;

    public function __construct(String $clientId, String $clientSecret, string $publicKey)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->publicKey = $publicKey;
    }
}