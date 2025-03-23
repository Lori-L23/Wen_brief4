<?php
class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function authenticate($email, $password) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
 // Créer un utilisateur
 public function createUser($username, $email, $password, $role_id) {
    // Hash du mot de passe
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

// Modifier un utilisateur
public function updateUser($id, $username, $email, $role, $is_active) {
    $query = "UPDATE users SET username = :username, email = :email, role = :role, is_active = :is_active WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':role_id', $role);
    $stmt->bindParam(':is_active', $is_active, PDO::PARAM_INT);
    return $stmt->execute();
}

// Activer/Désactiver un utilisateur
public function toggleUserStatus($id, $is_active) {
    $query = "UPDATE users SET is_active = :is_active WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':is_active', $is_active, PDO::PARAM_INT);
    return $stmt->execute();
}

// Supprimer un utilisateur
public function deleteUser($id) {
    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}



// Mettre à jour le profil de l'utilisateur
public function updateProfile($id, $username, $email) {
    $query = "UPDATE users SET username = :username, email = :email WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    return $stmt->execute();
}

// Lister l'historique des connexions
public function getLoginHistory() {
    $query = "SELECT * FROM loginhistory";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   // Récupérer un utilisateur par son ID
   public function getUserById($id) {
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
public function getAllUsers() {
    $query = "SELECT id, username, email, role_id, is_active FROM users"; // Inclure la colonne role
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


}
?>