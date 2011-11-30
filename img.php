<?php
/**
 * webTunes Remote
 * 
 * @author     Pascal Claisse <admin@pnkz.biz>
 * @copyright  Copyright (c) 2011, Pascal Claisse
 * @version    0.0.1
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

error_reporting(E_ALL);

require_once 'classes/Configuration.class.php';
require_once 'classes/Controller.class.php';

$track = !empty($_GET['track']) ? $_GET['track'] : null;
$list  = !empty($_GET['list']) ? $_GET['list'] : null;

if(empty($track))
  die('no track');

$controller = new Controller();
$img = $controller->getArtwork($track, $list);

if(empty($img))
  die('no artwork');

$img = '/' . str_replace(':', '/', $img);

header('Content-Type: image/jpeg');
echo file_get_contents($img);
unlink($img);
exit();

?>
