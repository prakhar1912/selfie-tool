<?php
session_start();

require'../vendor/autoload.php';

use Facebook\Facebook;

$fb = new Facebook([
  'app_id' => '2271843309508393',
  'app_secret' => 'e9267388b7dab5d4ccc6d03d667ed185',
  'default_graph_version' => 'v2.2',
]);

$message = $_POST['message'];
$url = '../../images/'.$_SESSION['target_file'];

$data = [
  'message' => $message,
  'source' => $fb->fileToUpload($url),
];

try {
  $response = $fb->post('/me/photos', $data, $_SESSION['fb_access_token']);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  $error = 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  $error = 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
if($response) : ?>
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
      <h3 style="color:black;width: 100%; text-align: center;">Your picture has been posted on Facebook.</h3>
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
<?php if($error) : ?>
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
      <h3 style="color:black;width: 100%; text-align: center;">An error occured while posting to Facebook: <?= $error ?></h3>
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