<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> redis and php - Add a subject </title>
</head>

<body>
<h3> Add a Subject </h3>
<?php
    // https://phpredis.github.io/phpredis/Redis.html#method_scan
    require 'connect.php';
    require 'cmd2web.php';
    parseNameEqualValue();    

	$k = "$me:DM:$studyid:17";
 $value = $redis->hGetAll($k);
echo $value['brthdtc'];
echo $value['sex'];
echo $value['race'];
echo $value['country'];
echo "<!-- closed: " . $redis->close() . ". --> \n";
?>
</body>
</html>
