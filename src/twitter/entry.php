<?php
session_start();

require '../vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY', 'Ccy5HrmAd5I4jnywiWL7Ec2x0');
define('CONSUMER_SECRET', 'daOxvGDdcBZKfWleUCtTpp8IPI8wN7hypAD1ehXZIrjHQfilLn');
define('OAUTH_CALLBACK', 'http://localhost:8000/wp-content/plugins/selfie-tool/src/twitter/landing.php');

$request = $_GET['request'];

if($request == 'fetchURL'){
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

	$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

	$url = $connection->url('oauth/authorize', array('oauth_token' => $_SESSION['oauth_token']));

	echo htmlspecialchars($url);
}