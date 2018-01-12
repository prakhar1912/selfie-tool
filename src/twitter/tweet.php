<?php

require '../vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

$api = (array)json_decode((string) file_get_contents('api.json'));

define('CONSUMER_KEY', $api['consumer_key']);
define('CONSUMER_SECRET', $api['consumer_secret']);

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
$access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_SESSION['oauth_verifier']]);

$_SESSION['access_token'] = $access_token;

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$connection->setTimeouts(20, 20);

$status = $_POST['status'];
$url = '../../images/'.$_SESSION['target_file'];

try {
    $media = $connection->upload('media/upload', ['media' => $url]);

    $parameters = [
        'status' => $status,
        'media_ids' => implode(',', [$media->media_id_string])
    ];
    $result = $connection->post('statuses/update', $parameters);
} catch(TwitterOAuth\TwitterOAuthException $e) {
  $error = 'An error occured while uploading image: ' . $e->getMessage();
}

if($result->errors || $error): ?>
    <!doctype html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="x-ua-compatible" content="ie=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
            <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat" rel="stylesheet">
            <link rel="stylesheet" href="/wp-content/plugins/selfie-tool/src/styles.css">
        </head>
        <body>
    		<div class="primary-container">
    			<h1 style="color:black;width: 100%; text-align: center;">Perfect Selfie Calculator</h1>
    			<br>
    			<h3 style="color:black;width: 100%; text-align: center;">Some errors occured while posting to Twitter. Error: <?= $error || $result->errors ?></h3>
    			<br>
          		<h3 style="color:black;width: 100%; text-align: center;">Window will close in 5 seconds.</h3>
	    		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	    		<script src="/wp-content/plugins/selfie-tool/src/script.js"></script>
		        <script>
		          setTimeout(function(){
		            window.close();
		          },5000);
		        </script>
    		</div>
        </body>
    </html>

<?php else :?>
    <!doctype html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="x-ua-compatible" content="ie=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
            <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat" rel="stylesheet">
            <link rel="stylesheet" href="/wp-content/plugins/selfie-tool/src/styles.css">
        </head>
        <body>
    		<div class="primary-container">
    			<h1 style="color:black;width: 100%; text-align: center;">Perfect Selfie Calculator</h1>
    			<br>
    			<h3 style="color:black;width: 100%; text-align: center;">Your selfie has been posted on Twitter.</h3>
    			<br>
          		<h3 style="color:black;width: 100%; text-align: center;">Window will close in 5 seconds.</h3>
	    		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	    		<script src="/wp-content/plugins/selfie-tool/src/script.js"></script>
		        <script>
		          setTimeout(function(){
		            window.close();
		          },5000);
		        </script>
		    </div>
        </body>
    </html>
<?php endif ?>