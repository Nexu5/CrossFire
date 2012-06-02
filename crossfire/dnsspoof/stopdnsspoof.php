<?php
#exec ("kill `/bin/busybox ps | grep spoofhost | grep -v -e grep | awk '{print $1}'`");
exec("killall dnsspoof");
?>
<html><head>
<meta http-equiv="refresh" content="0; url=/pineapple/">
</head><body bgcolor="black" text="white"><pre>
<?php
echo "Entropy Bunny unspoofing";
?>
</pre></head></body>
