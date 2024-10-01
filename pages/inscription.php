<!DOCTYPE html>
<html lang="en">
<?php
    require_once '../menu/menu.php';
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css_files/input_form.css">
    <link rel="stylesheet" href="css_files/form_card.css">
    <title>Inscription Airnes</title>
</head>

<body>
    <h1 class="text-center m-4">INSCRIPTION</h1>
    <form action="/controller/controller_formulaire.php" method="POST">
        <div class="form-card p-4">
            <div class="row d-flex justify-content-around">
                <div class="col-5">
                    <label for="nom">Nom :</label>
                    <input type="input" class="form__field" placeholder="Nom" name="nom" id='nom' required />
                </div>
                <div class="col-5">
                    <label for="prenom">Prenom :</label>
                    <input type="input" class="form__field" placeholder="Prenom" name="prenom" id='prenom' required />
                </div>
            </div>
            <br>
            <div class="row d-flex justify-content-between">
                <div class="col-8">
                    <label for="adresse1">Adresse 1 :</label>
                    <input type="input" class="form__field" placeholder="adresse1" name="adresse1" id='adresse1' required />
                </div>
                <div class="col-4">
                    <label for="adresse2">Adresse 2 :</label>
                    <input type="input" class="form__field" placeholder="adresse2" name="adresse2" id='adresse2' />
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-4">
                    <label for="ville">Ville :</label>
                    <input type="input" class="form__field" placeholder="ville" name="ville" id='ville' required />
                </div>
                <div class="col-4">
                    <label for="cp">Code postal :</label>
                    <input type="input" class="form__field" placeholder="cp" name="cp" id='cp' oninput="this.value = this.value.replace(/[^0-9]/g, '');" required />
                </div>
                <div class="col-4">
                    <label for="tel">Téléphone :</label>
                    <input type="input" class="form__field" placeholder="tel" name="tel" id='tel' oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="10" required />
                </div>
            </div>
            <br>
            <div>
                <label for="email">Email :</label>
                <input type="email" class="form__field" placeholder="email" name="email" id='email' required />
            </div>
            <br>
            <div class="row">
                <div class="col-6">
                    <label for="mdp">Mot de passe :</label>
                    <input type="password" class="form__field" placeholder="mdp" name="mdp" id='mdp' required />
                </div>
                <div class="col-6">
                    <label for="mdp_valide">Confirmer mot de passe :</label>
                    <input type="password" class="form__field" placeholder="mdp_valide" name="mdp_valide" id='mdp_valide' required />
                </div>
            </div>
            <br>
            <br>

            <div class="d-flex justify-content-center">
                <button class="button" type="submit" name="inscription">
                    <span class="button-text">S'inscrire</span>
                    <div class="fill-container"></div>
                </button>
            </div>
        </div>
    </form>
</body>

</html>