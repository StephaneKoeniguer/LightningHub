<!doctype html>
<html lang="fr" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="../assets/images/logo-lightninghub.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Admin - Dashboard</title>
</head>
<body>


<main>

    <div class="navbar-brand my-lg-3 ps-lg-3 d-none d-lg-block">Tableau de bord</div>

    <div class="d-lg-flex">

        <?php require_once(__DIR__ . "/nav_admin.php") ?>

        <section class="bg-color-purple-faded ms-lg-5">
            <p class="nav-dashboard-title ps-3 my-4 py-4">Accueil</p>
            <ul class="list-unstyled d-lg-flex">
                <li class="dashboard-title ps-3">Nombre d'utilisateurs</li>
                <li class="dashboard-title ps-3">Nombre de salons</li>
                <li class="dashboard-title ps-3">Nombre de jeux</li>
                <li class="dashboard-title ps-3">Nombre de FAQ</li>
            </ul>
            <hr class="mx-3 d-none d-lg-block"/>

        </section>

    </div>


</main>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/c608f59341.js" crossorigin="anonymous"></script>
</body>
</html>
