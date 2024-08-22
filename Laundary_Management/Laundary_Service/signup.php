<?php
$showAlert = false;
$showError = false;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'partials/_dbconnect.php';
    $username = $_POST["username"];
    $email = $_POST["email"];
    $hostel = $_POST["Hostel"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    
    // $exist = false;
    $existSql = "SELECT * FROM `users` WHERE username = '$username'";
    $result = mysqli_query($conn, $existSql);
    $numExitRows = mysqli_num_rows($result);
    if ($numExitRows > 0) {
        // $exist = true;
        $showError = "Username already exist";
    } else {
        // $exist = false;


        if (($password == $cpassword)) {

            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`username`,`email`,`Hostel` ,`password`, `dt`) VALUES ( '$username','$email','$hostel', '$hash', current_timestamp())";
            $result = mysqli_query($conn, $sql);



            $sql = "SELECT username FROM users WHERE username = '" . $username . "'";
            $result = mysqli_query($conn, $sql);


            $user_db_name = "user_" . $username; // Prefix the database name with "user_" to make it easy to identify
            $sql = "CREATE DATABASE " . $user_db_name;
            if (mysqli_query($conn, $sql)) {
                $showAlert = true;
                // echo "Database created successfully";
            } else {
                $showError = "Error in creating user database";
                // echo "Error creating database: " . mysqli_error($conn);
            }

            // Switch to the user's database
            mysqli_select_db($conn, $user_db_name);

            $sql = "CREATE TABLE users (`username` VARCHAR(255) NOT NULL , `dt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,`Hostel` VARCHAR(255) NOT NULL ,
             `Shirt` INT NOT NULL , `T_Shirt` INT NOT NULL , `Pant` INT NOT NULL , `Jeans` INT NOT NULL , `Shorts` INT NOT NULL , `Pyjama` INT NOT NULL ,
              `Bed_Sheet` INT NOT NULL , `Pillow_Cover` INT NOT NULL , `Towel` INT NOT NULL , `Total` INT NOT NULL ) ENGINE = InnoDB;";
         
            if (mysqli_query($conn, $sql)) {
                $showAlert = true;
                // echo "Table created successfully";
            } else {
                $showError = "Error in creating user database";
                // echo "Error creating table: " . mysqli_error($conn);
            }

            
            $sql = "INSERT INTO users (`username`,`Hostel`) VALUES ('" . $username . "','" .$hostel ."')";
            if (mysqli_query($conn, $sql)) {
                $showAlert = true;
                // echo "User created successfully";
            } else {
                $showError = "Error in creating user database";
                // echo "Error creating user: " . mysqli_error($conn);
            }

            mysqli_close($conn);






            
            if ($result) {
                $showAlert = true;
            }
        } else {

            $showError = "Password do not match";
        }
    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body style="background-image: url('laundary_background1.jpg');">

    <?php

    require 'partials/_nav.php'

        ?>
    <?php

    if ($showAlert) {
        echo '
        <div class="alert alert-success  alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your Account is now created and you can login
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if ($showError) {
        echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>ERROR!</strong>' . $showError . ' 
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    ?>
    <div class="container my-4" style="right:0px;left:50px;top:120px;">
        <div class="form1-box">
            <h1 class="text-center" style="margin-bottom: 15px;  margin-top:10px ">Signup</h1> 
            <form action="/login/signup.php" method="post" style=" padding: 0px 8px;">
                <div class="mb-3 ">
                    <label for="username" class="form-label" style="font-family:verdana;">Username</label>
                    <input type="text" maxLength="11" class="form-control" id="username" name="username"
                        aria-describedby="emailHelp" required>

                </div>
            
                <div class="mb-3 ">
                    <label for="email" class="form-label" style="font-family:verdana;">Email</label>
                    <input type="email" maxLength="31" class="form-control" id="email" name="email"
                        aria-describedby="emailHelp" required>

                </div>

                <div class="mb-3 ">
                    <label for="hostel" class="form-label hostel" style="font-family:verdana;">Hostel</label>
                    <select class="form-select hostel" name="Hostel" required>
                    <option value="">Select Your Hostel</option>
                    <option value="G1">G1</option>
                    <option value="G2">G2</option>
                    <option value="G3">G3</option>
                    <option value="G5">G5</option>
                    <option value="G6">G6</option>
                    <option value="B1">B1</option>
                    <option value="B3">B3</option>
                    <option value="B5">B5</option>
                    <option value="I2">I2</option>
                    <option value="I4">I4</option>
                    </select>

                </div>

                <div class="mb-3 ">
                    <label for="password" class="form-label" style="font-family:verdana;">Password</label>
                    <input type="password" maxLength="23" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3 ">
                    <label for="cpassword" class="form-label" style="font-family:verdana;">Confirm Password</label>
                    <input type="password" class="form-control" id="cpassword" name="cpassword" required>
                    <div id="emailHelp" class="form-text">Make sure to type same password</div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Sign up</button>
                </div>
            </form>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>

</html>
</body>

</html>