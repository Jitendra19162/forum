
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
    #question_container{
        min-height: 100vh;
    }
    </style>
</head>

<body>
    <?php
    include 'partials/_navbar.php';
    include 'partials/_dbconnect.php';
    ?>



    <!-- carousel starts here -->
    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="carousel1.jpg" class="d-block w-100" height="440vh" alt="...">
            </div>
            <div class="carousel-item">
                <img src="carousel2.jpg" class="d-block w-100" height="440vh" alt="...">
            </div>
            <div class="carousel-item">
                <img src="carousel3.jpg" class="d-block w-100" height="440vh" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- cards starts here -->
    <div class="container my-2" id="question_container">
        <h2 class="text-center">iDiscuss - Browse Categories</h2>
        <div class="card-group my-4">
            <!-- We will now fetch all the categories  -->
            <?php
            $sql_code = "SELECT * FROM `categories`";
            $result = mysqli_query($conn, $sql_code);
            while ($row = mysqli_fetch_assoc($result)) {
                $category_id = $row['category_id'];
                $category_title = $row['category_name'];
                $category_description = $row['category_description'];
                echo '
                <div class="col-md-4 ">
                <img src="' .$category_id. '.jpg" class="card-img-top" alt="..." style="border:2px solid white">
                  <div class="card-body">
                  <h5 class="card-title"><a href="threadlist.php?catid=' .$category_id . '">'  . $category_title . '</a></h5>
                  <p class="card-text">' . substr($category_description,0, 80) . '... <a href="threadlist.php?catid=' . $category_id . '">read more</a></p>
                  <a href="threadlist.php?catid=' .$category_id . '" type="button" class="btn btn-success">View Threads</a>
                    <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                  </div>
                </div>';
                
            }
            ?>

        </div>
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