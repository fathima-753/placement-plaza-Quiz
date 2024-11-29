<?php
session_start();
include("db1.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  
    if (!empty($_POST['id']) && !empty($_POST['category']) && !empty($_POST['Exam_time_in_Mins'])) {
        $id = mysqli_real_escape_string($con, $_POST['id']);
        $category = mysqli_real_escape_string($con, $_POST['category']);
        $exam_time_in_mins = mysqli_real_escape_string($con, $_POST['Exam_time_in_Mins']);

        $query = "INSERT INTO quiz (id, category, Exam_time_in_Mins) VALUES ('$id', '$category', '$exam_time_in_mins')";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<script>alert('Exam added successfully');</script>";
        } else {
            echo "<script>alert('Failed to add exam');</script>";
        }
    } else {
        echo "<script>alert('Please fill in all required fields');</script>";
    }
}
$quiz_time_limit = 0;
$query = "SELECT Exam_time_in_Mins FROM quiz ";
$result = mysqli_query($con, $query);
if ($row = mysqli_fetch_assoc($result)) {
    $quiz_time_limit = $row['Exam_time_in_Mins'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Placement plaza</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f2f2f2;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
}

.quiz-form {
    margin-bottom: 20px;
}

.quiz-question {
    margin-bottom: 10px;
}

.quiz-options label {
    display: block;
    margin-bottom: 5px;
}

.timer {
    text-align: center;
    font-size: 20px;
    margin-bottom: 20px;
}

.btn-submit {
    background-color: #4caf50;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: block;
    margin: 0 auto;
}

.btn-submit:hover {
    background-color: #45a049;
}
.menu{
  display: flex;
}
.menu li{
  list-style: none;
  margin: 0 20px;
}
.menu li:hover{
    transition: 0.5s;
    border-radius: 7px;
    background-color:skyblue;
}
.menu li a{
  color:green;
  font-size: 27px;
  text-decoration: none;
  
}
</style>
<script>
window.onload = function() {
    var timerStarted = false;
    var timeLeft = <?php echo $quiz_time_limit * 60; ?>; 
    var timer = document.getElementById('timer');
    var countdown;
    document.getElementById('startButton').addEventListener('click', function() {
        timerStarted = true;
        countdown = setInterval(function() {
            if (timerStarted) {
                var minutes = Math.floor(timeLeft / 60);
                var seconds = timeLeft % 60;

                timer.innerHTML = minutes + 'm : ' + seconds + 's';

                timeLeft--;

                if (timeLeft < 0) {
                    clearInterval(countdown);
                    timer.innerHTML = 'Time is up!';
                    
                }
            }
        }, 1000);
    });
};
</script>
</head>
<body>
<ul class="menu">  
                    <li><a href="student_login.php">Logout</a></li> 
                    <li><a href="s1.php">Student Dashboard</a></li> 

            </ul>
<div class="container">
    <h1>Take Quiz</h1>
    <button id="startButton">Start Quiz</button>
    <div class="timer">Time Left: <span id="timer"><?php echo $quiz_time_limit; ?>m : 0s</span></div>
    <form class="quiz-form" action="results.php" method="POST">
        <?php
       include("db1.php");
        $sql = "SELECT * FROM questions";
        $result = mysqli_query($con, $sql);

        $question_number = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="quiz-question">';
            echo '<p>Question ' . $question_number . ': ' . $row['question'] . '</p>';
            echo '<div class="quiz-options">';
            echo '<input type="hidden" name="question_id[]" value="' . $row['id'] . '">';
            echo '<input type="radio" name="answer[' . $row['id'] . ']" value="option1">' . $row['option1'] . '<br>';
            echo '<input type="radio" name="answer[' . $row['id'] . ']" value="option2">' . $row['option2'] . '<br>';
            echo '<input type="radio" name="answer[' . $row['id'] . ']" value="option3">' . $row['option3'] . '<br>';
            echo '<input type="radio" name="answer[' . $row['id'] . ']" value="option4">' . $row['option4'] . '<br>';
            echo '</div>'; 
            echo '</div>'; 
            $question_number++;
        }
        mysqli_close($con);
        ?>
        
        <button type="submit" class="btn-submit">Submit Quiz</button>
    </form>
</div>
</body>
</html>
