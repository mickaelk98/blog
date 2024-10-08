<?php
const ERROR_REQUIRED = "Ce champ est obligatoire";
const ERROR_TITLE_TO_SHORT = "Le titre est trop court";
const ERROR_CONTENT_TO_SHORT = "Le contenu de l'article est trop court";
const ERROR_IMAGE_URL = "L'mage doit etre une URL valide";

$filename = __DIR__ . "\data\articles.json";

$errors = [
    'title' => '',
    'image' => '',
    'category' => '',
    'content' => ''
];

$articles = [];


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (file_exists($filename)) {
        $articles = json_decode(file_get_contents($filename), true) ?? [];
    }

    $_POST = filter_input_array(INPUT_POST, [
        'title' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'image' => FILTER_SANITIZE_URL,
        'category' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
        'content' => [
            'filetr' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'flags' => FILTER_FLAG_NO_ENCODE_QUOTES
        ]
    ]);

    $title = $_POST['title'] ?? '';
    $image = $_POST['image'] ?? '';
    $category = $_POST['category'] ?? '';
    $content = $_POST['content'] ?? '';

    if (!$title) {
        $errors['title'] = ERROR_REQUIRED;
    } elseif (mb_strlen($title) < 5) {
        $errors['title'] = ERROR_TITLE_TO_SHORT;
    }

    if (!$image) {
        $errors['image'] = ERROR_REQUIRED;
    } elseif (!filter_var($image, FILTER_VALIDATE_URL)) {
        $errors['image'] = ERROR_IMAGE_URL;
    }

    if (!$category) {
        $errors['category'] = ERROR_REQUIRED;
    }

    if (!$content) {
        $errors['content'] = ERROR_REQUIRED;
    } elseif (mb_strlen($content) < 50) {
        $errors['content'] = ERROR_CONTENT_TO_SHORT;
    }

    if (empty(array_filter($errors, fn($e) => $e !== ''))) {
        $articles = [...$articles, [
            'id' => time(),
            'title' => $title,
            'image' => $image,
            'category' => $category,
            'content' => $content
        ]];

        file_put_contents($filename, json_encode($articles));
        header('Location: /');
    }
}


?>

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
                    <input class="border border-slate-400 px-1 py-2 rounded" value="<?= $title ?? "" ?>" type="text" name="title" id="title">
                    <?php if ($errors["title"]): ?>
                        <p class="text-red-600 text-center"><?= $errors['title'] ?></p>
                    <?php endif; ?>
                </div>
                <!-- Fin titre -->

                <!-- Debut image -->
                <div class="flex flex-col my-2">
                    <label class="mb-2" for="image">Image</label>
                    <input class="border border-slate-400 px-1 py-2 rounded" value="<?= $image ?? "" ?>" type="text" name="image" id="image">
                    <?php if ($errors["image"]): ?>
                        <p class="text-red-600 text-center"><?= $errors['image'] ?></p>
                    <?php endif; ?>
                </div>
                <!-- Fin image -->

                <!-- Debut categorie -->
                <div class="flex flex-col my-2">
                    <label class="mb-2" for="category">Categorie</label>
                    <select name="category" id="category" value="<?= $category ?? "" ?>" class="border border-slate-400">
                        <option value="tecnologie">Technologie</option>
                        <option value="politique">Politique</option>
                        <option value="nature">Nature</option>
                        <option value="finance">Finance</option>
                    </select>
                    <?php if ($errors["category"]): ?>
                        <p class="text-red-600 text-center"><?= $errors['category'] ?></p>
                    <?php endif; ?>
                </div>
                <!-- Fin categorie -->

                <!-- Debut contenu -->
                <div class="flex flex-col my-2">
                    <label class="mb-2" for="content">Contenu</label>
                    <textarea class="resize-none min-h-[280px] border border-slate-400 px-1 py-2 rounded" name="content" id="content"><?= $content ?? "" ?></textarea>
                    <?php if ($errors["content"]): ?>
                        <p class="text-red-600 text-center"><?= $errors['content'] ?></p>
                    <?php endif; ?>
                </div>
                <!-- Fin contenu -->

                <div class="flex flex-row flex-nowrap justify-end gap-2">
                    <a href="/" class="p-1 rounded bg-primary text-light">Annuler</a>
                    <button class="p-1 rounded bg-secondary text-light">Sauvegarder</button>
                </div>
            </form>
        </div>
    </main>
    <?php require_once "includes/footer.php" ?>
</body>

</html>