<?php
session_start();

require '../vendor/autoload.php';

use Facebook\Facebook;

$api = (array)json_decode((string) file_get_contents('api.json'));

$fb = new Facebook([
  'app_id' => $api['api_id'],
  'app_secret' => $api['api_secret'],
  'default_graph_version' => 'v2.2',
]);

$request = $_GET['request'];

if($request == 'fetchURL'){
	$helper = $fb->getRedirectLoginHelper();

	$permissions = ['email','publish_actions'];
	$redirect_uri = $api['redirect_uri'];
	$loginUrl = $helper->getLoginUrl($redirect_uri, $permissions);

	echo htmlspecialchars($loginUrl);
}