<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" style="margin-left:15px" href="#">Underground Hotel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
        <a class="btn btn-outline-primary mr-2" href="/login">Login</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-primary" href="/register">Registrieren</a>
      </li>
    </ul>
    ';
    } else {
      echo '
    <ul class="navbar-nav ms-auto">
      <li class="nav-item">
        <a class="btn btn-outline-primary mr-2" href="/profile">' . htmlspecialchars($_SESSION['username']) . '</a>
      </li>
      <li class="nav-item">
        <a class="btn btn-primary" href="/logout">Logout</a>
      </li>
    </ul>
    ';
    }
    ?>
  </div>
</nav>