<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lightning Hub - Home</title>
    <link rel="icon" type="image/png" href="../assets/images/logo-lightninghub.png">
    <script src="https://kit.fontawesome.com/c608f59341.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="navbar-brand my-lg-3 ps-lg-3 d-none d-lg-block">Tableau de bord</div>

<div class="d-lg-flex">

    <?php require_once base_path('view/admin/components/nav_admin.php'); ?>


    <section id="dashboard-hub" class="ms-lg-5 text-lg-start w-100">

        <div class="d-flex bd-highlight justify-content-between bg-color-purple-faded">
            <h2 class="nav-dashboard-title px-lg-3 my-4 py-4 reconstruct">Créer une faq</h2>
        </div>

        <div class="tab-pane fade show p-1 border bg-color-purple-faded" id="new-room-hub-tab-pane" role="tabpanel"
             aria-labelledby="new-room-hub-tab" tabindex="0">

            <div class="py-3">
                <div class="row-cols-1 px-3">

                    <div class="col">
                        <h2 class="reconstruct mt-2">Création d'une FAQ</h2>
                    </div>
                    <div class="col px-2 px-md-5 px-lg-0 pb-4">
                        <hr>
                    </div>

                    <!-- New FAQ Form -->
                    <form action="faq_create.php" method = "POST" class="row py-lg-3">
                        <input type="text" name="action" value="createFaq" hidden>
                        <!-- Left Side -->
                        <div class="col-lg-9 offset-lg-2 d-lg-flex flex-column">
                            <div>
                                <label for="question_faq" class="mb-2">Question</label>
                                <input type="text" name="question" id="question_faq" maxlength="40" class="input mb-4 w-100" required aria-required="true">
                            </div>

                            <div>
                                <label for="answer_faq" class="mb-2">Réponse</label>
                                <textarea name="answer" id="answer_faq" maxlength="100" cols="10" rows="7" class="input mb-4 w-100" required aria-required="true"></textarea>
                            </div>


                        </div>

                        <!-- Buttons -->
                        <div class="d-lg-flex col-lg-5 offset-lg-4">
                            <button class="btn w-100 lh-buttons-purple-faded mb-3 me-lg-4">Annuler</button>
                            <button class="btn w-100 lh-buttons-purple mb-3">Créer une FAQ</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>


    </section>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>