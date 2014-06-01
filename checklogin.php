<?php
    $host="localhost"; 
    $user="ayoub";      
    $passwd="secret";      
    $db="pi"; 

    $dbconn = pg_connect("host=$host dbname=$db user=$user password=$passwd")
    or die('Could not connect: ' . pg_last_error());

    $username = pg_escape_string(utf8_encode($_POST['username']));
    $password = pg_escape_string(utf8_encode($_POST['password']));


    $query = "SELECT * FROM active_user WHERE active_email = '$username' and passwd='$password'";  
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    $count = pg_num_rows($result);

    $query_suspended = "SELECT * FROM suspended_user WHERE suspended_email = '$username' and passwd='$password'"; 
    $result_sus = pg_query($query_suspended) or die('Query failed: ' . pg_last_error());
    $count_suspended = pg_num_rows($result_sus);

   

    if($count == 1) {
        $query_access = "INSERT INTO access VALUES(date_trunc('second', current_timestamp), '$username')";
        $result = pg_query($query_access) or die('Query failed: ' . pg_last_error());
        shell_exec("nodejs /home/ayoub/PiTank/app.js");
    }
    else if($count_suspended == 1){
        echo '<script language=javascript>document.location.href="suspended.html"</script>';
    }
    else {
        echo '<script language=javascript>document.location.href="index.html"</script>';
    }
?>
<html>
    <head>
        <title>Loading</title>
        <link rel="stylesheet" type="text/css" href="css/demo.css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <script type="text/javascript"> 
            function sleep(milliseconds) {
                var start = new Date().getTime();
                for(var i = 0; i < 1e7; i++) {
                    if((new Date().getTime() - start) > milliseconds){
                        break;
                    }
                }
            }
        </script>
    </head>
    <body>
        <div class="container">
            <header>
                <h1> Loading the node.js server, <span> please wait... </span></h1>
            </header>
            <script type="text/javascript">
                setTimeout('Redirect()',5000);
                function Redirect() {
                    location.href = 'http://localhost:3000';
                }
            </script>
        </div>
    </body>
</html>

