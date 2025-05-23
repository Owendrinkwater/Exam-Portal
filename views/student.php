<!-- TODO: Check if questions exist for an exam  -->

<!-- TODO: Display exam only if it doesn't have a result -->


<?php
// session_start();

include "helpers/timeout.php"; // Handle the session timeout after inactivity

ini_set("display_errors", 1);
$username = $_SESSION["username"];

$queryResult = mysqli_query($conn, "SELECT * FROM Student WHERE username='$username' LIMIT 1");
$studentObj = mysqli_fetch_object($queryResult);

$examResults = mysqli_query($conn, "SELECT * from Student_Result WHERE studentId='$username'");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student</title>

    <link rel="stylesheet" href="../assets/css/admin.css">
    <link rel="stylesheet" href="../assets/css/student.css">
     <style>
            @import url('https://fonts.googleapis.com/css?family=Patua+One|Be+Vietnam&display=swap');
* {
    box-sizing: border-box;
}

body {
    font-family: 'Be Vietnam', sans-serif;
}

.wrapper {
    display: flex;
    width: 100%;
}

.sidebar-header {
    font-family: 'Patua One', Verdana, Geneva, Tahoma, sans-serif;
    font-size: 1.8em;
    font-weight: 600;
    text-align: center;
    color: #fffdd0;
    margin: 2em;
}

#sidebar {
    width: 300px;
    background-color: #800000;
    height: 100vh;
    overflow-y: scroll;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 999;
    transition: all 0.3s;
}

#sidebar.active {
    margin-left: -300px;
}

.components {
    margin: 20px auto 50px;
}

.components a:hover, .components .active a {
    background-color: #FFEFD5;
    color: black;
}

.components a {
    font-size: 1.2em;
    color: white;
    display: block;
    padding: 1em;
}

.components a:hover {
    text-decoration: none;
}

.btn.logout {
    width: 50%;
}

.btn.logout:hover {
    background-color: rgb(255, 189, 89, 0.8);
}

.btn.logout a {
    text-decoration: none;
    color: black;
}

.menu {
    width: 40px;
}

main {
    background-color: #FFE4C4;
    width: calc(100% - 300px);
    padding: 10px 30px;
    position: absolute;
    top: 0;
    right: 0;
    min-height: 100vh;
}

main.active {
    width: 100%;
}

main .tab-content {
    display: none;
    margin: 20px auto;
}

main .tab-content.show {
    display: block;
}

.home {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.home .avatar {
    width: 200px;
    width: 200px;
}

.home .welcome-message {
    font-family: 'Patua One', Verdana, Geneva, Tahoma, sans-serif;
    color: #218380;
    font-size: 2.5em;
    font-weight: 500;
}

.home .time {
    margin: 5px;
    font-size: 1.5em;
}

.tab-content:not(:first-of-type) header {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px #ddd solid;
    padding-bottom: 10px;
    height: 100%;
}

.tab-content:not(:first-of-type) h1 {
    font-weight: 500;
    font-size: 2em;
}

header .left>* {
    vertical-align: middle;
}

.tab-content:not(:first-of-type) header form, header .left>*, button.add-users {
    display: inline-block;
}

.tab-content:not(:first-of-type) .search input[type=text] {
    background: url(../images/magnifying-glass.svg) no-repeat 10px 10px;
    background-size: 1em 1em;
    width: 150px;
    border: 1px solid #218380;
    padding: 0.3em 1em 0.3em 2.3em;
    border-radius: 20px;
    transition: all 0.7s ease 0s;
    font-size: 0.9em;
}

.tab-content:not(:first-of-type) .search input[type=text] {
    width: 220px;
}

.tab-content:not(:first-of-type) button.add {
    background: url(../images/plus.svg) 5px 4px no-repeat;
    background-size: 1.5em 1.5em;
    padding: 0.3em 1em 0.3em 2.3em;
    margin: 0 1em;
    border-radius: 15px;
    font-size: 0.8em;
    font-weight: 600;
    color: white;
    background-color: #218380;
    border: 2px solid #218380;
    text-transform: capitalize;
    cursor: pointer;
}

.user-image {
    width: 40px;
    border-radius: 50%;
}

img.user-action, .menu {
    width: 40px;
    padding: 5px;
    cursor: pointer;
    margin: 20px 10px 0px;
    display: none;
}

.modal-body {
    padding: 40px;
}

.modal .btn-save {
    background-color: #218380;
    color: white;
}

@media (max-width: 768px) {
    #sidebar {
        margin-left: -300px;
    }
    #sidebar.active {
        margin-left: 0;
    }
    main {
        width: 100%;
    }
    img.user-action, .menu {
        display: block;
    }
}

.results {
    text-align: center;
}

.show .tab-flex-cont {
    min-height: calc(90vh - 45px);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* This is a name you want to change later */

.actual-tab-content {
    width: 100%;
}

.tab-content div:nth-last-of-type(2) {
    flex: 1;
}

.exam-item, .result-item {
    background-color: white;
    min-height: 80px;
    height: auto;
    margin: 15px auto;
    width: 90%;
    display: flex;
    justify-content: space-between;
}

.exam-item>*, .result-item>* {
    padding: 0 10px;
}

.exam-item .course-code, .result-item .course-code {
    color: white;
    font-size: 1.2em;
    font-weight: 500;
    text-align: center;
    width: 100px;
    line-height: 80px;
    vertical-align: middle;
}

.exam-item:nth-of-type(odd) .course-code, .result-cont:nth-of-type(odd) .course-code {
    background-color: #218380;
}

.exam-item:nth-of-type(even) .course-code, .result-cont:nth-of-type(even) .course-code {
    background-color: #D49E4E;
}

.exam-item .course-name, .result-item .course-name {
    flex-grow: 3;
    font-size: 1.6em;
}

.start-exam {
    background-color: white;
    border: none;
    color: green;
    cursor: pointer;
}

.start-exam:hover {
    background-color: green;
    color: white;
}

.start-exam span {
    font-size: 1.2em;
    margin: 0 4px;
}

.result-cont {
    margin: 20px auto;
}

.result-item {
    box-shadow: 1px 1px 2px 1px #ccc;
    min-height: 40px;
    cursor: pointer;
    margin: 20px auto 0;
}

.result-item:hover {
    box-shadow: 1px 1px 2px 1.3px #bbb;
}

.result-item .course-name {
    margin: 3px 0 5px;
}

.result-item .collapse-icon {
    font-size: 1.4em;
    vertical-align: middle;
}

.result-item .course-code {
    line-height: 40px;
}

.result-details {
    width: 90%;
    background-color: #ece7df;
    margin: 0 auto 20px;
    padding: 20px;
    text-align: right;
}
     </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar and Navigation-->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h1> ST <br> Paul's <br> University </h1>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#home" data-tab="home"> Home </a>
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                </li>

                <li>
                    <a href="#exams" data-tab="exams">
                        Exams <span class="notification"> <span>
                    </a>
                </li>

                <li>
                    <a href="#results" data-tab="results">
                        Results <span class="notification">
                    </a>
                </li>
            </ul>

            <div class="logout-section text-center">
            <button style="background-color: cream; width: 6em;"> <a href="helpers/logout.php" style="margin: 5px; color:black;"> Logout </a> </button>
            </div>

        </nav>

        <!-- Main Content-->
        <main>
            <div class="menu-cont">
                <i> <img src="../assets/images/menu-icon.svg" class="menu" alt="menu"></i>
            </div>
            <!-- Home Tab -->
            <section class="tab-content home show" id="home">
                <div class="tab-flex-cont">
                    <div class="actual-tab-content">
                        <!-- <img class="rounded-circle avatar" src="assets/images/student_female_3.jpg" -->
                        <img class="rounded-circle avatar" src="assets<?php echo $studentObj->imageUrl ?>"
                            alt="Student avatar">
                        <h1 class="welcome-message">
                            <span class="greeting"> Good day,</span>
                            <br>
                            <?php echo $studentObj->firstName . " " . $studentObj->lastName ?>
                        </h1>
                        <p class="time"> </p>
                    </div>
                </div>
            </section>

            <!-- Exams Tab  -->
            <section class="tab-content exams" id="exams">
                <div class="tab-flex-cont">
                    <div class="actual-tab-content">

                        <?php
$sql = "
    SELECT examId, timeDuration, courseCode, courseTitle
    FROM Course_Student cs, Course c, Exam e
    WHERE cs.username='$username' and c.courseId=e.courseId and cs.courseId=c.courseId
    ";

$queryResult = mysqli_query($conn, $sql);
if (mysqli_num_rows($queryResult) == 0) {
    echo "<h3 style='text-align:center'> You have no pending exams. </h3>";

    mysqli_data_seek($queryResult, 0);
} else {
    $i = 0;
    while ($info = mysqli_fetch_assoc($queryResult)) {
        ?>
                        <!-- Print each pending exam -->
                        <div class="exam-item">
                            <span class="course-code"><?php echo $info['courseCode'] ?> </span>
                            <div>
                                <p class="course-name">
                                    <?php echo $info['courseTitle']; ?> </p>
                                <span class="duration"> Duration: <?php echo $info['timeDuration']; ?>
                                </span>
                            </div>
                            <button class="start-exam"
                                onclick="window.location.href='views/take-exam.php?examid=<?php echo $info['examId']; ?>'">
                                Start Exam <span> &#x25b6; </span>
                            </button>
                            <div>
                            </div>
                        </div>

                        <?php
}}
;
?>



                    </div>
                </div>
            </section>


            <!-- Show Results Tab  -->
            <section class="tab-content results" id="results">
                <div class="tab-flex-cont">
                    <div class="actual-tab-content">
                        <?php
if (mysqli_num_rows($examResults) == 0) {
    echo "<h3> You have no results yet. </h3>";
    echo "<p> Start by taking an exam. </p> ";

    mysqli_data_seek($examResults, 0);
} else {
    $i = 0;

    while ($examResult = mysqli_fetch_assoc($examResults)) {
        $sql = "SELECT c.courseCode, c.courseTitle FROM Exam e, Course c WHERE e.examId = " . $examResult['examId'] . " and e.courseId = c.courseId";
        $result = mysqli_query($conn, $sql);
        $i++;

        while ($row = mysqli_fetch_assoc($result)) {
            ?>

                        <!-- Show each result -->
                        <section class="result-cont">
                            <div class="result-item" data-toggle="collapse" data-target="#result-<?php echo $i ?>">
                                <span class="course-code"> <?php echo $row['courseCode'] ?> </span>
                                <div>
                                    <p class="course-name"> <?php echo $row['courseTitle'] ?> </p>
                                </div>
                                <span class="collapse-icon"> &#8964; </span>
                                <div> </div>
                            </div>
                            <div class="result-details collapse" id="result-<?php echo $i ?>">
                                <p> Score: <span class="score"> <?php echo $examResult['score'] ?> </span> out of <span
                                        class="score-ovrl"> <?php echo $examResult['scoreOverall'] ?> </span>
                                </p>
                                <p> Submitted: <span class="submit-time"> <?php echo $examResult['submitTime'] ?>
                                    </span> </p>
                            </div>
                        </section>

                        <?php }}}?>

                    </div>
                </div>

            </section>

        </main>





    </div>

    <script src="assets/js/date.js"> </script>
    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>



    <script>
    $(document).ready(function() {
        window.location.href = 'index.php#home';
        $(".menu").on("click", function() {
            $('#sidebar').toggleClass('active');
            $('main').toggleClass('active');
        });

        $("main").on("click", function(e) {
            if(document.querySelector("#sidebar.active") && e.target.className !== "menu"){
                $('#sidebar').removeClass('active');
            };
        });

        let resultSubmitTimes = document.querySelectorAll(".result-cont .submit-time");
        resultSubmitTimes.forEach(elem => {
            let time = GetClock(new Date(elem.innerText.trim().replace(' ', 'T')));
            elem.innerHTML = time;
        });

    });

    $("#sidebar li").on("click", function(event) {

        let ref_this = $("#sidebar li.active");
        let target = $(event.target);

        ref_this.removeClass("active");
        target.parent().addClass("active");


        // Get active tab
        let activeTab = target.data("tab");

        // Remove show from all tab contents
        $(".tab-content").each(function() {
            $(this).removeClass("show");
        });

        console.log($(`.tab-content.${activeTab}`));
        //  Add show to active tab
        $(`.tab-content.${activeTab}`).addClass("show");

        // Remove sidebar after navigating succesfully
        if(document.querySelector("#sidebar.active")){
                $('#sidebar').removeClass('active');
        };

    });


    // FIX: Resize to larger width removes active class from sidebar
    window.addEventListener('resize', () => {
        if(window.innerWidth > 768) {
            $('#sidebar').removeClass('active');
            console.log("resized");
        }
    });

    var tday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    var tmonth = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October",
        "November", "December"
    ];

    function GetClock(d) {
        var nday = d.getDay(),
            nmonth = d.getMonth(),
            ndate = d.getDate(),
            nyear = d.getFullYear();
        var nhour = d.getHours(),
            nmin = d.getMinutes(),
            ap;
        if (nhour == 0) {
            ap = " AM";
            nhour = 12;
        } else if (nhour < 12) {
            ap = " AM";
        } else if (nhour == 12) {
            ap = " PM";
        } else if (nhour > 12) {
            ap = " PM";
            nhour -= 12;
        }

        if (nmin <= 9) nmin = "0" + nmin;

        var clocktext = "" + tday[nday] + ", " + tmonth[nmonth] + " " + ndate + ", " + nyear + " <br>" +
            nhour + ":" + nmin + ap + "";

        return clocktext;
    }
    </script>

</body>

</html>

<?php

?>