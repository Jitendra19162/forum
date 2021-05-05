<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

    <title>Welcome to iDiscuss - Coding Forums</title>
    <style>
        #question_container {
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <?php
    include 'partials/_navbar.php';
    include 'partials/_dbconnect.php';

    ?>
    <?php
    // Fetching data from category table to show details in top jumbotron in threadlist page.
    $cat_id = $_GET['catid'];
    $sql_code = "SELECT * FROM `categories` WHERE category_id = $cat_id";
    $result = mysqli_query($conn, $sql_code);
    while ($row = mysqli_fetch_assoc($result)) {
        $cat_name = $row['category_name'];
        $cat_description = $row['category_description'];
    }
    ?>

    <?php

    $show_insertion_alert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        // Insert problem title and description into database
        $problem_title = $_POST['problem_title'];
        $problem_elaboration = $_POST['elaboration'];
        $problem_title_safe1 = str_replace("<", "&lt", "$problem_title");
        $problem_title_safe2 = str_replace(">", "&gt", "$problem_title_safe1");
        $problem_title_safe = str_replace("'", "&#39", "$problem_title_safe2");
        $problem_elaboration_safe1 = str_replace(">", "&gt", "$problem_elaboration");
        $problem_elaboration_safe2 = str_replace("<", "&lt", "$problem_elaboration_safe1");
        $problem_elaboration_safe = str_replace("'", "&#39", "$problem_elaboration_safe2");
        $cat_id = $_GET['catid'];
        
        
        


        $sql_code = "INSERT INTO `threads` (`thread_title`, `thread_description`, `thread_category_id`,`thread_username`, `TimeStamp`) VALUES ('$problem_title_safe', '$problem_elaboration_safe', '$cat_id','{$_SESSION['fullname']}', current_timestamp());";
        $insert_result = mysqli_query($conn, $sql_code);
        $show_insertion_alert = true;
        // // following code is for alert which will show after someone submits question.(temporarily i am keeping it off)
        // if ($show_insertion_alert) {
        //     echo '  <div class="alert alert-success  fade show" role="alert">
        //             <strong>Success!</strong> Your question has submitted...Wait until some expert provide answer.
        //             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //             <span aria-hidden="true">&times;</span>
        //             </button>
        //         </div>';
        // }
    }
    ?>




    <div class="container my-5">
        <div class="jumbotron">
            <br><br><br>
            <h1 class="display-4">Welcome to <strong> <?php echo $cat_name ?></strong> Forum</h1>
            <p class="lead"><?php echo $cat_description ?></p>
            <hr class="my-4">
            <p style="font-size: 30px;" class="text-success">This is <span class="text-danger"> <strong> India's No.1 Forum Website </strong> </span> helps you getting answers from experts all over the world.</p>
            <p><strong>Rules & Regulations of this website</strong>.</p>
            <ul>
                <li>Any material which constitutes defamation.</li>
                <li>harassment, or abuse is strictly prohibited.</li>
                <li>Material that is sexually or otherwise obscene, racist, or otherwise overly discriminatory is not permitted on these forums.</li>
                <li> You may register only one account. Reinstatement of banned or cancelled accounts can come only from an administrator.</li>
                <li>Do not post in order to anger other members or intentionally cause negative reactions.</li>
            </ul>
        </div>
    </div>



    <?php
    echo '<!-- Ask problem and start discussion form starts here -->
    <div class="container">
        <h1 class="text-center my-3">Ask a Question</h1>';
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] = true) {
        echo '
                <form action="threadlist.php?catid='.$cat_id.'" method="POST">
                    <div class="mb-3">
                        <label for="problem_title" class="form-label">Problem Title</label>
                        <input type="text" class="form-control" id="problem_title" name="problem_title" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">try to keep it short and upto point.</div>
                    </div>
                    <div class="mb-3">
                        <label for="elaboration" class="form-label">Elaborate the problem</label>
                        <textarea maxlength="500" class="form-control" id="elaboration" name="elaboration" rows="3"></textarea>
                        <small id="emailHelp" class="form-text text-danger">Maximum word limit 500*</small>
        
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Agree terms & conditions</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
        
            </div>
        ';
    } else {
        echo '<h4 class="text-muted text-center">-----  Please login to ask questions  -----</h4>';
    }
    ?>








    <!-- Browse question container starts here -->
    <div class="container my-5" id="question_container">
        <strong>
            <h1 class="text-center text-danger my-3">Browse Questions</h1>
        </strong>

        <ul class="list-unstyled">
            <?php
            // code to show questions and descriptions in the website.
            $cat_id = $_GET['catid'];
            $sql_code = "SELECT * FROM `threads` WHERE thread_category_id = $cat_id";
            $result = mysqli_query($conn, $sql_code);
            $noResult = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $noResult = false;
                $thread_id = $row['thread_id'];
                $thread_username = $row['thread_username'];
                $thread_title = $row['thread_title'];
                $thread_description = $row['thread_description'];

                echo '  <li class="media">
                            <img src="userdef.png" width="64px" class="mr-3" alt="...">
                            <div class="media-body">
                            <h5 class="mt-0 mb-1">' . $thread_username . '</h5>
                            <h6> <a class="text-dark" href="thread.php?threadid=' . $thread_id . '"> ' . $thread_title . ' </a></h6>
                            <p> ' . $thread_description . ' </p>
                            </div>
                        </li>';
            }
            if ($noResult) {
                echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                  <h4 class="text-muted text-center">Nothing to show (-_-)</h4>
                  <p class="text-muted text-center">Be the first one to ask and start discussion.</p>
                </div>
              </div>';
            }
            ?>
        </ul>
    </div>

    <!-- Footer starts here -->
    <?php
        include 'partials/_footer.php';
    ?>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
</body>

</html>