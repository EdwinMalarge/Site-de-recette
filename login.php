<?php


if (!isset($_SESSION["loggedUser"])): ?>
    <h5>Merci de vous identifer</h5>
    <form action="submit_login.php" method="POST">

        <?php if (isset($_SESSION["loginErrorMessage"])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_SESSION["loginErrorMessage"]; ?>
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="email-help">
            <div id="email-help" class="form-text">Nous ne revendrons pas votre email.</div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" minlength="6" required>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
<?php else: ?>
    <div class="alert alert-success" role="alert">
        Bonjour
        <?php echo $_SESSION["loggedUser"]["email"]; ?>, profite bien des recettes !
    </div>
    </div>
<?php endif; ?>