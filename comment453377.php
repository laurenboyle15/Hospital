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
        $n = preg_split('/:/',$id);
	$usubjid = $id[3]; //get subjid in the key
	$k = "$me:DM:$studyid:$id";
        //echo "$k";
	
	//set keys
//	$com = "$me:CO:$studyid:$usubjid:*";
//	$cokey = $redis->get($com);
	
	//loop through
//	foreach ($cokey as $key) {
//	      echo "Subject ID: " . $usubjid . " \n </br>";
//             echo "Comment Date Time: " . $com['codtc'] . " \n </br>";
//              echo "Comment: " . $com['coval'] . "\n </br>";
//	}
	if ($redis->exists($k)) {
                $sub = $redis->hGetAll($k);
		$lstc = $sub['last_coseq'];
		//echo $lstc;
		
		$key = "$me:CO:$studyid:$id:$lstc";
	//	echo $key;
                $com = $redis->hGetAll($key);
 		
//		echo "Subject ID: " . $id . " \n </br>";
//		echo "Comment Date Time: " . $com['codtc'] . " \n </br>";
//		echo "Comment: " . $com['coval'] . "\n </br>";
		echo "<table border='1'>
                <tr>
                        <th>Subject ID</th>
                        <td> $id </td> 
                </tr>
                <tr>
                        <th>Comment Date Time</th>";
                        echo "<td>" . $com['codtc'] . "</td>"; 
                echo "</tr>
                <tr>
                        <th>Comment</th>";
                        echo "<td>" . $com['coval'] . "</td>";  
                "</tr>"; 
   	        echo "</table>";
//		echo "Add a Comment";
 		if(isset($_GET["coval"])) {
                	 //insert a new comment (CO) for the above subject
			$id = $_GET['usubjid'];
			$subjid = $id;
			$last_coseq = $redis->hIncrBy("$me:DM:$studyid:$subjid",
						'last_coseq', 1 );
    			$now = new DateTime( date("Y-m-d H:i:s") );
    			$co = array(
        			'codtc' => $now->format( DateTime::ATOM ),  # ISO8601 format
        			'coval' => _GET['coval']
			);
			
			$cokey = "$me:CO:$studyid:$subjid:$last_coseq";
    			$redis->hMset( $cokey, $co );
		}   
	    //echo "<td><a style = text-decoration:none; href=\"addComment198624.php?usubjid=" . $id . "\">Click to Add Comment</a></td>";
	}
        echo "<!-- closed: " . $redis->close() . ". --> \n"; 
?>


<!--form-->
<form method = "get" action = "">
        <label for = "coval">Add a Comment: </label><br>
        <input type = "text" id = "coval" name = "coval"><br>
	<input type = "hidden" id = "subjid" name = "subjid"><br>
        <input type = "submit" value = "submit" name = "submit">
</form>
</body>
</html>
