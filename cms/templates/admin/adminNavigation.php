<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAdmin" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNavAdmin">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="navbar-brand" href="index.php">
                            <img src="images/eoa_logo_wht.png" height="30" alt="EOA Logo">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=listCategories">Kategorien</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=listProducer">Hersteller</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=listPositions">Büros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=viewAllInStock">Lager</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link border-right-xl" href="index.php?action=viewDamageItems">Kaputte Geräte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=viewInventur">Inventur</a>
                    </li>
                </ul>
                <div>
                    <form id="search-items" class="form-inline" style="display:inline-flex;color:rgba(255,255,255,.5);margin-right:15px;">
                        <input class="form-control form-control-sm mr-3 w-75" type="text" placeholder="Suchen" aria-label="Search">
                    </form>
                    <a class="btn btn-outline-primary" href="index.php?action=logout">Ausloggen</a>
                </div>
            </div>
        </div>
    </nav>
</header>

