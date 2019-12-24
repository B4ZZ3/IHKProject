<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAdmin" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNavAdmin">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="navbar-brand" href="index.php">
                        <img src="images/logo_eoa.png" height="30" alt="EOA Logo">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=listCategories">Kategorien</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=listProducer">Hersteller</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=listOffices">Büros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=viewAllInStock">Lager</a>
                </li>
            </ul>
            <div>
                <span style="color:white;margin-right:15px;">Eingeloggt als: <?php echo htmlspecialchars( $_SESSION['username']) ?></span>         
                <a class="btn btn-outline-primary" href="index.php?action=logout">Ausloggen</a>
            </div>
        </div>
    </div>
</nav>