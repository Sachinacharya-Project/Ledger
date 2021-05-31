<?php
    session_start();
    require './database.php';
    if(isset($_POST['asking'])){
        $asking = $_POST['asking'];
        if($asking == 'loggedIname'){
            $username = $_SESSION['username'];
            $query = mysqli_query($conn, "SELECT `fullname`, `shopname` FROM `usercollection` WHERE `username`='$username'");
            if(mysqli_num_rows($query) > 0){
                $rows = mysqli_fetch_array($query);
                $name = $rows[0];
                $shopname = $rows[1]; 
                echo "$name ($shopname)";
            }else{
                echo "Guest";
            }
        }
    }
?>