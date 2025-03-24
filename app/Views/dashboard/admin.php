<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin</title>
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
        <h1 class="text-2xl font-bold mb-6">Tableau de bord Admin</h1>
        <p>Bienvenue cher administrateur.</p>
    </div>
</div>
</body>
</html>