<?php
require_once("auth.php");
authorizeRole('officer');
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KTDA Farmer Management</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <style>
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 3px 6px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 18px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
            border-radius: 20px;
        }

        .button1 {
            background-color: white;
            color: black;
            border: 2px solid #4CAF50;
            border-radius: 20px;
        }

        .button1:hover {
            background-color: #4CAF50;
        }

        ul li a {
            padding: 0 10px;
            display: inline-block;
            text-decoration: none;
            color: black;
        }

        h1 {
            font-size: 39px;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>

    <header >
        <h1>KTDA Farmer Management</h1>
    </header>

    <nav>
        <ul>
            <li class= "button button1"><a href="Farmers.php">Farmers</a></li>
            <li class= "button button1"><a href="Cultivations.php">Cultivations</a></li>
            <li class= "button button1"><a href="IssueFertilizer.php">Fertilizer Issuing</a></li>
            <li class= "button button1"><a href="ViewStock.php">View Stock</a></li>
            <li class= "button button1"><a href="Produce.php">View Produce</a></li>
            <li class= "button button1"><a href="AdminQuestionare.php">QuestionnaireTemplates</a></li>
            <li class= "button button1"><a href="FarmerPickUpSchedule.php">Set Pickup Schedule</a></li>

            <!--            
            <li><a href="about-us.php">About Us</a></li>
            <li><a href="contact-us.php">Contact Us</a></li>
            <li><a href="services.php">Services</a></li>
            -->
        </ul>
    </nav>