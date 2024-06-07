<html>
<head>
    <!-- Linking to Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Importing Fira Sans font -->
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Importing Font Awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Linking to main stylesheet -->
    <link rel="stylesheet" href="styles/mainstyle.css">
</head>
<body>
    <?php require("../parts/globals.php")?>
    <div class="main">
        <?php 
            // Retrieving form data
            $userlogin=$_POST['userlogin'];
            $userpassword=$_POST['userpassword'];
            $useremail=$_POST['useremail'];
            $userstatus=$_POST['userstatus'];
            
            // Checking if user login already exists
            $checkuser = mysqli_query($conn,"SELECT * FROM users WHERE userlogin='$userlogin'");
            $row = mysqli_fetch_array($checkuser);
            if (!empty($row['userID'])){
                echo "Error. Login already exists";
                header('refresh:2, url=../registrationform.php');
                exit();
            }

            // Adding new user to the database
            $adduser = mysqli_query($conn, "INSERT INTO users(userlogin, useremail, userpassword, userstatus) VALUES('$userlogin','$useremail','$userpassword','$userstatus')");
            $checkuser = mysqli_query($conn,"SELECT * FROM users WHERE userlogin='$userlogin'");
            $row = mysqli_fetch_array($checkuser);
            if ($adduser){
                echo "New user added successfully!";
                // Setting session variables
                $_SESSION['userID']=$row['userID'];
                $_SESSION['userlogin']=$row['userlogin'];
                $_SESSION['userstatus']=$row['userstatus'];
                header('refresh:2, url=..\index.php');
                exit();
            }
            else{
                echo "Error";
            }
        ?>
    </div>
</body>
</html>
