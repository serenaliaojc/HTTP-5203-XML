<?php 

require_once 'githubread_fns.php';

if (isset($_POST['getaccount'])) {
	$url = "https://github.com/login/oauth/authorize?client_id=$client_id&redirect_uri=$redirect_url&scope=user&state=mystate";
	header("Location: $url");
}

if($_GET['code'])
{
	$code = $_GET['code'];

	$post = http_build_query(array(
		'client_id' => $client_id ,
		'redirect_uri' => $redirect_url ,
		'client_secret' => $client_secret,
		'code' => $code ,
		'state'=> 'mystate'
		));

	$c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($c, CURLOPT_URL, 'https://github.com/login/oauth/access_token?'.$post);
    $json_data =  curl_exec($c);
    curl_close($c); 

	$r = json_decode($json_data, true);
	$access_token = $r['access_token'];

	$url = "https://api.github.com/user";
	$options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));

	$c = curl_init();
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_HTTPHEADER, array('Accept: application/json','Authorization: Bearer '.$access_token, 'User-Agent: '.$_SERVER['HTTP_USER_AGENT']));
    curl_setopt($c, CURLOPT_URL, $url);
    $data =  curl_exec($c);
    curl_close($c); 

	$user_data  = json_decode($data, true);

}

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>See your GitHub!</title>
 	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
 	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
 	<link rel="stylesheet" type="text/css" href="style.css">
 </head>
 <body>
 	<div class="container">
 		<header>
 			<h1>Read Your GitHub</h1>
 			<p>Want to see your Github state?</p>
 		</header>
 		
 		<main>
 			<?php 

 			if ($user_data) {
 				?>

 				<h2><i class='fab fa-github'></i> Hello, <a href="<?= $user_data['html_url'] ?>"><?= $user_data['name'] ?></a>!</h2>
 				<div class="personal-info">
 					<img src="<?= $user_data['avatar_url'] ?>" alt="<?= $user_data['login'] ?>">
 					<h3 class="name"><?= $user_data['name'] ?></h3>
 					<div class="bio"><?= $user_data['bio'] ?></div>
 				</div>
 				<div class="charts">
 					<div id="repo"style="width: 650px;height:300px;"></div>
	 				<div id="follow"style="width: 650px;height:300px;"></div>
 				</div>
 				<div hidden="hidden">
 					<input type="hidden" id="i_followers" value="<?= $user_data['followers'] ?>">
 					<input type="hidden" id="i_following" value="<?= $user_data['following'] ?>">
 					<input type="hidden" id="i_public_repos" value="<?= $user_data['public_repos'] ?>">
 					<input type="hidden" id="i_total_private_repos" value="<?= $user_data['total_private_repos'] ?>">
 				</div>

 		<?php
 			
 			} else {
 				// $user_data = signup_github();
				echo "<form action='githubread.php' method='post'>
					<button class='btn btn-outline-secondary' type='submit' name='getaccount'><i class='fab fa-github'></i> Sign in with your Github account</button>
				</form>";
 			}
 			 ?> 
 		</main>
	 	
	 	<footer>
	 		<p>© 2018. Serena Liao.</p>
	 	</footer>
 	</div>
 	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
 	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
 	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
 	<script src="echarts.js"></script>
 	<script src="walden.js"></script>
 	<script src="githubread_js.js"></script>
 </body>
 </html>