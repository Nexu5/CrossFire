<?php
exec ("echo '' > /tmp/ngrep.log");
exec ("echo /var/www/crossfire/ngrep.sh | at now");
exec ("echo /var/www/crossfire/update-ngrep.sh | at now");
?>
<html><head>
<meta http-equiv="refresh" content="0; url=/pineapple/">
</head><body bgcolor="black" text="white"><pre>
<?php
echo "Entropy Bunny Grepping";
?>
</pre></head></body>
