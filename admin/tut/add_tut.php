<?php
session_start();
include 'db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_tuition'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $gpay_link = $_POST['gpay_link'];
    $amount = $_POST['amount'];
    $whatsapp_message = $_POST['whatsapp_message'];

    // Handle Image Upload for Tuition Display
    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Upload Image for Display
    $displayImageName = basename($_FILES['display_image']['name']);
    $displayImagePath = $uploadDir . $displayImageName; // Relative path for the database
    $fullDisplayImagePath = __DIR__ . '/' . $displayImagePath; // Full system path for uploading

    if (move_uploaded_file($_FILES['display_image']['tmp_name'], $displayImagePath)) {
        $displayImageUploaded = true;
    } else {
        $displayImageUploaded = false;
    }

    // Handle QR Code Upload
    $qrCodeName = basename($_FILES['qr_code']['name']);
    $qrCodePath = $uploadDir . $qrCodeName; // Relative path for the database
    $fullQrCodePath = __DIR__ . '/' . $qrCodePath; // Full system path for uploading

    if (move_uploaded_file($_FILES['qr_code']['tmp_name'], $qrCodePath)) {
        $qrCodeUploaded = true;
    } else {
        $qrCodeUploaded = false;
    }

    if ($displayImageUploaded && $qrCodeUploaded) {
        // Add tuition to the database
        $query = "INSERT INTO tuitions (title, description, gpay_link, amount, whatsapp_message, display_image, qr_code)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $title, $description, $gpay_link, $amount, $whatsapp_message, $displayImagePath, $qrCodePath);
        if ($stmt->execute()) {
            echo "Tuition added successfully!";
        } else {
            echo "Error adding tuition: " . $stmt->error;
        }
    } else {
        echo "File upload failed.";
    }
}


// Handle Registration Approval
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve'])) {
    $registration_id = $_POST['registration_id'];
    $stmt = $pdo->prepare("UPDATE tuition_registrations SET status = 'approved' WHERE id = ?");
    $stmt->execute([$registration_id]);
    echo "<div class='alert alert-success'>Registration approved successfully!</div>";
}

// Handle Registration Deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $registration_id = $_POST['registration_id'];
    $stmt = $pdo->prepare("DELETE FROM tuition_registrations WHERE id = ? AND status = 'pending'");
    $stmt->execute([$registration_id]);
    echo "<div class='alert alert-danger'>Registration deleted successfully!</div>";
}

// Fetch All Tuitions
$tuitions = $pdo->query("SELECT * FROM tuitions")->fetchAll();

// Fetch All Pending Registrations
$registrations = $pdo->query("SELECT r.*, t.title, t.whatsapp_message FROM tuition_registrations r JOIN tuitions t ON r.tuition_id = t.id WHERE r.status = 'pending'")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Tuitions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Tuition</h2>
        <form action="admin_tuitions.php" method="post" enctype="multipart/form-data">
            <!-- Display Image Upload Field -->
            <div class="form-group">
                <label for="display_image">Image for Tuition Display</label>
                <input type="file" class="form-control-file" id="display_image" name="display_image" required>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
           
                <label for="gpay_link">GPay Link</label> <br>upi://pay?pa=techtopservice1@oksbi&pn=Tech%Top&am=100.00&cu=INR
                <input type="text" class="form-control" id="gpay_link" name="gpay_link" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="qr_code">QR Code</label>
                <input type="file" class="form-control-file" id="qr_code" name="qr_code" required>
            </div>
            <div class="form-group">
                <label for="whatsapp_message">WhatsApp Message</label>
                <textarea class="form-control" id="whatsapp_message" name="whatsapp_message" rows="2" required></textarea>
            </div>
            <button type="submit" name="add_tuition" class="btn btn-primary">Add Tuition</button>
        </form>

        <hr>

        <!-- Display Image if uploaded -->
        <?php if (isset($displayImageUploaded) && $displayImageUploaded): ?>
            <div class="display-image-container mb-4">
                <img src="<?php echo htmlspecialchars($displayImagePath); ?>" class="img-fluid" alt="Display Image">
            </div>
        <?php endif; ?>

        <h3>Pending Registrations</h3>
        <?php if (count($registrations) > 0): ?>
            <ul class="list-group">
                <?php foreach ($registrations as $registration): ?>
                    <li class="list-group-item">
                        <strong>Tuition:</strong> <?php echo htmlspecialchars($registration['title']); ?><br>
                        <strong>Name:</strong> <?php echo htmlspecialchars($registration['student_name']); ?><br>
                        <strong>Phone:</strong> <?php echo htmlspecialchars($registration['phone_number']); ?><br>
                        <strong>Email:</strong> <?php echo htmlspecialchars($registration['email']); ?><br>
                        <strong>Remarks:</strong> <?php echo htmlspecialchars($registration['remarks']); ?><br>
                        <a href="<?php echo htmlspecialchars($registration['screenshot_image']); ?>" target="_blank">
                            <img src="<?php echo htmlspecialchars($registration['screenshot_image']); ?>" class="screenshot-image" alt="Screenshot">
                        </a>

                        <!-- Approve Button -->
                        <form action="admin_tuitions.php" method="post" style="display:inline-block;">
                            <input type="hidden" name="registration_id" value="<?php echo $registration['id']; ?>">
                            <button type="submit" name="approve" class="btn btn-success btn-sm">Approve</button>
                        </form>

                        <!-- Delete Button -->
                        <form action="admin_tuitions.php" method="post" style="display:inline-block;">
                            <input type="hidden" name="registration_id" value="<?php echo $registration['id']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                        </form>

                        <!-- WhatsApp Contact Button -->
                        <?php if ($registration['phone_number']): ?>
                            <a href="https://wa.me/<?php echo htmlspecialchars($registration['phone_number']); ?>?text=<?php echo urlencode($registration['whatsapp_message']); ?>" target="_blank" class="btn btn-info btn-sm mt-2">
                                Contact via WhatsApp
                            </a>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No pending registrations.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .screenshot-image {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
            margin: 10px 0;
        }
        .display-image-container {
            text-align: center;
        }
        .display-image-container img {
            max-width: 100%;
            height: auto;
        }
    </style>
</body>
</html>
