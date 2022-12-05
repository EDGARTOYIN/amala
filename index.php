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
    <title>Amala network</title>
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
                            <li class="nav-item">
                                <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i> <sup>
                                    <?php cart_item(); ?></sup></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Total Price: <?php total_cart_price(); ?></a>
                            </li>
                        </ul>

                        <form class="d-flex" role="search" action="search_product.php" method="get">
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                            <!-- -->
                            <input type="submit" value="Search" class="btn btn-dark" name="search_data_product">
                        </form>
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
                <p class="text-center">Selling courses is our business</p>

            </section>


            <!-- categories and products section -->

        </header>


        <main>
            <div class="container-fluid p-4">
                <section class="row">
                    <!-- Aside categories -->
                    <aside class="col-md-2 categories-container p-0">
                        <!-- popular topics -->
                        <ul class="navbar-nav me-auto text-center">
                            <li class="nav-item text-light bg-dark">
                                <a href="#" class="nav-link">
                                    <h4>Popular topics</h4>
                                </a>
                            </li>

                            <?php
                            //script para insertar topics de la base de datos
                            getTopics();
                            ?>
                        </ul>
                        <!-- categorias list -->
                        <ul class="navbar-nav me-auto text-center">
                            <li class="nav-item text-light bg-dark">
                                <a href="#" class="nav-link">
                                    <h4>Categories</h4>
                                </a>
                            </li>
                            <?php
                            //script para insertar topics de la base de datos
                            getCategory();
                            ?>
                        </ul>

                    </aside>

                    <!-- productos estaticos -->
                    <div class="col-md-10">

                        <div class="row">
                            <?php
                            //script para insertar productos de la base de datos
                            getProducts();
                            getOnlyCategories();
                            getOnlyTopics();
                            $ip = getIPAddress();  
                            // echo 'User Real IP Address - '.$ip;  
                            ?>
                        </div>
                    </div>
                </section>
            </div>
        </main>
        <!-- Include footer   -->
        <?php include("./includes\conection/footer.php") ?>
    </div>










    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>