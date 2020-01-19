<!DOCTYPE html>
<html lang="de">
  <head>
    <title><?php echo htmlspecialchars( $results['pageTitle'] )?></title>
    <link rel="stylesheet" type="text/css" href="style/style.css"/>
    <link rel="stylesheet" type="text/css" href="style/bootstrap.min.css"/>
    <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
  </head>
  <body class="text-center flex-column-reverse login-form">
    <form class="form-signin" action="index.php?action=login" method="post">
      <img class="mb-4" src="images/logo_eoa_b.png" alt="Elements of Art" style="max-width:80%;">
      <h1 class="h3 mb-3 font-weight-normal">Bitte einloggen</h1>
      <label for="username" class="sr-only">Benutzername</label>
      <input type="text" name="username" id="username" class="form-control" placeholder="Benutzername" required="" autofocus="">
      <br />
      <label for="password" class="sr-only">Passwort</label>
      <input type="password" name="password" id="password" class="form-control" placeholder="Passwort" required="">
      <br />
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="login" value="Login">Einloggen</button>
      <p class="mt-5 mb-3 text-muted">© 2020</p>
    </form>
<?php if ( isset( $results['errorMessage'] ) ) { ?>
        <div class="errorMessage"><?php echo $results['errorMessage'] ?></div>
<?php } ?>
  </body>
</html>