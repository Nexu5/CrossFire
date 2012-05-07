<html>
<head>
<title>CrossFire Control</title>
<!--<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">-->
<script type="text/javascript" src="includes/ajax.js"> </script>
<script type="text/javascript" src="logtail/logtail.js"> </script>
</head>
<body bgcolor="black" text="white" alink="green" vlink="green" link="green" onload="getLog('start');">

<?php require('includes/navbar.php'); ?>
<pre>

<table border="0" width="100%"><tr><td valign="top" align="left" width="350">
<b>Systems</b><br />
<?php
$iswlanup = exec("ifconfig wlan0 | grep UP | awk '{print $1}'");
if ($iswlanup == "UP") {
echo "&nbsp;Wireless  <font color=\"lime\"><b>enabled</b></font>.<br />";
} else { echo "&nbsp;Wireless  <font color=\"red\"><b>disabled</b></font>.<br />"; }
if ( exec("ifconfig wlan0 | grep UP | awk '{print $1}'") == "UP" ){
$iswlanup = true;
}
if ($iswlanup != "") {
echo "&nbsp;Wireless  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"config/wlandown.php\"><b>Stop</b></a><br />";
} else { echo "&nbsp;Wireless  <font color=\"red\"><b>disabled</b></font>. | <a href=\"config/wlanup.php\"><b>Start</b></a> <br />"; }

if ( exec("hostapd_cli -p /var/run/hostapd-phy0 karma_get_state | tail -1") == "ENABLED" ){
$iskarmaup = true;
}
if ($iskarmaup != "") {
echo "MK4 Karma  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"karma/stopkarma.php\"><b>Stop</b></a><br />";
} else { echo "&nbsp;&nbsp;&nbsp;&nbsp;Karma  <font color=\"red\"><b>disabled</b></font>. | <a href=\"karma/startkarma.php\"><b>Start</b></a> <br />"; }

$autoKarma = ( exec("if grep -q 'hostapd_cli -p /var/run/hostapd-phy0 karma_enable' /etc/rc.local; then echo 'true'; fi") );
if ($autoKarma != ""){
echo "Autostart  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"karma/autoKarmaStop.php\"><b>Stop</b></a><br />";
} else { echo "Autostart  <font color=\"red\"><b>disabled</b></font>. | <a href=\"karma/autoKarmaStart.php\"><b>Start</b></a><br />"; }

$cronjobs = ( exec("/bin/busybox ps | grep [c]ron"));
if ($cronjobs != ""){
echo "Cron Jobs <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"jobs.php?stop&goback\"><b>Stop</b></a><br />";
} else { echo "Cron Jobs <font color=\"red\"><b>disabled</b></font>. | <a href=\"jobs.php?start&goback\"><b>Start</b></a> | <a href=\"jobs.php\"><b>Edit</b></a><br />"; }

$isurlsnarfup = exec("/bin/busybox ps | grep urlsnarf.sh | grep -v -e grep");
if ($isurlsnarfup != "") {
echo "URL Snarf  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"urlsnarf/stopurlsnarf.php\"><b>Stop</b></a><br />";
} else { echo "URL Snarf  <font color=\"red\"><b>disabled</b></font>. | <a href=\"urlsnarf/starturlsnarf.php\"><b>Start</b></a><br />"; }

$isdnsspoofup = exec("/bin/busybox ps | grep dnsspoof.sh | grep -v -e grep");
if ($isdnsspoofup != "") {
echo "DNS Spoof  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"dnsspoof/stopdnsspoof.php\"><b>Stop</b></a><br />";
} else { echo "DNS Spoof  <font color=\"red\"><b>disabled</b></font>. | <a href=\"dnsspoof/startdnsspoof.php\"><b>Start</b></a> | <a href=\"config.php#spoofhost\"><b>Edit</b></a><br/>"; }

$isngrepup = exec("/bin/busybox ps | grep ngrep | grep -v -e \"grep ngrep\" | awk '{print $1}'");
if ($isngrepup != "") {
echo "&nbsp;&nbsp;&nbsp;&nbsp;Net Grep  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"ngrep/stopngrep.php\"><b>Stop</b></a>";
} else { echo "&nbsp;Net Grep  <font color=\"red\"><b>disabled</b></font>. | <a href=\"ngrep/startngrep.php\"><b>Start</b></a> | <a href=\"config.php#ngrep\"><b>Edit</b></a><br/>"; }


if (exec("grep 3g.sh /etc/rc.local") != ""){                                                         
echo "3G bootup  <font color=\"lime\"><b>enabled</b></font>.&nbsp; | <a href=\"3g.php?disable&disablekeepalive&goback\"><b>Disable</b></a><br />";
} else { echo "3G bootup <font color=\"red\"><b>disabled</b></font>. | <a href=\"3g.php?enable&goback\"><b>Enable</b></a><br />"; }              
                                                                                                                                                        
if (exec("grep 3g-keepalive.sh /etc/crontabs/root") == "") {                                                                              
echo "3G redial <font color='red'><b>disabled</b></font>. | <a href='3g.php?enablekeepalive&enable&goback'><b>Enable</b></a><br />";             
} else { echo "3G redial <font color='lime'><b>enabled</b></font>.&nbsp; | <a href='3g.php?disablekeepalive&goback'><b>Disable</b></a><br />"; } 

if (exec("/bin/busybox ps | grep [s]sh | grep -v -e ssh.php | grep -v grep") == "") {                                                                                             
echo "&nbsp; &nbsp; &nbsp; SSH <font color=\"red\"><b>offline</b></font>. &nbsp;| <a href=\"ssh.php?connect\"><b>Connect</b></a><br /><br />";        
} else {         
echo "&nbsp; &nbsp; &nbsp; SSH <font color=\"lime\"><b>online</b></font>. &nbsp; | <a href=\"ssh.php?disconnect\"><b>Disconnect</b></a><br /><br />";
} 


                                                                                                                                                        
echo "<br/><b>Interfaces</b><br />";

echo "&nbsp; LAN Port: " . exec("ifconfig lan0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'") . "<br />";
echo "&nbsp;WLAN Port: " . exec("ifconfig wlan0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'") . "<br />";
echo "&nbsp;&nbsp;3G Modem: " . exec("ifconfig ppp0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'") . "<br />";
echo "&nbsp;&nbsp;&nbsp;Ext. IP: "; 
if (isset($_GET[revealpublic])) { 
	echo exec("wget -qO- http://icanhazip.com") . "<br />"; 
} else { 
	echo "<a href=\"index.php?revealpublic\">Show External IP</a><br />"; 
}

?>



</td><td valign="top" align="left" width="*">



<pre>
<a href="#" onclick="getLog('start');return false"><b>Resume Log</b></a> | <a href="#" onclick="stopTail();return false"><b>Pause Log</b></a> | <?php if (isset($_GET[report])) { echo "<a href='index.php'><b>Dismiss Detailed Report</b></a>"; } else { echo "<a href='index.php?report'><b>Generate Detailed Report</b></a>"; } ?><br />

<?php
if (isset($_GET[report])) {
	echo "<br /><b>Detailed Report</b> &nbsp; &nbsp; <small><font color='gray'>CPU Intensive. Do not re-run reports in rapid succession</font></small><br /><br />";
	$cmd="/var/www/crossfire/karma/karmaclients.sh";
	exec("$cmd 2>&1", $output);                                                                                                                                     
	foreach($output as $outputline) {
		 echo ("$outputline\n");         
	 }
} else {

	echo "<div id='log'>Karma Log:</div>";

}
 
?>
<footer valign="left">
<pre>
<font color="red">  _____                   ______ _          
<font color="orange"> / ____|                 |  ____(_)         
<font color="yellow">| |     _ __ ___  ___ ___| |__   _ _ __ ___ 
<font color="lime">| |    | '__/ _ \/ __/ __|  __| | | '__/ _ \
<font color="green">| |____| | | (_) \__ \__ \ |    | | | |  __/
<font color="cyan"> \_____|_|  \___/|___/___/_|    |_|_|  \___| Firmware</font>
</pre>


</td></tr></table>
</pre><!-- http://www.youtube.com/watch?v=KqL_nsSl_Fs //easter egg -->
</body>
</html>
