<?php
include 'db.php'; // Include your database connection file

// Fetch all workshops for dropdown
$workshops = $pdo->query("SELECT id, title FROM workshops")->fetchAll();

// Handle the registration fetching based on selected workshop
$selectedWorkshopId = null;
$registrations = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['workshop_id'])) {
    $selectedWorkshopId = $_POST['workshop_id'];

    // Fetch registrations based on the selected workshop ID
    if (!empty($selectedWorkshopId) && is_numeric($selectedWorkshopId)) {
        $stmt = $pdo->prepare("SELECT * FROM workshop_registrations WHERE workshop_id = ?");
        $stmt->execute([$selectedWorkshopId]);
        $registrations = $stmt->fetchAll();
    }
}

// Handle CSV download request
if (isset($_POST['download_csv'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="workshop_registrations.csv"');

    $output = fopen('php://output', 'w');
    // Add CSV headers
    fputcsv($output, ['Student Name', 'Phone Number', 'Email', 'College Name', 'Department', 'Year', 'Referral Code', 'Remarks', 'Status']);

    // Add rows to CSV
    foreach ($registrations as $registration) {
        fputcsv($output, [
            $registration['student_name'],
            $registration['phone_number'],
            $registration['email'],
            $registration['college_name'],
            $registration['department_year'],
            $registration['referral_code'],
            $registration['remarks'],
            $registration['status']
        ]);
    }
    fclose($output);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Workshop Registrations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>View Registrations by Workshop</h2>
        
        <!-- Workshop Selection Form -->
        <form action="" method="post" class="mb-4">
            <div class="form-group">
                <label for="workshop_id">Select Workshop:</label>
                <select name="workshop_id" id="workshop_id" class="form-control" required>
                    <option value="">-- Select Workshop --</option>
                    <?php foreach ($workshops as $workshop): ?>
                        <option value="<?php echo $workshop['id']; ?>" <?php echo ($selectedWorkshopId == $workshop['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($workshop['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">View Registrations</button>
        </form>

        <!-- Display Registrations -->
        <?php if (!empty($registrations)): ?>
            <h4>Registrations for Workshop ID: <?php echo htmlspecialchars($selectedWorkshopId); ?></h4>
            <form action="" method="post">
                <input type="hidden" name="workshop_id" value="<?php echo htmlspecialchars($selectedWorkshopId); ?>">
                <input type="hidden" name="download_csv" value="1">
                <button type="submit" class="btn btn-success mb-3">Download CSV</button>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                        <th>College Name</th>
                        <th>Department_year</th>
                        <th>Referral Code</th>
                        <th>Remarks</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registrations as $registration): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($registration['student_name']); ?></td>
                            <td><?php echo htmlspecialchars($registration['phone_number']); ?></td>
                            <td><?php echo htmlspecialchars($registration['email']); ?></td>
                            <td><?php echo htmlspecialchars($registration['college_name']); ?></td>
                            <td><?php echo htmlspecialchars($registration['department_year']); ?></td>
                            <td><?php echo htmlspecialchars($registration['referral_code']); ?></td>
                            <td><?php echo htmlspecialchars($registration['remarks']); ?></td>
                            <td><?php echo htmlspecialchars($registration['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($selectedWorkshopId): ?>
            <p>No registrations found for the selected workshop.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
