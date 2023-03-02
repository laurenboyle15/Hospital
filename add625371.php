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
    
    //process form
	if (isset($_GET["usubjid"])) {
		$dob = new DateTime($_GET["dob"]);
		$dm = array (
			'brthdtc' 	=> $dob->format( DateTime::ATOM ), # ISO8601 format
			'sex'     	=> $_GET['sex'],
			'race'	  	=> $_GET['race'],
			'country' 	=> $_GET['country'],
			'last_visitnum' => $redis->hIncrBy("$me:DM:$studyid:$usubjid", 'last_visitnum', 1),
			'last_coseq'	=> $redis->hIncrBy("$me:DM:$studyid:$usubjid", 'last_coseq', 1)
		);
		$usubjid = $redis->incr("$me:$studyid:last_usubjid");
		$key = "$me:DM:$studyid:$usubjid";
		$redis -> hMset($key, $dm);

		$sub = $redis->hGetAll($key);
		echo "<pre> \n";
		echo "you entered a new subject \n";
		echo "dob = " . $sub['brthdtc'] . " \n";
		echo "sex = " . $sub['sex'] . " \n";
		echo "race = " . $sub['race'] . " \n";
		echo "country = " . $sub['country'] . " \n";
		echo "visitnum = " . $sub['last_visitnum'] . " \n";
		echo "comment  = " . $sub['last_coseq'] . " \n";
		echo "</pre> \n";
	}
	echo "<!-- closed: " . $redis->close() . ".--> \n";
?>	
<!--form-->
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
	<input type = "submit" value = "submit" name = "submit">
</form>

<button onclick = "document.location = 'study762128.php'">Click to see list of all subjects</button>
</body>
</html>
