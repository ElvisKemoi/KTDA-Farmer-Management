<?php
require_once("auth.php");
authorizeRole('clerk');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KTDA Clerk Portal</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <style>
        .button {
            background-color: #4CAF50;
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

        .success {
        color: green;
        font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }
    </style>
    <style>
    form {
        width: 50%;
        margin: auto;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    label {
        font-weight: bold;
    }

    select, input[type="number"], input[type="submit"] {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        margin-bottom: 15px;
    }
</style>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <header>
        <h1>KTDA Clerk Portal</h1>
    </header>

    <nav>
        <ul>
            <li class= "button button1"><a href="ClerkDashboard.php">Farmers</a></li>
            <li class= "button button1"><a href="ClerkProduceRecord.php">Produce Record</a></li>
            <li class= "button button1"><a href="ClerkAddProduce.php">Add Produce</a></li>
        </ul>
    </nav>
