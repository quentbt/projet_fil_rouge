from flask import Flask, jsonify
from flask_cors import CORS 
from flask_mysqldb import MySQL
import requests
import MySQLdb.cursors
import config # type: ignore


app = Flask(__name__)
CORS(app)
app.config.from_object(config.Config)
mysql = MySQL(app)

@app.route('/')
def home():
    return "Bienvenue sur l'API Flask"

@app.route('/api/donnees')
def get_donnees():
    try:
        response = requests.get('http://localhost:8000/pages/produits.php?id_produit=1') 
        response.raise_for_status()  
        data = response.json()  
        return jsonify(data)
    except requests.exceptions.RequestException as e:
        return jsonify({'error': str(e)}), 500

@app.route('/api/produits')
def get_produits():
    cursor = mysql.connection.cursor(MySQLdb.cursors.DictCursor)     
    cursor.execute('SELECT * FROM produits')     
    data = cursor.fetchall()
    return jsonify(data)

if __name__ == '__main__':
    app.run(debug=True)
