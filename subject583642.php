<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> redis and php - Details of Study Subject </title>
</head>

<body>
<h3>Subject Details</h3>

<?php
    // https://phpredis.github.io/phpredis/Redis.html#method_scan
    require 'connect.php';
    require 'cmd2web.php';
    parseNameEqualValue();

	$id = $_GET['usubjid'];
	//echo "$id";
	$k = "$me:DM:$studyid:$id";
	//echo "$k";
	if ($redis->exists($k)) {
		$sub = $redis->hGetAll($k);

		echo "<table border='1'>
           	<tr>
            		<th>Subject ID</th>
			<td> $id </td> 
		</tr>
		<tr>
			<th>Birth Date</th>";
			echo "<td>" . $sub['brthdtc'] . "</td>"; 
        	echo "</tr>
		<tr>
			<th>Sex</th>";
			echo "<td>" . $sub['sex'] . "</td>"; 
            	echo "</tr>
		<tr>
			<th>Race</th>";
			echo "<td>" . $sub['race'] . "</td>";
		echo "</tr>
            	<tr>
			<th>Country</th>";
			echo "<td>" . $sub['country'] . "</td>";
            	echo "</tr>
		<tr>
			<th>Last Visit</th>";
			echo "<td>" . $sub['last_visitnum'] . "</td>";
            	echo "</tr>
		<tr>
			<th>Last Coseq</th>";
			echo "<td>" . $sub['last_coseq'] . "</td>"; 
            	echo "</tr>
		<tr>
			<th>Comments</th>";
			echo "<td><a style = text-decoration:none; href=\"comment453377.php?usubjid=" . $id ."\">View Here</a></td>";
		echo "</tr>
		<tr>
                        <th>Subject Visits</th>";
                        echo "<td><a style = text-decoration:none; href=\"visit892749.php?usubjid=" . $id ."\">View Here</a></td>";
                echo "</tr>";
            echo "</table>";

	    if (isset($_POST['delete'])) {
		$subj = $redis->hGetAll($k);
                $last_co = $subj['last_coseq'];
                $last_sv = $subj['last_visitnum'];
                $cokey = "$me:CO:$studyid:$id:$last_co";
                $svkey = "$me:SV:$studyid:$id:$last_sv";
                $redis -> del($k);
                $redis -> del($cokey);
                $redis -> del($svkey);
                echo "subject deleted";
	
	    }
	    
	    if (isset($_GET['update'])) {
		$subj = $redis->hGetAll($k);
		$dob = new DateTime( $_GET["dob"]);
		$dm = array (
			'brthdtc' => $dob ->format( DateTime::ATOM), #ISO8601 format
			'sex' => $_GET["sex"],
			'race'=> $_GET["race"],
			'country' => $_GET["country"],
			'last_visitnum' => $subj['last_visitnum'],
			'last_coseq' => $subj['last_coseq']
		);
		$usubjid = $id;
		$key = "$me:DM:$studyid:$usubjid";
		$redis -> hMset($key,$dm);
		echo "updated subject";
	    }
	}
	echo "<!-- closed: " . $redis->close() . ". --> \n"; 
?>
	<form method = "post">
		<input type = "submit" name = "delete" value = "delete"/>
	</form>

	<form method = "get" action = "">
        	<label for = "dob"> Date of Birth: </label><br>
        	<input type = "datetime" id = "dob" name = "dob"><br>
        	<label for = "sex"> Sex: </label><br>
        	<input type = "radio" id = "m" name = "sex" value ="M">
        	<label for = "male">M</label><br>
        	<input type = "radio" id = "f" name = "sex" value ="F">
        	<label for = "female">F</label><br>
        	<input type = "radio" id = "other" name = "sex" value ="Other">
        	<label for = "Other">Other</label><br>
        	<label for = "Race"> Race: </label><br>
        	<input type = "text" id = "race" name = "race"><br>
        	<label for = "Country"> Country: </label><br>
        	<input type = "text" id = "country" name = "country"><br>
        	<input type = "hidden" id = "usubjid" name = "usubjid"><br>
        	<input type = "hidden" id = "comment" name = "comment"><br>
        	<input type = "hidden" id = "visitNum" name = "visitNum"><br>
        	<input type = "submit" value = "update" name = "update">
	</form>

</body>
</html>
