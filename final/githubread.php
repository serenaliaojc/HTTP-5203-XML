<?php 
require_once 'githubread_fns.php';

if (isset($_POST['getaccount'])) {
	$url = "https://github.com/login/oauth/authorize?client_id=$client_id&redirect_uri=$redirect_url&scope=user&state=mystate";
	header("Location: $url");
}

if(isset($_GET['code']))
{
	$code = $_GET['code'];

	$post = http_build_query(array(
		'client_id' => $client_id ,
		'redirect_uri' => $redirect_url ,
		'client_secret' => $client_secret,
		'code' => $code ,
		'state'=> 'mystate'
		));

	$context = stream_context_create(array("http" => array(
		"method" => "POST",
		"header" => "Content-type: application/x-www-form-urlencoded\r\n"."Content-Length: ". strlen($post) . "\r\n".
                            "Accept: application/json",  
		"content" => $post,
		))); 

	$json_data = file_get_contents("https://github.com/login/oauth/access_token", false, $context);

	$r = json_decode($json_data, true);
	// var_dump($r);

	$access_token = $r['access_token'];
	// echo "<br >";
	// var_dump($access_token);

	$url = "https://api.github.com/user?access_token=".$access_token;
	$options  = array('http' => array('user_agent'=> $_SERVER['HTTP_USER_AGENT']));
	// avoid 403 error
	$context  = stream_context_create($options);
	$data = file_get_contents($url, false, $context); 
	$user_data  = json_decode($data, true);
	// var_dump($user_data)
}

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>See your GitHub!</title>
 </head>
 <body>
 	<div class="container">
 		<header>
 			<h1>Read Your GitHub</h1>
 			<p>What to see your Github state?</p>
 		</header>
 		
 		<main>
 			<?php 

 			// var_dump($user_data);
 			// var_dump($_POST['getaccount']);

 			if (!isset($user_data)) {
 				echo "<form action='githubread.php' method='post'>
 				<input type='submit' name='getaccount' value='Sign in with your Github account'>
 			</form>";
 			} else {
 				echo $user_data['login'];
 			}

 			 ?>
 		</main>
	 	
	 	<footer>
	 		<p>© 2018. Serena Liao.</p>
	 	</footer>
 	</div>
 </body>
 </html>