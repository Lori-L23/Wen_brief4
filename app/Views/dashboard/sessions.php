<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des connexions</title>
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
        <h1 class="text-2xl font-bold mb-6">Historique des connexions</h1>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border">ID</th>
                    <th class="py-2 px-4 border">Utilisateur</th>
                    <th class="py-2 px-4 border">Date de connexion</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $entry): ?>
                    <tr>
                        <td class="py-2 px-4 border"><?php echo $entry['id']; ?></td>
                        <td class="py-2 px-4 border"><?php echo $entry['user_id']; ?></td>
                        <td class="py-2 px-4 border"><?php echo $entry['login_time']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>