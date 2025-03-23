<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un utilisateur</title>
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
                <a href="index.php?action=addUser" class="block hover:text-blue-300">Ajouter un utilisateur</a>
            </li>
            <li>
                <a href="index.php?action=editUser" class="block hover:text-blue-300">Modifier un utilisateur</a>
            </li>
            <li>
                <a href="index.php?action=utilisateuruser" class="block hover:text-blue-300">Liste des utilisateurs</a>
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
        <h1 class="text-2xl font-bold mb-6">Ajouter un utilisateur</h1>
        <?php if (isset($error)): ?>
            <div class="mb-4 text-red-500"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="index.php?action=addUser" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Nom d'utilisateur:</label>
                <input type="text" name="username" id="username" required class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" name="email" id="email" required class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Mot de passe:</label>
                <input type="password" name="password" id="password" required class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="role" class="block text-gray-700">Rôle:</label>
                <select name="role" id="role" class="w-full p-2 border rounded">
                    <option value="user">Utilisateur</option>
                    <option value="admin">Administrateur</option>
                </select>
            </div>
            <button type="submit" class="bg-purple-500 text-white px-4 py-2 rounded">Ajouter</button>
        </form>
    </div>
</div>
</body>
</html>