<?php
include 'db.php'; // Include database connection

// Fetch all tuitions
$tuitions = $pdo->query("SELECT * FROM internships")->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Tuitions</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .copy-button {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>All Tuitions</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Registration Link</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tuitions as $tuition): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($tuition['id']); ?></td>
                        <td><?php echo htmlspecialchars($tuition['title']); ?></td>
                        <td><?php echo htmlspecialchars($tuition['description']); ?></td>
                        <td><?php echo $tuition['status'] == 'open' ? 'Open' : 'Closed'; ?></td>
                        <td>
                            <input 
                                type="text" 
                                class="form-control" 
                                value="<?php echo 'https://retechnox.in/register.php?id=' . $tuition['id']; ?>" 
                                readonly 
                                id="link-<?php echo $tuition['id']; ?>"
                            >
                        </td>
                        <td>
                            <button 
                                class="btn btn-primary copy-button" 
                                onclick="copyLink(<?php echo $tuition['id']; ?>)">Copy Link
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Copy the link to clipboard
        function copyLink(id) {
            const link = document.getElementById(`link-${id}`);
            link.select();
            document.execCommand('copy');
            alert('Link copied to clipboard!');
        }
    </script>
</body>
</html>
