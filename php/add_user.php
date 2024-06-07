<?php require("../parts/globals.php")?>
<?php 
    // Retrieving form data
    $userlogin = $_POST['userlogin'];
    $userpassword = $_POST['userpassword']; // Raw user password
    $useremail = $_POST['useremail'];
    $username = $_POST['username'];
    $usersurname = $_POST['usersurname'];
    
    // Hashing the user password
    $hashed_password = password_hash($userpassword, PASSWORD_DEFAULT);

    // Checking if user login already exists
    $checkuser = mysqli_query($conn, "SELECT * FROM users WHERE userlogin='$userlogin'");
    $row = mysqli_fetch_array($checkuser);
    if (!empty($row['user_id'])){
        echo "Error. Login already exists";
        header('refresh:2, url=../login_form.php');
        exit();
    }

    // Adding new user to the database with the hashed password
    $adduser = mysqli_query($conn, "INSERT INTO users(userlogin, useremail, userpassword, username, usersurname) VALUES('$userlogin', '$useremail', '$hashed_password', '$username', '$usersurname')");
    $checkuser = mysqli_query($conn, "SELECT * FROM users WHERE userlogin='$userlogin'");
    $row = mysqli_fetch_array($checkuser);
    if ($adduser){
        echo "New user added successfully!";
        // Setting session variables
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['userlogin'] = $row['userlogin'];
        header('refresh:2, url=../choosing_form.php');
        exit();
    }
    else{
        echo "Error";
    }
?>