<?php
    session_start();
    require './database.php';
    if(isset($_POST['service'])){
        $service = $_POST['service'];
        $data = $_POST['data'];
        $username = $data['username'];
        $password = md5($data['password']);
        $firstquery = mysqli_query($conn, "SELECT * FROM `usercollection` WHERE `username`='$username' AND `password`='$password'");
        if(mysqli_num_rows($firstquery) > 0){
            if($service == 'login'){
                $_SESSION['username'] = $username;
                $_SESSION['id'] = mysqli_fetch_array($firstquery)[0];
                $_SESSION['error'] = null;
                echo "success";
            }else{
                $_SESSION['error'] = "
                    Sorry, cannot let you SignedUp
                    Perhaps, reasons are
                        <ol>
                            <li>You have already been signed in</li>
                            <li>Your Credential Matched with existing users</li>
                        </ol>
                ";
                echo "fail";
            }
        }else{
            if($service == 'login'){
                $_SESSION['error'] = "
                    Sorry, cannot let you Signed in
                    Perhaps, reasons are
                        <ol>
                            <li>Typing mistakes of your credential</li>
                            <li>Network Problem</li>
                        </ol>
                ";
                echo "fail";
            }else{
                $email = $data['email'];
                $name = $data['fullname'];
                $shopname = $data['shopname'];
                $regd = $data['regd'];
                $address = $data['address'];
                $phone = $data['phone'];
                mysqli_query($conn, "INSERT INTO `usercollection`(`email`, `fullname`, `username`, `password`, `shopname`, `regd`, `address`, `phone`) VALUES('$email', '$name', '$username', '$password', '$shopname', '$regd', '$address', '$phone')");
                $_SESSION['username'] = $username;
                $secquery = mysqli_query($conn, "SELECT * FROM `usercollection` WHERE `username`='$username' AND `password`='$password'");
                $_SESSION['id'] = mysqli_fetch_array($secquery)[0];
                $_SESSION['error'] = null;
                echo "success";
            }
        }
    }
?>