<?php
session_start();

require'../vendor/autoload.php';

use Facebook\Facebook;

$api = (array)json_decode((string) file_get_contents('api.json'));

$fb = new Facebook([
  'app_id' => $api['api_id'],
  'app_secret' => $api['api_secret'],
  'default_graph_version' => 'v2.2',
]);

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  $error =  'Graph returned an error: ' . $e->getMessage();
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  $error = 'Facebook SDK returned an error: ' . $e->getMessage();
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}
$oAuth2Client = $fb->getOAuth2Client();
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
$tokenMetadata->validateAppId($api['api_id']);
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    $error = "Error getting long-lived access token: " . $helper->getMessage();
  }
}

$_SESSION['fb_access_token'] = (string) $accessToken;
if($error) :
?>
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
      <h3 style="color:black;width: 100%; text-align: center;">Some errors occured while posting to Twitter. Error: <?= $error ?></h3>
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
<?php else: ?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="/wp-content/plugins/selfie-tool/src/styles.css">
        <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
        <style>
          .form textarea{
            padding: 20px;
          }
          .primary-container{
            background-color: #e9ebee;
          }
          .form button, .form button:visited, .form button:hover,.form button:active ,.form button:focus,.form button:active:focus{
            background-color: #4267b2;
            border-color: #4267b2;
          }
        </style>
    </head>
    <body>
    <div class="primary-container">
      <h1 style="color:black;width: 100%; text-align: center;">Perfect Selfie Calculator</h1>
      <br>
      <h3 style="color:black;width: 100%; text-align: center;">Post to Facebook</h3>
      <br>
      <form method="POST" action="post.php" class="form">
          <h4>Caption:</h4>
          <textarea name="message" class="form-control"></textarea>
          <br>
          <img src="/wp-content/plugins/selfie-tool/images/<?= $_SESSION['target_file'] ?>" id="preview"/>
          <br>
          <input type="submit" name="submit" style="display:none">
          <button class="btn btn-primary" id="submit" style="float:right">Post</button>
          <br>
          <br>
          <br>
      </form>
      <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script src="/wp-content/plugins/selfie-tool/src/script.js"></script>
      <script>
          var score = localStorage.getItem('score');
          $('textarea[name="message"]').html('Woah! My selfie score is '+score+'%, get your Perfect Selfie scored at HYPERLINK');
          $('button#submit').on('click',function(event){
              event.preventDefault();
              $(this).css('pointer-events','none').html('<i class="fa fa-spinner fa-spin" style="color:white;font-weight:bold"></i>Uploading..');
              $('input[type="submit"]').trigger('click');
          });
      </script>
    </div>
    </body>
</html>
<?php endif ?>