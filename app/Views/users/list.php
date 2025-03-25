<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>

<body>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="bg-gray-800 text-white w-64 p-6">
            <ul class="space-y-4">
                <li>
                    <a href="index.php?action=dashboardadmin" class="block hover:text-blue-300">Accueil</a>
                </li>
                <li>
                    <a href="index.php?action=utilisateur" class="block hover:text-blue-300">Gérer les utilisateurs</a>
                </li>
            
                <li>
                    <a href="index.php?action=sessions" class="block hover:text-blue-300">Historique des connexions</a>
                </li>
                <li>
                    <a href="index.php?action=logout" class="block hover:text-blue-300">Déconnexion</a>
                </li>
            </ul>
        </div>

        <!-- Contenu principal -->
        <div class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-6">Liste des utilisateurs</h1>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border">ID</th>
                    <th class="py-2 px-4 border">Nom d'utilisateur</th>
                    <th class="py-2 px-4 border">Email</th>
                    <th class="py-2 px-4 border">Rôle</th>
                    <th class="py-2 px-4 border">Statut</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="py-2 px-4 border"><?php echo $user['id']; ?></td>
                        <td class="py-2 px-4 border"><?php echo $user['username']; ?></td>
                        <td class="py-2 px-4 border"><?php echo $user['email']; ?></td>
                        <td class="py-2 px-4 border"><?php echo $user['role_id'] ?? 'Non défini'; ?></td>
                        <td class="py-2 px-4 border"><?php echo $user['is_active'] ? 'Inactif' : 'Actif'; ?></td>
                        <td class="py-2 px-4 border">
                            <a href="index.php?action=edit&id=<?php echo $user['id']; ?>" class="text-blue-500">Modifier</a>
                            <a href="index.php?action=toggleUser&id=<?php echo $user['id']; ?>&is_active=<?php echo $user['is_active'] ? 1 : 0; ?>" class="text-green-500 ml-2">
                                <?php echo $user['is_active'] ? 'Désactiver' : 'Activer'; ?>
                            </a>
                            <a href="index.php?action=deleteUser&id=<?php echo $user['id']; ?>" class="text-red-500 ml-2">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>