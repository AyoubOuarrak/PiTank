<?php
    $host="localhost"; 
    $user="ayoub";      
    $passwd="ragnarock";      
    $db="pi"; 

    // Connect to server and select databse.
    $dbconn = pg_connect("host=$host dbname=$db user=$user password=$passwd")
    or die('Could not connect: ' . pg_last_error());

    // username and password sent from form
    $nickname = pg_escape_string(utf8_encode($_POST['usernamesignup']));
    $password = pg_escape_string(utf8_encode($_POST['passwordsignup']));
    $password_confirm = pg_escape_string(utf8_encode($_POST['passwordsignup_confirm']));
    $email = pg_escape_string(utf8_encode($_POST['emailsignup']));

    $query = "INSERT INTO suspended_user(suspended_email, nickname, passwd) VALUES ('$email', '$nickname', '$password')";  
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());

    //header("location:index.html");

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
                <h1> Registration completed successfully, <span> You need to wait until your account is activated </span> </h1>
            </header>
            <script type="text/javascript">
                setTimeout('Redirect()',4000);
                function Redirect() {
                    location.href = 'index.html';
                }
            </script>
        </div>
    </body>
</html>
