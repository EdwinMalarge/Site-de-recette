<?php
session_start();
require_once(__DIR__ . "/variables.php");
require_once(__DIR__ . "/functions.php");


$postData = $_POST;
if (isset($postData["email"]) && isset($postData["password"])) {
    if (!filter_var($postData["email"], FILTER_VALIDATE_EMAIL)) {
        $_SESSION["loginErrorMessage"] = "L'email n'est pas valide";
    } else {
        foreach ($users as $user) {
            if ($user["email"] === $postData["email"] && $user["password"] === $postData["password"]) {
                $_SESSION["loggedUser"] = ["email" => $user["email"],];
            }
        }

        if (!isset($_SESSION["loggedUser"])) {
            $_SESSION["loginErrorMessage"] = sprintf("L'email et le mot de passe ne correspondent pas");
        }
    }
    redirectToUrl("index.php");
}
