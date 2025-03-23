<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>    
</head>
<body>
<form action="index.php?action=register" method="POST" class="max-w-md mx-auto p-6 bg-white rounded-md shadow-md mt-20">
    <h1 class="text-purple-500 text-4xl font-bold">Inscrivez-vous</h1>
    <?php if (isset($error)): ?>
        <div class="mb-4 text-red-500 text-center"><?php echo $error; ?></div>
    <?php endif; ?>
    <div class="mb-4">
        <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Nom d'utilisateur:</label>
        <input type="text" name="username" id="username" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-4">
        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
        <input type="email" name="email" id="email" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="mb-6">
        <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Mot de passe:</label>
        <input type="password" name="password" id="password" required class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>
    <div class="flex items-center justify-between">
        <button type="submit" class="bg-purple-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            S'inscrire
        </button>
    </div>
</form>
</body>
</html>