<?php
session_start();
date_default_timezone_set("Asia/Kuala_Lumpur");
include 'dbcon.php';

// Handle status update
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

// Fetch the report records
$sql = "SELECT * FROM emas_report ORDER BY emas_report_time DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin View Laporan</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to right, #6a11cb, #2575fc);
        color: #fff;
    }

    .container {
        margin-top: 50px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    }

    h2 {
        font-weight: bold;
        text-transform: uppercase;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        color: #f8f9fa;
        margin-bottom: 30px;
    }

    table {
        border-collapse: separate;
        border-spacing: 0 15px;
    }

    thead tr {
        background: #1a1a1d;
        color: #fff;
    }

    tbody tr {
        background: #fff;
        color: #000;
        transition: transform 0.3s ease-in-out;
    }

    tbody tr:hover {
        transform: scale(1.02);
        box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.2);
    }

    .btn {
        border-radius: 20px;
        transition: all 0.3s ease-in-out;
    }

    .btn:hover {
        transform: scale(1.1);
        box-shadow: 0px 10px 15px rgba(255, 255, 255, 0.2);
    }

    .form-select {
        border-radius: 10px;
        font-weight: bold;
        background: #f8f9fa;
        color: #000;
    }

    .alert {
        font-weight: bold;
        text-align: center;
    }

    .table-wrapper {
        overflow-x: auto;
    }
</style>
</head>
<body>
<div class="container">
    <h2 class="text-center">Admin Dashboard - Laporan PDF</h2>

    <!-- Display success or error messages -->
    <?php if (!empty($successMessage)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $successMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (!empty($errorMessage)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $errorMessage; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Table -->
    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="table-wrapper">
            <table class="table table-borderless text-center align-middle">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>User ID</th>
                        <th>Upload Time</th>
                        <th>File</th>
                        <th>Status</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($result)):
                        $reportId = $row['emas_report_id'];
                        $userId = $row['emas_report_user'];
                        $uploadTime = $row['emas_report_time'];
                        $filePath = $row['emas_report_file'];
                        $status = $row['emas_report_status'];
                    ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo htmlspecialchars($userId); ?></td>
                        <td><?php echo htmlspecialchars($uploadTime); ?></td>
                        <td>
                            <a href="<?php echo htmlspecialchars($filePath); ?>" target="_blank" class="btn btn-outline-light btn-sm" data-bs-toggle="tooltip" title="View PDF">
                                <i class="bi bi-file-earmark-pdf-fill"></i> View PDF
                            </a>
                        </td>
                        <td>
                            <form method="POST">
                                <select class="form-select form-select-sm" name="status">
                                    <option value="DALAM PROSES" <?php if ($status == 'DALAM PROSES') echo 'selected'; ?>>DALAM PROSES</option>
                                    <option value="DITERIMA" <?php if ($status == 'DITERIMA') echo 'selected'; ?>>DITERIMA</option>
                                    <option value="DITOLAK" <?php if ($status == 'DITOLAK') echo 'selected'; ?>>DITOLAK</option>
                                </select>
                        </td>
                        <td>
                            <input type="hidden" name="report_id" value="<?php echo $reportId; ?>">
                            <button type="submit" class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip" title="Update Status">
                                <i class="bi bi-check-circle-fill"></i> Update
                            </button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No reports available.</div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
</body>
</html>
