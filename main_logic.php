<?php $url = $_SERVER['REQUEST_URI'];
echo "<h1>Directory contents: $url</h1>";
?>
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
        //Showing current working directory's files and folders
        if (!isset($_GET['path']) and !isset($_POST['new_dir']) and empty($_POST)) {
            $dir = getcwd();
            $a = scandir($dir);
            displayContents($a);
        };
        //Navigating among folders
        if (isset($_GET) and $_GET['path'] != "") {
            $current_dir = $_GET['path'];
            chdir($current_dir);
            $dir = getcwd();
            $a = scandir($dir);
            foreach ($a as $val) {
                if ($val != '.' and $val != '..')
                    if (is_dir($val)) {
                        print("<tr><td>Folder</td><td><a href='$url/$val'>" . $val . "</a></td><td></td></tr>");
                    } else {
                        print("<tr><td>File</td><td>" . $val . "</td><td><form method='POST'><button type='submit' name='del' value=$val>Delete</button></form>");
                        print('<form action="?path=' . $val . '" method="POST">');
                        print('<button id="dwn" type="submit" name="download" value="' . $val . '">Download</button>');
                        print('</form>');
                        print("</td></tr><br>");
                    }
            };
        }
        //Creating new directory
        if (isset($_POST['new_dir']) and $_POST['new_dir'] != "") {
            $dir = getcwd();
            mkdir($dir . '/' . $_POST['new_dir']);
            header('Location: ' . $_SERVER['REQUEST_URI']);
            $a = scandir($dir);
            displayContents($a);
        };
        // Deleting files
        if (isset($_POST['del'])) {
            $dirc = $_SERVER['REQUEST_URI'];
            $previous_dir = dirname($dirc);
            $file_del =  $_GET['path'] . './' . $_POST['del'];
            // define('ROOTPATH', dirname(dirname(__FILE__)));
            // unlink(ROOTPATH .  "/" . $_GET['path'] . '/' . $_POST['del']);
            // print_r($file_del); 
            unlink($file_del);
            header('Location: ' . $_SERVER['REQUEST_URI']);
            // $dir = getcwd();
            // $a = scandir($dir);
            // displayContents($a);
        }
        ?>
    </tbody>
</table>
<?php
//Back button
$dirc = $_SERVER['REQUEST_URI'];
$previous_dir = dirname($dirc);
print("<button id='bck'><a href='$previous_dir'>BACK</a></button>");
print("<br>"); ?>
<form action="" method="POST" id="upl" enctype="multipart/form-data">
    <input type="file" name="image">
    <input type="submit">
</form>
<?php
print("<br>");
print("<form action=''method='POST'><input type='text' required name='new_dir' id='input' placeholder='Name of new directory'><button id='submit'>Submit</button></form>");
?>
<div class="logout">Click here to <a href="index.php?action=logout"> logout.</div>