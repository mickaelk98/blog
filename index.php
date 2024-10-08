<?php

$filename = __DIR__ . "\data\articles.json";
$articles = [];
$categories = [];

$_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$selectedCat = $_GET['cat'] ?? '';

if (file_exists($filename)) {
    $articles = json_decode(file_get_contents($filename), true) ?? [];
    $cattmp = array_map(fn($article) => $article["category"], $articles);
    $categories = array_reduce($cattmp, function ($acc, $cat) {
        if (isset($acc[$cat])) {
            $acc[$cat]++;
        } else {
            $acc[$cat] = 1;
        }
        return $acc;
    }, []);
    $articlePerCategories = array_reduce($articles, function ($acc, $article) {
        if (isset($acc[$article["category"]])) {
            $acc[$article["category"]] = [...$acc[$article["category"]], $article];
        } else {
            $acc[$article["category"]] = [$article];
        }

        return $acc;
    }, []);
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Blog</title>
    <?php require_once "includes/head.php" ?>
</head>

<body class="flex flex-col h-screen font-poppins bg-slate-100">
    <?php require_once "includes/header.php" ?>
    <main class="flex-1 flex flex-col self-center items-center py-8 max-w-5xl">
        <div class="flex flex-row flex-nowrap">
            <ul class="flex-[280px]">
                <li class="hover:text-primary cursor-pointer transition duration-300 <?= $selectedCat ? "" : "font-bold text-primary" ?>">
                    <a href="/">Tous les articles<small>(<?= count($articles) ?>)</small> </a>
                </li>
                <?php foreach ($categories as $catName => $catNum): ?>
                    <li class="capitalize my-2 hover:text-primary cursor-pointer transition duration-300 <?= $selectedCat === $catName ? "font-bold text-primary" : "" ?>">
                        <a href="/?cat=<?= $catName ?>"><?= $catName ?><small>(<?= $catNum ?></small>)</a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div>
                <?php if (!$selectedCat): ?>
                    <?php foreach ($categories as $cat => $num): ?>
                        <h1 class="text-xl font-bold px-2 capitalize"><?= $cat ?></h1>
                        <div class="flex flex-row flex-wrap justify-center items-start mb-5">
                            <?php foreach ($articlePerCategories[$cat] as $article): ?>
                                <article class="flex-[30%] m-2 bg-light shadow-md min-h-[365px] cursor-pointer">
                                    <div class="overflow-hidden">
                                        <div class=" bg-[url('<?= $article["image"] ?>')] h-[300px] bg-cover hover:scale-125 transition duration-500"></div>
                                    </div>
                                    <h2 class="p-2"><?= $article["title"] ?></h2>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach ?>
                <?php else: ?>
                    <h1 class="text-xl font-bold px-2 capitalize"><?= $selectedCat ?></h1>
                    <div class="flex flex-row flex-wrap justify-center items-start mb-5">
                        <?php foreach ($articlePerCategories[$selectedCat] as $article): ?>
                            <article class="flex-[30%] m-2 bg-light shadow-md min-h-[365px] cursor-pointer">
                                <div class="overflow-hidden">
                                    <div class=" bg-[url('<?= $article["image"] ?>')] h-[300px] bg-cover hover:scale-125 transition duration-500"></div>
                                </div>
                                <h2 class="p-2"><?= $article["title"] ?></h2>
                            </article>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php require_once "includes/footer.php" ?>
</body>

</html>