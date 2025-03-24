<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>    
</head>
<body>
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="p-8 rounded-lg shadow-md w-full max-w-md bg-white">
        <h1 class="text-2xl font-bold mb-6 text-center text-purple-500">Connexion</h1>
        <?php if (isset($error)): ?>
            <div class="mb-4 text-red-500 text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="index.php?action=login">
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" name="email" id="email" required class="mt-1 p-2 w-full border rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
            </div>
            <div class="mb-6">
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe:</label>
                <input type="password" name="password" id="password" required class="mt-1 p-2 w-full border rounded-md focus:ring focus:ring-blue-200 focus:outline-none">
            </div>
            <div class="flex flex-col items-center">
                <button type="submit" class="bg-purple-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-blue-300 mb-4">Se connecter</button>
                <a href="index.php?action=register" class="text-sm text-purple-600 hover:underline">Créer un compte?</a>
            </div>
        </form>
    </div>
</div>
</body>
</html>