<nav class="navtop">
            <div>
                <h1>Kuvagalleria</h1>
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="logout.php" class="nav-link">Kirjaudu ulos</a>
                    <a href="addphoto.php" class="nav-link">Lisää kuva</a>
                    <a href="index.php" class="nav-link">Kuvat</a>
            <?php endif; ?>
            </div>
    

        </nav>
