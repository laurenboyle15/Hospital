<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> redis and php - Add a comment </title>
</head>

<body>
<h3> Add a Comment </h3>
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
	$lstcom = $sub['last_coseq'];


   	// process form
   	if(isset($_GET["coval"])) {
		
		$lst_coseq = $redis->hIncrBy(	"$me:DM:$studyid:$id",
						'last_coseq', 1 );	
       		$now = new DateTime(date("Y-m-d H:i:s"));
	        $co = array(
                	'codtc'       => $now->format( DateTime::ATOM ),  # ISO8601 format
                	'coval'       => $_GET["coval"]
	        );
//		echo $id;
		$usubjid = $id;
        	$key = "$me:CO:$studyid:$id:$lst_coseq";
        	$redis->hMset($key,$co);
        
        	$com = $redis->hGetAll($key);
        	echo "<pre> \n";
        	echo "you entered a new comment \n";
		echo "id = : " . $id . "\n";
		echo "last_coseq = : " . $lst_coseq . "\n";	
        	echo "date = " . $com['codtc'] ." \n";
        	echo "comment  = " . $com['coval'] ." \n";
       		echo "</pre> \n";
	}
    }     
//    echo "inserting new usubjid = $usubjid <br/> \n";

    echo "<!-- closed: " . $redis->close() . ". --> \n";
?>


<!--form-->
<form method = "get" action = "">
        <label for = "coval"> Comment: </label><br>
       	<input type = "hidden" id = "usubjid" name = "usubjid"><br>
	<input type = "hidden" id = "lst_coseq" name = "lst_coseq"><br>
	<input type = "text" id = "coval" name = "coval"><br>
        <input type = "submit" value = "submit" name = "submit">
</form>
<!--<a style = text-decoration:none; href=\"addComment198624.php?usubjid=" . $id . "\">Click to Add Comment</a></td>"; -->

<a style = text-decoration:none; href= "comment453377.php?usubjid= . $id .">Click to see comment</button>
</body>
</html>
