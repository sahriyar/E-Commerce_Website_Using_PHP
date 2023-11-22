<?php 
    include 'connection.php';
    session_start();

    if (isset($_POST['submit-btn'])){

        $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $email = mysqli_real_escape_string($conn, $filter_email);

        $filter_password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $password = mysqli_real_escape_string($conn, $filter_password);


        $select_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'") or die('query failed');

        if (mysqli_num_rows($select_user) > 0) {
            $row = mysqli_fetch_assoc($select_user);
            if($row['user_type'] == 'admin') {
                $_SESSION['admin_name'] = $row['name'];
                $_SESSION['admin_email'] = $row['email'];
                $_SESSION['admin_id'] = $row['id'];
                header('location:admin.php');
            }else if ($row['user_type'] == 'user') {
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
                header('location:index.php');
            }else{
                $message[] = 'Incorrect email or password';
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <title>User registration Page</title>
</head>
<body>

    <?php 
        if(isset($message)){
            foreach ($message as $message) {
                echo '
                    <div class="message">
                        <span>'.$message.'</span>
                        <i class="bi bi-x-circle" onclick="this.parentElement.remove()"></i>
                    </div>
                ';
            }
        }
    ?>


    <section class="form-container">
        <form action="" method="post">
            <h3>Login now</h3>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="password" placeholder="Enter your Password" required>
            <input type="submit" name="submit-btn" class="btn" value="Login now">
            <p>Do not have an account ? <a href="register.php">Register Now</a></p>
        </form>
    </section>
</body>
</html>