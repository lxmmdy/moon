<?php
session_start();
require_once 'dbcon.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emas_user_id = mysqli_real_escape_string($conn, $_POST['emas_user_id']);
    $emas_user_pass = mysqli_real_escape_string($conn, $_POST['emas_user_pass']);

    $sql = "SELECT * FROM emas_user WHERE emas_user_id = '$emas_user_id' AND emas_user_pass = '$emas_user_pass'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['emas_user_id'] = $emas_user_id;
        header("Location: report.php");
        exit();
    } else {
        $error_message = "Invalid User ID or Password";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #141E30, #243B55);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: fadeIn 0.8s ease-in-out;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #141E30;
            font-weight: 600;
        }

        .form-control {
            border-radius: 30px;
            padding: 12px 20px;
            box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: linear-gradient(to right, #6A82FB, #FC5C7D);
            border: none;
            color: white;
            font-weight: bold;
            padding: 12px;
            border-radius: 30px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(252, 92, 125, 0.4);
        }

        .alert {
            margin-top: 15px;
        }

        .form-label {
            font-weight: 600;
            color: #555;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10%);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>User Login</h2>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $error_message; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="emas_user_id" class="form-label">User ID:</label>
            <input type="text" class="form-control" id="emas_user_id" name="emas_user_id" placeholder="Enter your User ID" required>
        </div>
        <div class="form-group">
            <label for="emas_user_pass" class="form-label">Password:</label>
            <input type="password" class="form-control" id="emas_user_pass" name="emas_user_pass" placeholder="Enter your Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
