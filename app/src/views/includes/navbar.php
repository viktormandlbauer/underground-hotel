<nav class="navbar navbar-expand-md navbar-dark bg-dark floating-navbar">
  <div class="container-fluid">
    <a class="navbar-brand fs-1" id="navBrand" href="/">Underground Hotel</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ps-2 fs-2" id="navPages">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/news">News</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/galerie">Galerie</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/rooms">Zimmer</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/impressum">Impressum</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/help">Hilfe</a>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto d-flex flex-row justify-content-end" id="navProfile">
        <?php if (!isset($_SESSION['username'])): ?>
          <li class="nav-item mx-2">
            <a class="btn btn-light fs-4" href="/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-light fs-4" href="/register">Registrieren</a>
          </li>
        <?php else: ?>
          <li class="nav-item mx-2">
            <a class="btn btn-light fs-4" href="/dashboard">Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-light fs-4" href="/logout">Logout</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<style>
  @font-face {
    font-family: 'UNDERGROUND-HOTEL-BRAND';
    src: url('/public/fonts/DOCALLISME_ON_STREET.ttf');
  }

  @font-face {
    font-family: 'UNDERGROUND-HOTEL-PAGES';
    src: url('/public/fonts/adrip1.ttf');
  }

  @font-face {
    font-family: 'UNDERGROUND-HOTEL-PROFILE';
    src: url('/public/fonts/Gemstone.ttf');
  }

  #navBrand {
    font-family: 'UNDERGROUND-HOTEL-BRAND';
  }

  #navPages {
    font-family: 'UNDERGROUND-HOTEL-PAGES';
  }

  #navProfile {
    font-family: 'UNDERGROUND-HOTEL-PROFILE';
  }

  .floating-navbar {
    position: fixed;
    top: 0px;
    left: 0px;
    right: 0px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
  }
</style>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('#navPages .nav-link');

    navLinks.forEach(link => {
      if (link.getAttribute('href') === currentPath) {
        link.classList.add('active');
      }
    });
  });
</script>