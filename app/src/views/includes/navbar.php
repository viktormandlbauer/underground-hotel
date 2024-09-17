<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Underground Hotel</a>
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
    <?php
    if (!isset($_SESSION['username'])) {
      echo '
    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <a class="btn btn-outline-primary mr-2 navbar-items-right" href="/login">Login</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-primary navbar-items-right" href="/register">Registrieren</a>
      </li>
    </ul>
    ';
    } else {
      echo '
    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <a class="btn btn-outline-primary mr-2 navbar-items-right" href="/profile">' . htmlspecialchars($_SESSION['username']) . '</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-primary navbar-items-right" href="/logout">Logout</a>
      </li>
    </ul>
    ';
    }
    ?>
  </div>
</nav>