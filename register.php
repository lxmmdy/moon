<?php
// Database connection
include 'dbcon.php'; 

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emas_user_id = $_POST['emas_user_id'];
    $emas_user_name = $_POST['emas_user_name'];
    $emas_user_pass = $_POST['emas_user_pass'];
    $emas_user_phone = $_POST['emas_user_phone'];
    $emas_user_course = $_POST['emas_user_course'];



    // Insert query
    $sql = "INSERT INTO emas_user (emas_user_id, emas_user_name, emas_user_pass, emas_user_phone, emas_user_course) 
            VALUES ('$emas_user_id', '$emas_user_name', '$emas_user_pass', '$emas_user_phone', '$emas_user_course')";

    if (mysqli_query($conn, $sql)) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Registration</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>User Registration</h2>
    <form action="register.php" method="POST">
        <div class="form-group">
            <label for="emas_user_id">No Pelajar:</label>
            <input type="text" class="form-control" id="emas_user_id" name="emas_user_id" required>
        </div>
        <div class="form-group">
            <label for="emas_user_name">Nama:</label>
            <input type="text" class="form-control" id="emas_user_name" name="emas_user_name" required>
        </div>
        <div class="form-group">
            <label for="emas_user_pass">Kata Laluan:</label>
            <input type="text" class="form-control" id="emas_user_pass" name="emas_user_pass" required>
        </div>
        <div class="form-group">
            <label for="emas_user_phone">No Telefon:</label>
            <input type="text" class="form-control" id="emas_user_phone" name="emas_user_phone" required>
        </div>
        <div class="form-group">
            <label for="emas_user_course">Kos:</label>
            <input type="text" class="form-control" id="emas_user_course" name="emas_user_course" required>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>
</body>
</html>
