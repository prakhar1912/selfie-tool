<?php
session_start();

require '../vendor/autoload.php';

use Facebook\Facebook;

$fb = new Facebook([
  'app_id' => '2271843309508393',
  'app_secret' => 'e9267388b7dab5d4ccc6d03d667ed185',
  'default_graph_version' => 'v2.2',
]);

$request = $_GET['request'];

if($request == 'fetchURL'){
	$helper = $fb->getRedirectLoginHelper();

	$permissions = ['email','publish_actions'];
	$redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].'/wp-content/plugins/selfie-tool/src/facebook/landing.php';
	$loginUrl = $helper->getLoginUrl($redirect_uri, $permissions);

	echo htmlspecialchars($loginUrl);
}