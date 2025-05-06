<?php
include 'db.php'; // Include your database connection file

// Check if scheme_id is set in the URL
if (!isset($_GET['scheme_id'])) {
    echo "Scheme not selected.";
    exit;
}

$scheme_id = $_GET['scheme_id'];

// Fetch the scheme information
$scheme = $pdo->prepare('SELECT * FROM schemes WHERE id = ?');
$scheme->execute([$scheme_id]);
$scheme = $scheme->fetch();

// If scheme not found, display an error
if (!$scheme) {
    echo "Scheme not found.";
    exit;
}

// Fetch branches associated with the scheme
$branches = $pdo->prepare('SELECT * FROM branches WHERE scheme_id = ?');
$branches->execute([$scheme_id]);
$branches = $branches->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($scheme['name']) ?> Branches</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Glowing card with animated border */
        .card {
            position: relative;
            border-radius: 15px;
            box-shadow: 0px 4px 80px rgba(0, 123, 255, 0.2);
            transition: box-shadow 0.3s ease-in-out;
            background: white;
            z-index: 1;
            overflow: hidden;
        }

        /* Hover effect for glowing */
        .card:hover {
            box-shadow: 0px 6px 120px rgba(0, 123, 255, 0.4);
        }

        /* Glowing gradient border animation */
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: inherit;
            padding: 2px;
            background: linear-gradient(90deg,
                rgba(255, 255, 255, 0) 25%,
                rgba(0, 123, 255, 0.8) 50%,
                rgba(255, 0, 122, 0.8) 75%,
                rgba(255, 255, 255, 0) 100%);
            -webkit-mask:
                linear-gradient(#fff 0 0) content-box,
                linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            z-index: -1;
            background-size: 300% 300%;
            animation: glowingMove 4s linear infinite;
        }

        /* Glowing animation keyframes */
        @keyframes glowingMove {
            0% {
                background-position: 0% 50%;
            }
            100% {
                background-position: 100% 50%;
            }
        }

        .card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center"><?= htmlspecialchars($scheme['name']) ?> Branches</h2>

        <div class="row">
            <?php if (!empty($branches)): ?>
                <?php foreach ($branches as $branch): ?>
                    <div class="col-md-4 col-sm-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($branch['name']) ?></h5>
                                <a href="view_branch.php?branch_id=<?= $branch['id'] ?>" class="btn btn-primary">View Courses</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No branches available for this scheme.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS for responsiveness -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
