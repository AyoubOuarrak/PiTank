<?php
    $host="localhost"; 
    $user="ayoub";      
    $passwd="ragnarock";      
    $db="pi"; 

    // Connect to server and select databse.
    $dbconn = pg_connect("host=$host dbname=$db user=$user password=$passwd")
    or die('Could not connect: ' . pg_last_error());

    // username and password sent from form
    $username = pg_escape_string(utf8_encode($_POST['username']));
    $password = pg_escape_string(utf8_encode($_POST['password']));


    $query = "SELECT * FROM active_user WHERE active_email = '$username' and passwd='$password'";  
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    // Mysql_num_row is counting table row
    $count = pg_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row

    if($count == 1) {
        // Register $myusername, $mypassword and redirect to file "login_success.php"
        //session_register("username");
        //session_register("password");
        $query_access = "INSERT INTO access VALUES(date_trunc('second', current_timestamp), '$username')";
        $result = pg_query($query_access) or die('Query failed: ' . pg_last_error());

        header("location:http://localhost:3000");
    }
    else {
        echo '<script language=javascript>document.location.href="index.html"</script>';
    }
?>
