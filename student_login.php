<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="proj.css">
    <title>Login Form</title>
    <style>
        body {
            background-image: url(bg1.png);
        }
    </style>
</head>
<body>
    <div class="login">
        <h1>Student Login</h1>
        <form method="POST" action="valid.php">

            <label>Student ID</label>
            <input type="text" name="studentId" required id="studentId">
            <label>Password</label>
            <input type="password" name="password" required id="password">
            <button type="submit" name="submit">Submit</button>
            <p class="profile-options">Don't have an account? <a href="student_reg.php">Sign up</a></p>
        </form>
    </div>
</body>
</html>


