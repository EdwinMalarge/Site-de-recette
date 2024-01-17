<?php
$postData = $_POST;
$fileInfo = pathinfo($_FILES["screenshot"]["name"]);

$extension = $fileInfo["extension"];
$allowedExtensions = ["jpg", "jpeg", "gif", "png"];
$path = __DIR__ . "/uploads";
$isFileLoaded = false;

if (
    !isset($postData['email'])
    || !filter_var($postData['email'], FILTER_VALIDATE_EMAIL)
    || empty($postData['message'])
    || trim($postData['message']) === ''
) {
    echo ('Il faut un email et un message valides pour soumettre le formulaire.');
    return;
}

if (isset($_FILES["screenshot"]) && $_FILES["scrennshot"]["error"] === 0) {

    if ($_FILES["screenshot"]["size"] > 1000000) {
        echo ("Le fichier est trop volumineux pour être envoyé");
        return;
    }

    if (in_array($extension, $allowedExtensions)) {
        echo ("L'extension {$extension} n'est pas autorisée pour cet envoi");
        return;
    }

    if (!is_dir($path)) {
        echo ("Le fichier n'as pas pu être receptionné car le dossier 'upload' est manquant, merci de contacter un administrateur");
        return;
    }

    move_uploaded_file($_FILES["scrennshot"]["tmp_name"], $path . basename($_FILES["screenshot"]["name"]));
    $isFileLoaded = true;

}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Contact reçu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">

        <?php require_once(__DIR__ . '/header.php'); ?>
        <h1>Message bien reçu !</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Rappel de vos informations</h5>
                <p class="card-text"><b>Email</b> :
                    <?php echo ($postData['email']); ?>
                </p>
                <p class="card-text"><b>Message</b> :
                    <?php echo strip_tags($postData['message']); ?>
                </p>
                <?php if ($isFileLoaded): ?>
                    <div class="alert alert-success" role="alert">
                        L'envoi a bien été effectué !
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>