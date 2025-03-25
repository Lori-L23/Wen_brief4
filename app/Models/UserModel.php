<?php
class UserModel {
    private $db;

    // Constructeur qui initialise la connexion à la base de données
    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Authentifie un utilisateur avec son email et mot de passe
     * @param string $email Email de l'utilisateur
     * @param string $password Mot de passe en clair
     * @return array|false Retourne les infos utilisateur (sans le mot de passe) ou false si échec
     */
    public function authenticate($email, $password) {
        $query = "SELECT id, username, email, password, role_id FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        
        if (!$stmt->execute()) {
            error_log("Erreur d'authentification: " . implode(" ", $stmt->errorInfo()));
            return false;
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérification du mot de passe avec password_verify
        if ($user && password_verify($password, $user['password'])) {
            // Ne retournez pas le mot de passe dans le tableau
            unset($user['password']);
            return $user;
        }

        return false;
    }
    
    /**
     * Crée un nouvel utilisateur
     * @param string $username Nom d'utilisateur
     * @param string $email Email
     * @param string $password Mot de passe en clair (sera hashé)
     * @param int $role_id ID du rôle
     * @return bool True si succès, false sinon
     */
    public function createUser($username, $email, $password, $role_id) {
        // Hash du mot de passe avec l'algorithme par défaut
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Requête SQL pour insérer un nouvel utilisateur
        $query = "INSERT INTO users (username, email, password, role_id) VALUES (:username, :email, :password, :role_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Met à jour les informations d'un utilisateur
     * @param int $id ID de l'utilisateur
     * @param string $username Nouveau nom d'utilisateur
     * @param string $email Nouvel email
     * @param int $role Nouveau rôle
     * @param int $is_active Statut actif/inactif
     * @return bool True si succès, false sinon
     */
    public function updateUser($id, $username, $email, $role, $is_active) {
        $query = "UPDATE users SET id = :id, username = :username, email = :email, role_id = :role_id, is_active = :is_active WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role_id', $role);
        $stmt->bindParam(':is_active', $is_active, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Active ou désactive un utilisateur
     * @param int $id ID de l'utilisateur
     * @param int $is_active 1 pour actif, 0 pour inactif
     * @return bool True si succès, false sinon
     */
    public function toggleUserStatus($id, $is_active) {
        $query = "UPDATE users SET is_active = :is_active WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':is_active', $is_active, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Supprime un utilisateur
     * @param int $id ID de l'utilisateur
     * @return bool True si succès, false sinon
     */
    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    /**
     * Met à jour le profil utilisateur (nom et email)
     * @param int $id ID de l'utilisateur
     * @param string $username Nouveau nom
     * @param string $email Nouvel email
     * @return bool True si succès, false sinon
     */
    public function updateProfile($id, $username, $email) {
        $query = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    /**
     * Récupère l'historique des connexions
     * @return array Tableau des historiques de connexion
     */
    public function getLoginHistory() {
        $query = "SELECT * FROM loginhistory";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur par son email
     * @param string $email Email à rechercher
     * @return array|false Infos utilisateur ou false si non trouvé
     */
    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur par son ID
     * @param int $id ID de l'utilisateur
     * @return array|false Infos utilisateur ou false si non trouvé
     */
    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les utilisateurs
     * @return array Liste de tous les utilisateurs (sans les mots de passe)
     */
    public function getAllUsers() {
        $query = "SELECT id, username, email, role_id, is_active FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}