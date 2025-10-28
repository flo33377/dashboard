
<div id="authenticate_content">

  <h1>Bienvenue sur le dashboard des sites de Florian Neto</h1>

  <p>Pour accéder aux données de navigation, vous devez être authentifié.</p>

  <form action="" method="POST" id="authenticate_form">
    <input type='hidden' name="post_authenticate" required>
    <label for="password">Merci de saisir le mot de passe :</label>
    <input type="password" id="password" name="password" placeholder="Mot de passe" required>
    <input type="submit" id="authenticate_button" value="Valider">
  </form>


  <?php if(isset($errorMessage) && $errorMessage == "wrong_password") : ?>
      <div id="error_message">Le mot de passe saisi est incorrect. Merci de réessayer</div>
  <?php endif ?>

</div>
