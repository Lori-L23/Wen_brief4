<?php
// Définition de la classe LoginHistoryModel pour gérer l'historique de connexion.
class LoginHistoryModel {
    private $db; // Instance de la connexion à la base de données (PDO).

    // Constructeur : initialise la connexion à la base de données.
    public function __construct($db) {
        $this->db = $db;
    }

    // Fonction pour enregistrer un log de connexion.
    public function logLogin($user_id) {
        try {
            // Requête SQL pour insérer un enregistrement dans la table login_history.
            $query = "INSERT INTO login_history (user_id, ip_address, user_agent) 
                      VALUES (:user_id, :ip, :ua)";
            
            // Préparation de la requête.
            $stmt = $this->db->prepare($query);

            // Liaison des valeurs aux paramètres de la requête.
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT); // L'ID de l'utilisateur (entier).
            $stmt->bindValue(':ip', $_SERVER['REMOTE_ADDR'] ?? ''); // L'adresse IP du client (ou une chaîne vide si non définie).
            $stmt->bindValue(':ua', $_SERVER['HTTP_USER_AGENT'] ?? ''); // L'agent utilisateur du client (ou une chaîne vide si non définie).

            // Exécution de la requête et retour du résultat (true si réussi, false sinon).
            return $stmt->execute();

        } catch (PDOException $e) {
            // En cas d'erreur PDO (par exemple, problème de connexion à la base de données),
            // enregistre l'erreur dans le log et retourne false.
            error_log("Erreur d'enregistrement du log: " . $e->getMessage());
            return false;
        }
    }

    // Fonction pour récupérer l'historique de connexion (pour un utilisateur spécifique ou tous les utilisateurs).
    public function getLoginHistory($user_id = null) {
        // Requête SQL pour sélectionner les enregistrements de l'historique de connexion,
        // avec une jointure LEFT JOIN pour récupérer le nom d'utilisateur à partir de la table users.
        $query = "SELECT lh.*, u.username 
                  FROM loginhistory lh
                  LEFT JOIN users u ON lh.user_id = u.id";

        // Si un ID d'utilisateur est fourni, ajoute une clause WHERE pour filtrer les résultats.
        if ($user_id) {
            $query .= " WHERE lh.user_id = :user_id";
        }

        // Ajoute une clause ORDER BY pour trier les résultats par date de connexion décroissante.
        $query .= " ORDER BY lh.login_time DESC";

        // Préparation de la requête.
        $stmt = $this->db->prepare($query);

        // Si un ID d'utilisateur est fourni, lie la valeur au paramètre de la requête.
        if ($user_id) {
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        }

        // Exécution de la requête.
        $stmt->execute();

        // Récupération de tous les résultats sous forme de tableau associatif.
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>