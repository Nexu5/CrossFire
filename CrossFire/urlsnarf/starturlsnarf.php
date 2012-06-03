<?php
exec ("echo '' > /www/pineapple/logs/urlsnarf.log");
exec ("echo /www/pineapple/urlsnarf/urlsnarf.sh | at now");
exec ("echo /www/pineapple/urlsnarf/update-urlsnarf.sh | at now");
?>
<html><head>
<meta http-equiv="refresh" content="0; url=/pineapple/">
</head><body bgcolor="black" text="white"><pre>
<?php
echo "Entropy Bunny Pouncing on URLs";
?>
</pre></head></body>
