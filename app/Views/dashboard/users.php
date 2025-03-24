<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les utilisateurs</title>
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
        <h1 class="text-2xl font-bold mb-6 text-purple-700">Gérer les utilisateurs</h1>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2 px-4 border text-blue-600">ID</th>
                    <th class="py-2 px-4 border text-blue-600">Nom d'utilisateur</th>
                    <th class="py-2 px-4 border text-blue-600">Email</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td class="py-2 px-4 border "><?php echo $user['id']; ?></td>
                        <td class="py-2 px-4 border "><?php echo $user['username']; ?></td>
                        <td class="py-2 px-4 border "><?php echo $user['email']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="mt-10 justify-around">
            <a href="index.php?action=addUser" class="border border-white text-purple-700 mb-6"> Ajouter un utilisateur</a>
            <a href="index.php?action=utilisateuruser" class="border border-white text-purple-700 mb-6">Liste des utilisateurs</a>
</div>


    </div>
</div>
</body>
</html>