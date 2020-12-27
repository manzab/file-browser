<?php

declare(strict_types=1) ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File browser</title>
    <style>
        h1 {
            margin-left: 5vw;
        }

        table {
            width: 90vw;
            margin: auto;
            background-color: #f4f1de;
            border-collapse: collapse;
        }

        th {
            font-size: 1.5em;
            background-color: #81b29a;
            border: 2px solid #81b29a;
        }

        td {
            font-size: 1.5em;
            text-align: center;
            height: 1.5em;
            width: calc(100% / 3);
        }

        tr:nth-of-type(even) {
            background-color: white;
        }

        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        button {
            margin-left: 5vw;
            margin-top: 1vw;
            width: 15vw;
            padding: .25vw;
        }

        #submit {
            width: 6vw;
            margin-left: 0;
            padding: 0;
            height: 2.1vh;
        }

        #input {
            margin-left: 5vw;
        }
    </style>
</head>

<body>
    <?php
    $url = $_SERVER['REQUEST_URI'];
    echo "<h1>Directory contents: $url</h1>" ?>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!isset($_GET['path']) and !isset($_POST['new_dir'])) {
                $dir = getcwd();
                $a = scandir($dir);
                foreach ($a as $val) {
                    if ($val != '.' and $val != '..')
                        if (is_dir($val)) {
                            print("<tr><td>Folder</td><td><a href='?path=$val'>" . $val . "</a></td><td></td></tr>");
                        } else print("<tr><td>File</td><td>" . $val . "</a></td><td><form method='POST'><input type='submit' name='delete' value='Delete'></form></td></tr><br>");
                };
            };
            if (isset($_GET) and $_GET['path'] != "") {
                $current_dir = $_GET['path'];
                chdir($current_dir);
                $dir = getcwd();
                $a = scandir($dir);
                foreach ($a as $val) {
                    if ($val != '.' and $val != '..')
                        if (is_dir($val)) {
                            print("<tr><td>Folder</td><td><a href='$url/$val'>" . $val . "</a></td><td></td></tr>");
                        } else print("<tr><td>File</td><td>" . $val . "</a></td><td><form method='POST'><input type='submit' name= $val value='Delete'></form></td></tr><br>");
                };
            }
            if (isset($_POST['new_dir']) and $_POST['new_dir'] != "") {
                $dir = getcwd();
                mkdir($dir . '/' . $_POST['new_dir']);
                $a = scandir($dir);
                foreach ($a as $val) {
                    if ($val != '.' and $val != '..')
                        if (is_dir($val)) {
                            print("<tr><td>Folder</td><td><a href='?path=$val'>" . $val . "</a></td><td></td></tr>");
                        } else print("<tr><td>File</td><td>" . $val . "</a></td><td><form method='POST'><input type='submit' name='delete' value='Delete'></form></td></tr><br>");
                };
            };
            if (isset($_POST["'" . $val . "'"])) unlink($val);


            ?>
        </tbody>
    </table>
    <?php
    $dirc = $_SERVER['REQUEST_URI'];
    $previous_dir = dirname($dirc);
    print("<button><a href='$previous_dir'>BACK</a></button>");
    print("<br>");
    print("<form action=''method='POST'><input type='text' name='new_dir' id='input' placeholder='Name of new directory'><button id='submit'>Submit</button></form>");
    ?>
</body>

</html>