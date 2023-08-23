<?php
require_once '../db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $query = "SELECT id, full_name, password_hash, email FROM utilisateurs WHERE email = :email";
  $stmt = $pdo->prepare($query);
  $stmt->execute(['email' => $email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  if ($user && password_verify($password, $user["password_hash"])) {
    header('Location: /pages/user-home.php');
  } else {
    $loginError = "Identifiants incorrects.";
  }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>Bienvenue sur la page de connexion de l'utilisateur</h1>
  <?php if (isset($loginError)): ?>
    <p>
      <?php echo $loginError; ?>
    </p>
  <?php endif; ?>
  <form method="post" action="/pages/login-user.php">
    <input type="email" name="email" placeholder="Adresse e-mail" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit" name="login">Se connecter</button>
  </form>
  <p>Vous n'avez pas de compte ? <a href="/pages/register-user.php"> Inscrivez-vous </a></p>
</body>

</html>
