<?php
/**
 * webTunes Remote
 * 
 * @author     Pascal Claisse <admin@pnkz.biz>
 * @copyright  Copyright (c) 2011, Pascal Claisse
 * @version    0.0.1
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Configuration {
  
  
  /**
   * operating system constants
   */
  const WT_SERVER_OS_MAC = 1;
  const WT_SERVER_OS_WIN = 2;
  
  
  /**
   * constructor
   * set config file
   * 
   * @access  public
   */
  public function __construct() {
    
    if(is_readable('config/setup.ini'))
      $this->ini = parse_ini_file('config/setup.ini', true);
    else
      die('no config file found');
    
    $this->setInstallPath();
    
  }
  
  
  public function setInstallPath() {
    
    define('WT_DOC_PATH', $_SERVER['DOCUMENT_ROOT'] . $this->ini['SETUP']['INSTALL_PATH']);
    set_include_path(get_include_path() . PATH_SEPARATOR . WT_DOC_PATH);
    
  }
  
  
  public function getServerOS() {
    return $this->ini['SETUP']['OPERATING_SYSTEM'];
  }
  
  
}
