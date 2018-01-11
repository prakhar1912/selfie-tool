<?php
session_start();

$submit = $_POST['submit'];

if($submit){
    include 'tweet.php';
} else{
    $_SESSION['oauth_verifier'] = $_REQUEST['oauth_verifier'];
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
            <link rel="stylesheet" href="../font-awesome/css/font-awesome.min.css">
            <style>
              .tweet{
                height: 200px;
                padding: 20px;
              }
            </style>
        </head>
        <body>
            <div class="primary-container">
                <h1 style="color:black;width: 100%; text-align: center;">Perfect Selfie Calculator</h1>
                <br>
                <h3 style="color:black;width: 100%; text-align: center;">Compose Tweet</h3>
                <br>
                <form method="POST" action="landing.php" class="form">
                    <p>Tweet:</p>
                    </br>
                    <textarea name="status" class="form-control tweet"></textarea>
                    <br>
                    <img src="/wp-content/plugins/selfie-tool/images/<?= $_SESSION['target_file'] ?>" id="preview"/>
                    <br>
                    <input type="submit" name="submit" style="display:none">
                    <button class="btn btn-primary" id="submit" style="float:right">Tweet</button>
                    <br>
                    <br>
                    <br>
                </form> 
                <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
                <script src="/wp-content/plugins/selfie-tool/src/script.js"></script>
                <script>
                    var score = localStorage.getItem('score');
                    $('textarea[name="status"]').html('Woah! My selfie score is '+score+'%, get your Perfect Selfie scored at HYPERLINK');
                    $('button#submit').on('click',function(event){
                        event.preventDefault();
                        $(this).css('pointer-events','none').html('<i class="fa fa-spinner fa-spin" style="color:white;font-weight:bold"></i>Uploading..');
                        $('input[type="submit"]').trigger('click');
                    });
                </script>
            </div>
        </body>
    </html>
<?php } ?>