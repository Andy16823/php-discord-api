# php-discord-api
php-discord-api is a simple class for communicating with the discord api in php. 

## Example code
```php
<?php
// Include the discord class into your script
include_once "php-discord-api/discord.php";

// define the redirect url
$redirectUrl = "http://127.0.0.1/www/DiscordAPI/";

// Create new credentials and a new instance from the discord class
$credentials = new UserCredentials("YOUR_CLIENT_ID", "YOUR_CLIENT_SECRET", "YOUR_PUBLIC_KEY");
$discord = new Discord($credentials);

// Create the scopes you need
$scopes = array(
    "identify",
    "guilds",
    "email"
);

// Get an oauth url
$url = $discord->getAuthCode($redirectUrl, $scopes);

// Check if we recived an authcode
if (isset($_GET['code'])) {
    $authCode = $_GET['code'];
    // Create an accessToken and get the user data and the guilds
    $accessToken = $discord->getAccessToken($authCode, $redirectUrl);
    $userInfo = $discord->getUserInformation($accessToken);
    $guilds = $discord->getUserGuilds($accessToken);
}
?>

<!-- Display an login link when we have no authCode -->
<?php if (!isset($_GET['code'])): ?>
    <a href="<?php echo $url; ?>">Login with Discord</a>
<?php else: ?>
    <?php echo "hello " . $userInfo['username']; ?>
<?php endif; ?>
```
