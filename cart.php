<?php
include("includes/conection/connect.php");
include("functions/common.php");
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amala network Cart Details</title>
    <!-- fontawesome CDN link -->
    <script src="https://kit.fontawesome.com/d9de7fd168.js" crossorigin="anonymous"></script>
    <!-- BOOTSRAP CDN LINK -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- archivo de estilos -->
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container-fluid p-0">
        <header>

            <!-- navigation bar -->
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid ">
                    <a class="navbar-brand logo" href="#"><i>Amala network</i></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="display_all.php">Products</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="http://18.118.154.227/">Free Course</a>
                            </li>
                        </ul>


                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                            <?php
                            if(isset($_SESSION['username'])){
                                echo "<li class='nav-item'>
                                <a class='nav-link' href='./users_area/profile.php'>My Account</a>
                            </li>";  
                            }else{
                                echo "<li class='nav-item'>
                                <a class='nav-link' href='./users_area/user_registration.php'>Register</a>
                            </li>";
                            }
                            ?>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i> <sup>
                                    <?php cart_item(); ?></sup></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- calling cart funtion -->
            <?php cart(); ?>
            <!-- secondary navbar user type -->
            <nav class="navbar navbar-expand-lg subh-bg-color">
                <ul class="navbar-nav ms-auto pe-4">
                    <?php
                    if(!isset($_SESSION['username'])){
                        echo "<li class='nav-item' >
                        <a class='nav-link text-light' href='#'>Welcome Guest</a>
                    </li>";
                    }else{
                        echo "<li class='nav-item'>
                        <a class='nav-link text-light' href='#'>Welcome ".$_SESSION['username']."</a>
                    </li>";
                    }
                        if(!isset($_SESSION['username'])){
                            echo "<li class='nav-item'>
                            <a class='nav-link text-light' href='./users_area/user_login.php'>Login</a>
                        </li>";
                        }else{
                            echo "<li class='nav-item'>
                            <a class='nav-link text-light' href='./users_area/logout.php'>Logout</a>
                        </li>";
                        }
                    ?>
                </ul>
            </nav>

            <!-- Welcome section -->
            <section class="welcome-section p-4">
                <h3 class="text-center">Welcome to Amala</h3>
                <p class="text-center">selling courses is our business</p>

            </section>


            <!-- categories and products section -->

        </header>


        <main class="mb-5 mt-5">
        <!-- fourt chield-table -->
            <div class="container-fluid p-4">
               <div class="row">
                <form action="" method="post" >
                  <table class="table table-bordered text-center">
                    
                        <!-- php code to dysplay dynamic data -->
                        <?php 
                         $get_ip_add = getIPAddress();
                         $total_price=0;
                         $cart_query="Select * from `cart_details` where ip_address='$get_ip_add'";
                         $result=mysqli_query($conn, $cart_query);
                         $result_count=mysqli_num_rows($result);
                         if($result_count>0){
                            echo "<thead>
                            <tr>
                                <th>Product Title</th>
                                <th>Product Image</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>Remove</th>
                                <th colspan='2'>Operations</th>
                            </tr>
                        </thead>
                        <tbody>";
                                                     

                         while($row=mysqli_fetch_array($result)){
                             $product_id=$row['product_id'];
                             $select_products="Select * from `products` where product_id='$product_id'";
                             $result_products=mysqli_query($conn, $select_products);
                             while($row_product_price=mysqli_fetch_array($result_products)){
                                 $product_price=array($row_product_price['product_price']);
                                 $price_table=$row_product_price['product_price'];
                                 $product_title=$row_product_price['product_title'];
                                 $product_image=$row_product_price['product_image'];
                                 $product_values=array_sum($product_price);
                                 $total_price+=$product_values;
                     
                        ?>
                        <tr>
                            <td><?php echo $product_title ?></td>
                            <td><img src="./img/<?php echo $product_image ?>" class="cart_img" alt=""> </td>
                            <td><input type="text" name="qty" id="" class="form-input w-50"></td>
                            <?php 
                            $get_ip_add = getIPAddress();
                            if(isset($_POST['update_cart'])){
                                $quantities=$_POST['qty'];
                                $update_cart="update `cart_details` set quantity=$quantities where ip_address='$get_ip_add'";
                                $result_products_quantity=mysqli_query($conn, $update_cart);
                                $total_price=$total_price*$quantities;
                                
                            }

                            ?>
                            <td>$ <?php echo $price_table ?></td>
                            <td><input type="checkbox" name="removeitem[]" value=<?php echo $product_id ?>></td>
                            <td>
                                <!-- <button class="bg-info px-3 py-2 border-0 mx-1">Update</button> -->
                                <input type="submit" value="Update Cart" class="bg-info px-3 py-2 border-0 mx-1" name="update_cart">
                                <!-- <button class="bg-info px-3 py-2 border-0">Remove</button> -->
                                                <input type="submit" value="Remove Cart" class="bg-info px-3 py-2 border-0 mx-1" name="remove_cart">

                            </td>
                        </tr>
                    </tbody>
                    <?php }} }
                    
                    else{
                        echo "<h2 class='text-center text-danger'>Cart is empty </h2>";
                    }
                    ?>
                  </table>
                  <!-- Subtotal -->
                  <div class="d-flex">
                    <?php 
                    $get_ip_add = getIPAddress();
                    $cart_query="Select * from `cart_details` where ip_address='$get_ip_add'";
                    $result=mysqli_query($conn, $cart_query);
                    $result_count=mysqli_num_rows($result);
                    if($result_count>0){
                        echo "<h4 class='px-4'>Subtotal: <strong class='text-info'>$$total_price</strong></h4>
                        <input type='submit' value='Continue Shoping' class='bg-info px-3 py-2 border-0 mx-1' name='continue_shoping'>
                        <button class='bg-secondary px-3 py-2 border-0 '><a href='./users_area/checkout.php' class='text-light text-decoration-none'>Checkout</a></button>
    ";
                    }else{
                        echo "<input type='submit' value='Continue Shoping' class='bg-info px-3 py-2 border-0 mx-1' name='continue_shoping'>
                        ";
                    }
                    if(isset($_POST['continue_shoping'])){
                        echo "<script>window.open('index.php','_self')</script>";
                    }
                    
                    ?>
                    
                  </div>
               </div>                
            </div>
            </form>
            <!-- function remove items -->
            <?php 
            function remove_cart_item(){
                global $conn;
                if(isset($_POST['remove_cart'])){
                    foreach($_POST['removeitem'] as $remove_id){
                        echo $remove_id;
                        $delete_query="Delete from `cart_details` where product_id=$remove_id";
                        $run_delete=mysqli_query($conn,$delete_query);
                        if($run_delete){
                            echo "<script>window.open('cart.php','_self')</script>";
                        }
                    }
                }
            }
            echo $remove_item=remove_cart_item();
            ?>

        </main>
        <!-- Include footer   -->
        <?php include("./includes\conection/footer.php") ?>
    </div>










    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>