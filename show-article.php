<?php
$filename = __DIR__ . "\data\articles.json";
$articles = [];
$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = $_GET['id'] ?? '';

if (!$id) {
    header('Location: /');
} else {
    if (file_exists($filename)) {
        $articles = json_decode(file_get_contents($filename), true) ?? [];
        $articleIndex = array_search($id, array_column($articles, "id"));
        $article = $articles[$articleIndex];
    }
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Article</title>
    <?php require_once "includes/head.php" ?>
</head>

<body class="flex flex-col h-screen font-poppins bg-slate-100">
    <?php require_once "includes/header.php" ?>
    <main class="flex-1 flex flex-col self-center items-center py-8 max-w-5xl">
        <a class="font-bold mb-2 self-start underline" href="/">Retour à la liste des articles</a>
        <article class="max-w-[850px] bg-light shadow-md">
            <div class=" bg-[url('<?= $article["image"] ?>')] w-full h-[500px] bg-cover"></div>
            <h1 class="text-4xl font-bold text-center my-5"><?= $article["title"] ?></h1>
            <p class="m-2 text-xl"><?= $article["content"] ?></p>
        </article>
        <a class="p-1 rounded bg-secondary text-light self-end mt-2" href="/form-article.php?id=<?= $article["id"] ?>">Modifier l'article</a>
    </main>
    <?php require_once "includes/footer.php" ?>
</body>

</html>