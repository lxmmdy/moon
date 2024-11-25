<?php
session_start();
date_default_timezone_set("Asia/Kuala_Lumpur");
include 'dbcon.php';

$error = ""; 
$success = ""; 
$successMessage = "";
$errorMessage = "";

// Get User ID
if (isset($_SESSION['emas_user_id'])) {
    $userId = $_SESSION['emas_user_id'];
} elseif (isset($_GET['id'])) {
    $userId = $_GET['id'];
} else {
    echo "Error: User ID not provided.";
    exit;
}

// Handle File Upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['laporan_file'])) {
    $targetDir = "files/";
    if (!is_dir($targetDir)) {
        if (!mkdir($targetDir, 0777, true) && !is_dir($targetDir)) {
            $error .= "Failed to create directory: $targetDir. Error: " . error_get_last()['message'] . "<br>";
        }        
    }

    if ($_FILES['laporan_file']['error'] == UPLOAD_ERR_OK) {
        $fileName = $_FILES["laporan_file"]["name"];
        $fileTmpPath = $_FILES["laporan_file"]["tmp_name"];
        $fileType = mime_content_type($fileTmpPath);

        if ($fileType === 'application/pdf') {
            $newFileName = uniqid('laporan_', true) . '.pdf';
            $fileTargetPath = $targetDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $fileTargetPath)) {
                $emas_report_file = $fileTargetPath;
                $sql = "INSERT INTO emas_report (emas_report_user, emas_report_time, emas_report_file) 
                        VALUES ('$userId', NOW(), '$emas_report_file')";

                if (mysqli_query($conn, $sql)) {
                    $success = "Laporan successfully uploaded!";
                } else {
                    $error = "Database error: " . mysqli_error($conn);
                }
            } else {
                $error .= "Error uploading file: $fileName<br>";
            }
        } else {
            $error .= "Invalid file type. Only PDF files are allowed.<br>";
        }
    } else {
        $error .= "No file uploaded or upload error.<br>";
    }
}

// Handle Status Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['report_id']) && isset($_POST['status'])) {
    $reportId = $_POST['report_id'];
    $newStatus = $_POST['status'];
    $sql = "UPDATE emas_report SET emas_report_status = '$newStatus' WHERE emas_report_id = '$reportId'";

    if (mysqli_query($conn, $sql)) {
        $successMessage = "Status updated successfully!";
    } else {
        $errorMessage = "Error updating status: " . mysqli_error($conn);
    }
}

// Fetch Report Records
// Fetch Report Records - Only show reports for the current user
$sql = "SELECT * FROM emas_report WHERE emas_report_user = '$userId' ORDER BY emas_report_time DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload & Manage Laporan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #2e3b4e, #2c5364);
            min-height: 100vh;
            color: #f3f3f3;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }

        .upload-container, .report-table {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .upload-container:hover, .report-table:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.5);
        }

        h2 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 20px;
            color: #f3f3f3;
        }

        .btn-upload {
            background: linear-gradient(90deg, #ff6f61, #ff9153);
            color: #fff;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 30px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }

        .btn-upload:hover {
            background: linear-gradient(90deg, #ff9153, #ff6f61);
            box-shadow: 0 4px 15px rgba(255, 110, 80, 0.5);
        }

        .table {
            margin-top: 20px;
        }

        .table th, .table td {
            text-align: center;
            vertical-align: middle;
            color: #f3f3f3;
        }

        .table thead {
            background: linear-gradient(90deg, #4facfe, #00f2fe);
        }

        .table tbody tr {
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .alert {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            text-align: center;
            border: none;
            margin-top: 15px;
            padding: 10px;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            h2 {
                font-size: 24px;
            }

            .btn-upload {
                font-size: 14px;
            }

            .table th, .table td {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Upload Section -->
    <div class="upload-container p-4 shadow-sm rounded">
        <h2 class="text-center mb-4 text-primary">Upload Laporan PDF</h2>

        <?php if ($success): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $success; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="mb-4">
                <label for="laporan_file" class="form-label fw-semibold">Select PDF File:</label>
                <input type="file" class="form-control form-control-lg" name="laporan_file" id="laporan_file" accept=".pdf" required>
                <div class="invalid-feedback">
                    Please select a PDF file.
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg w-100">Upload Laporan</button>
        </form>
    </div>

    <!-- Report Table Section -->
    <div class="report-table">
        <h2>Laporan PDF</h2>

        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?php echo $successMessage; ?></div>
        <?php elseif ($errorMessage): ?>
            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>User ID</th>
                    <th>Upload Time</th>
                    <th>File</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $counter = 1;
                while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo htmlspecialchars($row['emas_report_user']); ?></td>
                        <td><?php echo htmlspecialchars($row['emas_report_time']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($row['emas_report_file']); ?>" target="_blank" class="btn btn-outline-primary btn-sm">View PDF</a></td>
                        <td><?php echo htmlspecialchars($row['emas_report_status']); ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No reports available.</div>
        <?php endif; ?>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>