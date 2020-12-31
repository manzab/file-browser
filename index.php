<?php

declare(strict_types=1);
// file download logic
if (isset($_POST['download'])) {
    $file = './' . $_POST['download'];
    $fileToDownloadEscaped = str_replace("&nbsp;", " ", htmlentities($file, 0, 'utf-8'));
    ob_clean();
    ob_start();
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf'); // mime type → ši forma turėtų veikti daugumai failų, su šiuo mime type. Jei neveiktų reiktų daryti sudėtingesnę logiką
    header('Content-Disposition: attachment; filename=' . basename($fileToDownloadEscaped));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileToDownloadEscaped)); // kiek baitų browseriui laukti, jei 0 - failas neveiks nors bus sukurtas
    ob_end_flush();
    readfile($fileToDownloadEscaped);
    exit;
}
// file upload logic
if (isset($_FILES['image'])) {
    $errors = array();

    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];

    // check extension (and only permit jpegs, jpgs and pngs)
    $file_ext = strtolower(end(explode('.', $_FILES['image']['name'])));
    $extensions = array("jpeg", "jpg", "png");
    if (in_array($file_ext, $extensions) === false) {
        $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
    }
    if ($file_size > 2097152) {
        $errors[] = 'File size must be less than 2 MB';
    }
    if (empty($errors) == true) {
        move_uploaded_file($file_tmp, $_GET['path'] . "./" . $file_name);
        header('Location: ' . $_SERVER['REQUEST_URI']);
    } else {
        print_r($errors[0]);
    }
}
// main function for displaying files and directories
function displayContents($x)
{
    foreach ($x as $val) {
        if ($val != '.' and $val != '..' and $val != '.git') {
            if (is_dir($val)) {
                print("<tr><td>Folder</td><td><a href='?path=$val'>" . $val . "</a></td><td></td></tr>");
            } else {
                print("<tr><td>File</td><td>" . $val . "</td><td><form method='POST'><button type='submit' name='del' value=$val>Delete</button></form>");
                print('<form action="?path=' . $val . '" method="POST">');
                print('<button id="dwn" type="submit" name="download" value="' . $val . '">Download</button>');
                print('</form>');
                print("</td></tr><br>");
            }
        }
    };
}

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
                $_SESSION['timeout'] = time();
                $_SESSION['username'] = 'Mantas';
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