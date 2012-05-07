<html>
<head>
<title>CrossFire Control</title>
<script  type="text/javascript" src="includes/jquery.min.js"></script>
</head>
<body bgcolor="black" text="white" alink="green" vlink="green" link="green">

<?php require('includes/navbar.php'); ?>
<pre>
<?php

$cmd = "logread";
exec ($cmd, $output);                                                              
foreach($output as $outputline) {
echo ("$outputline\n");}   

?>
<a name="bottom"></a>
<a href="javascript:window.location.reload()">Refresh Log</a>
</pre>
</body>
</html>
