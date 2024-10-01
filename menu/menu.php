<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <title>Navbar</title>
    <style>
        .navbar-nav {
            flex: 1;
            justify-content: center;
        }
    
        body {
            font-family: 'Roboto', sans-serif;
        }
        .navbar {
            background-color: #ffffff; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
        }
        .navbar-brand, .nav-link {
            color: #333333 !important; 
            transition: color 0.3s ease; 
        }
        .navbar-brand:hover, .nav-link:hover {
            color: #007bff !important; 
        }
        .nav-item .dropdown-menu {
            border-radius: 0.25rem; 
            border: none; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
        }
        .dropdown-item {
            transition: background-color 0.3s ease; 
        }
        .dropdown-item:hover {
            background-color: #f8f9fa; 
        }
        .navbar-toggler {
            border: none; 
        }
        .navbar-toggler:focus {
            outline: none; 
        }
        .navbar-brand img {
            max-height: 60px;
            width: auto; 
        }
        @media (max-width: 991px) {
            .navbar-nav {
                justify-content: flex-start; 
            }
        }
    </style>
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <a class="navbar-brand" href="#">
                <img src="../../images/logo-png.png" alt="Logo">
            </a>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Catégorie
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="../pages/categorie.php">Catégorie</a>
                        <a class="dropdown-item" href="../pages/modif_categorie.php">Modif Catégorie</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Produit
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="../pages/produits.php">Produit</a>
                        <a class="dropdown-item" href="../pages/ajouter_produit.php">Ajouter Produit</a>
                        <a class="dropdown-item" href="../pages/modif_produit.php">Modif Produit</a>
                        <a class="dropdown-item" href="../pages/back_produits.php">Back Produit</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Panier
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="../pages/panier.php">Panier</a>
                        <a class="dropdown-item" href="../pages/panier_detail.php">Panier Détail</a>
                    </div>
                </li>
                <li>
                    <a class="navbar-brand" href="../pages/accueil.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/historique.php">Historique</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/back_client.php">Back Client</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../pages/test_graph.php">Test Graph</a>
                </li>
            </ul>
            
        </div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            
        </div>
    </nav>
    

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
