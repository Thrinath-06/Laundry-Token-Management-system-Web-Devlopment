<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet"/>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <title>Welcome -
        <?php $_SESSION['username'] ?>
    </title>
</head>

<body style="background-color: #e7f1f126; background-image: url('8.jpg');">
    <?php require 'partials/_nav_welcome_admin.php' ?>

    
    <div class="container my-3">
    <div class="alert alert-info" role="alert">
            <h1  class="alert-heading title text-center">G3 Data
    
            </h1>
            
        </div>
    </div>

    <?php
    include 'partials/_dbconnect.php';
    $username = $_SESSION['username'];


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
        $hostel="G3";
        $sql = "SELECT * FROM items where Hostel='$hostel'";
        $result = $conn->query($sql);
        ?>
        
            <?php
        if ($result->num_rows > 0) {
        ?>
            <div class="container my-4">
        
            <table class="table table-bordered table-striped table-hover">
            <thead>
                    <tr>
                        <th class="text-center">Username</th><th class="text-center">Date</th><th class="text-center">Time</th><th class="text-center">Shirt</th>
                        <th class="text-center">T-Shirt</th><th class="text-center">Pant</th><th class="text-center">Jeans</th>
                        <th class="text-center">Shorts</th><th class="text-center">Pyjama</th><th class="text-center">Bed Sheet</th>
                        <th class="text-center">Pillow Cover</th><th class="text-center">Towel</th><th class="text-center">Total</th>
                    </tr>
            </thead>
            <tbody>
            <?php
            while($row = $result->fetch_assoc()) {
            ?>      
            <tr>
                <td class='text-center'><?= $row["username"] ?></td><td class='text-center'><?= $row["dt"] ?></td><td class='text-center'><?= $row["time"] ?></td><td class='text-center'><?= $row["Shirt"] ?></td>
                <td class='text-center'><?= $row["T_Shirt"] ?></td><td class='text-center'><?= $row["Pant"] ?></td><td class='text-center'><?= $row["Jeans"] ?></td>
                <td class='text-center'><?= $row["Shorts"] ?></td><td class='text-center'><?= $row["Pyjama"] ?></td><td class='text-center'><?= $row["Bed_Sheet"] ?></td>
                <td class='text-center'><?= $row["Pillow_Cover"] ?></td><td class='text-center'><?= $row["Towel"] ?></td><td class='text-center'><?= $row["Total"] ?></td>
            </tr>
            <?php } ?>
            </tbody>
            
            </table>        
            </div>

    <?php
    }else{
    ?>
        <div class="container my-3">
        <div class="alert alert-danger" role="alert">
            <h4  class="alert-heading title text-center">No Entry
    
            </h4>
            
        </div>
        </div>
    <?php }
    ?>
    
    <script type="text/javascript">
        $(document).ready(function () {
            $('table').DataTable({
                paging:true
            })
        });
    </script>

</body>

</html>