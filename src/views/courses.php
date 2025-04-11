<?php
require_once __DIR__ . '/../controllers/CourseController.php';

$courseController = new CourseController();
$courses = $courseController->index();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cours</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php include "../includes/header.php"; ?>
<?php include '../includes/sidebar.php' ?>

<section class="courses">

    <h1 class="heading">Nos cours</h1>

    <div class="box-container">

        <?php
        foreach ($courses as $course) {
            echo "
            <div class='box'>
            <div class='tutor'>
                <img src=\"../assets/images/{$course['user_photo']}\" alt=''>
                <div class='info'>
                    <h2>{$course['instructor_name']}</h2>
                    <span>${course['created_at']}</span>
                </div>
            </div>
            <div class='thumb'>
                <img src='../assets/images/${course['thumbnail']}' alt=''>
            </div>
            <h3 class='title'>{$course['title']}</h3>
            <a href='playlist.html' class='inline-btn'>Suivre ce cours</a>
        </div>
            ";
        }
        ?>

        <div class="box">
            <div class="tutor">
                <img src="../assets/images/pic-3.jpg" alt="">
                <div class="info">
                    <h3>Maxime K.</h3>
                    <span>21-10-2022</span>
                </div>
            </div>
            <div class="thumb">
                <img src="../assets/images/thumb-2.png" alt="">
                <span>10 vidéos</span>
            </div>
            <h3 class="title">Cours complet CSS</h3>
            <a href="playlist.html" class="inline-btn">voir playlist</a>
        </div>

        <div class="box">
            <div class="tutor">
                <img src="../assets/images/pic-3.jpg" alt="">
                <div class="info">
                    <h3>Maxime K.</h3>
                    <span>21-10-2022</span>
                </div>
            </div>
            <div class="thumb">
                <img src="../assets/images/thumb-2.png" alt="">
                <span>10 vidéos</span>
            </div>
            <h3 class="title">Cours complet CSS</h3>
            <a href="playlist.html" class="inline-btn">voir playlist</a>
        </div>
    </div>

</section>

<?php include '../includes/footer.php' ?>

<!-- custom js file link  -->
<script src="../assets/js/script.js"></script>
</body>
</html>
