<?php
session_start();

require '../vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$api = (array)json_decode((string) file_get_contents('api.json'));

define('CONSUMER_KEY', $api['consumer_key']);
define('CONSUMER_SECRET', $api['consumer_secret']);
define('OAUTH_CALLBACK', $api['oauth_callback']);

$request = $_GET['request'];

if($request == 'fetchURL'){
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

	$url = $connection->url('oauth/authorize', array('oauth_token' => $_SESSION['oauth_token']));

	echo htmlspecialchars($url);
}