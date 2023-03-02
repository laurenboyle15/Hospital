<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> redis and php - Comment Information </title>
</head>

<body>
<h3>Comment Information</h3>

<?php
    // https://phpredis.github.io/phpredis/Redis.html#method_scan
    require 'connect.php';
    require 'cmd2web.php';
    parseNameEqualValue();

        $id = $_GET['usubjid'];
        //echo "$id";
        $k = "$me:DM:$studyid:$id"; //key for this id
        //echo "$k";
        
        if ($redis->exists($k)) {
                $sub = $redis->hGetAll($k); //get all value pairs
                $last_visitnum = $sub['last_visitnum'];

                $key = "$me:SV:$studyid:$id:$last_visitnum";
        //      echo $key;
                $sv = $redis->hGetAll($key);
                
                echo "<table border='1'>
                <tr>
                        <th>Subject ID</th>
                        <td> $id </td> 
                </tr>
                <tr>
                        <th>Start Date Time</th>";
                        echo "<td>" . $sv['svstdc'] . "</td>"; 
                echo "</tr>
                <tr>
                        <th>End Date Time</th>";
                        echo "<td>" . $sv['svendtc'] . "</td>";  
                echo "</tr>
		<tr>
                        <th>Visit</th>";
                        echo "<td>" . $sv['visit'] . "</td>";
		echo "</tr>"; 
                echo "</table>";

                if(isset($_GET["visit"])) {
                        //insert a new sv for the above subject
                       
                        $last_visitnum = $redis->hIncrBy("$me:DM:$studyid:$id",'last_visitnum',1);
                        $start = new DateTime( $_GET["svstdc"]("Y-m-d H:i:s") );
			$end = new DateTime( $_GET["svendtc"]("Y-m-d H:i:s") );
                        $sv = array(
                                'svstdc' => $start->format( DateTime::ATOM ),  # ISO8601 format
                                'svendtc' => $end->format( DateTime::ATOM ),  # ISO8601 format
				'visit' =>  $_GET["visit"]
                        );
                        
                        $svkey = "$me:SV:$studyid:$id:$last_visitnum";
                        $redis->hMset( $svkey, $sv );
                }   

        }
        echo "<!-- closed: " . $redis->close() . ". --> \n"; 
?>


<!--form-->
<form method = "get" action = "">
        <label for = "svstdc">Start Date: </label><br>
        <input type = "datetime" id = "svstdc" name = "svstdc"><br>
	<label for = "svendtc">End Date: </label><br>
        <input type = "datetime" id = "svendtc" name = "svendtc"><br>
	<label for = "visit">Visit</label><br>
        <input type = "text" id = "visit" name = "visit"><br>
        <input type = "hidden" id = "last_visitnum" name = "last_visitnum"><br>
        <input type = "submit" value = "submit" name = "submit">
</form>
</body>
</html>
