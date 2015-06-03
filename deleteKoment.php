<?php
function my_autoloader($class) {
    include $class . '.php';
}
spl_autoload_register('my_autoloader');

Db::pripoj('127.0.0.1','root', '', 'blog');
$model = new BlogModel();
$del = $model->odebratKoment($_GET['id']);
header('Location: renderPost.php?id=' . $_GET['id_post'] . '');