<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/">Underground Hotel</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav me-auto">
      <li class="nav-item">
        <a class="nav-link" href="/">Startseite</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="/galerie">Galerie</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="/news">News</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/impressum">Impressum</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/help">Hilfe</a>
      </li>
    </ul>
    <?php if (!isset($_SESSION['username'])) : ?>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="btn btn-outline-primary mr-2 navbar-items-right" href="/login">Login</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-primary navbar-items-right" href="/register">Registrieren</a>
        </li>
      </ul>
    <?php else: ?>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="btn btn-outline-primary dropdown-toggle mr-2 navbar-items-right" href="#" id="user_dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $_SESSION['username'] ?></a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="user_dropdown">
            <li><a class="dropdown-item" href="/profile">Profil anzeigen</a></li>
            <li><a class="dropdown-item" href="/">Einstellungen</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Logout</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="btn btn-primary navbar-items-right" href="/logout">Logout</a>
        </li>
      </ul>
    <?php endif ?>
  </div>
</nav>