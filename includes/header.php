<header class="bg-primary p-4 flex flex-row flex-nowrap items-center justify-between">
    <a href="/" class="text-light text-3xl font-bold cursor-pointer">Blog</a>
    <ul>
        <li class="rounded px-1 py-4 hover:bg-primaryDark transition duration-300 <?= $_SERVER["REQUEST_URI"] === "/add-article.php" ? "bg-primaryDark" : "" ?>">
            <a class="text-light" href="/form-article.php">Ecrire un article</a>
        </li>
    </ul>
</header>