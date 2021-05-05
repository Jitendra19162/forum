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
    // Fetching data from table threads for details in jubotron(top of the page)
    $thread_id = $_GET['threadid'];
    $sql_code = "SELECT * FROM `threads` WHERE thread_id = $thread_id";
    $result = mysqli_query($conn, $sql_code);
    while ($row = mysqli_fetch_assoc($result)) {
        $thread_username = $row['thread_username'];
        $thread_title = $row['thread_title'];
        $thread_description = $row['thread_description'];
    }
    ?>
    <?php
    // Writing code for inserting comment in comment_table.

    $show_comment_alert = false;
    $comment_thread_id = $_GET['threadid'];
    $comment_thread_category_id = $_GET['threadid'];
    
    

    $method = $_SERVER['REQUEST_METHOD'];
    if ($method == 'POST') {
        $comment_content = $_POST['comment_content'];
        $comment_content_safe1 = str_replace("<", "&lt", "$comment_content");
        $comment_content_safe2 = str_replace(">", "&gt", "$comment_content_safe1");
        $comment_content_safe = str_replace("'", "&#39", "$comment_content_safe2");
                $sql_code_comment_insert = "INSERT INTO `comments_table` (`comment_content`, `comment_by`, `comment_thread_id`, `comment_thread_category_id`, `comment_at`) VALUES ('$comment_content_safe', '{$_SESSION['fullname']}', '$comment_thread_category_id', '$comment_thread_category_id', current_timestamp())";
        $result = mysqli_query($conn, $sql_code_comment_insert);
        // // following code is for showing alert after someone post comment(I am putting it temprarily off)
        // if ($result) {
        //     $show_comment_alert = true;
        // }
        // if ($show_comment_alert) {
        //     echo '<div class="alert alert-success  fade show" role="alert">
        //     <strong>Success!</strong> Your comment has been posted.
        //     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        //     <span aria-hidden="true">&times;</span>
        //     </button>
        // </div>';
        // }
    }


    ?>



    <div class="container my-5">
        <div class="jumbotron">
            <h3 class="display-4"><strong> <?php echo $thread_title ?></strong></h3>
            <p class="text-muted">Description:</p>
            <p class="lead"><?php echo $thread_description ?></p>
            <hr class="my-4">
            <p style="font-size: 30px;" class="text-success">Posted by : <span class="text-danger"> <strong> <?php echo $thread_username ?> </strong> </span> </p> <br>
            <hr>
        </div>
    </div>


    <div class="container">
        <h3 class="text-center my-3">Your Comment</h3>

        <?php

        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            echo '<!-- Comment form starts here -->
            <div class="container">
                <form action="thread.php?threadid='.$thread_id.'" method="POST">
                    <div class="mb-3">
                        <label for="comment_content" class="form-label">Write your opinion or solution</label>
                        <textarea maxlength="500" class="form-control" id="comment_content" name="comment_content" rows="3"></textarea>
                        <small  class="form-text text-danger">Maximum word limit 500*</small>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Agree terms & conditions</label>
                    </div>
                    <button type="submit"  class="btn btn-primary">Post Comment</button>
                </form>
            </div>
        </div>';
        } else {
            echo '<h5 class="text-muted text-center">----- Please login to Comment -----</h5>';
        }


        ?>



        <!-- Browse question container starts here -->
        <div class="container" id="question_container">
            <strong>
                <h1 class="text-center text-danger my-3">Comments & Discussions</h1>
            </strong>
            <ul class="list-unstyled">
                <?php
                // writing code to fetch data from comment_table and show posted comments in website.
                $comment_thread_id = $_GET['threadid'];
                $sql_code_show_comment = "SELECT * FROM `comments_table` WHERE comment_thread_id = $comment_thread_id";
                $result = mysqli_query($conn, $sql_code_show_comment);
                $noResult = true;
                while ($row = mysqli_fetch_assoc($result)) {
                    $noResult = false;
                    $comment_by = $row['comment_by'];
                    $comment_content = $row['comment_content'];
                    $comment_at = $row['comment_at'];
                    echo '<li class="media">
                        <div class="media-body">
                        <h4 class="mt-0 mb-1">' . $comment_by . ':  <small style="font-size: 15px;" class="text-muted"> at ' . $comment_at . '</small></h4>
                        <p> ' . $comment_content . ' </p>
                        </div>
                     </li>';
                }
                if ($noResult) {
                    echo '<div class="jumbotron jumbotron-fluid">
                            <div class="container">
                            <h4 class="text-muted text-center">Nothing to show (-_-)</h4>
                            <p class="text-muted text-center">Be the first one to comment and start discussion.</p>
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