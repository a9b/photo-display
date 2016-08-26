<?php
require 'vendor/autoload.php';
$dir = dirname(dirname(dirname(__FILE__))) .  "/lobona_camera/";
define("DIR_PHOTO",$dir);

$url = "http://lobona-photo.a9b.jp/";
define("IMAGE_HOSTNAME",$url);

use Slim\Slim;
//use Slim\Extras\Views\Twig as Twig;

$app = new Slim(array(
//  'view' => new Twig,
  'templates.path' => './templates'
));


/**
 * none
 * @create  2015/02/25 05:07:28
 * @update  2015/02/25 05:07:31
 * @author  seki
 * @access  public
 * @param   string $str string 
 * @return  mixed array() or false(boolean)
 **/
function get_file_path($dir="./") {
  $dir = DIR_PHOTO . $dir . DIRECTORY_SEPARATOR;
  $tmp = glob($dir . "*");
  return array_filter($tmp,function($path){
    return is_file($path);
  });
}//function

/**
 * none
 * @create  2015/02/23 15:10:22
 * @update  2015/02/23 15:10:22
 * @author  seki
 * @access  public
 * @param   string $str string 
 * @return  mixed array() or false(boolean)
 **/
function get_dir() {
  $dir = DIR_PHOTO;
  $tmp = glob($dir . "*");
  return array_filter($tmp,function($path){
    return is_dir($path);
  });
}//function

$app->get('/', function () use ($app){
  $dir = get_dir();
  $app->view->setData('dir', $dir);
  $app->render('index.html');
});

$app->get('/date/:date', function ($date) use ($app) {
    $a_file_path = get_file_path($date);
    $a_file_path = array_map(function($path){
      return str_replace(DIR_PHOTO,IMAGE_HOSTNAME,$path);
    },$a_file_path);

    sort($a_file_path);

    $app->view->setData('date', $date);
    $app->view->setData('a_file_path', $a_file_path);

    $app->render('view.html', array('name' => 'taka512'));
});

$app->get('/hello/:name', function ($name) use ($app) {
  echo "Hello, $name";
});

$app->run();
?>
