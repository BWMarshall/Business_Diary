<?php 
        //Connection - Connects to the Databases
        
        //Server Login details
        $servername = "localhost"; 
        $username = "root"; 
        $password = ""; 
        $dbname = "BusinessDiary"; 
        //Tries to log in using Details
        try { 
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password); 
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
            //echo "Connected successfully <br>";  
            } 
        catch(PDOException $e) 
            { 
            //echo "Connection failed: " . $e->getMessage(); 
            } 
    ?>   