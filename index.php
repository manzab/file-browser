<?php

declare(strict_types=1);
function displayContents($x)
{
    foreach ($x as $val) {
        if ($val != '.' and $val != '..')
            if (is_dir($val)) {
                print("<tr><td>Folder</td><td><a href='?path=$val'>" . $val . "</a></td><td></td></tr>");
            } else print("<tr><td>File</td><td>" . $val . "</a></td><td><form method='POST'><input type='submit' name='$val' value='Delete'></form></td></tr><br>");
    };
};
session_start();
// logout logic
if (isset($_GET['action']) and $_GET['action'] == 'logout') {
    session_start();
    unset($_SESSION['username']);
    unset($_SESSION['password']);
    unset($_SESSION['logged_in']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File browser</title>
    <link type="text/css" rel="stylesheet" href="styles.css">
</head>
<body>
    <div>
        <?php
        $err = '';
        if (
            isset($_POST['login'])
            && !empty($_POST['username'])
            && !empty($_POST['password'])
        ) {
            if (
                $_POST['username'] == 'Mantas' &&
                $_POST['password'] == 'qwerty'
            ) {
                $_SESSION['logged_in'] = true;
                $_SESSION['timeout'] = time()+1800;
                $_SESSION['username'] = 'Mantas';
                echo 'You have entered valid use name and password';
            } else {
                $err = 'Wrong username or password';
                echo $err;
            }
        }
        ?>
    </div>
    <div>
        <?php
        if ($_SESSION['logged_in'] == true) {
            require('main_logic.php');
        } else {
        ?>
            <form id="login" action="./index.php" method="post">
                <input type="text" name="username" placeholder="username = Mantas" required></br>
                <input type="password" name="password" placeholder="password = qwerty" required>
                <button type="submit" name="login">Login</button>
            </form>
            <br>
        <?php } ?>
    </div>
</body>

</html>