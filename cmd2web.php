<?php
//file:cmd2web.php
//parse command line options (if any). (similar to post.)
//ex. form.php message=12 submit=submit start=0
function parseNameEqualValue ( ) {
    global $argv, $_SERVER, $_GET, $_POST;
    if (isset($_SERVER["HTTP_HOST"]))    return;
    if (!isset($argv[1]))                return;

    $_POST[ "submit" ] = 1;
    $_GET[  "submit" ] = 1;
    $i = -1;
    foreach ($argv as $a) {
        $i++;
        if ($i == 0)    continue;
        list( $name, $val ) = explode( "=", $a );
        echo( "<!-- $i: $a --> \n" );
        echo( "<!-- $i: $a $name $val --> \n" );
        $_POST[ $name ] = $val;
        $_GET[  $name ] = $val;
    }
}
?>
