<?php require("../parts/globals.php")?>
<?php 
    // Retrieving form data
    $userlogin = $_POST['userlogin'];
    $userpassword = $_POST['userpassword'];
    
    // Checking if user exists
    $searchuser = mysqli_query($conn, "SELECT * FROM users WHERE userlogin='$userlogin'");
    if(!$searchuser || mysqli_num_rows($searchuser) == 0){
        echo "User doesn't exist";
        header("refresh:2, url=../login_form.php");
        exit();
    }
    $row = mysqli_fetch_array($searchuser);
    
    // Checking if password matches
    if(password_verify($userpassword, $row['userpassword'])){
        echo "You are entered to the system successfully";
        // Setting session variables
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['userlogin'] = $row['userlogin'];
        header("refresh:2, url=../index.php");
        exit();
    } else {
        echo "Invalid login or password";
        header("refresh:2, url=../login_form.php");
        exit();
    }
?>
