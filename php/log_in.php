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
    <link rel="stylesheet" href="../styles/main.css">
</head>
<body>
    <?php require("../parts/globals.php")?>
    <div class="main">
    <?php 
            // Retrieving form data
            $userlogin=$_POST['userlogin'];
            $userpassword=$_POST['userpassword'];
            
            // Checking if user exists
            $searchuser=mysqli_query($conn, "SELECT * FROM users WHERE userlogin='$userlogin'");
            if(!$searchuser){
                echo "User doesn't exist";
                header("refresh:2, url=../onaypqu/index.php");
                exit();
            }
            $row = mysqli_fetch_array($searchuser);
            
            // Checking if password matches
            if($userpassword==$row['userpassword']){
                echo "You are entered to the system successfully";
                // Setting session variables
                $_SESSION['userID']=$row['userID'];
                $_SESSION['userlogin']=$row['userlogin'];
                $_SESSION['userstatus']=$row['userstatus'];
                header("refresh:2, url=../index.php");
                exit();
            };
        ?>
    </div>
</body>
</html>
