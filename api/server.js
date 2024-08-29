const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql2');

const app = express();
const port = 8000;

// Configurer bodyParser pour analyser le JSON
app.use(bodyParser.json());

// Configurer la connexion à la base de données
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'airneis'
});

db.connect((err) => {
  if (err) {
    throw err;
  }
  console.log('Connected to database');
});

// Routes pour les clients

// Route pour créer un client
app.post('/clients', (req, res) => {
  const { nom, prenom, adresse1, adresse2, ville, code_postal, telephone, email, mdp, admin } = req.body;
  const hashedPassword = mdp; // pour sécuriser les mots de passe

  const sql = 'INSERT INTO clients (nom, prenom, adresse1, adresse2, ville, code_postal, telephone, email, mdp, admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
  db.query(sql, [nom, prenom, adresse1, adresse2, ville, code_postal, telephone, email, hashedPassword, admin], (err, result) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Client created successfully', id: result.insertId });
  });
});

// Route pour lire les clients
app.get('/clients', (req, res) => {
  const sql = 'SELECT id_client, nom, prenom, adresse1, adresse2, ville, code_postal, telephone, email, admin FROM clients';
  db.query(sql, (err, results) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json(results);
  });
});

// Route pour mettre à jour un client
app.put('/clients/:id', (req, res) => {
  const { id } = req.params;
  const { nom, prenom, adresse1, adresse2, ville, code_postal, telephone, email, mdp, admin } = req.body;

  const sql = 'UPDATE clients SET nom = ?, prenom = ?, adresse1 = ?, adresse2 = ?, ville = ?, code_postal = ?, telephone = ?, email = ?, mdp = ?, admin = ? WHERE id_client = ?';
  db.query(sql, [nom, prenom, adresse1, adresse2, ville, code_postal, telephone, email, mdp, admin, id], (err, result) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Client updated successfully' });
  });
});

// Route pour supprimer un client
app.delete('/clients/:id', (req, res) => {
  const { id } = req.params;

  const sql = 'DELETE FROM clients WHERE id_client = ?';
  db.query(sql, [id], (err, result) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Client deleted successfully' });
  });
});

// Routes pour les produits

// Route pour créer un produit
app.post('/produits', (req, res) => {
  const { nom, description, stock, prix, piece, image_produit, categorie, ordre, highlander, carrousel } = req.body;

  const sql = 'INSERT INTO produits (nom, description, stock, prix, piece, image_produit, categorie, ordre, highlander, carrousel) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
  db.query(sql, [nom, description, stock, prix, piece, image_produit, categorie, ordre, highlander, carrousel], (err, result) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Produit created successfully', id: result.insertId });
  });
});

// Route pour lire les produits
app.get('/produits', (req, res) => {
  const sql = 'SELECT id_produit, nom, description, stock, prix, piece, image_produit, categorie, ordre, highlander, carrousel FROM produits';
  db.query(sql, (err, results) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json(results);
  });
});

// Route pour mettre à jour un produit
app.put('/produits/:id', (req, res) => {
  const { id } = req.params;
  const { nom, description, stock, prix, piece, image_produit, categorie, ordre, highlander, carrousel } = req.body;

  const sql = 'UPDATE produits SET nom = ?, description = ?, stock = ?, prix = ?, piece = ?, image_produit = ?, categorie = ?, ordre = ?, highlander = ?, carrousel = ? WHERE id_produit = ?';
  db.query(sql, [nom, description, stock, prix, piece, image_produit, categorie, ordre, highlander, carrousel, id], (err, result) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Produit updated successfully' });
  });
});

// Route pour supprimer un produit
app.delete('/produits/:id', (req, res) => {
  const { id } = req.params;

  const sql = 'DELETE FROM produits WHERE id_produit = ?';
  db.query(sql, [id], (err, result) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Produit deleted successfully' });
  });
});

// Routes pour le panier

// Route pour créer un panier
app.post('/panier', (req, res) => {
  const { id_client } = req.body;

  const sql = 'INSERT INTO panier (id_client) VALUES (?)';
  db.query(sql, [id_client], (err, result) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Panier created successfully', id: result.insertId });
  });
});

// Route pour lire les paniers
app.get('/panier', (req, res) => {
  const sql = 'SELECT * FROM panier';
  db.query(sql, (err, results) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json(results);
  });
});

// Routes pour les produits dans le panier

// Route pour ajouter un produit au panier
app.post('/panier_produit', (req, res) => {
  const { id_panier, id_produit, quantite } = req.body;

  const sql = 'INSERT INTO panier_produit (id_panier, id_produit, quantite) VALUES (?, ?, ?)';
  db.query(sql, [id_panier, id_produit, quantite], (err, result) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Product added to panier successfully' });
  });
});

// Route pour lire les produits dans le panier
app.get('/panier_produit/:id_panier', (req, res) => {
  const { id_panier } = req.params;

  const sql = 'SELECT * FROM panier_produit WHERE id_panier = ?';
  db.query(sql, [id_panier], (err, results) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json(results);
  });
});

// Routes pour l'historique

// Route pour créer un historique
app.post('/historique', (req, res) => {
  const { id_panier, date_achat, cout_total } = req.body;

  const sql = 'INSERT INTO historique (id_panier, date_achat, cout_total) VALUES (?, ?, ?)';
  db.query(sql, [id_panier, date_achat, cout_total], (err, result) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Historique created successfully', id: result.insertId });
  });
});

// Route pour lire l'historique
app.get('/historique', (req, res) => {
  const sql = 'SELECT * FROM historique';
  db.query(sql, (err, results) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json(results);
  });
});

// Routes pour les matériaux

// Route pour créer un matériau
app.post('/materiaux', (req, res) => {
  const { materiaux } = req.body;

  const sql = 'INSERT INTO materiaux (materiaux) VALUES (?)';
  db.query(sql, [materiaux], (err, result) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Matériau created successfully', id: result.insertId });
  });
});

// Route pour lire les matériaux
app.get('/materiaux', (req, res) => {
  const sql = 'SELECT * FROM materiaux';
  db.query(sql, (err, results) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json(results);
  });
});

// Routes pour les matériaux des produits

// Route pour ajouter un matériau à un produit
app.post('/prod_mat', (req, res) => {
  const { id_produit, id_materiaux } = req.body;

  const sql = 'INSERT INTO prod_mat (id_produit, id_materiaux) VALUES (?, ?)';
  db.query(sql, [id_produit, id_materiaux], (err, result) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Matériau added to product successfully' });
  });
});

// Route pour lire les matériaux d'un produit
app.get('/prod_mat/:id_produit', (req, res) => {
  const { id_produit } = req.params;

  const sql = 'SELECT * FROM prod_mat WHERE id_produit = ?';
  db.query(sql, [id_produit], (err, results) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json(results);
  });
});

// Routes pour les images des produits

// Route pour ajouter une image à un produit
app.post('/images', (req, res) => {
  const { nom_image, id_produit } = req.body;

  const sql = 'INSERT INTO images (nom_image, id_produit) VALUES (?, ?)';
  db.query(sql, [nom_image, id_produit], (err, result) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json({ message: 'Image added to product successfully' });
  });
});

// Route pour lire les images d'un produit
app.get('/images/:id_produit', (req, res) => {
  const { id_produit } = req.params;

  const sql = 'SELECT * FROM images WHERE id_produit = ?';
  db.query(sql, [id_produit], (err, results) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }
    res.json(results);
  });
});

// Route pour la connexion
app.post('/login', (req, res) => {
  const { email, mdp } = req.body;

  // Vérifier si l'utilisateur existe avec cet email
  const sql = 'SELECT * FROM clients WHERE email = ?';
  db.query(sql, [email], (err, results) => {
    if (err) {
      return res.status(500).json({ error: err.message });
    }

    if (results.length === 0) {
      // Aucune correspondance pour cet email
      return res.status(401).json({ message: 'Email ou mot de passe incorrect' });
    }

    const user = results[0];

    // Comparer les mots de passe hachés
    bcrypt.compare(mdp, user.mdp, (err, isMatch) => {
      if (err) {
        return res.status(500).json({ error: err.message });
      }

      if (isMatch) {
        // Le mot de passe est correct
        res.json({ message: 'Connexion réussie', user: { id_client: user.id_client, nom: user.nom, prenom: user.prenom, email: user.email, admin: user.admin } });
      } else {
        // Le mot de passe est incorrect
        res.status(401).json({ message: 'Email ou mot de passe incorrect' });
      }
    });
  });
});


// Démarrer le serveur
app.listen(port, () => {
  console.log(`Server running on port ${port}`);
});
