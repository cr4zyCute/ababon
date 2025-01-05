<?php
session_start();
include '../database/dbcon.php';
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $email_check_sql = "SELECT * FROM admin WHERE admin_email = '$email'";
    $email_check_result = mysqli_query($conn, $email_check_sql);

    if (mysqli_num_rows($email_check_result) === 0) {
        $error_message = "Admin does not exist!";
    } else {
        $user = mysqli_fetch_assoc($email_check_result);
        if ($user['admin_password'] === $password) {
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['admin_email'] = $user['admin_email'];

            header('Location: admin-dashboard.php');

            exit();
        } else {
            $error_message = "Wrong password!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>AdminPage</title>
    <link rel="icon" href="../images/bsitlogo.png">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./admin-css/admin-login.css">

</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form action="admin-login.php" method="post">
        <img src="../images/bsitlogo.png" alt="Logo" class="logo">
        <h3>Welcome Admin</h3>
        <section id="formContainer" class="<?= !empty(trim($error_message)) ? 'show' : '' ?>">
            <div class="ring">
                <i style="--clr:#d7dbdd;"></i>
                <i style="--clr:#d7dbdd;"></i>
                <i style="--clr:#d7dbdd;"></i>
                <div class="login">

                    <div class="inputBx">

                        <?php if (!empty($error_message)) : ?>
                            <p style="color: red" id="errorMessage" style="color: white;"><?= $error_message; ?></p>
                        <?php endif; ?>

                        <input type="text" name="email" placeholder="Username" required>
                    </div>
                    <div class="inputBx">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="inputBx">
                        <input type="submit" name="login" value="Log in">
                    </div>
                    <div class="links">
                    </div>
                </div>
            </div>
        </section>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const errorMessage = document.getElementById('errorMessage');
            if (errorMessage) {
                setTimeout(() => {
                    errorMessage.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</body>

</html>