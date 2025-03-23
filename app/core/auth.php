<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=gestion_utilisateurs', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion à la base de données réussie !";
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
// Exemple de fonction pour vérifier si l'utilisateur est un admin
class Auth {
    public static function isAdmin() {
        // Implémentez la logique pour vérifier si l'utilisateur est un admin
        return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
    }

}
?>