<?php
session_start();
$showAlert = false;
$showError = false;
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}
else{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        include 'partials/_dbconnect.php';
        $username = $_SESSION['username'];

        // Retrieve the Hostel value for the particular user
        $username = $_SESSION['username'];
        $sql = "SELECT Hostel FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Output data of the first (and only) row
            $row = $result->fetch_assoc();
            $hostel = $row["Hostel"];
        } else {
            echo "0 results";
        }

        $Shirt = $_POST["Shirt"];
        $T_Shirt = $_POST["T_Shirt"];
        $Pant = $_POST["Pant"];
        $Jeans = $_POST["Jeans"];
        $Shorts = $_POST["Shorts"];
        $Pyjama = $_POST["Pyjama"];
        $Bed_Sheet = $_POST["Bed_Sheet"];
        $Pillow_Cover = $_POST["Pillow_Cover"];
        $Towel = $_POST["Towel"];
        $Total = $Shirt + $T_Shirt + $Pant + $Jeans + $Shorts + $Pyjama + $Bed_Sheet + $Pillow_Cover + $Towel;
       
        if($Total>0 && $Total <=10){
            $sql = "INSERT INTO `items` (`username`,`Hostel`,`dt`,`Shirt`, `T_Shirt`, `Pant`, `Jeans`, `Shorts`, `Pyjama`, `Bed_Sheet`, `Pillow_Cover`, `Towel` , `Total`) 
            VALUES ('$username','$hostel',current_timestamp(),'$Shirt', '$T_Shirt', '$Pant',
            '$Jeans', '$Shorts', '$Pyjama', '$Bed_Sheet', '$Pillow_Cover', '$Towel', '$Total')";
            $result = mysqli_query($conn, $sql);


            $user_db_name = "user_" . $username; 
            mysqli_select_db($conn, $user_db_name);


            $sql = "INSERT INTO  users  (`username`,`dt`,`Hostel`,`Shirt`, `T_Shirt`, `Pant`, `Jeans`, `Shorts`, `Pyjama`, `Bed_Sheet`, `Pillow_Cover`, `Towel` , `Total`) 
            VALUES ('$username',current_timestamp(),'$hostel','$Shirt', '$T_Shirt', '$Pant',
            '$Jeans', '$Shorts', '$Pyjama', '$Bed_Sheet', '$Pillow_Cover', '$Towel', '$Total')";

           $result = mysqli_query($conn, $sql);
           if ($result) {
               $showAlert = true;
               
           }
        }
        else if($Total <=0){
            $showError = "Please add at least 1 item";
        }
        else{
            $showError = "You can add maximum 10 items";
        }
        
    }
}

?>
<!doctype html>
<html lang="en" >

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Welcome -
        <?php $_SESSION['username'] ?>
    </title>
    
</head>


<body style="background-color: #c8d9f3b0;  background-image: url('1.jpg');">
    <?php
    if($_SESSION['username'] == "admin"){
    
        require 'partials/_nav_welcome_admin.php';
    ?>
        <div class="container my-3">
        <div class="alert alert-info" role="alert">
            <h3 class="alert-heading">Welcome -
                <?php echo $_SESSION['username'] ?>
            </h3>
            <p>Hey how are you doing? Welcome to Laundary Service. You are logged in as
                <?php echo $_SESSION['username'] ?>.You can see laundary items of different hostels below.
            </p>
            <hr>
            <p class="mb-0">Whenever you need to, be sure to logout <a href="/login/logout.php"> using this link.</a>
            </p>
        </div>
    </div>

    <?php }else{
        require 'partials/_nav_welcome.php';
    ?>
        <div class="container my-3">
        <div class="alert alert-info" role="alert">
            <h3 class="alert-heading">Welcome -
                <?php echo $_SESSION['username'] ?>
            </h3>
            <p>Hey how are you doing? Welcome to Laundary Service. You are logged in as
                <?php echo $_SESSION['username'] ?>.You can add your laundary items below.
            </p>
            <hr>
            <p class="mb-0">Whenever you need to, be sure to logout <a href="/login/logout.php"> using this link.</a>
            </p>
        </div>
    </div>
    <div class="container my-3">
        <div class="alert alert-warning" role="alert">
            <h5 style="font-weight:normal">You can add maximum 10 items.</h5>
            
        </div>
    </div>
    <?php
    }
    ?>

    
    <?php

    if ($showAlert) {
        
        echo '
        <div class="container my-3">
        <div class="alert alert-success  alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your items are submitted successfully
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        </div>';
        
    }
    
    if ($showError) {
        
        echo '
        <div class="container my-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>ERROR!  </strong>' . $showError . ' 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        </div>';
        
    }
    ?>

    <?php
        include 'partials/_dbconnect.php';
        $username = $_SESSION['username'];
    ?>

    <?php
    if($username == "admin"){
    ?>
        
            
        <div class="container my-3">
        <div class="form1-box">
        <div class="text-center ">
        <a style="text-decoration: none; color: #324aac;" class = "menu" href="G1.php"><div class="form2-box"><h1 >G1</h1></div></a>
        <a style="text-decoration: none; color: #324aac;" class = "menu" href="G2.php"><div class="form2-box"><h1 >G2</h1></div></a>
        <a style="text-decoration: none; color: #324aac;" class = "menu" href="G3.php"><div class="form2-box"><h1 >G3</h1></div></a>
        </div>
        <div class="text-center">
        <a style="text-decoration: none; color: #324aac;" class = "menu" href="G5.php"><div class="form2-box"><h1 >G5</h1></div></a>
        <a style="text-decoration: none; color: #324aac;" class = "menu" href="G6.php"><div class="form2-box"><h1 >G6</h1></div></a>
        <a style="text-decoration: none; color: #324aac;" class = "menu" href="B1.php"><div class="form2-box"><h1 >B1</h1></div></a>
        </div>
        <div class=" text-center">
        <a style="text-decoration: none; color: #324aac;" class = "menu" href="B3.php"><div class="form2-box"><h1 >B3</h1></div></a>
        <a style="text-decoration: none; color: #324aac;" class = "menu" href="B5.php"><div class="form2-box"><h1 >B5</h1></div></a>
        <a style="text-decoration: none; color: #324aac;" class = "menu" href="I2.php"><div class="form2-box"><h1 >I2</h1></div></a>
        </div>
            
        </div>
        
    <?php
    }else{
    ?>
        <div class="container my-4">
        <form action="/login/welcom.php " method="post" onsubmit="return confirm('Do you really want to submit the Laundary items??');">
        <div class="form-box">
        <div class="row ">
            <div class="col-md-4 text-center">
                <div class="mb-4" style="width: 40%; margin-left:120px; margin-top: 20px;">
                    <label for="Shirt" class="form-label" style="font-size:20px;font-weight: 500;">Shirt</label>
                    <input type="number" min = "0" max = "10"  value = "0" onkeyup="if(value<0) value=0;else if(value>10) value=0" class="form-control text-center shirt-input" id="Shirt" name="Shirt"
                        aria-describedby="emailHelp" >
                </div>
                <div class="mb-4" style="width: 40%; margin-left:120px;">
                    <label for="T_Shirt" class="form-label" style="font-size:20px;font-weight: 500;">T-Shirt</label>
                    <input type="number" min = "0" max = "10"  value = "0" onkeyup="if(value<0) value=0;else if(value>10) value=0" class="form-control text-center" id="T_Shirt" name="T_Shirt"
                        aria-describedby="emailHelp" >
                </div>
                <div class="mb-4" style="width: 40%; margin-left:120px;">
                    <label for="Pant" class="form-label" style="font-size:20px;font-weight: 500;">Pant</label>
                    <input type="number" min = "0" max = "10" value = "0" onkeyup="if(value<0) value=0;else if(value>10) value=0" class="form-control text-center" id="Pant" name="Pant"
                        aria-describedby="emailHelp" >
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="mb-4" style="width: 40%; margin-left:90px; margin-top: 20px;">
                    <label for="Jeans" class="form-label" style="font-size:20px;font-weight: 500;">Jeans</label>
                    <input type="number" min = "0" max = "10"  value = "0" onkeyup="if(value<0) value=0;else if(value>10) value=0" class="form-control text-center" id="Jeans" name="Jeans"
                        aria-describedby="emailHelp" >
                </div>
                <div class="mb-4" style="width: 40%; margin-left:90px;"">
                    <label for="Shorts" class="form-label" style="font-size:20px;font-weight: 500;">Shorts</label>
                    <input type="number" min = "0" max = "10"  value = "0" onkeyup="if(value<0) value=0;else if(value>10) value=0" class="form-control text-center" id="Shorts" name="Shorts"
                        aria-describedby="emailHelp">
                </div>
                <div class="mb-4 " style="width: 40%; margin-left:90px;"">
                    <label for="Pyjama" class="form-label" style="font-size:20px;font-weight: 500;">Pyjama</label>
                    <input type="number" min = "0" max = "10"  value = "0" onkeyup="if(value<0) value=0;else if(value>10) value=0" class="form-control text-center" id="Pyjama" name="Pyjama"
                        aria-describedby="emailHelp">
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="mb-4 " style="width: 40%; margin-left:90px; margin-top: 20px;">
                    <label for="Bed_Sheet" class="form-label" style="font-size:20px;font-weight: 500;">Bed Sheet</label>
                    <input type="number" min = "0" max = "10" value = "0" onkeyup="if(value<0) value=0;else if(value>10) value=0" class="form-control text-center" id="Bed_Sheet" name="Bed_Sheet"
                        aria-describedby="emailHelp">
                </div>
                <div class="mb-4 " style="width: 40%; margin-left:90px;"">
                    <label for="Pillow_Cover" class="form-label" style="font-size:20px;font-weight: 500;">Pillow Cover</label>
                    <input type="number" min = "0" max = "10" value = "0" onkeyup="if(value<0) value=0;else if(value>10) value=0" class="form-control text-center" id="Pillow_Cover" name="Pillow_Cover"
                        aria-describedby="emailHelp" >
                </div>
                <div class="mb-4" style="width: 40%; margin-left:90px;"">
                    <label for="Towel" class="form-label" style="font-size:20px;font-weight: 500;">Towel</label>
                    <input type="number" min = "0" max = "10" value = "0" onkeyup="if(value<0) value=0;else if(value>10) value=0"  class="form-control text-center" id="Towel" name="Towel"
                        aria-describedby="emailHelp" >
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary btn-lg " style="width: 100px; height: 45px; font-weight: 400; font-size: 20px; margin-top: 10px;">Submit</button>
        </div>
        </form>
        </div>
    </div>
    <?php
    }
    ?>
    
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
</body>

</html>