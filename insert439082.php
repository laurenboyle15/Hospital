<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
 <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title> redis and php - insert into DM, CO, and SV </title>
</head>

<body>
<h3> performing insert ... </h3>
<?php
    // https://phpredis.github.io/phpredis/Redis.html#method_scan
    require 'connect.php';
    //insert a new subject into DM (via an assoc array)
    $dob = new DateTime( '2010-12-30 23:21:46' );
    $dm = array(
        'brthdtc'           => $dob->format( DateTime::ATOM ),  # ISO8601 format
        'sex'                   => 'f',
        'race'                 => 'caucasian',
        'country'           => 'usa',
        'last_visitnum' => 0,
        'last_coseq'      => 0
    );
    $usubjid = $redis->incr( "$me:$studyid:last_usubjid" );
    echo "inserting new usubjid = $usubjid <br/> \n";
    $key = "$me:DM:$studyid:$usubjid";
    $redis->hMset( $key, $dm );
    //insert a new comment (CO) for the above subject
    $last_coseq = $redis->hIncrBy( "$me:DM:$studyid:$usubjid",
                                   'last_coseq', 1 );
    $now = new DateTime( date("Y-m-d H:i:s") );
    $co = array(
        'codtc' => $now->format( DateTime::ATOM ),  # ISO8601 format
        'coval' => 'this is my first comment'
    );
    $key = "$me:CO:$studyid:$usubjid:$last_coseq";
    $redis->hMset( $key, $co );
    //insert another new comment (CO) for the above subject
    $last_coseq = $redis->hIncrBy( "$me:DM:$studyid:$usubjid",
                                   'last_coseq', 1 );
    $now = new DateTime( date("Y-m-d H:i:s") );
    $co = array(
        'codtc' => $now->format( DateTime::ATOM ),  # ISO8601 format
        'coval' => 'this is my second comment'
    );
    $key = "$me:CO:$studyid:$usubjid:$last_coseq";
    $redis->hMset( $key, $co );
    for ($i=1; $i<=3; $i++) {
        //insert a new subject visit (SV) for the above subject
        $last_visitnum = $redis->hIncrBy( "$me:DM:$studyid:$usubjid",
                                          'last_visitnum', 1 );
        $start = new DateTime( date("Y-m-d H:i:s") );
        $end   = new DateTime( date("Y-m-d H:i:s") );
        $sv = array(
            'svstdtc'  => $start->format( DateTime::ATOM ),   # ISO8601 format
            'svendtc' => $end->format( DateTime::ATOM ),    # ISO8601 format
            'visit'        => "this is a visit comment $i"
        );
        $key = "$me:SV:$studyid:$usubjid:$last_visitnum";
        $redis->hMset( $key, $sv );
    }

    echo "<!-- closed: " . $redis->close() . ". --> \n";
?>
<h3> insert done </h3>
</body>
</html>
