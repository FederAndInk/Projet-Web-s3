<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<style>
p.error{
  color: red;
}
</style>
<body>
<?php
$error = $_GET['error'] ?? null;
if (! is_null($error)) {
  echo "<p class='error'>";
  
  if ($error == "createLoginUsed") {
    echo "Le nom d'utilisateur est déjà utilisé";
  } elseif ($error == "createMdpSize") {
    echo "Le mot de passe n'est pas assez long !";
  }elseif ($error == "loginNotExist"){
    echo "Le nom d'utilisateur n'existe pas ou le mot de passe n'est pas valide";
  }
  
  echo "</p>";
}
?>
	<!-- login et mdp -->
	<form action="../controler/login_flux.ctrl.php" method="post">
		<p>
			<label>Nom d'utilisateur : </label> <input type="text" name="login"
				required="required">
		</p>
		<p>
			<label>Mot de passe (8 caractere minimum) : </label> <input
				type="password" name="mdp" required="required" min="8">
		</p>
		<p>
			<input type="submit" value="Nouveau Compte" name="newLogin"> <input
				type="submit" value="Se connecter" name="connection">
		</p>
	</form>
</body>
</html>
