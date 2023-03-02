<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> redis and php - Delete a subject </title>
</head>

<body>
<h3> Add a Subject </h3>
<?php
    // https://phpredis.github.io/phpredis/Redis.html#method_scan
    require 'connect.php';
    require 'cmd2web.php';
    parseNameEqualValue();    

    //get all ids
    $n = $redis->get( "$me:$studyid:last_usubjid" );
//    echo "<h3> $n subjects </h3> \n";

    //for loop 
    for ($s=1; $s<=$n; $s++) {
        $k = "$me:DM:$studyid:$s"; //hash values
        if ($redis->exists($k)) { //if it exists
            $sub = $redis->hGetAll( $k ); //get all values associated
            //var_dump( $sub );
            $delsub = $redis->del($k);
	    echo "subject " . $s . "was deleted";
	}
    }
     
//    echo "inserting new usubjid = $usubjid <br/> \n";

    echo "<!-- closed: " . $redis->close() . ". --> \n";
?>

</body>
</html>
