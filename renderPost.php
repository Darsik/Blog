<?php
session_start();

function my_autoloader($class) {
    include $class . '.php';
}
spl_autoload_register('my_autoloader');

Db::pripoj('127.0.0.1','root', '', 'blog');

$model = new BlogModel();

$post = $model->vybratClanek($_GET['id']);
$coments = $model->vybratKomentare($_GET['id']);
$zpráva = "";
if(isset($_POST['submit']))
{
  if($_POST['text'] != "")
  {
    $comment = $model->pridatKoment($_POST['text'], $_SESSION['USER'], $_GET['id']);
    header('Location: renderPost.php?id=' . $_GET['id'] . '');
  }
  else $zpráva = "Zapomněl jsi vyplnit obsah komentáře.";
}

if(isset($_SESSION['USER'])) $userLog = $_SESSION['USER'];
  else $userLog = "";

  if(isset($_SESSION['ADMIN'])) $admin = $_SESSION['ADMIN'];
  else $admin = "";

?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale-1">
  <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="jquery.confirm-master/jquery.confirm.min.js"></script>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="style/reset.css">
  <link rel="stylesheet" href="style/layout.css">
  <link rel="stylesheet" href="style/main.css">
  <script type="text/javascript" src="js/javascript.js"></script>
  <title>Blog</title>
 </head>
 <body>
  <div class="top clearfix">
    <h1>Blog</h1>
    <a href="index.php" class="back">Hlavní stránka</a>
    <?php 
      if(isset($_SESSION['USER']))
        echo "<a href='logout.php' class='logout'>Odhlásit</a>";
      else
        echo "<a href='login.php' class='login'>Přihlásit</a>";
      ?>
  </div>
  <div class="info-bar">
    <?php
      if(isset($_SESSION['USER'])) { 
        echo "<a class='user'>" . $_SESSION['USER'] . "</a>";
        echo "<a class='add' href='updatePost.php?id=" . $_GET['id'] . "'>Upravit článek</a>";
      } 
    ?>
  </div>
  <div class="stranka">
    <?php 
      foreach ($post as $pos) {
        echo "<div class='obsah'><p class='nadpis'>" . $pos['title'] . "</p><div class='obsahText'>" . $pos['text'] . "</div><div class='autor'>Autor: " . $pos['author'] . "</div></div>";
      }
    ?>
  </div>
  <div class='pridatKoment'>
    <div class="pridatKoment2">
      <?php
        if(isset($_SESSION['USER']))
        {
          echo "<form method=post><textarea name='text' class='bord' placeholder='Komentář'></textarea><input type='submit' name='submit' value='Odeslat' class='addKoment'></form>";

        }
        else echo "<div class='chciLogin'>Pro přidání komentáře se musíte <a href='login.php'>přihlásit</a></div>";
        echo $zpráva;
      ?>
    </div>
  </div>
  <div class="komenty">
    <div class="komenty2">
      <?php
        foreach ($coments as $coment) {
          echo "<div class='koment'><p class='komentAutor'>" . $coment['name'] . " napsal: </p>" . (($admin == 1)? "<div class='crossKom'><a href='deleteKoment.php?id=" . $coment['id'] . "&id_post=" . $_GET['id'] . "'>x</a></div>":(($userLog == $coment['name'])? "<div class='crossKom'><a href='deleteKoment.php?id=" . $coment['id'] . "&id_post=" . $_GET['id'] . "'>x</a></div>":"")) . "<p class='komentText'>" . $coment['text'] . "</p></div>";
        }
      ?>
    </div>
  </div>
 </body>
</html>