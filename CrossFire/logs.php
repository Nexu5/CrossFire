<html>
<head>
<title>CrossFire Dashboard</title>
<script  type="text/javascript" src="includes/jquery.min.js"></script>
</head>
<body>

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
