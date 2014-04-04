<?php
// Databases - Spring 2014 - Chunyi Lyu
// Programming Assignment 1
// select.php

require('lib.php');

show_html_header('Who are in the club?', 'banner.jpg');

if (!isset($_POST['search'])) {
    show_course_title_form();
}

else {
    $pdo = connect_pdo('sc_db.sq3');
    $name = $_POST['name'];
    if (isset($_POST['advisor'])) {
        $n = 1;
    }
    else {
        $stmt = $pdo->prepare("SELECT advisor FROM clubs WHERE name=:t");
        $stmt->bindValue(':t', $name);
        $stmt->execute();
        $advisors = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        $n = count($advisors);
    }
    if ($n == 1) {
        if (isset($_POST['advisor'])) {
            $advisor = $_POST['advisor'];
        }
        else {
            $advisor = $advisors[0];
        }
        $stmt = $pdo->prepare("SELECT students.full_name, students.id, membership.name as club_name, advisor, year_participate FROM membership, students WHERE membership.advisor=:advisor AND membership.name=:name AND students.id=membership.student_id");
        $stmt->bindValue(':advisor', $advisor);
        $stmt->bindValue(':name', $name);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h3>Here are the students who are in the club $name (advised by $advisor)</h3>";
        show_table($rows);
    }

    else if ($n == 0) {
        echo <<<END_NO_COURSES_FOUND
<p>
  No club found as name "$name" were found. Try another name.
</p>
END_NO_COURSES_FOUND;
        show_course_title_form();
    }

    else {
            echo <<<END_MULTIPLE_FOUND
<p>
More than one club with name "$name" found.
Select a advisor to specify the club uniquely.
</p>

END_MULTIPLE_FOUND;
            show_teacher_form($name, $advisors);
    }
}


show_html_footer();



function show_course_title_form() {
    $action = $_SERVER['PHP_SELF'];
    echo <<<END_SELECT_FORM
<h4>search a club by its name</h4>

<form action="$action" method="POST">
<p>Club name: <input type="text" name="name"></p>
<p><input type="submit" name="search" value="show the table"></p>
</form>
END_SELECT_FORM;
}



function show_teacher_form($name, $advisors) {
    $action = $_SERVER['PHP_SELF'];
    echo <<<END_TEACHER_FORM_0

<form action="$action" method="POST">

END_TEACHER_FORM_0;
    echo generate_html_select_menu('advisor', $advisors);
    echo <<<END_TEACHER_FORM_1

<input type="hidden" name="name" value="$name">
<input type="submit" name="search" value="go">
</form>

END_TEACHER_FORM_1;
}


?>




?>