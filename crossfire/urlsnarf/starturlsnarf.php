<?php
exec ("echo '' > /var/www/crossfire/logs/urlsnarf.log");
exec ("echo /var/www/crossfire/urlsnarf/urlsnarf.sh | at now");
exec ("echo /var/www/crossfire/urlsnarf/update-urlsnarf.sh | at now");
?>
<html><head>
<meta http-equiv="refresh" content="0; url=/pineapple/">
</head><body bgcolor="black" text="white"><pre>
<?php
echo "Entropy Bunny Pouncing on URLs";
?>
</pre></head></body>
