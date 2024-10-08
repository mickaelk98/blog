<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Créer un article</title>
    <?php require_once "includes/head.php" ?>
</head>

<body class="flex flex-col h-screen font-poppins bg-slate-100">
    <?php require_once "includes/header.php" ?>
    <main class="flex-1 w-full max-w-5xl flex flex-col self-center items-center py-8">
        <div class="bg-light shadow-md p-5 flex flex-col w-[550px]">
            <h1 class="font-bold text-2xl text-center text-dark mb-5">Ecrire un article</h1>
            <form action="/add-article.php" method="POST">
                <!-- Debut titre -->
                <div class="flex flex-col my-2">
                    <label class="mb-2" for="title">Titre</label>
                    <input class="border border-slate-400 px-1 py-2 rounded" type="text" name="title" id="title">
                </div>
                <!-- Fin titre -->

                <!-- Debut image -->
                <div class="flex flex-col my-2">
                    <label class="mb-2" for="image">Image</label>
                    <input class="border border-slate-400 px-1 py-2 rounded" type="text" name="image" id="image">
                </div>
                <!-- Fin image -->

                <!-- Debut categorie -->
                <div class="flex flex-col my-2">
                    <label class="mb-2" for="category">Categorie</label>
                    <select name="category" id="category" class="border border-slate-400">
                        <option value="tecnology">Technologie</option>
                        <option value="politic">Politique</option>
                        <option value="nature">Nature</option>
                        <option value="finance">Finance</option>
                    </select>
                </div>
                <!-- Fin categorie -->

                <!-- Debut contenu -->
                <div class="flex flex-col my-2">
                    <label class="mb-2" for="content">Contenu</label>
                    <textarea class="resize-none min-h-[280px] border border-slate-400 px-1 py-2 rounded" name="content" id="content"></textarea>
                </div>
                <!-- Fin contenu -->

                <div class="flex flex-row flex-nowrap justify-end gap-2">
                    <a href="/" class="p-1 rounded bg-primary text-light" type="button">Annuler</a>
                    <button class="p-1 rounded bg-secondary text-light">Sauvegarder</button>
                </div>
            </form>
        </div>
    </main>
    <?php require_once "includes/footer.php" ?>
</body>

</html>