    <?php
    //file: connect.php
    error_reporting( E_ALL );

    // https://phpredis.github.io/phpredis/Redis.html
    $me = 'bettyrubble';     // <-- change to your username
    $studyid = 12700;

    //connect to redis server on localhost
    $redis = new Redis();
    $redis->connect( 'localhost' );
    echo "<!-- connected. --> \n";

    $redis->auth( [$me, '754579'] );  // <-- change to your password
    echo "<!-- logged in. --> \n";

    //check whether server is running or not
    echo "<!-- server is running: " . $redis->ping() . ". --> \n";
?>
