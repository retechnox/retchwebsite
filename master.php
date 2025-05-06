<?php
include 'db.php'; // Include your database connection file

// Fetch all internships ordered by creation date (latest first)
$stmt = $pdo->query('SELECT * FROM internships ORDER BY created_at DESC');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Internships</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="favicon.ico">
    <style>
        body{
            background-color: black;
        }
        /* Custom CSS for the headline */
        .headline {
            color: #007bff; /* Bootstrap primary blue */
            font-weight: 700;
            text-align: center;
            margin-bottom: 20px;
        }

 

        /* Custom Read More button style */
        .read-more-btn {
            color: #007bff;
            background-color: transparent;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        /* Flexbox for buttons side by side */
        .button-group {
            display: flex;
            justify-content: space-between;
        }

        .button-group .btn {
            flex: 1;
            margin: 0 5px;
        }
    </style>
</head>

<body>
<style>
            /* Navbar styling */
            .navbar {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 15px 40px;
                background-color: #fff;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .navbar-brand {
                font-size: 1.7em;
                font-weight: bold;
                color: #333;
                display: flex;
                align-items: center;
                gap: 10px;
                margin-top: auto;
                margin-left: -1px;
            }

            .navbar-brand span {
                margin-left: -13px;
            }

            .navbar-brand img {
                width: 80px;
                height: 40px;
                object-fit: contain;
                margin-top: 3px;
                scale: 2.5;
            }

            /* Flex row for navigation links on desktop */
            .nav-links {
                display: flex;
                gap: 20px;
            }

            .nav-links a {
                text-decoration: none;
                color: #333;
                font-weight: 600;
                transition: color 0.3s;
            }

            .nav-links a:hover {
                color: #007bff;
            }

            /* Hide overlay menu and nav-toggle by default */
            .nav-toggle,
            .overlay {
                display: none;
            }

            /* Responsive adjustments for mobile screens */
            @media (max-width: 1090px) {
                .nav-links {
                    display: none;
                    /* Hide flex links in mobile */
                }

                .nav-toggle {
                    display: block;
                    font-size: 1.5em;
                    cursor: pointer;
                    color: #333;
                }

                /* Make overlay visible and animated */
                .overlay {
                    display: block;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 0;
                    background: rgba(0, 0, 0, 0.9);
                    overflow: hidden;
                    z-index: 999;
                    transition: height 0.4s ease;
                }
            }

            .overlay-content {
                position: relative;
                top: 50%;
                transform: translateY(-50%);
                text-align: center;
                color: white;
            }

            .overlay-content a {
                display: block;
                font-size: 2em;
                color: white;
                margin: 10px 0;
                text-decoration: none;
            }

            .overlay-content a:hover {
                color: #007bff;
            }

            .close-btn {
                position: absolute;
                top: 20px;
                right: 30px;
                font-size: 2em;
                color: white;
                cursor: pointer;
            }

            .social-icons {
                display: flex;
                gap: 15px;
                font-size: 20px;
            }

            .social-icons a {
                color: #333;
                font-size: 1.2em;
                transition: color 0.3s;
            }

            .social-icons a:hover {
                color: #007bff;
            }

            /* Responsive styling: hide social icons on mobile */
            @media (max-width: 1090px) {
                .social-icons {
                    display: none;
                    /* Hide on smaller screens */
                }
            }
            @media (max-width: 800px) {
                .navbar-brand img {
                scale: 2;
                }
            }

            /* Overlay content for mobile view */
            .overlay-content .social-icons-mobile {
                margin-top: 20px;
                display: flex;
                gap: 20px;
                justify-content: center;
            }

            .overlay-content .social-icons-mobile a {
                color: white;
                font-size: 1.8em;
            }

            .overlay-content .social-icons-mobile a:hover {
                color: #007bff;
            }
        </style>

        <nav class="navbar">
            <div class="navbar-brand">
                <a href="/">
                <img src="img/rtxxxnew.png" alt="ReTechNox Logo"> </a>
                <span>Retechnox</span>
            </div>
            <div class="nav-links">
                <a href="/">Home</a>
                <a href="all_internship.php">Internship</a>
                <a href="all_work.php">Workshops And Events</a>
                <a href="all_tut.php">Tuitions</a>
                <a href="https://ktumagic.retechnox.in">KTU Materials</a>
                <a href="https://wa.me/+916238795437">Contact Us</a>
                <div class="social-icons-mobile">
                    <a href="https://chat.whatsapp.com/FD814OHDdKtD0sqhte3KRT"><i class="fab fa-whatsapp"></i></a>
                    <a href="http://www.instagram.com/retechnox"><i class="fab fa-instagram"></i></a>
                    <a href="http://linkedin.com/company/retechnox-technologies"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <span class="nav-toggle" onclick="openNav()">☰</span>
        </nav>

        <!-- Overlay Menu -->
        <div id="myNav" class="overlay">
            <span class="close-btn" onclick="closeNav()">&times;</span>
            <div class="overlay-content">
                <a href="/">Home</a>
                <a href="all_internship.php">Internship</a>
                <a href="all_work.php">Workshops And Events</a>
                <a href="all_tut.php">Tuitions</a>
                <a href="https://ktumagic.retechnox.in">KTU Materials</a>
                <a href="https://wa.me/+916238795437">Contact Us</a>
                <div class="social-icons-mobile">
                    <a href="https://chat.whatsapp.com/FD814OHDdKtD0sqhte3KRT"><i class="fab fa-whatsapp"></i></a>
                    <a href="http://www.instagram.com/retechnox"><i class="fab fa-instagram"></i></a>
                    <a href="http://linkedin.com/company/retechnox-technologies"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>

        <script>
            function openNav() {
                document.getElementById("myNav").style.height = "100%";
            }

            function closeNav() {
                document.getElementById("myNav").style.height = "0%";
            }
        </script>



<div class="container mt-5">
    <!-- Headline for All Internships -->
    <h2 class="headline">MASTER COURSES</h2>
    <div class="row">
        <?php
        while ($row = $stmt->fetch()) {
            $status = $row['status'] === 'open' ? 'Open' : 'Closed';
            echo '<div class="col-16 col-md-3 mb-3">';
            echo '<div class="card h-100">';
            echo '<img src="admin/intern/' . htmlspecialchars($row['display_image']) . '" class="card-img-top" alt="Internship Image" style="height: 150px; object-fit: cover;">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>';
            echo '<p class="card-text">';
            echo '<span id="desc-short-' . $row['id'] . '">' . htmlspecialchars(substr($row['description'], 0, 100)) . '</span>';
            echo '<span id="desc-full-' . $row['id'] . '" style="display: none;">' . htmlspecialchars($row['description']) . '</span>';
            echo '<button style="margin-left:10px" class="btn btn-link p-0 text-primary read-more-btn" data-id="' . $row['id'] . '">Read More</button>';
            echo '</p>';
            echo '<p class="card-text"><strong>Status:</strong> ' . $status . '</p>';
            if ($row['status'] === 'open') {
                echo '<a href="/register.php?id=' . $row['id'] . '" class="btn btn-primary btn-block" target="_blank">Register</a>';
            } else {
                echo '<div class="button-group">';
                echo '<a href="https://api.whatsapp.com/send/?phone=%2B917907552296" class="btn btn-success" target="_blank">Book Slots</a>';
                echo '<button class="btn btn-secondary" disabled style="margin-left:10px;">Closed</button>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>
<br> <br> <br> <br> 
    <center>    <h4 style="color: white;"> We are Planning for a new.. Will be back soon...</h4> </center>

<br> <br> <br> <br>

<!-- CSS: Make sure the full description is not constrained -->
<style>
    .card-text span#desc-full {
        display: none;      /* Initially hidden */
        white-space: normal;/* Allow text wrapping */
        max-height: none;   /* Remove any height limits */
        overflow: visible;  /* Ensure full content is visible */
    }
</style>

<!-- JavaScript: Toggle between short and full description -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.read-more-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const shortText = document.getElementById(`desc-short-${id}`);
                const fullText = document.getElementById(`desc-full-${id}`);
                
                // Check if full text is hidden (or its display value is empty)
                if (fullText.style.display === 'none' || fullText.style.display === '') {
                    shortText.style.display = 'none';      // Hide the short text
                    fullText.style.display = 'block';        // Display full text as a block element
                    this.textContent = 'Read Less';          // Update button text
                } else {
                    shortText.style.display = 'inline';      // Show the short text
                    fullText.style.display = 'none';         // Hide the full text
                    this.textContent = 'Read More';          // Update button text
                }
            });
        });
    });
</script>



    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



<style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

            .container {
                max-width: 3070px;
                margin: auto;
            }

            .row {
                display: flex;
                flex-wrap: wrap;
            }

            ul {
                list-style: none;
                margin-left: -25px;
            }

            .footer {
                background-color: rgb(12, 29, 51);
                padding: 10px 0;
            }

            .footer-col {
                width: 20%;
                padding: 0 15px;
                margin-left: 50px;
            }

            .footer-col h4 {
                font-size: 18px;
                color: #ffffff;
                text-transform: capitalize;
                margin-bottom: 35px;
                font-weight: 500;
                position: relative;
            }

            .footer-col h4::before {
                content: '';
                position: absolute;
                left: 0;
                bottom: -10px;
                background-color: #e91e63;
                height: 2px;
                box-sizing: border-box;
                width: 50px;
            }

            .footer-col ul li:not(:last-child) {
                margin-bottom: 10px;
            }

            .footer-col ul li a {
                font-size: 16px;
                text-transform: capitalize;
                color: #ffffff;
                text-decoration: none;
                font-weight: 400;
                color: white;
                display: block;
                transition: all 0.3s ease;
            }

            .footer-col ul li a:hover {
                color: #ffffff;
                padding-left: 8px;
            }

            .footer-col .social-links a {
                display: inline-block;
                height: 40px;
                width: 40px;
                background-color: rgba(255, 255, 255, 0.2);
                margin: 0 10px 10px 0;
                text-align: center;
                line-height: 40px;
                border-radius: 50%;
                color: #ffffff;
                transition: all 0.5s ease;
            }

            .footer-col .social-links a:hover {
                color: #24262b;
                background-color: #ffffff;
            }

            /*responsive*/
            @media(max-width: 767px) {
                .footer-col {
                    width: 50%;
                    margin-bottom: 30px;
                }

            }

            @media(max-width: 574px) {
                .footer-col {
                    width: 70%;
                }

            }
        </style>
<footer class="footer">
            <div class="container"><br><br>
                <div class="row">
                    <div class="footer-col">
                        <div class="navbar-brand">
                            <div class="navbar1">
                                <img src="img/rtxxxnew.png" alt="ReTechNox Logo">
                            </div>
                        </div>
                        <style>
                            .navbar1 img{
                                justify-content: center;
                                margin-left: 100%; margin-top: 30%;
                                scale: 6;
                            }

                            @media (max-width: 800px) {
                                .navbar1 img{
                                    margin-left: 1%;
                                    margin-bottom: 15%;
                                    scale: 4;
                                }
                            }
                        </style>

                    </div>

                    <div class="footer-col">
                        <h4>SERVICES</h4>
                        <ul>
                            <li><a href="all_internship.php">Internships</a></li>
                            <li><a href="https://ktumagic.retechnox.in">Study Materials</a></li>
                            <li><a href="all_tut.php">Tuitions</a></li>
                            <li><a href="https://wa.me/+916238795437">Workshops And events</a></li>
                            <li><a href="https://wa.me/+916238795437">Contact</a></li>
                            <li><a href="admin/admin.php">Admin</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>FOLLOW US</h4>
                        <div class="social-links">
                            <a href="https://chat.whatsapp.com/FD814OHDdKtD0sqhte3KRT"><i class="fab fa-whatsapp"></i></a>
                            <a href="http://www.instagram.com/retechnox"><i class="fab fa-instagram"></i></a>
                            <a href="http://linkedin.com/company/retechnox-technologies"><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>

                    </div>
                    <div class="footer-col">
                        <h4>CONTACT</h4>
                        <ul>
                            <li><a href="https://wa.me/+916238795437">Contact-us: +916238795437</a></li>
                            <li><a href="mailto:Retechnox@gmail.com">Email-us: Retechnox@gmail.com</a></li>

                        </ul>
                    </div>
                </div>
            </div>
            <div
                style="color:white;width:100; padding-bottom:15px;margin-top:-30px; font-size: 13px; text-align:center; margin-top:110px">
                Copyright 2024 Retechnox Technologies LLP all rights reserved <a
                    href="https://www.instagram.com/crem.create/">crem.create</a> </div>
        </footer>

    
</body>

</html>
