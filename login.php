<?php
require 'config.php';
session_start();

$error = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $motdepasse = $_POST['pass'] ?? '';
    $role = htmlspecialchars($_POST['role'] ?? ''); // Récupération du rôle

    // Validation des champs
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Veuillez entrer une adresse email valide.';
    }

    if (empty($motdepasse)) {
        $error[] = 'Le mot de passe est requis.';
    }

    // Validation du rôle
    $roles_valides = ['etudiant', 'professeur', 'mentor'];
    if (empty($role) || !in_array($role, $roles_valides)) {
        $error[] = 'Veuillez sélectionner un rôle valide.';
    }

    if (empty($error)) {
        try {
            // Requête pour vérifier les identifiants dans la table correspondant au rôle
            $stmt = $pdo->prepare("SELECT id, pass, nom, email FROM $role WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($motdepasse, $user['pass'])) {
                // Stocker les informations de l'utilisateur dans la session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $role;

                // Redirection vers la page de profil
                header("Location: profil.php");
                exit();
            } else {
                $error[] = 'Identifiants incorrects.';
            }
        } catch (PDOException $e) {
            $error[] = "Erreur de connexion : " . $e->getMessage();
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
    <title>Se connecter</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

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
                <img src="pic-1.jpg" class="image" alt="">
                <h3 class="name">Abalo Kossi</h3>
                <p class="role">Étudiant</p>
                <a href="profile.html" class="btn">Voir profil</a>
                <div class="flex-btn">
                    <a href="login.php" class="option-btn">Connexion</a>
                    <a href="register.php" class="option-btn">Inscription</a>
                </div>
            </div>

        </section>

    </header>

    <div class="side-bar">

        <div id="close-btn">
            <i class="fas fa-times"></i>
        </div>

        <div class="profile">
            <img src="pic-1.jpg" class="image" alt="">
            <h3 class="name">Abalo Kossi</h3>
            <p class="role">Étudiant</p>
            <a href="profile.html" class="btn">Voir profil</a>
        </div>

        <nav class="navbar">
            <a href="home.html"><i class="fas fa-home"></i><span>Accueil</span></a>
            <a href="about.html"><i class="fas fa-question"></i><span>À Propos</span></a>
            <a href="courses.html"><i class="fas fa-graduation-cap"></i><span>Cours</span></a>
            <a href="teachers.html"><i class="fas fa-chalkboard-user"></i><span>Enseignants</span></a>
            <a href="contact.html"><i class="fas fa-headset"></i><span>Contactez-nous</span></a>
        </nav>

    </div>

    <section class="form-container">

        <form action="" method="post">
            <h3>Connexion</h3>
            <?php
            if (!empty($error)) {
                foreach ($error as $e) {
                    echo "<p style='color:red;text-align:center'>$e</p>";
                }
            } ?>
            <p>Email <span>*</span></p>
            <input type="email" name="email" placeholder="Entrez votre email" required maxlength="50" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" class="box">
            <p>Mot de passe <span>*</span></p>
            <input type="password" name="pass" placeholder="Entrez votre mot de passe" required maxlength="20" class="box">
            <p>Rôle <span>*</span></p>
            <select name="role" required class="box">
                <option value="" disabled selected>Sélectionnez votre rôle</option>
                <option value="etudiant">Étudiant</option>
                <option value="professeur">Professeur</option>
                <option value="mentor">Mentor</option>
            </select>
            <input type="submit" value="Se connecter" name="submit" class="btn">
        </form>

    </section>

    <footer class="footer">
        &copy; copyright @ 2025 by <span>Code Reapers | MBH 25</span> | Tous droits réservés
    </footer>

    <!-- custom js file link  -->
    <script src="script.js"></script>

</body>

</html>