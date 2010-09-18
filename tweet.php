<?php
include 'twitter/EpiCurl.php';
include 'twitter/EpiOAuth.php';
include 'twitter/EpiTwitter.php';

$consumer_key = 'H1xFwXIVtUC6WI6S4WrQrg';
$consumer_secret = 'gB4owMNP3MULWJYtiIgXufKHmMOaKNoVYvdFobOAm4';

$token = '69655255-XuO44jJEEdOguXmQINJSRiSq3o4Vcd4VaIDXGZA3c';
$secret= 'cZ0h3eZKf1YQSBiT9RUWHTiZX4sX5bCw7AUvvJonj0';

$twitterObj = new EpiTwitter($consumer_key, $consumer_secret, $token, $secret);
$twitterObjUnAuth = new EpiTwitter($consumer_key, $consumer_secret);
?>

<h1>Single test to verify everything works ok</h1>

<hr>

<h2>Generate the authorization link</h2>
<?php echo $twitterObjUnAuth->getAuthenticateUrl(); ?>

<hr>

<h2>Verify credentials</h2>
<?php
  $creds = $twitterObj->get('/account/verify_credentials.json');
?>
<pre>
<?php print_r($creds->response); ?>
</pre>

