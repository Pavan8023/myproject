<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

        body{
            background: linear-gradient(0deg, #d2ecb0, #dcffba, transparent);
        }

        .form {
            display: flex;
            align-items: center;
            box-shadow: 0px 0px 9px 6px rgb(0 0 0 / 50%);
            height: 78vh;
            width: 60%;
            padding: 20px;
            flex-direction: column;
            margin: auto;
            margin-top: 30px;
            margin-bottom: 13px;
        }
        
        .box:hover {
            background-color: rgb(137, 237, 237);
            color: black;
        }
        
        .btn:hover {
            background-color: rgb(98, 196, 231);
            color: black;
        }
        
        .btn1:hover {
            background-color: rgb(98, 196, 231);
            color: black;
        }
        
        .box {
            width: 80%;
            padding: 10px;
            margin-top: 20px;
            box-shadow: 0px 0px 8px 1px rgb(97 79 30 / 50%);
            border-radius: 7px;
        }
        
        .btn {
            padding: 5px;
            border-radius: 5px;
            width: 15%;
            margin-top: 20px;
        }
        
        .btn1 {
            padding: 5px;
            border-radius: 5px;
            width: 15%;
            margin-top: 20px;
            margin-left: 10px;
        }
        
        span {
            width: 83%;
            margin-top: 100px;
        }
        
        h1 {
            font-family: cursive;
            font-weight: bold;
        }
        h2 {
            font-size: 30px;
            font-family: cursive;
            font-weight: bold;
            text-align: center;
        }
        a,p { 
            font-size: 20px;
            font-family: cursive;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>ELECTROTECH SOFTWARE AUTOMATION</h2>
    <form action="#" method="POST" id="form" class="form">
        <h1>Registration Form</h1>
        <input type="text" name="name" class="box" id="name" for="name" placeholder="enter your name">
        <input type="email" name="email" class="box" id="email" for="email" placeholder="enter your email">
        <input type="number" name="number" class="box" id="number" for="number" placeholder="enter your number">
        <input type="password" name="password" class="box" id="password" for="password" placeholder="enter your password">
        <span>
        <input type="submit" id="button" class="btn" value="submit">
        <input type="reset" class="btn1"  value="clear">

        </span>
    </form>

    <script type="text/javascript"
    src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>

    <script type="text/javascript">
    emailjs.init('iJY93j6ExbugsXv6b')
    </script>

    <script>
        const btn = document.getElementById('button');

        document.getElementById('form').addEventListener('submit', function(event) {
                event.preventDefault();

                btn.value = 'Sending...';

                const serviceID = 'service_fr74nga';
                const templateID = 'template_m3ogbmb';

                emailjs.sendForm(serviceID, templateID, this).then(() => {
                        btn.value = 'submit';
                        alert('Sent!');}, 
                        (err) => {
                        btn.value = 'submit';
                        alert(JSON.stringify(err));
                    });
            });
    </script>

</body>

</html>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "electrotech";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the submitted data and trim white spaces
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $calling_number = trim($_POST['number']); // Changed to match your form field name
    $user_password = trim($_POST['password']); // Changed to match your form field name
    
    // Check if the fields are not empty
    if (!empty($name) && !empty($email) && !empty($calling_number) && !empty($user_password)) {

        // Query to check if email, calling number, or password already exists
        $check_sql = "SELECT * FROM `info` WHERE email='$email' OR number='$calling_number' OR password='$user_password'";
        $check_result = $conn->query($check_sql);

        // Check if query execution was successful
        if ($check_result === false) {
            die("Error in SQL query: " . $conn->error); // Output the SQL error
        }

        // If query was successful, proceed to check num_rows
        if ($check_result->num_rows == 0) {
            // Insert data into the database
            $sql = "INSERT INTO `info` (name, email, number, password) 
                    VALUES ('$name', '$email', '$calling_number', '$user_password')";

            if ($conn->query($sql) === TRUE) {
                // Redirect to avoid duplicate insert on refresh
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Error: Email, Number, or Password already exists!";
        }
    } else {
        echo "Error: All fields are required!";
    }
}

        
                    
$conn->close();
?>