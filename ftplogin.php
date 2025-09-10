<?php

 $connection = ftp_connect("127.0.0.1");
        $login = ftp_login($connection, "admin", "pass");
        if (!$connection)
            {
             die('FTP Connection attempt failed!');
            }
       
    if (!$login)
            {
             die('Login attempt failed!');
            }
			?>