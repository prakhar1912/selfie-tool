<?php
session_start();

$target_dir = "../images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    	$_SESSION['target_file'] = (string) $_FILES["fileToUpload"]["name"];
    } else{
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
<?php if($uploadOk): ?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css?family=Lato|Montserrat" rel="stylesheet">
        <link rel="stylesheet" href="/wp-content/plugins/selfie-tool/src/styles.css">
        <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    </head>
    <body>
		<div class="primary-container">
			<h1 style="color:black;font-weight:bold;width: 100%; text-align: center;">Perfect Selfie Calculator</h1>
			<br>
			<?php echo '<img id="preview" alt="Uploaded image" src="'.$target_file.'"/>'?>
			<br>
			<div class="progress-bar">
				<div class="progress"></div>
			</div>
			<br>
			<br>
			<div class="criteria-container">
			  	<div class="criteria clearfix">
			  		<div class="slide">
			  			<h3>Head Tilt</h3>
			  			<br>
			  			<div class="option">
			  				<input type="radio" name="headtilt" value="crh">&nbsp;<span>Chin Raised High</span><span class="checkbox"></span>
			  			</div>
			  			<div class="option">
			  				<input type="radio" name="headtilt" value="lh">&nbsp;<span>Level Height</span><span class="checkbox"></span>
			  			</div>
			  			<div class="option">
			  				<input type="radio" name="headtilt" value="ctu">&nbsp;<span>Chin Tucked Under</span><span class="checkbox"></span>
			  			</div>
			  			<br>
			  			<button class="btn btn-primary btn-block" id="next">Next</button>
			  		</div>
			  		<div class="slide">
			  			<h3>Filter</h3>
			  			<br>
			  			<div class="option">
			  				<input type="radio" name="filter" value="f">&nbsp;<span>Filter</span><span class="checkbox"></span>
			  			</div>
			  			<div class="option">
			  				<input type="radio" name="filter" value="nf">&nbsp;<span>No Filter</span><span class="checkbox"></span>
			  			</div>
			  			<br>
			  			<button class="btn btn-primary btn-block" id="next">Next</button>
			  		</div>
			  		<div class="slide">
			  			<h3>Lighting</h3>
			  			<br>
			  			<div class="option">
			  				<input type="radio" name="lighting" value="g">&nbsp;<span>Good but not overly bright</span><span class="checkbox"></span>
			  			</div>
			  			<div class="option">
			  				<input type="radio" name="lighting" value="d">&nbsp;<span>Dark lighting</span><span class="checkbox"></span>
			  			</div>
			  			<div class="option">
			  				<input type="radio" name="lighting" value="v">&nbsp;<span>Very bright lighting</span><span class="checkbox"></span>
			  			</div>
			  			<br>
			  			<button class="btn btn-primary btn-block" id="next">Next</button>
			  		</div>
			  		<div class="slide">
			  			<h3>Body</h3>
			  			<br>
			  			<div class="option">
			  				<input type="radio" name="body" value="ff">&nbsp;<span>Full face and some body</span><span class="checkbox"></span>
			  			</div>
			  			<div class="option">
			  				<input type="radio" name="body" value="cu">&nbsp;<span>Close up face</span><span class="checkbox"></span>
			  			</div>
			  			<br>
			  			<button class="btn btn-primary btn-block" id="next">Next</button>
			  		</div>
			  		<div class="slide">
			  			<h3>Teeth</h3>
			  			<br>
			  			<div class="option">
			  				<input type="radio" name="teeth" value="ws">&nbsp;<span>Wide smile with good display of teeth</span><span class="checkbox"></span>
			  			</div>
			  			<div class="option">
			  				<input type="radio" name="teeth" value="cm">&nbsp;<span>Closed mouth and no smile</span><span class="checkbox"></span>
			  			</div>
			  			<br>
			  			<button class="btn btn-primary btn-block" id="next">Next</button>
			  		</div>
			  		<div class="slide last">
			  			<h3>Angle of Camera</h3>
			  			<br>
			  			<div class="option">
			  				<input type="radio" name="camera" value="lth">&nbsp;<span>Level with top of the head</span><span class="checkbox"></span>
			  			</div>
			  			<div class="option">
			  				<input type="radio" name="camera" value="up">&nbsp;<span>Low down pointing upwards</span><span class="checkbox"></span>
			  			</div>
			  			<div class="option">
			  				<input type="radio" name="camera" value="vh">&nbsp;<span>Very high above</span><span class="checkbox"></span>
			  			</div>
			  			<br>
			  			<button class="btn btn-primary btn-block" id="next">Finish</button>
			  		</div>
			  		<div class="slide">
			  			<h3>Selfie Score:<span id="score"></span>%</h3>
			  			<div id="social">
					  		<div class="share">
					  			<a href="#" id="facebook" target="popup" class="icon" style="background-image: url('facebook.jpg');"></a>
					  			<p>Share to<br>Facebook</p>
					  		</div>
					  		<div class="share">
					  			<a href="#" id="hopper" target="_blank" class="icon" style="background-image: url('instagram.png');"></a>
					  			<p>Schedule to<br>Instagram</p>
					  		</div>
					  		<div class="share">
					  			<a href="#" id="twitter" target="popup" class="icon" style="background-image: url('twitter.png');"></a>
					  			<p>Share to<br>Twitter</p>
					  		</div>
			  			</div>
			  			<a href="/wp-content/plugins/selfie-tool/src/source.html" class="btn btn-primary btn-block">Start Again</a>
			  		</div>
			  	</div>
		  	</div>
		</div>
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script src="/wp-content/plugins/selfie-tool/src/script.js"></script>
		<script src="/wp-content/plugins/selfie-tool/src/socials.js"></script>
    </body>
</html>
<?php endif ?>