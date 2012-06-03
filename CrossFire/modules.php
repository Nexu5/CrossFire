<?php

if(isset($_GET[getModule], $_GET[moduleVersion], $_GET[destination])){
		
	exec("mkdir -p /tmp/modules");
	exec("wget -O /tmp/modules/mk4-module-".$_GET[getModule]."-".$_GET[moduleVersion].".tar.gz \"http://cloud.wifipineapple.com/mk4/downloads.php?downloadModule=".$_GET[getModule]."&moduleVersion=".$_GET[moduleVersion]."\"");
        $path = "/tmp/modules/mk4-module-".$_GET[getModule]."-".$_GET[moduleVersion].".tar.gz";
        $cmd = "tar -xzf ".$path." -C /tmp/modules/";
        exec($cmd);
        $configArray = explode("\n", trim(file_get_contents("/tmp/modules/mk4-module-".$_GET[getModule]."-".$_GET[moduleVersion]."/module.conf")));

        $name = explode("=", $configArray[0]);
        $version = explode("=", $configArray[1]);
        $author = explode("=", $configArray[2]);
        $destination = explode("=", $configArray[3]);
        $depends = explode("=", $configArray[4]);
        $startPage = explode("=", $configArray[5]);

        if(is_dir("/www/CrossFire/modules/".$name[1]) || is_dir("/www/CrossFire/modules/usb/".$name[1]))
        {
                echo "Already installed";

        }else{
                if($depends[1] != ""){
                        #download+install depends
                        $dependsArray = explode(",", $depends[1]);
                        exec("opkg update");
                        foreach($dependsArray as $dep){
                                exec("opkg install -d ".$_GET[destination]." ".$dep);
                        }
                }
                #Install the module
                if($_GET[destination] == "root"){
                	exec("mv ".substr_replace($path, "", -7)."/$name[1] /www/CrossFire/modules/");
                	exec("echo '".$name[1]."|".$version[1]."|".$startPage[1]."|root"."|./"."' >> /www/CrossFire/modules/moduleList");
                }elseif($_GET[destination] =="usb"){
                	exec("mv ".substr_replace($path, "", -7)."/$name[1] /www/CrossFire/modules/usb/");
                	exec("echo '".$name[1]."|".$version[1]."|".$startPage[1]."|usb"."|./usb/"."' >> /www/CrossFire/modules/usb/moduleList");
                }
                
        }


}


?>
<html>
<head>
<title>CrossFire Dashboard</title>
<script  type="text/javascript" src="includes/jquery.min.js"></script>
</head>
<body>

<?php require('includes/navbar.php'); ?>
<pre>
<?php

	if(isset($_GET[remove]) && $_GET[remove] != ""){
		exec("rm -rf modules/".$_GET[remove]);
		exec("rm -rf modules/usb/".$_GET[remove]);
		$cmd = "sed '/".$_GET[remove]."/{x;/^$/d;x}' modules/moduleList > modules/moduleListtmp && mv modules/moduleListtmp modules/moduleList";
			exec($cmd);
		$cmd = "sed '/".$_GET[remove]."/{x;/^$/d;x}' modules/usb/moduleList > modules/usb/moduleListtmp && mv modules/usb/moduleListtmp modules/usb/moduleList";
			exec($cmd);
		echo "removed ".$_GET[remove];
	}

?>
<center>
<font color="yellow"><b>Pineapple Bar</b></font>
Come get some infusions for your pineapple cocktail
</center>
<b>Installed Infusions:</b>
<?php
	if(!file_exists("modules/usb/moduleList")){ //check if usb modules have been used before to avoid errors
		if(!file_exists("modules/usb/")){
			symlink("/usb/modules", "/www/CrossFire/modules/usb/");
		}
		touch("modules/usb/moduleList");		
	}
	#get list of current modules:
	$rootmoduleArray = explode("\n", trim(file_get_contents("modules/moduleList")));
	$usbmoduleArray = explode("\n", trim(file_get_contents("modules/usb/moduleList")));//use two seperate files so usb storage can be switched out
	$moduleArray = ($rootmoduleArray[0] != "") ? $moduleArray = array_merge($rootmoduleArray, $usbmoduleArray) : $usbmoduleArray ;
?>

<table cellpadding=5px><tr>
<tr><td>Module </td><td> Version </td><td> Location</td></tr>
<?php
foreach($moduleArray as $module){
$moduleArray = explode("|", $module);
if($moduleArray[0] == ""){ echo "No modules installed."; break;}
echo "
<tr>
	<td><font color=lime>".$moduleArray[0]." </td>
	<td> ".$moduleArray[1]."<td>".$moduleArray[3]."
		<td><a href='modules/".$moduleArray[4].$moduleArray[0]."/".$moduleArray[2]."'>Launch</a></td>
		<td><font color=red><a href='?remove=".$moduleArray[0]."' )'>Remove</a>
	</td>
</tr>";
}
?>
</table>


<b>Avaliable Infusions: <a href="?show">Show</a></b>
<font color=red>Warning: This will establish a
connection to wifipineapple.com</font>


<?php
if(isset($_GET[show])){
$moduleListArray = explode("#", file_get_contents("http://cloud.wifipineapple.com/mk4/downloads.php?moduleList"));
if($moduleListArray[0] != ""){
	echo "<table cellpadding=5px>
		<tr>
		<tr>
			<td>Module </td>
			<td> Version </td>
			<td>Author</td>
			<td>Description</td>
			<td>location</td>
		</tr>";
	foreach($moduleListArray as $moduleArr){
		$nameVersion = explode("|", $moduleArr);
		if($nameVersion[0] != "\n" && $nameVersion[0] != ""){
			echo "<tr><td><font color=lime>".$nameVersion[0]."</td><td>".$nameVersion[1]."</td><td>".$nameVersion[2]."</td><td>".$nameVersion[3]."</td><td>
				<a href='modules.php?getModule=".$nameVersion[0]."&moduleVersion=".$nameVersion[1]."&destination=root"."'>ROOT</a>
				<a href='modules.php?getModule=".$nameVersion[0]."&moduleVersion=".$nameVersion[1]."&destination=usb"."'>USB</a>";
		}
	}
	echo "</td></tr><br />";
echo "</table>";
}else{
echo "No modules found";
}
}
?>
</pre>
</body>
</html>
