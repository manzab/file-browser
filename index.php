<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File system</title>
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
        }
        tr:nth-of-type(even) {
            background-color: white;
        }
    </style>
</head>

<body>
    <?php
    $dir = $_SERVER['REQUEST_URI'];
    echo "<h1>Directory contents: $dir</h1>" ?>
    <form action="" name="files" method="GET"></form>
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
            if (!isset($_GET['path'])) {
                $dir = getcwd();
                $a = scandir($dir);
                foreach ($a as $val) {
                    if ($val != '.' and $val != '..')
                        if (is_dir($val)) {
                            print("<tr><td>Folder</td><td><a href='?path=$val'>" . $val . "</a></td><td></td></tr>");
                        } else print("<tr><td>File</td><td>" . $val . "</a></td><td></td></tr><br>");
                };
            };
            if (isset($_GET) && $_GET['path'] != "") {
                $current_dir = $_GET['path'];
                chdir($current_dir);
                $dir = getcwd();
                $a = scandir($dir);
                foreach ($a as $val) {
                    if ($val != '.' and $val != '..')
                        if (is_dir($val)) {
                            print("<tr><td>Folder</td><td><a href='?path=$val'>" . $val . "</a></td><td></td></tr>");
                        } else print("<tr><td>File</td><td>" . $val . "</a></td><td></td></tr><br>");
                };
            }
            ?>
        </tbody>
    </table>
</body>

</html>