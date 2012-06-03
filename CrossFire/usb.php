<html>
<head>
<title>CrossFire Dashboard</title>
<script  type="text/javascript" src="includes/jquery.min.js"></script>
</head>
<body>

<?php require('includes/navbar.php'); ?>
<pre>
<?php
$filename =$_POST['filename'];
$newdata = $_POST['newdata'];

if ($newdata != "") { $newdata = ereg_replace(13,  "", $newdata);
 $fw = fopen($filename, 'w') or die('Could not open file!');
 $fb = fwrite($fw,stripslashes($newdata)) or die('Could not write to file');
 fclose($fw);
 echo "Updated " . $filename . "<br /><br />";
} ?>
</pre>
<pre>
<b>lsusb output:</b><br />
<?php
$exec = exec("lsusb", $return);
foreach ($return as $line) {
echo("$line <br />");
}
?>
</pre>
<pre>

<table border="0" width="100%" >
<td width="700">
	<?php
		$filename = "/etc/config/fstab";
		$fh = fopen($filename, "r") or die("Could not open FsTab!");
		$data = fread($fh, filesize($filename)) or die("FsTab!");
		fclose($fh);
	?>
	<b>Fstab</b>
	<form action='<?php $_SERVER[php_self] ?>' method= 'post' >
	<textarea name='newdata' class='configBox'>
    <?php echo $data?>
	</textarea>
	<input type='hidden' name='filename' value='/etc/config/fstab'>
	<br><input type='submit' value='Update Fstab'>
	</form>
    
</td>
<td valign="top" align="left">
	Fstab Configuration.
</td>
</table>

</pre>
</body>
</html>
