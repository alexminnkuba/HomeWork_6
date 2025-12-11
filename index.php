<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PV315-site</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <main>
        <div>
            <?php
            require_once 'connection.php';
            require_once 'pages/functions.php';
            checkRemember();
            require_once 'pages/menu.php';
            ?>
        </div>
        <div class="container py-3">
            <?php
            if (isset($_GET['page'])) {
                $page = (int)$_GET['page'];
                if ($page === 1) {
                    require_once "pages/home.php";
                } elseif ($page === 2) {
                    require_once "pages/upload.php";
                } elseif ($page === 3) {
                    require_once "pages/gallery.php";
                } elseif ($page === 4) {
                    require_once "pages/registration.php";
                } elseif ($page === 5) {
                    require_once 'pages/login.php';
                } elseif ($page === 6) {
                    logout();
                    header("Location: index.php?page=1");
                    exit;
                } else {
                    require_once "pages/home.php";
                }
            }
            ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>