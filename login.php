<?php
session_start();

function my_autoloader($class) {
    include $class . '.php';
}
spl_autoload_register('my_autoloader');

Db::pripoj('127.0.0.1','root', '', 'blog');

$model = new BlogModel();

$zprava = "";
if($_POST)
  {
    if($_POST['heslo'] != "" && $_POST['jmeno'] != "")
    {
      $uzivatel = $model->login($_POST['jmeno'], $_POST['heslo']);
      $admin = $model->isAdmin($_POST['jmeno'], $_POST['heslo']);
        if (!$uzivatel) 
        {
                $zprava = 'Neplatné uživatelské jméno nebo heslo';
        }
        
        else
        {
                $_SESSION['USER'] = $_POST['jmeno'];
                
                  if((string)$admin == '1') $_SESSION['ADMIN'] = 1;
                  else $_SESSION['ADMIN'] = 0;

                header('Location: index.php');
                exit();
        }
    }
    else $zprava = "Vyplňte všechna pole";
  }
 ?>
 <html>
 <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale-1">
  <script src="js/jquery-1.11.1.min.js"></script>
  <link rel="stylesheet" href="style/reset.css">
  <link rel="stylesheet" href="style/layout.css">
  <link rel="stylesheet" href="style/main.css">
  <title>Blog</title>
 </head>
 <body>
  <div class="top clearfix">
    <h1>Blog</h1>
    <a href="index.php" class="back">Hlavní stránka</a>
  </div>
  <form method="post" class="log">
  	<div class="block"><p class="elem">Jméno: </p><input type="text" name="jmeno" class="bord jmeno"></div>
  	<div class="block"><p class="elem">Heslo: </p><input type="password" name="heslo" class="bord heslo"></div>
  	<div class="block"><input type="submit" value="Odeslat" name="submit"><br></div>
  	<?php
  		echo "<p class='zprava marg'>" . $zprava . "</p>";
  	?>
  </form>
 </body>
</html>