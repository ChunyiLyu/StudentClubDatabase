<?php
// Databases - Spring 2014 - Chunyi
// Programming Assignment 1
// lib.php
// a library of functions common to the PHP/SQLite example



function connect_pdo($db_name) {
    $root = $_SERVER['DOCUMENT_ROOT'];
    $filename = "$root/$db_name";
    if (file_exists($filename)) {
        return new PDO("sqlite:$filename", null, null, 
                       array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    }
    die("Fatal error: unable to connect to database '$db_name'");
}



function show_html_header($title, $img) {
    echo <<<END_HTML_HEADER
<!DOCTYPE html>
<html>
<head>
  <title>Databases: PHP/SQLite - $title</title>
  <link type="text/css" rel="stylesheet" href="basic.css"/>
  <img src= $img/>
</head>

<body>
  <h2>$title</h2>
  <hr/>
END_HTML_HEADER;
}



function show_html_footer() {
    echo <<<END_HTML_FOOTER

<hr/>
        <p align="center"><a href="main.php">main menu</a> &nbsp;</p>

</body>
</html>
END_HTML_FOOTER;
}



function generate_html_select_menu($name, $items) {
    $s = "<select name=\"$name\">\n";
    foreach ($items as $item) {
        $s .= "  <option value=\"$item\">$item</option>\n";
    }
    $s .= "</select>\n";
    return $s;
}



function generate_html_select_from_assoc($name, $items) {
    $s = "<select name=\"$name\">\n";
    foreach ($items as $k => $v) {
        $s .= "  <option value=\"$k\">$v</option>\n";
    }
    $s .= "</select>\n";
    return $s;
}



function show_table($rows) {
    echo "<table border=\"1\">\n";
    echo "<tr>\n";
    foreach ($rows[0] as $c => $x) {
        echo "<th>$c</th>\n";
    }
    echo "</tr>\n";
    foreach ($rows as $row) {
        echo "<tr>\n";
        foreach ($row as $value) {
            echo "<td>$value</td>\n";
        }
        echo "</tr>\n";
    }
    echo '</table>';
}


?>
