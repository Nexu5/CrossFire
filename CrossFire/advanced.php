<html>
<head>
<title>CrossFire Dashboard</title>
<script type="text/javascript" src="jquery.min.js"></script>
</head>
<body bgcolor="black" text="white" alink="green" vlink="green" link="green">

<?php require('includes/navbar.php'); ?>

<table border="0" width="100%"><tr><td align="left" valign="top" width="700">
<pre>

<?php

if(isset($_POST['route']) && $_POST['route'] != "") {
exec($_POST['route'], $routeoutput);
echo "<br /><font color='yellow'>Executing " . $_POST['route'] . "</font><br /><br /><font color='red'><b>";
foreach($routeoutput as $routeoutputline) { echo ("$routeoutputline\n"); }
echo "</b></font><br />"; }

if(isset($_POST['zcommand']) && $_POST['zcommand'] != "") {
$zcommand = $_POST['zcommand'];

$keyarr=explode("\n",$zcommand);
foreach($keyarr as $key=>$value)
{
  $value=trim($value);
  if (!empty($value)) {
      echo "\n<font color='red'>Executing: $value</font>\n";
      $zoutput = "";
      $zoutputline = "";
      exec ($value, $zoutput);
      foreach($zoutput as $zoutputline) {
      echo ("$zoutputline\n");}
  }
}
echo "<br /><br />";
}


$filename =$_POST['filename'];
$newdata = $_POST['newdata'];

if ($newdata != '') {
 $fw = fopen($filename, 'w') or die('Could not open file!');
 $fb = fwrite($fw,stripslashes($newdata)) or die('Could not write to file');
 fclose($fw);
 echo "Updated " . $filename . "<br /><br />";
}

if(isset($_POST['clearcache']) && $_POST['clearcache'] == "1") {
exec("echo '' > /www/pineapple/logs/associations.log");
exec("echo '' > /www/pineapple/logs/urlsnarf.log");
exec("echo '' > /www/pineapple/logs/urlsnarf-clean.log");
exec("echo '' > /www/pineapple/logs/ngrep.log");
exec("echo '' > /www/pineapple/logs/ngrep-clean.log");
echo "<font color='lime'><b>Cache Cleared</b></font><br />";
}

if(isset($_POST['factoryreset']) && $_POST['factoryreset'] == "1") {
echo "<font color='red'><b>Factory reset has been disabled in this version of the firmware.</b></font><br /><br />";
}

if(isset($_POST['reboot']) && $_POST['reboot'] == "1") {
exec("reboot");
}

?>
<b>Kernel IP Routing Table</b>
<?php $cmd = "route | grep -v 'Kernel IP routing table'";
exec("$cmd 2>&1", $output);
foreach($output as $outputline) {echo ("$outputline\n");}?>

<form action='<?php echo $_SERVER[php_self] ?>' method= 'post' >
<input type="text" name="route" value="Route..." size="70" style='font-family:courier; font-weight:bold; background-color:black; color:gray; border-style:dotted; width:690px;'>
<input type='submit' value='Update Routing Table'> <small><font color="gray">Example: <i>route add default gw 172.16.42.42 br-lan</i> <br /></font></small></form>
<form method="post" action="advanced/ping.php"><input type="text" name="pinghost" style='font-family:courier; font-weight:bold; background-color:black; color:gray; border-style:dotted;'/> <input type="submit" value="Ping" name="submit"></form>
<form method="post" action="advanced/traceroute.php"><input type="text" name="traceroutehost" style='font-family:courier; font-weight:bold; background-color:black; color:gray; border-style:dotted;'/> <input type="submit" value="Traceroute" name="submit"></form>
<form action='<?php echo $_SERVER[php_self] ?>' method= 'post' ><textarea cols="80" rows="10" name="zcommand" style='font-family:courier; font-weight:bold; background-color:black; color:gray; border-style:dotted;'></textarea>
<input type='submit' value='Execute Commands'> <small><font color="gray">Will execute one command per line</font></small></form>
<left><br>Change the root password:
                <form action="" method="POST">
                    <table>
                        <tr>
                            <td><?php echo $passMessage ?></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" name="pass"></td>
                        </tr>
                        <tr>
                            <td>Repeat Password:</td>
                            <td><input type="password" name="pass2"></td>
                        </tr>
                        <tr>
                            <td><input type="submit" name="changePass" value="Change Password"></td>
                        </tr>
                    </table>
                </form>


</pre>
</td><td valign="top" align="left" width="*">
<pre>

<form method="post" action="<?php echo $_SERVER[php_self]?>"><input type="hidden" name="clearcache" value="1"><input type="submit" value="Clear Cache" onClick="return confirm('If you shutdown before disabling services like Karma, you may still have sessions in the background, clearing the cache will remove them.')"></form><form method="post" action="<?php echo $_SERVER[php_self]?>"><input type="hidden" name="factoryreset" value="1"><input type="submit" value="Factory Reset" onClick="return confirm('Are you sure you want to reset to factory default configuration? This change cannot be undone.')"></form><form method="post" action="<?php echo $_SERVER[php_self]?>"><input type="hidden" name="reboot" value="1"><input type="submit" value="Reboot" onClick="return confirm('Are you sure you want to reboot?')"></form>

<red>  _____                   ______ _          
<orange> / ____|                 |  ____(_)         
<yellow>| |     _ __ ___  ___ ___| |__   _ _ __ ___ 
<lime>| |    | '__/ _ \/ __/ __|  __| | | '__/ _ \
<green>| |____| | | (_) \__ \__ \ |    | | | |  __/
<cyan> \_____|_|  \___/|___/___/_|    |_|_|  \___|<pink>  BETA!</pink>


