<?php
session_start();

function my_autoloader($class) {
    include $class . '.php';
}

spl_autoload_register('my_autoloader');

Db::pripoj('127.0.0.1','root', '', 'blog');

$model = new BlogModel();

if(!isset($_SESSION['USER']))
	header('Location: index.php');

$zprava = "";

if($_POST)
{
	if($_POST['title'] != "" && $_POST['text'] != "" && $_POST['perex'] != "")
  {
		$post = $model->pridatClanek($_POST['title'], $_SESSION['USER'], $_POST['text'], $_POST['perex']);
    header('Location: index.php');
  }
  else $zprava = "Některý údaj není vyplněný.";
}

?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale-1">
  <script src="js/jquery-1.11.1.min.js"></script>
  <link href="froala_editor_1.2.6/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
  <link href="froala_editor_1.2.6/css/froala_editor.min.css" rel="stylesheet" type="text/css" />
  <link href="froala_editor_1.2.6/css/froala_style.min.css" rel="stylesheet" type="text/css" />
  <link href="froala_editor_1.2.6/css/froala_content.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="style/reset.css">
  <link rel="stylesheet" href="style/layout.css">
  <link rel="stylesheet" href="style/main.css">
  <script src="froala_editor_1.2.6/js/froala_editor.min.js"></script>
  <script type="text/javascript" src="js/edit.js"></script>
  <title>Blog</title>
 </head>
 <body>
  <div class="top clearfix">
    <h1>Blog</h1>
    <?php 
      if(isset($_SESSION['USER']))
        echo "<a href='logout.php' class='logout'>Odhlásit</a>";
      ?>
      <a href="index.php" class="back">Hlavní stránka</a>
  </div>
  <div class="info-bar">
    <?php
      if(isset($_SESSION['USER'])) { 
        echo "<a class='user'>" . $_SESSION['USER'] . "</a>";
       } 
    ?>
  </div>
  <div class="pridatPost">
    <form method="post">
    	<div class="inline"><p class="elem">Titulek:</p><input type="text" name="title" class="title bord"></div>
      <div class="inline"><p class="elem">Perex:</p><textarea name="perex" class="bord"></textarea></div>
    	<div class="left"><p class="elem">Text:</p><textarea id="edit" name="text"></textarea></div>
    	<input type="submit" value="Odeslat" name="submit" class="addBut"><br>
      <?php 
        echo "<p class='zprava'>" . $zprava . "</p>";
      ?>
    </form>
  </div>
 </body>
</html>