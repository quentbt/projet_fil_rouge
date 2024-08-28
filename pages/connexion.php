<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css_files/input_form.css">
    <link rel="stylesheet" href="css_files/form_card.css">
    <title>Connexion Airneis</title>
</head>

<body>
    <h1 class="text-center">Connexion</h1>
    <form action="/controller/controller_formulaire.php" method="POST">
        <div class="form-card d-flex justify-content-around">
            <div class="col-6">
                <label for="email">Email :</label>
                <input type="email" name="email" class="form__field" placeholder="nom" required>
                <br>
                <label for="mdp">Mot de Passe :</label>
                <input type="password" name="mdp" name="email" class="form__field" placeholder="email" required>
                <br>
                <br>
                <div class="d-flex justify-content-center">
                    <button class="button" type="submit" name="connexion">
                        <span class="button-text">Connexion</span>
                        <div class="fill-container"></div>
                    </button>
                </div>
            </div>
    </form>
    </div>
</body>

</html>