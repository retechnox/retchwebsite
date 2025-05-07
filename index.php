<?php include 'db.php'; ?>

<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="UTF-8">

    <title>Retechnox Homepage</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="favicon.ico">

    <style>

        body {

            overflow-x: hidden;

        }





        .card1 {

            display: inline-block;

            background-color: white;

            border-radius: 15px;

            border: solid 1px #007bff;

            width: 200px;

            height: 100px;

            /* Fixed height for the cards */

            margin: 10px;

            vertical-align: top;

            word-wrap: break-word;

            white-space: normal;

            overflow: hidden;



        }







        .card {

            position: relative;

            border-radius: 15px;

            box-shadow: 0px 4px 80px rgba(0, 123, 255, 0.2);

            transition: box-shadow 0.3s ease-in-out;

            background: white;

            /* Card's background */

            z-index: 1;

            overflow: hidden;

        }



        /* Pseudo-element to create the glowing, moving gradient border */

        .card::before {

            content: '';

            position: absolute;

            top: 0;

            left: 0;

            right: 0;

            bottom: 0;

            border-radius: inherit;

            /* Matches the card's rounded corners */

            padding: 2px;

            /* Thickness of the border */

            background: linear-gradient(90deg,

                    rgba(255, 255, 255, 0) 25%,

                    rgba(0, 123, 255, 0.8) 50%,

                    rgba(255, 0, 122, 0.8) 75%,

                    rgba(255, 255, 255, 0) 100%);

            /* Glowing segment */

            -webkit-mask:

                linear-gradient(#fff 0 0) content-box,

                linear-gradient(#fff 0 0);

            -webkit-mask-composite: xor;

            mask-composite: exclude;

            z-index: -1;

            /* Places the gradient behind the card content */

            background-size: 300% 300%;

            /* Enlarges the background for smooth animation */

            animation: glowingMove 4s linear infinite;

            /* Animation settings */

        }



        /* Keyframes for the snake-like gradient movement */

        @keyframes glowingMove {

            0% {

                background-position: 0% 50%;

            }



            100% {

                background-position: 100% 50%;

            }

        }



        .card-title {

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

            max-width: 100%;

        }



        .card-text {

            line-height: 1.5;

            text-decoration: none;

        }



        .carousel-item {

            height: 100vh;

            /* Full viewport height */

        }



        .carousel-item .left-container {

            background-size: cover;

            background-position: center;

            height: 100%;

            /* Full height of the item */

        }



        .carousel-item .right-container {

            display: flex;

            flex-direction: column;

            justify-content: center;

            align-items: flex-start;

            /* Left align content */

            padding: 20px;

            height: 100%;

            /* Full height of the item */

        }



        /* Stacking for mobile */

        @media (max-width: 768px) {

            .carousel-item {

                flex-direction: column;

                height: 80vh;

                /* Stack vertically */

            }



            .left-container {

                width: 100%;

                height: 80vh;

            }



            .right-container {

                width: 100%;

                height: 20vh;

                align-items: flex-start;

                text-align: left;

            }

        }



        .interactive-section {

            background-color: #000;

            /* Black background */

            color: #fff;

            /* White text */

            text-align: center;

            padding: 50px 20px;

            font-family: 'Poppins', sans-serif;

        }



        .interactive-section .logo {

            width: 150px;

            margin-bottom: 20px;

            transition: transform 0.3s ease-in-out;

        }



        /* Hover effect on the logo */

        .interactive-section .logo:hover {

            transform: scale(1.1);

            /* Scale up the logo */

        }



        .interactive-section h1 {

            font-size: 2rem;

            font-weight: 700;

            margin-bottom: 10px;

            transition: color 0.3s ease;

        }



        .interactive-section h3 {

            font-size: 1rem;

            font-weight: 300;

            margin-bottom: 20px;

            transition: color 0.3s ease;

            max-width: 60%;

            margin-left: auto;

            margin-right: auto;

            text-align: center;

            padding: 10px;

            border: 1px solid #000;

            display: block;

            word-wrap: break-word;

            box-sizing: border-box;

        }



        /* For mobile view */

        @media (max-width: 768px) {

            .interactive-section h3 {

                max-width: 90%;

                font-size: .4rem;

            }

        }





        /* Hover effect on text */

        .interactive-section h1:hover,

        .interactive-section h3:hover {

            color: #f39c12;

            /* Change text color on hover */

        }



        /* Make the section responsive */

        @media (max-width: 768px) {

            .interactive-section h1 {

                font-size: 2rem;

            }



            .interactive-section h3 {

                font-size: 1rem;

                max-width: 100%;

            }

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



            .navbar-brand {

                margin-left: -14px;

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











    <style>

        .casstitle {

            font-size: 6rem;

        }



        .casspara {

            font-size: 1.5rem;

            width: 75%;

        }



        @media (max-width: 768px) {

            .casstitle {

                max-width: 90%;

                font-size: 2rem;

            }



            .casspara {

                max-width: 100%;

                font-size: .9rem;

            }

        }



        .btn22 {

            color: black;

            background-color: transparent;

            padding: 7px;

            border: 2px solid black;

            text-decoration: none;

            text-transform: uppercase;

            font-weight: 600;

            font-size: .8rem;

        }

    </style>







<style>

        /* Reset and base styles */

        * {

            margin: 0;

            padding: 0;

            box-sizing: border-box;

            font-family: Arial, sans-serif;

        }



        /* WhatsApp Chat Widget Styles */

        .whatsapp-widget {

            position: fixed;

            bottom: 20px;

            right: 20px;

            z-index: 1000;

            transition: all 0.3s ease;

        }



        .whatsapp-btn {

            background-color:#25d366;

            color: white;

            border: none;

            border-radius: 50%;

            width: 60px;

            height: 60px;

            display: flex;

            justify-content: center;

            align-items: center;

            cursor: pointer;

            box-shadow: 0 4px 6px rgba(0,0,0,0.1);

            transition: background-color 0.3s ease;

        }



   



        .whatsapp-chat-container {

            width: 350px;

            background-color: white;

            border-radius: 10px;

            box-shadow: 0 4px 15px rgba(0,0,0,0.2);

            display: none;

            flex-direction: column;

            position: absolute;

            bottom: 80px;

            right: 0;

            overflow: hidden;

        }



        .whatsapp-chat-container.active {

            display: flex;

        }



        .chat-header {

            background-color:#25d366;

            color: white;

            padding: 15px;

            display: flex;

            align-items: center;

            justify-content: space-between;

        }



        .chat-header-info {

            display: flex;

            align-items: center;

        }



        .chat-header-info img {

            width: 45px;

            height: 45px;

            border-radius: 50%;

            margin-right: 10px;

        }



        .chat-header-info .contact-details {

            display: flex;

            flex-direction: column;

        }



        .contact-details .contact-name {

            font-weight: bold;

        }



        .contact-details .contact-status {

            font-size: 0.8em;

            color: #DCF8C6;

        }



        .close-btn {

            background: none;

            border: none;

            color: white;

            cursor: pointer;

        }



        .chat-body {

            height: 100px;

            background-color: #F0F0F0;

            padding: 15px;

            overflow-y: auto;

        }



        .chat-footer {

            display: flex;

            padding: 10px;

            background-color: white;

            border-top: 1px solid #e0e0e0;

        }



        .message-input {

            flex-grow: 1;

            padding: 10px;

            border: 1px solid #ddd;

            border-radius: 20px;

            margin-right: 10px;

        }



        .send-btn {

            background-color: #25d366;

            color: white;

            border: none;

            border-radius: 50%;

            width: 45px;

            height: 45px;

            display: flex;

            justify-content: center;

            align-items: center;

            cursor: pointer;

        }



        .send-btn:hover {

            background-color: #128C7E;

        }

    </style>



    <div class="whatsapp-widget">

        <button class="whatsapp-btn" id="toggleChatBtn">

            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>

            </svg>

        </button>



        <div class="whatsapp-chat-container" id="chatContainer">

            <div class="chat-header">

                <div class="chat-header-info">

                    <img src="img/rtxxxnew.png" alt="Retechnox Logo">

                    <div class="contact-details">

                        <span class="contact-name">Retechnox</span>

                        <span class="contact-status">Online</span>

                    </div>

                </div>

                <button class="close-btn" id="closeChatBtn">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                        <line x1="18" y1="6" x2="6" y2="18"></line>

                        <line x1="6" y1="6" x2="18" y2="18"></line>

                    </svg>

                </button>

            </div>



            <div class="chat-body" id="chatBody">

                <div style="text-align: center; color: #888; margin-top: 100px;">

                    Start a conversation with Retechnox

                </div>

            </div>



            <div class="chat-footer">

                <input type="text" class="message-input" id="messageInput" placeholder="Type a message">

                <button class="send-btn" id="sendMessageBtn">

                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                        <line x1="22" y1="2" x2="11" y2="13"></line>

                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>

                    </svg>

                </button>

            </div>

        </div>

    </div>



    <script>

        document.addEventListener('DOMContentLoaded', function() {

            const toggleChatBtn = document.getElementById('toggleChatBtn');

            const closeChatBtn = document.getElementById('closeChatBtn');

            const chatContainer = document.getElementById('chatContainer');

            const messageInput = document.getElementById('messageInput');

            const sendMessageBtn = document.getElementById('sendMessageBtn');



            // Toggle chat container

            toggleChatBtn.addEventListener('click', function() {

                chatContainer.classList.add('active');

            });



            // Close chat container

            closeChatBtn.addEventListener('click', function() {

                chatContainer.classList.remove('active');

            });



            // Send message

            sendMessageBtn.addEventListener('click', function() {

                const message = messageInput.value.trim();

                if (message) {

                    // Redirect to WhatsApp with pre-filled message

                    const whatsappNumber = '+916238795437';

                    const whatsappUrl = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;

                    window.open(whatsappUrl, '_blank');

                    

                    // Clear input and close chat

                    messageInput.value = '';

                    chatContainer.classList.remove('active');

                }

            });



            // Allow sending message by pressing Enter

            messageInput.addEventListener('keypress', function(e) {

                if (e.key === 'Enter') {

                    sendMessageBtn.click();

                }

            });

        });

    </script>





    <!-- Carousel -->

    <div id="carouselExample" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2000">

        <div class="carousel-inner">



            <!-- Carousel Item 1 -->

            <div class="carousel-item active">

                <div class="d-flex flex-md-row flex-column h-100 w-100 p-0">



                    <!-- Left Container (Image) -->

                    <div class="col-md-6 p-0 left-container" style="background-image: url('img/3.jpg');"></div>



                    <!-- Right Container (Text and Button) -->

                    <div class="col-md-6 right-container bg-light text-start">

                        <h1 class="casstitle">Internships</h1>

                        <p class="casspara">Explore our internships, available both

                            online and offline across all branches.

                            Gain hands-on experience and skill

                            development tailored to your field,

                            enhancing your resume and preparing

                            you for a successful career.</p>

                        <a href="all_internship.php" class="btn22 btn-dark">Learn More</a>

                    </div>

                </div>

            </div>



            <!-- Carousel Item 2 -->

            <div class="carousel-item">

                <div class="d-flex flex-md-row flex-column h-100 w-100 p-0">



                    <!-- Left Container (Image) -->

                    <div class="col-md-6 p-0 left-container" style="background-image: url('img/2.jpg');"></div>



                    <!-- Right Container (Text and Button) -->

                    <div class="col-md-6 right-container bg-light text-start">

                        <h1 class="casstitle">Tuitions</h1>

                        <p class="casspara">Join our comprehensive tuition

                            programs featuring online, recorded,

                            and live sessions tailored to your

                            needs, from experienced and

                            friendly faculty</p>

                        <a href="all_tut.php" class="btn22 btn-dark">Learn More</a>

                    </div>

                </div>

            </div>



            <!-- Carousel Item 3 -->

            <div class="carousel-item">

                <div class="d-flex flex-md-row flex-column h-100 w-100 p-0">



                    <!-- Left Container (Image) -->

                    <div class="col-md-6 p-0 left-container" style="background-image: url('img/stdy.jpg');"></div>



                    <!-- Right Container (Text and Button) -->

                    <div class="col-md-6 right-container bg-light text-start">

                        <h1 class="casstitle">KTU Study Materials</h1>

                        <p class="casspara">We offer a wide range of KTU

                            materials, including notifications

                            and study resources. Our collection

                            includes notes, presentations, and

                            previous exam questions</p>

                        <a href="https://ktumagic.retechnox.in" class="btn22 btn-dark">Learn More</a>

                    </div>

                </div>

            </div>



        </div>



        <!-- Carousel Indicators (Styled Blue) -->

        <ol class="carousel-indicators">

            <li data-bs-target="#carouselExample" data-bs-slide-to="0" class="active"></li>

            <li data-bs-target="#carouselExample" data-bs-slide-to="1"></li>

            <li data-bs-target="#carouselExample" data-bs-slide-to="2"></li>

        </ol>



        <!-- Carousel Controls -->

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">

            <span class="carousel-control-prev-icon" aria-hidden="true"></span>

            <span class="visually-hidden">Previous</span>

        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">

            <span class="carousel-control-next-icon" aria-hidden="true"></span>

            <span class="visually-hidden">Next</span>

        </button>

    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            var carousel = document.getElementById('carouselExample');

            var bootstrapCarousel = new bootstrap.Carousel(carousel, {

                interval: 2000,

                wrap: true

            });

        });

    </script>

    <!-- Custom CSS -->

    <style>

        /* Maintain consistent height */

        #carouselExample {

            min-height: 400px;

        }



        .carousel {

            background-color: #000;

            /* Match your darkest slide background */

        }



        .carousel-inner {

            overflow: hidden;

        }



        .carousel-item {

            transition: transform 0.6s ease-in-out !important;

            /* Adjust timing as needed */

        }



        .carousel-item.active,

        .carousel-item-next,

        .carousel-item-prev {

            display: flex !important;

        }



        /* Remove default Bootstrap transition override */

        .carousel-fade .carousel-item {

            opacity: 0;

            transition-property: opacity;

            transform: none;

        }



        /* Image container styles */

        .left-container {

            min-height: 400px;

            background-size: cover;

            background-position: center;

        }



        /* Text container styles */

        .right-container {

            padding: 2rem;

        }



        /* Custom button style */

        .btn22 {

            padding: 0.5rem 2rem;

            border-radius: 4px;

            text-decoration: none;

            display: inline-block;

        }



        /* Custom title and paragraph styles */

        .casstitle {

            margin-bottom: 1.5rem;

        }



        .casspara {

            margin-bottom: 2rem;

        }



        /* Enhanced Carousel Indicators */

        .carousel-indicators {

            margin-bottom: 1rem;

        }



        .carousel-indicators [data-bs-target] {

            width: 10px;

            height: 10px;

            border-radius: 50%;

            margin: 0 6px;

            background-color: gray;

            border: none;

            opacity: 0.7;

        }



        .carousel-indicators .active {

            background-color: black;

            opacity: 1;

            transform: scale(1.2);

        }



        /* Responsive adjustments */

        @media (max-width: 768px) {

            .left-container {

                min-height: 250px;

            }



            .carousel-indicators {

                scale: .5;

            }



        }



        /* Prevent white flash */

        .carousel-item {

            display: none;

        }



        .carousel-item.active {

            display: block;

        }

    </style>









    <section class="interactive-section" style="background-color:#132f51;"><br>

        <!-- Logo (you can replace the src with your logo URL) --><br>

        <img src="img/rtx.png" alt="Company Logo" class="logo" style="margin-top: -60px;">

        <!-- Heading -->

        <h1>RETECHNOX TECHNOLOGIES LLP</h1>



        <!-- Subheading -->

        <h3 style="border:none;">We offer internships, workshops, and personalized tuition to meet your needs.

            Looking to enhance your tech skills? Our institution provides cutting-edge courses

            across various technology domains, ensuring you're always ahead in your field.</h3>

    </section>



    <section class="interactive-section1">

        <style>

            .interactive-section1 {

                background-color: #132f51;

                margin-top: -60px;

            }



            .interactive-section h1 {

                margin-top: -10px;

            }



            .interactive-section1 h3 {

                color: white;

                margin-top: -80px;

                font-size: 1.5rem;

                font-weight: 600;

                margin-bottom: 20px;

                transition: color 0.3s ease;

                margin-left: 10px;

                text-align: left;

                padding: 50px 20px;

            }

        </style>



        <div class="container" style="background-color:#132f51; height:100%; padding-bottom:50px; overflow: hidden;">

            <div class="row">

                <?php

                try {

                    $stmt = $pdo->query("SELECT * FROM internships ORDER BY FIELD(status, 'open', 'closed'), created_at DESC");



                    if ($stmt->rowCount() > 0) {

                        echo '<br><br><br>';

                        echo '<h3 class="col-12 text-center mb-4 text-white">LATEST INTERNSHIPS</h3>';



                        echo '<div class="scroll-container">';

                        echo '<div class="scroll-content">';



                        foreach ($stmt->fetchAll() as $row) {

                            renderInternshipCard($row);

                        }



                        echo '</div>'; // Close scroll-content

                        echo '</div>'; // Close scroll-container

                    } else {

                        echo '<p class="text-center text-white">No internships available at the moment.</p>';

                    }

                } catch (PDOException $e) {

                    echo '<p class="text-danger">Error fetching internships: ' . htmlspecialchars($e->getMessage()) . '</p>';

                }



                function renderInternshipCard($row)

                {

                    echo '<div class="card-wrapper">';

                    echo '<div class="card">';

                    echo '<div class="card-body">';

                    echo '<h5 class="card-title">' . htmlspecialchars($row['title']) . '</h5>';

                    echo '<p class="card-text">' . htmlspecialchars($row['description']) . '</p>';

                    if ($row['status'] === 'open') {

                        echo '<p><strong>Status:</strong> Open</p>';

                        echo '<a href="registerintern.php?id=' . $row['id'] . '" class="btn btn-primary" target="_blank">Register</a>';

                    } else {

                        //  HR   echo '<p><strong>Status:</strong> Closed</p>';

                        //  echo '<button class="btn btn-secondary" disabled>Closed</button>';

                        echo '<a href="https://wa.me/+916238795437"><button class="btn btn-secondary" style="background-color:green; margin-left:10px">Book slot</button></a>';

                    }

                    echo '</div>'; // Close card-body

                    echo '</div>'; // Close card

                    echo '</div>'; // Close card-wrapper

                }

                ?>

            </div>

        </div>



        <style>

            /* Scroll container */

            .scroll-container {

                position: relative;

                overflow: hidden;

                width: 100%;

                height: auto;

            }



            /* Scroll content */

            .scroll-content {

                display: flex;

                gap: 20px;

                animation: scroll-left 20s linear infinite;

            }



            @media (max-width: 768px) {

                .scroll-container {

                    position: relative;

                    overflow: hidden;

                    width: 100%;

                    height: auto;

                }



                .scroll-content {

                    display: flex;

                    gap: 20px;

                    animation: scroll-left 3s linear infinite;

                }

            }



            /* Individual cards */

            .card-wrapper {

                flex: 0 0 auto;

                width: 300px;

            }



            .card {

                border-radius: 10px;

                overflow: hidden;

                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);

                transition: transform 0.3s;

            }



            .card:hover {

                transform: scale(1.05);

            }



            /* Keyframes for scrolling */

            @keyframes scroll-left {

                0% {

                    transform: translateX(0%);

                }



                100% {

                    transform: translateX(-100%);

                }

            }

        </style>





        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



        <script>

            function readMore(id) {

                const description = document.getElementById('description-' + id);

                const readMoreBtn = event.target;



                if (readMoreBtn.innerHTML === 'Read More') {

                    // Expand the description

                    description.style.display = 'block'; // Ensure full visibility

                    description.classList.remove('clamped'); // Remove clamping class

                    readMoreBtn.innerHTML = 'Read Less'; // Update button text

                } else {

                    // Collapse the description

                    description.style.display = '-webkit-box'; // Apply clamping display style

                    description.classList.add('clamped'); // Reapply clamping class

                    readMoreBtn.innerHTML = 'Read More'; // Update button text

                }

            }



        </script>



        <style>

            /* Custom CSS for the headline */

            .headline {

                color: #007bff;

                font-weight: 700;

                text-align: center;

                margin-bottom: 20px;

            }



            /* CSS to limit the description to 3 lines */

            .card-text {

                display: -webkit-box;

                -webkit-line-clamp: 3;

                -webkit-box-orient: vertical;

                overflow: hidden;

                text-overflow: ellipsis;

            }



            .card-text.clamped {

                display: -webkit-box;

                /* Apply clamping */

                -webkit-line-clamp: 3;

                /* Clamp to 3 lines */

                overflow: hidden;

                /* Ensure hidden overflow */

                text-overflow: ellipsis;

                /* Maintain ellipsis */

            }



            /* Custom Read More button style */

            .read-more-btn {

                color: #007bff;

                background-color: transparent;

                border: none;

                padding: 0;

                cursor: pointer;

            }



            /* Flexbox for side-by-side buttons */

            .button-group {

                display: flex;

                justify-content: space-between;

            }



            .button-group .btn {

                flex: 1;

                margin: 0 5px;

            }

        </style>



    </section>





    <!-- Hardcoded 6 Cards Section -->

    <div class="container mt-5">

        <style>

            .col-12.col-md-4 a {

                text-decoration: none !important;

                /* Remove underline for the entire link */

                color: black !important;

                ;

            }



            .col-12.col-md-4 a:hover {

                text-decoration: none !important;

                /* Ensure no underline on hover */

            }



            .card-body a {

                color: inherit;

                /* Make sure the link inherits the color of surrounding text */

                text-decoration: none !important;

            }

        </style> <br> <br>

        <div class="row" style="width:90%; dispaly:flex; justify-content:center;margin:auto;">

            <div class="col-12 col-md-4 mb-4">

                <a href="all_internship.php">

                    <div class="card">

                        <div

                            style="background-image: url('img/3.jpg'); background-size: cover; background-position: center; width:100%; height:200px;">

                        </div>

                        <div class="card-body">

                            <h5 class="card-title">Internships </h5>

                            <p class="card-text">

                                Explore our internships, available both

                                online and offline across all branches.

                                Gain hands-on experience and skill

                                development tailored to your field,

                                enhancing your resume and preparing

                                you for a successful career.</p>

                        </div>

                    </div>

                </a>

            </div>



            <div class="col-12 col-md-4 mb-4">

                <a href="all_work.php">

                    <div class="card">

                        <div

                            style="background-image: url('img/my.jpg'); background-size: cover; background-position: center; width:100%; height:200px;">

                        </div>

                        <div class="card-body">

                            <h5 class="card-title">Workshops & Events</h5>

                            <p class="card-text">We offer 1 to 5-day workshops and a variety of events, both

                                online and offline, complete with certificates. Enhance your resume and prepare

                                for a successful career with our engaging programs designed to equip you with

                                valuable skills and knowledge.</p>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-12 col-md-4 mb-4">

                <a href="all_tut.php">

                    <div class="card">

                        <div

                            style="background-image: url('img/2.jpg'); background-size: cover; background-position: center; width:100%; height:200px;">

                        </div>

                        <div class="card-body">

                            <h5 class="card-title">Tuition </h5>

                            <p class="card-text"> Join our comprehensive tuition

                                programs featuring online, recorded,

                                and live sessions tailored to your

                                needs, from experienced and

                                friendly faculty.</p>

                            </p>

                        </div>

                    </div>

                </a>

            </div>

            <div class="col-12 col-md-4 mb-4">

                <div class="card">

                    <a href="master.php">

                        <div

                            style="background-image: url('img/101.jpg'); background-size: cover; background-position: center; width:100%; height:200px;">

                        </div>

                        <div class="card-body">

                            <h5 class="card-title">Master Course</h5>

                            <p class="card-text">Join our 1-3 month internship program, featuring a master

                                course to enhance your skills. With expert mentorship and placement assistance,

                                along with certificates, this is a great opportunity to boost your career!</p>

                        </div>

                    </a>

                </div>

            </div>



            <!-- Card 1 -->

            <div class="col-12 col-md-4 mb-4">

                <a href="https://ktumagic.retechnox.in" target="_blank">

                    <div class="card">

                        <div

                            style="background-image: url('img/stdy.jpg'); background-size: cover; background-position: center; width:100%; height:200px;">

                        </div>

                        <div class="card-body">

                            <h5 class="card-title">KTU Study Materials </h5>

                            <p class="card-text">

                                We offer a wide range of KTU

                                materials, including notifications

                                and study resources. Our collection

                                includes notes, presentations, and

                                previous exam questions

                        </div>

                    </div>

                </a>

            </div>



            <div class="col-12 col-md-4 mb-4">

                <a href="https://forms.gle/viQvrCTnkdgmyTb48">

                    <div class="card">

                        <img src="img/2.png" alt="Card Image 5" style="    background-size: cover;

    background-position: center;

    width: 100%;

    height: 200px;">

                        <div class="card-body">

                            <h5 class="card-title">Campus Ambassador </h5>

                            <p class="card-text">

                                Become our Campus Ambassador and earn up to ₹10,000, along with certificates,

                                free internships, and exciting gifts for top performers. This is a great

                                opportunity to gain experience, rewards, and recognition!</p>

                        </div>

                    </div>

                </a>

            </div>



        </div>

    </div>

    <style>

        /* Metrics Section Styling */

        .metrics-section {

            background-color: #132f51;

            padding: 20px 0;

            text-align: center;

            display: flex;

            flex-wrap: wrap;

            justify-content: center;

            align-items: center;

            gap: 20px;

            /* Space between items */

        }



        /* Flexbox for inline arrangement */

        .metrics-section .metric {

            margin: 0 20px;

            /* Space between metrics */

            font-size: 1.5rem;

            font-weight: 700;

            color: #fff;

            text-align: center;

            min-width: 150px;

        }



        /* Count Styling (Bold, Large & Glow Effect) */

        .metric .count {

            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;

            font-size: 3rem;

            font-weight: 900;

            color: #fff;

            padding: 5px 0;

            /* Glow effect */

        }





        .metric .count ::after {

            content: '#';

        }



        /* Responsive Adjustments */

        @media (max-width: 768px) {

            .metrics-section {

                flex-direction: column;

                padding: 10px;

            }



            .metric {

                margin: 10px 0;

            }



            .metric .count {

                font-size: 2.5rem;

            }

        }



        /* Mobile-only style adjustments */

        @media (max-width: 550px) {

            .metric .count {

                font-size: 2rem;

            }

        }



        /* Additional spacing for text under count */

        .metric span+br+span {

            margin-top: 5px;

            display: inline-block;

        }



        .metric .count:after {

            content: "+";

            font-size: inherit;

            /* Matches the size of the numbers */

            margin-left: 2px;

            /* Adjust spacing as needed */

        }

    </style>



    <div class="metrics-section">

        <br> <br>

        <div class="metric">

            <span class="count" data-count="2200">0</span><br><span>CERTIFICATES ISSUED</span>

        </div>

        <div class="metric">

            <span class="count" data-count="400">0</span><br><span>INTERNSHIPS</span>

        </div>

        <div class="metric">

            <span class="count" data-count="150">0</span><br><span>TUITIONS</span>

        </div>

        <div style="height:40px;width:100%"></div>

        <div class="gallery-container">

            <div class="image-track" id="imageTrack">

                <!-- Add your images here -->

                <img src="img/f1.jpg" alt="Image 1">

                <img src="img/f2.jpg" alt="Image 1">

                <img src="img/f3.jpg" alt="Image 1">

                <img src="img/f4.jpg" alt="Image 1">

                <img src="img/f5.jpg" alt="Image 1">

                <img src="img/f6.jpg" alt="Image 1">

                <img src="img/f7.jpg" alt="Image 1">

                <img src="img/f8.jpg" alt="Image 1">

                <img src="img/f9.jpg" alt="Image 1">

                <img src="img/f10.jpg" alt="Image 1">

                <img src="img/f11.jpg" alt="Image 1">

                <img src="img/f12.jpg" alt="Image 1">





            </div>

        </div>

        <br>

    </div>



    <!-- JavaScript to animate counters -->

    <script>

        // Function to animate counters

        function animateCounters() {

            const counters = document.querySelectorAll('.count');

            counters.forEach(counter => {

                const target = +counter.getAttribute('data-count');

                const increment = Math.ceil(target / 100);

                let current = 0;



                const updateCounter = () => {

                    if (current < target) {

                        current += increment;

                        counter.textContent = current > target ? target : current;

                        setTimeout(updateCounter, 10);

                    } else {

                        counter.textContent = target;

                    }

                };



                updateCounter();

            });

        }



        // Intersection Observer to trigger animation on scroll

        document.addEventListener('DOMContentLoaded', () => {

            const options = {

                root: null,

                rootMargin: '0px',

                threshold: 0.5

            };



            const observer = new IntersectionObserver((entries, observer) => {

                entries.forEach(entry => {

                    if (entry.isIntersecting) {

                        animateCounters();

                        observer.unobserve(entry.target);

                    }

                });

            }, options);



            const metricsSection = document.querySelector('.metrics-section');

            observer.observe(metricsSection);

        });

    </script>



    <!-- footer -->

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

    <br><br><br>

    <style>

        .gallery-container {

            position: relative;

            overflow: hidden;

            width: 100%;

            height: 200px;

            /* Adjust height as needed */

            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);

        }



        .image-track {

            display: flex;

            align-items: center;

            height: 100%;

            animation: scroll 20s linear infinite;

        }



        @media (max-width: 768px) {

            .image-track {

                display: flex;

                align-items: center;

                height: 100%;

                animation: scroll 6s linear infinite !important;

            }

        }



        .image-track img {

            height: 100%;

            margin-right: 10px;

            object-fit: cover;

            border-radius: 10px;

        }



        /* Animation */

        @keyframes scroll {

            0% {

                transform: translateX(0);

            }



            100% {

                transform: translateX(-100%);

            }

        }

    </style>

    <script>document.addEventListener('DOMContentLoaded', () => {

            const imageTrack = document.getElementById('imageTrack');



            // Clone images to create a seamless infinite scroll

            const images = Array.from(imageTrack.children);

            images.forEach(image => {

                const clone = image.cloneNode(true);

                imageTrack.appendChild(clone);

            });



            // Adjust the animation duration based on the total number of images

            const totalImages = imageTrack.children.length;

            const animationDuration = 16 * (totalImages / images.length); // 20s base duration

            imageTrack.style.animationDuration = `${animationDuration}s`;

        });

    </script>

    <div class="card-container">

        <!-- Card 1 -->

        <div class="card11">

            <div class="icon-bg">

                <img src="img/timer.png" alt="Icon" class="icon">

            </div>

            <h2 class="card-title">Flexible Timings</h2>

            <p class="card-subtitle">Our real-time professionals helps you to learn any ...</p>

        </div>



        <!-- Card 2 -->

        <div class="card11">

            <div class="icon-bg">

                <img src="img/user.png" alt="Icon" class="icon">

            </div>

            <h2 class="card-title">Full Hands-On-Training

            </h2>

            <p class="card-subtitle">Earn from from anywhere. Utilize your...</p>

        </div>



        <!-- Card 3 -->

        <div class="card11">

            <div class="icon-bg">

                <img src="img/classes.png" alt="Icon" class="icon">

            </div>

            <h2 class="card-title">17000+ Students Last Year </h2>

            <p class="card-subtitle">95% positive feedback. Have a look of...</p>

        </div>



        <!-- Card 4 -->

        <div class="card11">

            <div class="icon-bg">

                <img src="img/money.png" alt="Icon" class="icon">

            </div>

            <h2 class="card-title">Affordable Fees</h2>

            <p class="card-subtitle">No matter what your current issue is...</p>

        </div>



        <!-- Card 5 -->

        <div class="card11">

            <div class="icon-bg">

                <img src="img/user.png" alt="Icon" class="icon">

            </div>

            <h2 class="card-title">Corporate Expert Trainer</h2>

            <p class="card-subtitle">Best certified trainer & real time projects...</p>

        </div>



        <!-- Card 6 -->

        <div class="card11">

            <div class="icon-bg">

                <img src="img/classes.png" alt="Icon" class="icon">

            </div>

            <h2 class="card-title">Updated Syllabus</h2>

            <p class="card-subtitle">Best curriculum designed by industrial expert...</p>

        </div>



        <!-- Card 7 -->

        <div class="card11">

            <div class="icon-bg">

                <img src="img/degree.png" alt="Icon" class="icon">

            </div>

            <h2 class="card-title">Earn Certificates</h2>

            <p class="card-subtitle">Useful for palcements and add it into your CV's</p>

        </div>



        <!-- Card 8 -->

        <div class="card11">

            <div class="icon-bg">

                <img src="img/awards.png" alt="Icon" class="icon">

            </div>

            <h2 class="card-title">Study Material</h2>

            <p class="card-subtitle">Access study materials, Videos, notifications of KTU ...</p>

        </div>

        <br><br><br>

    </div>



    <style>

        .card-container {

            display: grid;

            grid-template-columns: repeat(4, 1fr);

            gap: 17px;

            margin: auto;

        }



        .card11 {

            background-color: white;

            border-radius: 8px;

            padding: 5px;

            padding-bottom: 20px;

            text-align: center;

            position: relative;

        }



        .icon-bg {

            width: 70px;

            height: 70px;

            background-color: #132f51;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            margin: 0 auto;

        }



        .icon {

            width: 35px;

            height: 35px;

        }



        .transparent-image {

            width: 100%;

            height: auto;

            opacity: 0.7;

            margin-top: 10px;

        }



        .card-title {

            font-size: 30px;

            margin: 15px 0 10px;

            color: #333;

        }



        .card-subtitle {

            font-size: 20px;

            font-weight: 500;

            color: #777;

        }



        @media screen and (max-width: 1200px) {

            .card-container {

                grid-template-columns: repeat(3, 1fr);

            }

        }



        @media screen and (max-width: 700px) {

            .card-container {

                grid-template-columns: 1fr;

            }

        }

    </style>

    <section class="interactive-section" style="background-color:white;">



        <h3 style="font-size:18px;color:black;border:none; font-weight:500;">ASSOCIATED INSTITUTE</h3>

        <img src="img/ktupori.png" alt="Company Logo" class="logo" style="margin-top:-30px;">





    </section>

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

                        .navbar1 img {

                            justify-content: center;

                            margin-left: 100%;

                            margin-top: 30%;

                            scale: 6;

                        }



                        @media (max-width: 800px) {

                            .navbar1 img {

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

                        <li><a href="all_work.php">Workshops And events</a></li>

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



    <!-- Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>



</html>