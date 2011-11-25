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

$query  = !empty($_GET['q']) ? $_GET['q'] : '';
$params = !empty($_GET['p']) ? $_GET['p'] : '';

require_once 'classes/Configuration.class.php';
require_once 'classes/Controller.class.php';

$controller = new Controller();
$controller->setParams($params);
$controller->setCmd($query);

$controller->run();

?>
