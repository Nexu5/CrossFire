<?php
if(isset($_GET[css]) && file_exists("/www/CrossFire/includes/".$_GET[css].".css")){
	exec("echo ".$_GET[css]." > /www/CrossFire/includes/css");
}
$css = exec("cat '/www/CrossFire/includes/css'");
if($css == ""){$css = "main";}
echo "<link href='/CrossFire/includes/".$css.".css' rel='stylesheet' type='text/css' />";
?>
<table class="nav" >
	<tr class="nav">
		<td class="nav">
			<a href="/CrossFire/index.php" class="nav">Status</a> | 
            <a href="/CrossFire/config.php" class="nav">Configuration</a> | 
            <a href="/CrossFire/advanced.php" class="nav">Advanced</a> | 
            <a href="/CrossFire/usb.php" class="nav">USB</a> | 
            <a href="/CrossFire/jobs.php" class="nav">Jobs</a> | 
            <a href="/CrossFire/3g.php" class="nav">3G</a> | 
            <a href="/CrossFire/ssh.php" class="nav">SSH</a> | 
            <a href="/CrossFire/scripts.php" class="nav">Scripts</a> | 
            <a href="/CrossFire/logs.php" class="nav">Logs</a> | 
            <a href="/CrossFire/upgrade.php" class="nav">Upgrade</a> | 
            <a href="/CrossFire/resources.php" class="nav">Resources</a> | 
            <a href="/CrossFire/modules.php" class="nav">Modules</a> | 
            <a href="/CrossFire/about.php" class="nav">About</a>
		</td>
	</tr>
</table>
