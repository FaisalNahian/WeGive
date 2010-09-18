<?php

?>

<h1>Single test to verify everything works ok</h1>

<hr>

<h2>Generate the authorization link</h2>
<?php  ?>

<hr>

<h2>Verify credentials</h2>
<?php
  $creds = $twitterObj->get('/account/verify_credentials.json');
?>
<pre>
<?php print_r($creds->response); ?>
</pre>

