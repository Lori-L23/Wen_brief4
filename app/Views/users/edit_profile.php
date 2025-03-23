<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le profil</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body>
<div class="flex h-screen">
    <!-- Sidebar -->
    <div class="bg-gray-800 text-white w-64 p-6">
        <ul class="space-y-4">
            <li>
                <a href="index.php?action=dashboard" class="block hover:text-blue-300">Tableau de bord</a>
            </li>
            <li>
                <a href="index.php?action=editProfile" class="block hover:text-blue-300">Modifier le profil</a>
            </li>
            <li>
                <a href="index.php?action=loginHistory" class="block hover:text-blue-300">Historique des connexions</a>
            </li>
            <li>
                <a href="index.php?action=logout" class="block hover:text-blue-300">Déconnexion</a>
            </li>
        </ul>
    </div>

    <!-- Contenu principal -->
    <div class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier le profil</h1>
        <?php if (isset($error)): ?>
            <div class="mb-4 text-red-500"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="index.php?action=updateProfile" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-gray-700">Nom d'utilisateur:</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required class="w-full p-2 border rounded">
            </div>
            <button type="submit" class="bg-purple-500 text-white px-4 py-2 rounded">Enregistrer</button>
        </form>
    </div>
</div>
</body>
</html>