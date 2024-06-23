<?php
include_once "usercredentials.php";

class Discord {
    public UserCredentials $credentials;

    public function __construct(UserCredentials $credentials, ) {
        $this->credentials = $credentials;
    }

    public function getAuthCode($redirectUrl, array $scopes, string $responseType = "code")
    {
        $scopes = implode("+", $scopes);
        $redirectUrl = urlencode($redirectUrl);
        $responseType = urlencode($responseType);

        return "https://discord.com/oauth2/authorize?client_id={$this->credentials->clientId}&response_type={$responseType}&redirect_uri={$redirectUrl}&scope={$scopes}";
    }
    
    public function getAccessToken($authCode, $redirect_uri)
    {
        $token_url = "https://discord.com/api/oauth2/token";
        $data = array(
            'client_id' => $this->credentials->clientId,
            'client_secret' => $this->credentials->clientSecret,
            'grant_type' => 'authorization_code',
            'code' => $authCode,
            'redirect_uri' => $redirect_uri
        );
    
        $options = array(
            'http' => array(
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
    
        $context = stream_context_create($options);
        $result = file_get_contents($token_url, false, $context);
        $token_response = json_decode($result, true);
        return $token_response['access_token'];
    }
    
    public function getUserInformation($access_token)
    {
        $api_url = "https://discord.com/api/users/@me";
        $options = array(
            'http' => array(
                'header' => "Authorization: Bearer $access_token\r\n",
                'method' => 'GET'
            )
        );
    
        $context = stream_context_create($options);
        $user_info = file_get_contents($api_url, false, $context);
        $user = json_decode($user_info, true);
        return $user;
    }

    public function getUserGuilds($access_token)
    {
        $api_url = "https://discord.com/api/users/@me/guilds";
        $options = array(
            'http' => array(
                'header' => "Authorization: Bearer $access_token\r\n",
                'method' => 'GET'
            )
        );
    
        $context = stream_context_create($options);
        $guilds_info = file_get_contents($api_url, false, $context);
        $guilds = json_decode($guilds_info, true);
        return $guilds;
    }
    
}


?>