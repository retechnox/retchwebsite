<?php
include 'db.php'; // Include your database connection file

// Get the branch_id from the URL
$branch_id = $_GET['branch_id'] ?? null;

if (!$branch_id) {
    echo "Branch ID not provided.";
    exit;
}

// Fetch the branch information
$branch_query = $pdo->prepare('SELECT * FROM branches WHERE id = ?');
$branch_query->execute([$branch_id]);
$branch = $branch_query->fetch();

if (!$branch) {
    echo "Branch not found.";
    exit;
}

// Fetch the scheme information for the branch
$scheme_query = $pdo->prepare('SELECT * FROM schemes WHERE id = ?');
$scheme_query->execute([$branch['scheme_id']]);
$scheme = $scheme_query->fetch();

if (!$scheme) {
    echo "Scheme not found.";
    exit;
}

// Fetch courses associated with the branch
$courses_query = $pdo->prepare('SELECT * FROM courses WHERE branch_id = ?');
$courses_query->execute([$branch_id]);
$courses = $courses_query->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($branch['name']) ?> Courses</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom styles */
        .search-bar {
            max-width: 400px;
            margin: 20px auto;
            position: relative;
        }

        .search-bar input {
            padding-left: 40px;
            border-radius: 30px;
            border: 2px solid #007bff;
            background-color: #f8f9fa;
        }

        .search-bar i {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            color: #007bff;
        }

        .card {
            border: 1px solid #ddd;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 767px) {
            .card-body {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center"><?= htmlspecialchars($branch['name']) ?> Courses</h2>
        <h4 class="mb-4 text-center">Scheme: <?= htmlspecialchars($scheme['name']) ?></h4>

        <!-- Search Bar -->
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" id="search-input" class="form-control" placeholder="Search for a course...">
        </div>

        <div class="row" id="course-list">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-4 col-sm-6 mb-4 course-card">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($course['name']) ?></h5>
                                <?php
                                // Fetch JSON links for the course
                                $links_query = $pdo->prepare('SELECT links FROM courses WHERE id = ?');
                                $links_query->execute([$course['id']]);
                                $links_json = $links_query->fetchColumn();
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
    <script>
        // JavaScript function for filtering course titles based on user input
        document.getElementById('search-input').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const courseCards = document.querySelectorAll('.course-card');
            
            courseCards.forEach(function(card) {
                const courseTitle = card.querySelector('.card-title').textContent.toLowerCase();
                if (courseTitle.includes(searchValue)) {
                    card.style.display = ''; // Show the course if it matches the search
                } else {
                    card.style.display = 'none'; // Hide the course if it doesn't match
                }
            });
        });
    </script>
</body>
</html>
