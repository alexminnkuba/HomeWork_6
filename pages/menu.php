<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="#">PV315</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php?page=1">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=2">Upload</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=3">Gallery</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?page=4">Registration</a>
        </li>
        <?php if (isLoggedIn()): ?>
          <li class="nav-item">
            <a class="nav-link" href="index.php?page=6">Logout (<?= htmlspecialchars(getCurrentUser()['username']) ?>)</a>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="index.php?page=5">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>