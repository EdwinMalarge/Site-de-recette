<?php
session_start();

require_once(__DIR__ . '/config/my_sql.php');
require_once(__DIR__ . '/databaseconnect.php');

$getData = $_GET;

if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo ('La recette n\'existe pas');
    return;
}

// On récupère la recette
$retrieveRecipeStatement = $mysqlClient->prepare('SELECT r.* FROM recipes r WHERE r.recipe_id = :id ');
$retrieveRecipeStatement->execute([
    'id' => (int) $getData['id'],
]);
$recipe = $retrieveRecipeStatement->fetch();

if (!$recipe) {
    echo ('La recette n\'existe pas');
    return;


}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes -
        <?php echo ($recipe['title']); ?>
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">
    <div class="container">

        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>
            <?php echo ($recipe['title']); ?>
        </h1>
        <div class="row">
            <article class="col">
                <?php echo ($recipe['recipe']); ?>
            </article>
            <aside class="col">
                <p><i>Contribuée par
                        <?php echo ($recipe['author']); ?>
                    </i></p>
            </aside>
        </div>
        <hr />
        <h2>Commentaires</h2>
        <?php if ($recipe['comments'] !== []): ?>
            <div class="row">
                <?php foreach ($recipe['comments'] as $comment): ?>
                    <div class="comment">
                        <p>
                            <?php echo $comment['comment']; ?>
                        </p>
                        <i>(
                            <?php echo $comment['full_name']; ?>)
                        </i>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="row">
                <p>Aucun commentaire</p>
            </div>
        <?php endif; ?>
        <hr />
        <?php if (isset($_SESSION['loggedUser'])): ?>
            <?php require_once(__DIR__ . '/comments_create.php'); ?>
        <?php endif; ?>
    </div>
    <?php require_once(__DIR__ . '/footer.php'); ?>
</body>

</html>