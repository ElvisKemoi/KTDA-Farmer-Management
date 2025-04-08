<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>KTDA Farmer Portal</title>
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
  border-radius : 20px
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
h1{
    font-size: 39px;
}
 

    </style>
</head>
<body>

    <header>
        <h1>KTDA Farmer Portal</h1>
    </header>

    <nav>
        <ul>
            <li class= "button button1"><a href="FarmersView.php">Farmers</a></li>
            <li class= "button button1"><a href="FarmerIssueFertilizer.php">Fertilizer Issuing</a></li>
            <li class= "button button1"><a href="FertilizerRequests.php">Fertilizer Requests</a></li>
            <li class= "button button1"><a href="FarmerLoanRequest.php">Loan Requests</a></li>
            <li class= "button button1"><a href="FarmerProduce.php">My Produce</a></li>
            <li class= "button button1"><a href="FarmerTaskScheduler.php">Task Scheduler</a></li>
            <li class= "button button1"><a href="FarmerQuestionnare.php">Questionnaires</a></li>
            <li class= "button button1"><a href="FarmerViewSchedule.php">View PickUp Schedule</a></li>

        </ul>
    </nav>