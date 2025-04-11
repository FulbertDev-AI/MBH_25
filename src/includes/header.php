<header class="header">

    <section class="flex">

        <a href="../views/home.php" class="logo">Nunya</a>

        <form action="search.html" method="post" class="search-form">
            <input type="text" name="search_box" required placeholder="rechercher les cours..." maxlength="100">
            <button type="submit" class="fas fa-search"></button>
        </form>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
        </div>

        <div class="profile">
            <img src="../assets/images/pic-1.jpg" class="image" alt="">
            <h3 class="name">Abalo Kossi</h3>
            <p class="role">Etudiant</p>
            <a href="../views/profile.html" class="btn">Voir profile</a>
            <div class="flex-btn">
                <a href="../views/auth/login.html" class="option-btn">Connexion</a>
                <a href="../views/auth/register.html" class="option-btn">Inscription</a>
            </div>
        </div>

    </section>

</header>