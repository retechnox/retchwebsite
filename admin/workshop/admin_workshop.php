<?php
session_start();
include 'db.php';

// Handle Workshop Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_workshop'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $gpay_link = $_POST['gpay_link'];
    $amount = $_POST['amount'];
    $whatsapp_message = $_POST['whatsapp_message'];

    // Handle Image Upload for Workshop Display
    $uploadDir = __DIR__ . '/uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Upload Display Image
    $displayImageName = basename($_FILES['display_image']['name']);
    $displayImagePath = $uploadDir . $displayImageName;

    if (move_uploaded_file($_FILES['display_image']['tmp_name'], $displayImagePath)) {
        $displayImageUploaded = true;
        $displayImagePathForDB = 'uploads/' . $displayImageName;
    } else {
        $displayImageUploaded = false;
    }

    // Upload QR Code
    $qrCodeName = basename($_FILES['qr_code']['name']);
    $qrCodePath = $uploadDir . $qrCodeName;

    if (move_uploaded_file($_FILES['qr_code']['tmp_name'], $qrCodePath)) {
        $qrCodePathForDB = 'uploads/' . $qrCodeName;

        // Insert into the database
        $stmt = $pdo->prepare("INSERT INTO workshops (title, description, gpay_link, qr_code, amount, whatsapp_message, display_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $description, $gpay_link, $qrCodePathForDB, $amount, $whatsapp_message, $displayImagePathForDB]);
        echo "<div class='alert alert-success'>Workshop added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to upload QR Code.</div>";
    }
}

// Handle Registration Approval
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve'])) {
    $registration_id = $_POST['registration_id'];
    $stmt = $pdo->prepare("UPDATE workshop_registrations SET status = 'approved' WHERE id = ?");
    $stmt->execute([$registration_id]);
    echo "<div class='alert alert-success'>Registration approved successfully!</div>";
}

// Handle Registration Deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $registration_id = $_POST['registration_id'];
    $stmt = $pdo->prepare("DELETE FROM workshop_registrations WHERE id = ? AND status = 'pending'");
    $stmt->execute([$registration_id]);
    echo "<div class='alert alert-danger'>Registration deleted successfully!</div>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Workshops</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Add New Workshop</h2>
        <form action="admin_workshop.php" method="post" enctype="multipart/form-data">
            <!-- Display Image Upload -->
            <div class="form-group">
                <label for="display_image">Workshop Display Image</label>
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
                <label for="gpay_link">GPay Link</label>
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
            <button type="submit" name="add_workshop" class="btn btn-primary">Add Workshop</button>
        </form>

        <hr>

        <h3>Pending Registrations</h3>
        <?php if (count($registrations) > 0): ?>
            <ul class="list-group">
                <?php foreach ($registrations as $registration): ?>
                    <li class="list-group-item">
                        <strong>Workshop:</strong> <?php echo htmlspecialchars($registration['title']); ?><br>
                        <strong>Name:</strong> <?php echo htmlspecialchars($registration['student_name']); ?><br>
                        <strong>Phone:</strong> <?php echo htmlspecialchars($registration['phone_number']); ?><br>
                        <strong>Email:</strong> <?php echo htmlspecialchars($registration['email']); ?><br>
                        <strong>College:</strong> <?php echo htmlspecialchars($registration['college_name']); ?><br>
                        <strong>Department & Year:</strong>
                        <?php echo htmlspecialchars($registration['department']) . ', ' . htmlspecialchars($registration['year']); ?><br>
                        <strong>Referral Code:</strong> <?php echo htmlspecialchars($registration['referral_code']); ?><br>
                        <strong>Remarks:</strong> <?php echo htmlspecialchars($registration['remarks']); ?><br>

                        <!-- Approve -->
                        <form action="admin_workshop.php" method="post" style="display:inline-block;">
                            <input type="hidden" name="registration_id" value="<?php echo $registration['id']; ?>">
                            <button type="submit" name="approve" class="btn btn-success btn-sm">Approve</button>
                        </form>

                        <!-- Delete -->
                        <form action="admin_workshop.php" method="post" style="display:inline-block;">
                            <input type="hidden" name="registration_id" value="<?php echo $registration['id']; ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No pending registrations.</p>
        <?php endif; ?>
    </div>
</body>

</html>

$workshops = $pdo->query("SELECT * FROM workshops")->fetchAll();

// Fetch All Pending Registrations
$registrations = $pdo->query("SELECT r.*, w.title, w.whatsapp_message FROM workshop_registrations r JOIN workshops w ON r.workshop_id = w.id WHERE r.status = 'pending'")->fetchAll();
?>

