<?php
require 'config.php';

$error = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   // Récupération des données
   $nom = htmlspecialchars($_POST['name']);
   $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
   $password = $_POST['pass'];
   $confirm_password = $_POST['c_pass'];
   $role = htmlspecialchars($_POST['role']); // Récupération du rôle

   // Validation
   if (empty($nom) || empty($email) || empty($password) || empty($role)) {
      $error[] = "Tous les champs sont obligatoires.";
   }

   if (strlen($password) < 8) {
      $error[] = "Le mot de passe doit contenir au moins 8 caractères.";
   } elseif ($password !== $confirm_password) {
      $error[] = "Les mots de passe ne correspondent pas.";
   }

   // Validation du rôle
   $roles_valides = ['etudiant', 'professeur', 'mentor'];
   if (!in_array($role, $roles_valides)) {
      $error[] = "Rôle invalide.";
   }

   // Vérification de l'email existant dans la table correspondante
   if (empty($error)) {
      $checkEmail = $pdo->prepare("SELECT COUNT(*) FROM $role WHERE email = ?");
      $checkEmail->execute([$email]);
      if ($checkEmail->fetchColumn() > 0) {
         $error[] = "Cet email est déjà enregistré en tant que $role.";
      }
   }

   // Traitement de l'image
   if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
      $image_name = uniqid() . '_' . basename($_FILES['image']['name']);
      $image_tmp = $_FILES['image']['tmp_name'];
      $image_dir = 'uploads/' . $image_name;
      $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
      $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

      if (!in_array($image_ext, $allowed)) {
         $error[] = "Le format de l'image n'est pas autorisé.";
      }
   } else {
      $error[] = "Erreur lors du téléchargement de l'image.";
   }

   // Si pas d'erreurs, on enregistre
   if (empty($error)) {
      if (!file_exists('uploads')) {
         mkdir('uploads', 0777, true);
      }

      move_uploaded_file($image_tmp, $image_dir);

      $hashagepassword = password_hash($password, PASSWORD_DEFAULT);

      // Insérer dans la table correspondant au rôle
      $sql = "INSERT INTO $role (nom, email, pass, photo) VALUES (:nom, :email, :pass, :photo)";
      $stmt = $pdo->prepare($sql);
      $stmt->bindParam(':nom', $nom);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':pass', $hashagepassword);
      $stmt->bindParam(':photo', $image_name);

      try {
         if ($stmt->execute()) {
            $success = "Inscription réussie en tant que " . ucfirst($role) . " !";
         }
      } catch (PDOException $e) {
         $error[] = "Erreur lors de l'inscription : " . $e->getMessage();
      }
   }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Inscription</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>

<body>

   <header class="header">

      <section class="flex">

         <a href="home.html" class="logo">Nunya</a>

         <form action="search.html" method="post" class="search-form">
            <input type="text" name="search_box" required placeholder="Rechercher les cours..." maxlength="100">
            <button type="submit" class="fas fa-search"></button>
         </form>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
         </div>

         <div class="profile">
            <img src="images/pic-1.jpg" class="image" alt="">
            <h3 class="name">Abalo Kossi</h3>
            <p class="role">Etudiant</p>
            <a href="profile.html" class="btn">Voir Profile</a>
            <div class="flex-btn">
               <a href="login.html" class="option-btn">Connexion</a>
               <a href="register.html" class="option-btn">Inscription</a>
            </div>
         </div>

      </section>

   </header>

   <div class="side-bar">

      <div id="close-btn">
         <i class="fas fa-times"></i>
      </div>

      <div class="profile">
         <img src="images/pic-1.jpg" class="image" alt="">
         <h3 class="name">Abalo Kossi</h3>
         <p class="role">Etudiant</p>
         <a href="profile.html" class="btn">Voir Profile</a>
      </div>

      <nav class="navbar">
         <a href="home.html"><i class="fas fa-home"></i><span>Accueil</span></a>
         <a href="about.html"><i class="fas fa-question"></i><span>A Propos</span></a>
         <a href="courses.html"><i class="fas fa-graduation-cap"></i><span>cours</span></a>
         <a href="teachers.html"><i class="fas fa-chalkboard-user"></i><span>Enseignants</span></a>
         <a href="contact.html"><i class="fas fa-headset"></i><span>Contactez-nous</span></a>
      </nav>

   </div>

   <section class="form-container">

      <form action="" method="post" enctype="multipart/form-data">
         <h3>Inscription</h3>
         <?php
         if (!empty($error)) {
            foreach ($error as $e) {
               echo "<p style='color:red;text-align:center'>$e</p>";
            }
         } elseif (!empty($success)) {
            echo "<p style='color:green;text-align:center'>$success</p>";
         }
         ?>
         <p>Nom <span>*</span></p>
         <input type="text" name="name" placeholder="Entrez votre nom" required maxlength="50" class="box">
         <p>Email <span>*</span></p>
         <input type="email" name="email" placeholder="Entrez votre email" required maxlength="50" class="box">
         <p>Mot de passe <span>*</span></p>
         <input type="password" name="pass" placeholder="Entrez le mot de passe" required maxlength="20" class="box">
         <p>Confirmer le mot de passe <span>*</span></p>
         <input type="password" name="c_pass" placeholder="Confirmer le mot de passe" required maxlength="20" class="box">
         <div class="form-group">
            <label for="role">Rôle<span>*</span></label>
            <select id="role" name="role" required>
               <option value="" disabled selected>Sélectionnez votre rôle</option>
               <option value="etudiant">Étudiant</option>
               <option value="professeur">Professeur</option>
               <option value="mentor">Mentor</option>
            </select>
         </div>
         <p>Photo <span>*</span></p>
         <input type="file" name="image" accept="image/*" required class="box">
         <input type="submit" value="S'inscrire" name="submit" class="btn">
      </form>

   </section>

   <footer class="footer">

      &copy; copyright @ 2025 by <span>Code Reapers | MBH 25</span> | all rights reserved

   </footer>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>

      &copy; copyright @ 2025 by <span>Code Reapers | MBH 25</span> | all rights reserved

   </footer>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

</body>

</html>