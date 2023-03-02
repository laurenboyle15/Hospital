<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"> <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> redis and php - List all subjects </title>  
  <style>
  table {
	border-style:solid;
	border-color:black;
  }
  </style>
</head>

<body>
	<h3 style = "color: black;"> Subjects </h3>
<?php
    // https://phpredis.github.io/phpredis/Redis.html#method_scan
    require 'connect.php';
    require 'cmd2web.php';
    parseNameEqualValue();

    //subjects = n
   
    $n = $redis->get( "$me:$studyid:last_usubjid" );
//    echo "<h3> $n subjects </h3> \n";

    //for loop 
    for ($s=1; $s<=$n; $s++) {
	$k = "$me:DM:$studyid:$s";
        if ($redis->exists($k)) { //where n is the subjects id
	    $sub = $redis->hGetAll( $k );
	    //var_dump( $sub );
	    echo "<table border='1'>
            <tr>
	    <th>Subject ID</th>
	    <th>Birth Date</th>
	    <th>Sex</th>
	    <th>Race</th>
	    <th>Country</th>
	    <th>Last Visit</th>
	    <th>Last Coseq</th>
	    </tr>";
	
	    echo "<tr>";     	  
  	    echo "<td>" . $s . "</td>"; 
	    echo "<td>" . $sub['brthdtc'] . "</td>";
	    echo "<td>" . $sub['sex'] . "</td>";	  
 // echo $sub['sex'] . "<br/> \n";
	    echo "<td>" .  $sub['race'] . "</td>";
	    echo "<td>" .  $sub['country'] . "</td>";
            echo "<td>" .  $sub['last_visitnum'] . "</td>";
            echo "<td>" . $sub['last_coseq'] . "</td>";
	    echo "<td><a style = text-decoration:none; href=\"subject583642.php?usubjid=" . $s . "\">Details</a></td>";
//	    echo "<td><form method = 'get' action = 'subject583642.php'>
//			<input type = 'hidden' name = 'usubjid'  value = '1'>
//			<input type = 'submit' value = 'Details'></form></td>" ;
	    echo "</tr>";
	    echo "</table>";
	}
    }
    echo "<!-- closed: " . $redis->close() . ". --> \n";
?>
<h3> list done </h3>
<button onclick = "document.location = 'add625371.php'"> Click to add a subject</button>
</body>
</html>
