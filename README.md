# Documentation Technique du Système de Gestion des Utilisateurs

## 1. Architecture du Projet

### 1.1 Structure MVC
Le projet suit l'architecture Modèle-Vue-Contrôleur (MVC), séparant clairement les responsabilités :
- **Modèles** : Gèrent l'interaction avec la base de données
- **Vues** : Gèrent l'affichage et l'interface utilisateur
- **Contrôleurs** : Traitent la logique métier et les interactions

### 1.2 Structure des Fichiers
```
WEN_BRIEF4/
        │app/
            │
            ├── Controllers/
            │   ├── AuthController.php
            │   ├── UserController.php
            │   └── DashboardController.php
            │   └── LoginHistoryController.php
            │
            ├── Models/
            │   ├── UserModel.php
            │   └── LoginHistoryModel.php
            │
            ├── views/
            │   ├── users/
                          ├── add.php
                          ├── dashboard.php
                          ├── edit_profile.php
                          ├── edit.php
                          ├── history.php
                          ├── list.php

            │   └── dashboard/
                              ├── admin.php
                              ├── sessions.php
                              ├── users.php
                ├── login.php
                ├── register.php
            
            └── core/
                └── auth.php

          
        │public/ 
                ├── index.php 

         ```

## 2. Fonctionnalités Principales

### 2.1 Authentification
- Connexion des utilisateurs
- Inscription de nouveaux utilisateurs
- Gestion des sessions
- Protection contre les attaques (injection, CSRF)

### 2.2 Gestion des Utilisateurs
- Création d'utilisateurs
- Modification de profil
- Activation/Désactivation des comptes
- Suppression d'utilisateurs
- Gestion des rôles (admin/utilisateur)

### 2.3 Historique des Connexions
- Enregistrement des connexion
- voir l historique des connexions(login_time et logout_time)

## 3. Sécurité

### 3.1 Authentification
- Hashage des mots de passe avec `password_hash()`
- Validation des entrées utilisateur
- Nettoyage des inputs avec `filter_input()`

### 3.2 Protection contre les Vulnérabilités
- Requêtes préparées PDO contre les injections SQL
- Sanitization des URLs
- Validation des emails
- Contraintes sur la longueur des mots de passe

## 4. Technologies Utilisées

### 4.1 Backend
- PHP 7.x/8.x
- PDO pour l'accès à la base de données
- Architecture MVC

### 4.2 Frontend
- HTML5
- Tailwind CSS (framework utility-first)


### 4.3 Base de Données
- Tables principales :
  - `users` : Informations des utilisateurs
  - `login_history` : Historique des connexions
  -  `roles` : roles des diffrenets utilisateurs


## 5. Fonctionnement des Contrôleurs

### 5.1 AuthController
- Gère l'authentification
- Méthodes : 
  - `login()`: Connexion utilisateur
  - `logout()`: Déconnexion
  - `register()`: Inscription

### 5.2 UserController
- Gère les opérations sur les utilisateurs
- Méthodes :
  - `addUser()`: Ajout d'utilisateur
  - `editUser()`: Modification d'utilisateur
  - `deleteUser()`: Suppression d'utilisateur
  - `listUsers()`: Liste des utilisateurs

### 5.3 DashboardController
- Gère les tableaux de bord
- Méthodes :
  - `dashboardAdmin()`: Tableau de bord administrateur
  - `manageUsers()`: Gestion des utilisateurs
  - `loginHistory()`: Historique des connexions

### 5.4 LoginHistoryController
- Gère les sessions de connexion des utilisateurs
- Méthodes :
  - `showHistory()`:  afficher l'historique des connexions.
  - `logLogin()`: enregistrer une connexion (à appeler après une connexion réussie).


## 6. Modèles de Données

### 6.1 Utilisateur
```php
{
    id: INT (clé primaire),
    username: VARCHAR,
    email: VARCHAR,
    password: VARCHAR (hashé),
    role_id: INT,
    is_active: BOOLEAN
}
```

### 6.2 Historique de Connexion
```php
{
    id: INT (clé primaire),
    user_id: INT (clé étrangère),
    login_time: DATETIME,
    logout_time: DATETIME
}
```

## 7. Points d'Amélioration

- Implémenter une authentification à deux facteurs
- Ajouter des logs de sécurité plus complets
- Mettre en place une politique de réinitialisation de mot de passe
- Ajouter des tests unitaires et d'intégration
- Mise en place d'un système de cache

## 8. Déploiement

### 8.1 Prérequis
- PHP 7.4 ou supérieur
- MySQL/MariaDB
- Serveur web (Apache/Nginx)

### 8.2 Configuration
- Configurer la connexion à la base de données
- Définir les variables d'environnement
- Sécuriser le fichier de configuration

## 9. Licence et Contributions

Veuillez consulter le fichier `README.md` et `CONTRIBUTING.md` pour plus d'informations sur les contributions et la licence du projet.
