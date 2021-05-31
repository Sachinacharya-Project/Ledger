<?php
    session_start();
    require './database.php';
    $username = $_SESSION['username'];
    if(isset($_POST['queryType'])){
        $queryType = $_POST['queryType'];
        if($queryType == 'product_and_units'){
            // Display all the product and units
            $query = mysqli_query($conn, "SELECT * FROM `products` WHERE `username`='$username'");
            $output = [];
            $i = 0;
            if(mysqli_num_rows($query) > 0){
                while($rows = mysqli_fetch_assoc($query)){
                    $output[$i]['name'] = $rows['name'];
                    $output[$i]['unit'] = $rows['unit'];
                    $i++;
                }
            }
            header("Content-Type: application/json");
            echo json_encode([$output]);
        }elseif($queryType == 'adding_products'){
            // Add/Update Product to database
            $datas = $_POST['datas'];
            foreach($datas as $data){
                // ['Name', 'Unit', 'Quantity']
                $productName = $data[0];
                $unit = $data[1];
                $quantity = $data[2];
                $query = mysqli_query($conn, "SELECT * FROM `products` WHERE `name`='$productName' AND `username`='$username'");
                if(mysqli_num_rows($query) > 0){
                    $row = mysqli_fetch_assoc($query);
                    $previousQuantity = $row['quantity'];
                    $newQuantity = $quantity + $previousQuantity;
                    mysqli_query($conn, "UPDATE `products` SET `quantity`='$newQuantity' WHERE `name`='$productName' AND `username`='$username'");
                }else{
                    mysqli_query($conn, "INSERT INTO `products`(`username`, `name`, `quantity`, `unit`) VALUES('$username', '$productName', '$quantity','$unit')");
                }
            }
        }elseif($queryType == 'showing_prod'){
            $data_list = [];
            $i = 0;
            $query = mysqli_query($conn, "SELECT * FROM `products` WHERE `username`='$username'");
            if(mysqli_num_rows($query) > 0){
                while($rows = mysqli_fetch_assoc($query)){
                    $data_list[$i]['name'] = $rows['name'];
                    $data_list[$i]['quantity'] = $rows['quantity'];
                    $data_list[$i]['unit'] = $rows['unit'];
                    $status = 'Enough';
                    $quantity = $rows['quantity'];
                    if($quantity < 10 && $quantity > 0){
                        $status = 'Almost Out';
                    }elseif($quantity <= 0){
                        $status = 'Out Of Stock';
                    }
                    $data_list[$i]['status'] = $status;
                    $i++;
                }
            }
            header("Content-Type: application/json");
            echo json_encode($data_list);
        }elseif($queryType == 'add_to_purchase'){
            $refno = uniqid();
            $data = $_POST['data'];
            // Checking and updating customer in
            $shopname = $data['shopname'];
            $shopaddr = $data['address'];
            $shopPh = $data['phone'];
            $regd = $data['regd'];
            $totalvalue = $data['total'];
            $customer_query = mysqli_query($conn, "SELECT * FROM `customers` WHERE `name`='$shopname' AND `username`='$username'");
            if(mysqli_num_rows($customer_query) == 0){
                mysqli_query($conn, "INSERT INTO `customers`(`name`, `address`, `phone`, `regd`, `username`) VALUES('$shopname', '$shopaddr', '$shopPh', '$regd', '$username')");
            }
            // Adding to Purchase list
            $productList = $data['data'];
            foreach($productList as $prod){
                // Managing Quantity of Product
                $prodname = $prod[0];
                $prodquantity = $prod[1];
                $prodrate = $prod[2];
                $produnit = $prod[3];
                $prodtotal = $prod[4];
                $prodQuery = mysqli_query($conn, "SELECT * FROM `products` WHERE `name`='$prodname' AND `username`='$username'");
                if(mysqli_num_rows($query) > 0){
                    $row = mysqli_fetch_assoc();
                    $prevQuantity = $row['quantity'];
                    $newQuantity = $prevQuantity + $prodquantity;
                    mysqli_query($conn, "UPDATE `products` SET `quantity`='$newQuantity' WHERE `name`='$prodname' AND `username`='$username'");
                }else{
                    mysqli_query($conn, "INSERT INTO `products`(`username`, `name`, `quantity`, `unit`) VALUES('$username', '$prodname', '$prodquantity', '$produnit')");
                }
                // Finally Adding all of this instruction to purchases table
            }
        }
    }
?>