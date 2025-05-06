<?php
include 'db.php'; // Include your database connection file

// Get the branch_id from the URL
$branch_id = $_GET['branch_id'] ?? null;

if (!$branch_id) {
    echo "Branch ID not provided.";
    exit;
}

// Fetch the branch information
$branch = $pdo->prepare('SELECT * FROM branches WHERE id = ?');
$branch->execute([$branch_id]);
$branch = $branch->fetch();

if (!$branch) {
    echo "Branch not found.";
    exit;
}

// Fetch courses associated with the branch
$courses = $pdo->prepare('SELECT * FROM courses WHERE branch_id = ?');
$courses->execute([$branch_id]);
$courses = $courses->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($branch['name']) ?> Courses</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            position: relative;
            border-radius: 15px;
            box-shadow: 0px 4px 80px rgba(0, 123, 255, 0.2);
            transition: box-shadow 0.3s ease-in-out;
            background: white;
        }

        .card:hover {
            box-shadow: 0px 6px 120px rgba(0, 123, 255, 0.4);
        }

        .card-body {
            text-align: center;
        }

        .card ul li a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .card ul li a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center"><?= htmlspecialchars($branch['name']) ?> Courses</h2>

        <div class="row">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($course['name']) ?></h5>
                                <?php
                                // Fetch JSON links for the course
                                $course_id = $course['id'];
                                $links_query = $pdo->prepare('SELECT links FROM courses WHERE id = ?');
                                $links_query->execute([$course_id]);
                                $links_json = $links_query->fetchColumn();
                                
                                // Decode JSON data
                                $links = json_decode($links_json, true);
                                ?>

                                <?php if (!empty($links) && is_array($links)): ?>
                                    <ul class="list-unstyled">
                                        <?php foreach ($links as $link): ?>
                                            <li><a href="<?= htmlspecialchars($link['url']) ?>" target="_blank"><?= htmlspecialchars($link['link_name']) ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="text-muted">No links provided.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">No courses available for this branch.</p>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
