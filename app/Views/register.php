<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body>
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="p-8 rounded-lg shadow-md w-full max-w-md bg-white">
        <h1 class="text-2xl font-bold mb-6 text-center text-purple-500">Inscription</h1>
        <?php if (isset($error)): ?>
            <div class="mb-4 text-red-500 text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="index.php?action=register" method="POST">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-700">Nom d'utilisateur:</label>
                <input type="text" name="username" id="username" required class="mt-1 p-2 w-full border rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" name="email" id="email" required class="mt-1 p-2 w-full border rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe:</label>
                <input type="password" name="password" id="password" required class="mt-1 p-2 w-full border rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
            </div>
            <div class="mb-4">
                <label for="role_id" class="block text-sm font-medium text-gray-700">Rôle:</label>
                <select name="role_id" id="role_id" required class="mt-1 p-2 w-full border rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
                    <option value="1">Utilisateur</option>
                    <option value="2">Administrateur</option>
                </select>
            </div>
            <div class="flex flex-col items-center">
                <button type="submit" class="bg-purple-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-blue-300 mb-4">S'inscrire</button>
                <a href="index.php?action=login" class="text-sm text-purple-600 hover:underline">Déjà un compte? Connectez-vous</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>