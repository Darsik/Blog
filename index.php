<?php
session_start();

function my_autoloader($class) {
    include $class . '.php';
}
spl_autoload_register('my_autoloader');

Db::pripoj('127.0.0.1','root', '', 'blog');
$posts = Db::dotazVsechny('SELECT * FROM post');

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
    <?php 
      if(isset($_SESSION['USER']))
        echo "<a href='logout.php' class='logout'>Odhlásit</a>";
      else
        echo "<a href='login.php' class='login'>Přihlásit</a><a href='registrace.php' class='register'>Registrace</a>";
      ?>
  </div>
  <div class="info-bar">
    <?php
      if(isset($_SESSION['USER'])) { 
        echo "<a class='user'>" . $_SESSION['USER'] . "</a>";
        echo "<a href='addPost.php' class='add'>Přidat příspěvek</a>";
      } 
    ?>
  </div>
  <div class="fitrace zarovnani">
    <div class="vse filtry"><p>Vybrat Vše</p></div>
    <div class="dleAutora filtry"><p>Podle Autora</p></div>
    <div class="autori">
      <form onsubmit="return false;">
        <input type="text" id="inputAutor" placeholder="Jmeno autora" class="inputAutor bord">
      </form>
    </div>
  </div>
  <div class="posty" id="posty">
    <?php
      if(is_array($posts))
      {
        foreach ($posts as $post) {
          echo "<div class='ukazkaClanku clearfix'><p class='heading'><a href='renderPost.php?id=" . $post['id'] . "'>" . $post['title'] . "</a></p>" . (($admin == 1)? "<div class='cross'><a href='deletePost.php?id=" . $post['id'] . "' class='crossx'>x</a></div>":(($userLog == $post['author'])? "<div class='cross'><a href='deletePost.php?id=" . $post['id'] . "' class='crossx'>x</a></div>":"")) . (($post['author'] == $userLog)? "<b><a href='updatePost.php?id=" . $post['id'] . "' class='edit'>Edit</a></b>":"") . "<div class='text'>" . $post['perex'] . "</div><b><p class='author'>Autor: " . $post['author'] . "</p></b><a href='renderPost.php?id=" . $post['id'] . "' class='next'>Celý článek</a></div>";
        }
      }
    ?>
  </div>
 </body>
</html>