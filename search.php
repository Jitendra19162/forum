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
        #search_container {
            min-height: 81vh;
        }
    </style>
</head>

<body>
    <?php
    include 'partials/_navbar.php';
    include 'partials/_dbconnect.php';
    ?>




    <div class="container my-4" id="search_container">
        <?php
        $search_Query = $_GET["searchQuery"];
        $search_Query_safe1 = str_replace("<", "&lt", "$search_Query");
        $search_Query_safe2 = str_replace(">", "&gt", "$search_Query_safe1");
        $search_Query_safe = str_replace("'", "&#39", "$search_Query_safe2");
        echo '
        <h2>Showing result for " <span style="color: green;">' . $search_Query_safe . '</span> "</h2>';
        ?>

        <div class="search_content my-5"></div>
        <?php
        $searched = $_GET["searchQuery"];
        $search_Query_safe1 = str_replace("'", "&quot", "$search_Query");



        // searching from thread table
        $sql_code_thread = "SELECT * FROM `threads` WHERE MATCH (`thread_title`, `thread_description`) against ('$search_Query_safe1')";
        // Searching from category table
        $sql_code_category = "SELECT * FROM `categories` WHERE MATCH (`category_name`, `category_description`) against ('$search_Query_safe1')";
        // Searching from category table
        $sql_code_comments = "SELECT * FROM `comments_table` WHERE MATCH (`comment_content`) against ('$search_Query_safe1')";

        $result_thread = mysqli_query($conn, $sql_code_thread);
        $result_category = mysqli_query($conn, $sql_code_category);
        $result_comments = mysqli_query($conn, $sql_code_comments);
        $noResult = true;

        while ($row = mysqli_fetch_assoc($result_thread)) {
            $noResult = false;
            $thread_title = $row['thread_title'];
            $thread_id = $row['thread_id'];
            $thread_description = $row['thread_description'];
            echo '  <h5> <a href="thread.php?threadid=' . $thread_id . '">' . $thread_title . ' </a> </5>
                    <p> ' . $thread_description . '</p>';
        }
        while ($row = mysqli_fetch_assoc($result_category)) {
            $noResult = false;
            $category_name = $row['category_name'];
            $category_description = $row['category_description'];
            $category_id = $row['category_id'];
            echo '  <h5> <a href="threadlist.php?catid=' . $category_id . '"> ' . $category_name . ' </a> </5>
                    <p> ' . $category_description . '</p>';
        }
        while ($row = mysqli_fetch_assoc($result_comments)) {
            $noResult = false;
            $comment_content = $row['comment_content'];
            $comment_by = $row['comment_by'];
            $comment_thread_category_id = $row['comment_thread_category_id'];
            echo '  <h5> <a class="text-dark" href="thread.php?threadid=' . $comment_thread_category_id . '"> ' . $comment_content . ' </a> </5>

                    <p>Commented by : ' . $comment_by . '</p>';
        }
        if ($noResult) {
            echo '  <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <h4 class="text-muted text-center">Ummm...</h4>
                            <h4 class="text-muted text-center">We couldn\'t find any matches for "' . $_GET['searchQuery'] . '" (-_-)</h4>
                            <ul class="mt-5">
                                <strong>Search Tips</strong>
                                <li class="mt-2">Double check your search for any typos or spelling error - or try a different search term</li>
                                <li>Try using words that might appear on the page that you’re looking for.</li>
                                <li>Can\'t find what you are looking for? <a href="/forum/contact.php">Contact us</a></li>
                            </ul>
                        </div>
                    </div>';
        }
        ?>
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