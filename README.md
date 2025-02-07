# Projet e-commerce en PHP (Sans Framework) avec Docker

## 📌 Introduction
Ce projet est un **micro site e-commerce** développé en **PHP/MySQL/HTML/CSS** sans framework. Il utilise **Docker** pour simplifier le déploiement.

---

## 🚀 Installation
### 1️⃣ **Cloner le projet**
```sh
git clone https://github.com/ton-repo/projet-ecommerce.git
cd projet-ecommerce
```

### 2️⃣ **Configurer les variables d'environnement**
Créer un fichier `.env` à la racine du projet et y mettre :
```ini
DB_HOST=db
DB_DATABASE=ecommerce
DB_USERNAME=user
DB_PASSWORD=password
APP_ENV=production
APP_DEBUG=false
```

### 3️⃣ **Lancer Docker**
```sh
docker-compose up --build -d
```
Cela va lancer **MySQL, PHP, Apache et phpMyAdmin**.

---

## 🛠️ Commandes utiles

### **📌 Vérifier que les conteneurs tournent**
```sh
docker ps
```

### **📌 Se connecter à MySQL dans Docker**
```sh
docker exec -it ecommerce_db mysql -u root -p
```
**Identifiants par défaut :**
- **Utilisateur :** `root`
- **Mot de passe :** `root`

### **📌 Exécuter manuellement `init.sql` (si les tables ne sont pas créées)**
```sh
docker exec -i ecommerce_db mysql -u root -p ecommerce < db/init.sql
```

### **📌 Accéder à phpMyAdmin**
- **URL :** [http://localhost:8080](http://localhost:8080)
- **Serveur :** `db`
- **Utilisateur :** `root`
- **Mot de passe :** `root`

### **📌 Vérifier que les tables existent**
Dans MySQL :
```sql
USE ecommerce;
SHOW TABLES;
```

---

## 🏗️ Architecture du projet
```
/projet-ecommerce
│── /config          # Configuration (Connexion DB)
│   │── database.php
│── /controllers     # Logique métier (Authentification, Produits...)
│   │── AuthController.php
│   │── ProductController.php
│── /db              # Base de données
│   │── init.sql      # Script SQL de création des tables
│── /docker          # Configuration Docker
│   │── php.ini
│── /includes        # Fonctions et éléments partagés
│   │── header.php
│   │── footer.php
│   │── functions.php
│── /models          # Modèles de base de données
│   │── User.php
│   │── Product.php
│── /public          # Fichiers accessibles au public (HTML/PHP)
│   │── index.php
│   │── login.php
│   │── register.php
│   │── produits.php
│   │── contact.php
│   │── admin.php
│   │── vendeur.php
│── .gitignore       # Fichiers à ignorer par Git
│── .env             # Variables d'environnement
│── .htaccess        # Sécurité Apache
│── README.md        # Documentation du projet
│── Dockerfile       # Configuration PHP
│── docker-compose.yml # Configuration Docker
```

---

## 🔧 Dépannage

### **❌ Problème : Impossible de se connecter à MySQL**
**Solution :** Vérifier si MySQL tourne bien :
```sh
docker ps
```
Si MySQL ne tourne pas, relance Docker :
```sh
docker-compose down && docker-compose up -d
```

### **❌ Problème : Aucune table dans MySQL**
**Solution :** Exécuter `init.sql` manuellement :
```sh
docker exec -i ecommerce_db mysql -u root -p ecommerce < db/init.sql
```

### **❌ Problème : phpMyAdmin ne s'affiche pas**
**Solution :** Vérifier que le conteneur tourne :
```sh
docker ps
```
Si `phpmyadmin` n'est pas listé, relance Docker :
```sh
docker-compose up -d phpmyadmin
```

---

## 🛡️ Sécurité
- **Utilisation de requêtes préparées** (`PDO`) pour éviter les injections SQL.
- **Protection contre le Cross-Site Scripting (XSS)** avec `htmlspecialchars()`.
- **Sécurisation des sessions** avec `session_set_cookie_params()`.
- **Protection CSRF** avec un token dans les formulaires.

---

