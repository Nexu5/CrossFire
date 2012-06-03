<html>
<head>
<title>CrossFire Dashboard</title>
<!--<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">-->
<script type="text/javascript" src="includes/ajax.js"> </script>
<script type="text/javascript" src="logtail/logtail.js"> </script>
</head>

<?php require('includes/navbar.php'); ?>
<body onLoad="getLog('start');">
<pre>

<table border="0" width="100%">
	<tr>
		<td class="status" nowrap>

			<b>Systems</b><br />
			<servicesList>
				<?php

				$iswlanup = exec("ifconfig wlan0 | grep UP | awk '{print $1}'");
				if ($iswlanup == "UP") {
					echo "&nbsp;Wireless  <enabled>enabled</enabled>.<br />";
				} else {
					echo "&nbsp;Wireless  <disabled>disabled</disabled> | <a href=\"wlan.php?start\"><b>Start</b></a><br />";
				}

				if ( exec("hostapd_cli -p /var/run/hostapd-phy0 karma_get_state | tail -1") == "ENABLED" ){
					$iskarmaup = true;
				}
				
				if ($iskarmaup != "") {
					echo "MK4 Karma  <enabled>enabled</enabled>.&nbsp; | <a href=\"karma/stopkarma.php\"><b>Stop</b></a><br />";
				} else {
					echo "MK4 Karma  <disabled>disabled</disabled>. | <a href=\"karma/startkarma.php\"><b>Start</b></a> <br />";
				}

				$autoKarma = ( exec("if grep -q 'hostapd_cli -p /var/run/hostapd-phy0 karma_enable' /etc/rc.local; then echo 'true'; fi") );
				if ($autoKarma != ""){
					echo "Autostart  <enabled>enabled</enabled>.&nbsp; | <a href=\"karma/autoKarmaStop.php\"><b>Stop</b></a><br />";
				} else {
					echo "Autostart  <disabled>disabled</disabled>. | <a href=\"karma/autoKarmaStart.php\"><b>Start</b></a><br />";
				}

				$cronjobs = ( exec("ps -all | grep [c]ron"));
				if ($cronjobs != ""){
					echo "Cron Jobs <enabled>enabled</enabled>.&nbsp; | <a href=\"jobs.php?stop&goback\"><b>Stop</b></a><br />";
				} else {
					echo "Cron Jobs <disabled>disabled</disabled>. | <a href=\"jobs.php?start&goback\"><b>Start</b></a> | <a href=\"jobs.php\"><b>Edit</b></a><br />";
				}

				$isurlsnarfup = exec("ps auxww | grep urlsnarf.sh | grep -v -e grep");
				if ($isurlsnarfup != "") {
					echo "URL Snarf  <enabled>enabled</enabled>.&nbsp; | <a href=\"urlsnarf/stopurlsnarf.php\"><b>Stop</b></a><br />";
				} else {
					echo "URL Snarf  <disabled>disabled</disabled>. | <a href=\"urlsnarf/starturlsnarf.php\"><b>Start</b></a><br />";
				}

				$isdnsspoofup = exec("ps auxww| grep dnsspoof.sh | grep -v -e grep");
				if ($isdnsspoofup != "") {
					echo "DNS Spoof  <enabled>enabled</enabled>.&nbsp; | <a href=\"dnsspoof/stopdnsspoof.php\"><b>Stop</b></a><br />";
				} else {
					echo "DNS Spoof  <disabled>disabled</disabled>. | <a href=\"dnsspoof/startdnsspoof.php\"><b>Start</b></a> | <a href=\"config.php#spoofhost\"><b>Edit</b></a><br/>";
				}

				/*$isngrepup = exec("/bin/busybox ps | grep ngrep | grep -v -e \"grep ngrep\" | awk '{print $1}'");
				if ($isngrepup != "") {
					echo "&nbsp;&nbsp;&nbsp;&nbsp;ngrep  <enabled>enabled</enabled>.&nbsp; | <a href=\"ngrep/stopngrep.php\"><b>Stop</b></a>";
				} else {
					echo "&nbsp;&nbsp;&nbsp;&nbsp;ngrep  <disabled>disabled</disabled>. | <a href=\"ngrep/startngrep.php\"><b>Start</b></a> | <a href=\"config.php#ngrep\"><b>Edit</b></a><br/>";
				}*/

				if (exec("grep 3g.sh /etc/rc.local") != ""){
					echo "3G bootup  <enabled>enabled</enabled>.&nbsp; | <a href=\"3g.php?disable&disablekeepalive&goback\"><b>Disable</b></a><br />";
				} else {
					echo "3G bootup <disabled>disabled</disabled>. | <a href=\"3g.php?enable&goback\"><b>Enable</b></a><br />";
				}              
                                                                                                                                                        
				if (exec("grep 3g-keepalive.sh /etc/crontabs/root") == "") {
					echo "3G redial <font color='red'><b>disabled</b></font>. | <a href='3g.php?enablekeepalive&enable&goback'><b>Enable</b></a><br />";
				} else {
					echo "3G redial <font color='lime'><b>enabled</b></font>.&nbsp; | <a href='3g.php?disablekeepalive&goback'><b>Disable</b></a><br />";
				}
				
				if (exec("ps aux | grep [s]sh | grep -v -e ssh.php | grep -v grep") == "") {
					echo "&nbsp; &nbsp; &nbsp; SSH <disabled>offline</disabled>. &nbsp;| <a href=\"ssh.php?connect\"><b>Connect</b></a><br /><br />";
				} else {
					echo "&nbsp; &nbsp; &nbsp; SSH <enabled>online</enabled>. &nbsp; | <a href=\"ssh.php?disconnect\"><b>Disconnect</b></a><br /><br />";
				}
			?>
			</servicesList>
			<br/><b>Interfaces</b><br />
			
			<?php
				echo "&nbsp;LAN/WAN Port: " . exec("ifconfig eth0 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'") . "<br />";
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3G Modem: " . exec("ifconfig 3g-wan2 | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'") . "<br />";
				echo "&nbsp; External IP: "; 
				if (isset($_GET[revealpublic])) {
					echo exec("wget -qO- http://cloud.wifipineapple.com/ip.php") . "<br />";
				} else {
					echo "<a href=\"index.php?revealpublic\">reveal public ip</a><br />";
				}
			?>

		</td>
		<td class="statusLogs">
			<pre>
				<a href="#" onClick="getLog('start');return false"><b>Resume Log</b></a> | <a href="#" onClick="stopTail();return false"><b>Pause Log</b></a> | <?php if (isset($_GET[report])) { echo "<a href='index.php'><b>Dismiss Detailed Report</b></a>"; } else { echo "<a href='index.php?report'><b>Generate Detailed Report</b></a>"; } ?><br />

				<?php
					if (isset($_GET[report])) {
						echo "<br /><b>Detailed Report</b> &nbsp; &nbsp; <small><font color='gray'>CPU Intensive. Do not re-run reports in rapid succession</font></small><br /><br />";
						$cmd="/www/CrossFire/karma/karmaclients.sh";
						exec("$cmd 2>&1", $output);
						foreach($output as $outputline) {
		 					echo ("$outputline\n");
						}
					} else {
						echo "<div id='log'>Karma Log:</div>";
					}
				?>

			</pre>
		</td>
	</tr>
</table>
</pre><!-- http://www.youtube.com/watch?v=KqL_nsSl_Fs //easter egg -->
</body>
</html>
