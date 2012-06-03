<?php

if(isset($_GET[start])){
exec("wifi");
header("Location:index.php");
}

if(isset($_GET[stop])){
exec("wifi down");
header("Location:index.php");
}
