<?php
session_start();
function my_autoloader($class) {
    include $class . '.php';
}
spl_autoload_register('my_autoloader');

Db::pripoj('127.0.0.1','root', '', 'blog');

if(isset($_SESSION['USER'])) $userLog = $_SESSION['USER'];
  else $userLog = "";

if(isset($_SESSION['ADMIN'])) $admin = $_SESSION['ADMIN'];
  else $admin = "";

$filter = $_REQUEST['filter'];
if(isset($_GET['autor'])) $autor = $_GET['autor'];


if($filter === "all")
{
	$posts = Db::dotazVsechny('SELECT * FROM post');
	if(is_array($posts))
    {
        foreach ($posts as $post) {
        	echo "<div class='ukazkaClanku clearfix'><p class='heading'><a href='renderPost.php?id=" . $post['id'] . "'>" . $post['title'] . "</a></p>" . (($admin == 1)? "<div class='cross'><a href='deletePost.php?id=" . $post['id'] . "' class='crossx'>x</a></div>":(($userLog == $post['author'])? "<div class='cross'><a href='deletePost.php?id=" . $post['id'] . "' class='crossx'>x</a></div>":"")) . (($post['author'] == $userLog)? "<b><a href='updatePost.php?id=" . $post['id'] . "' class='edit'>Edit</a></b>":"") . "<div class='text'>" . $post['perex'] . "</div><b><p class='author'>Autor: " . $post['author'] . "</p></b><a href='renderPost.php?id=" . $post['id'] . "' class='next'>Celý článek</a></div>";
        }
    }
}
else if($filter === "autori")
{
	$autoriPosts = Db::dotazVsechny('SELECT * FROM post WHERE author LIKE ?',array("%$autor%"));
	if(is_array($autoriPosts))
    {
        foreach ($autoriPosts as $apost) {
        	echo "<div class='ukazkaClanku clearfix'><p class='heading'><a href='renderPost.php?id=" . $apost['id'] . "'>" . $apost['title'] . "</a></p>" . (($admin == 1)? "<div class='cross'><a href='deletePost.php?id=" . $apost['id'] . "' class='crossx'>x</a></div>":(($userLog == $apost['author'])? "<div class='cross'><a href='deletePost.php?id=" . $apost['id'] . "' class='crossx'>x</a></div>":"")) . (($apost['author'] == $userLog)? "<b><a href='updatePost.php?id=" . $apost['id'] . "' class='edit'>Edit</a></b>":"") . "<div class='text'>" . $apost['perex'] . "</div><b><p class='author'>Autor: " . $apost['author'] . "</p></b><a href='renderPost.php?id=" . $apost['id'] . "' class='next'>Celý článek</a></div>";
        }
    }
}
