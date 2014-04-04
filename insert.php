<?php

// Databases - Spring 2014 - Chunyi Lyu
// Programming Assignment 1
// insert.php

require('lib.php');


show_html_header('Insertion', 'banner.jpg');

$pdo = connect_pdo('sc_db.sq3');


if (!isset($_POST['insert'])) {
    $q = <<<STUDENT_QUERY
SELECT id, full_name 
FROM students
ORDER BY full_name, id
STUDENT_QUERY;
    $s = $pdo->prepare($q);
    $s->execute();
    $rows = $s->fetchAll(PDO::FETCH_ASSOC);
    $students = array();
    foreach ($rows as $row) {
        $id = $row['id'];
        $full_name = $row['full_name'];
        $students[$id] = "$full_name ($id)";
    }
    $q = <<<CLUB_QUERY
SELECT name, advisor
FROM clubs
ORDER BY name, advisor
CLUB_QUERY;
    $s = $pdo->prepare($q);
    $s->execute();
    $rows = $s->fetchAll(PDO::FETCH_ASSOC);
    $courses = array();
    foreach ($rows as $row) {
        $name = $row['name'];
        $advisor = $row['advisor'];
        $key = "name=$name&advisor=$advisor";
        $clubs[$key] = "$name ($advisor)";
    }
    show_add_student_form($students, $clubs);
}


else {
    $student_id = $_POST['student_id'];
    $name_advisor = $_POST['name_advisor'];
    $year_participate = $_POST['year_participate'];
    parse_str($name_advisor);
    $q = <<<CHECK_QUERY
SELECT COUNT(*) 
FROM membership
WHERE student_id=:student_id AND name=:name AND advisor=:advisor
CHECK_QUERY;
    $s = $pdo->prepare($q);
    $s->bindValue('student_id', $student_id);
    $s->bindValue('name', $name);
    $s->bindValue('advisor', $advisor);
    $s->execute();
    $n = $s->fetchColumn();
    if ($n > 0) {
        echo <<<END_ALREADY_ENROLLED
<p>That student has already join the club!</p>
END_ALREADY_ENROLLED;
    }

    else {     
        $s = $pdo->prepare("INSERT INTO membership (name, advisor, student_id, year_participate) VALUES (:name, :advisor, :student_id, :year_participate)");
        $s->bindValue('name', $name);
        $s->bindValue('advisor', $advisor);
        $s->bindValue('year_participate', $year_participate);
        $s->bindValue('student_id', $student_id);
        $s->execute();
        if ($s->errorCode() === "00000") {
            echo <<<END_SUCCESS
<p>The student has successfully been enrolled.</p>
END_SUCCESS;
        }
        else {
            die("Fatal error: Insert query failed.");
        }
        
    }
}


show_html_footer();



// -----------------------------------------------
// HTML generation functions specific to this page
// -----------------------------------------------

function show_add_student_form($students, $clubs) {
    $action = $_SERVER['PHP_SELF'];
    echo <<<END_INSERT_FORM_0
<h2>Someone just joined the club! </h2>

<form action="$action" method="POST">
<p>Add student 
END_INSERT_FORM_0;

    echo generate_html_select_from_assoc('student_id', $students);

    echo " to club ";

    echo generate_html_select_from_assoc('name_advisor', $clubs);


    echo <<<END_INSERT_FORM_1

<p>Club year_participate: <input type="text" name="year_participate"></p>

END_INSERT_FORM_1;
    
    echo <<<END

<p><input type="submit" name="insert" value="add studnet to the club"></p>
</form>

END;
}


?>