<?php
/**
 * webTunes Remote
 * 
 * @author     Pascal Claisse <admin@pnkz.biz>
 * @copyright  Copyright (c) 2011, Pascal Claisse
 * @version    0.0.1
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class Controller extends Configuration {
  
  /**
   * itunes object
   * wether iTunesWin or iTunesMac
   * 
   * @access  private
   * @var     object
   */
  private $itunes;
  
  
  /**
   * command to execute
   * 
   * @access  private
   * @var     string
   */
  private $cmd;
  
  
  /**
   * params for command to execute
   * 
   * @access  private
   * @var     array
   */
  private $params = array();
  
  
  
  /**
   * array of available commands
   * 
   * @access  private
   * @var     array
   */
  private $available_cmds = array();
  
  
  /**
   * constructor
   * analysis os and set object
   * 
   * @access  public
   */
  public function __construct() {
    parent::__construct();
    
    // set available commands
    $this->available_cmds = array('*' => true);
    
    switch($this->getServerOS()) {
      case Configuration::WT_SERVER_OS_MAC:
        require_once 'classes/iTunesMac.class.php';
        $this->itunes = new iTunesMac();
        break;
      case Configuration::WT_SERVER_OS_WIN:
        // NA
        break;
    }
    
  }
  
  
  public function setParams($p = array()) {
    if(!empty($p)) {
      if(is_array($p))
        $this->params = $p;
      else
        $this->params = array($p);
    }
  }
  
  
  public function setCmd($c = '') {
    if(!empty($c) && $this->isAvailableCmd($c))
      $this->cmd = $c;
  }
  
  
  private function isAvailableCmd($c = '') {
    return !empty($this->available_cmds['*']) || !empty($this->available_cmds[$c]);
  }
  
  
  public function getArtwork($track = '', $list = '') {
    return $this->itunes->getArtwork($track, $list);
  }
  
  
  public function run() {
    
    if(empty($this->cmd))
      die('no cmd given');
    
    switch ($this->cmd) {
      case "play";
        $this->itunes->play();
        break;
        
      case "playtrack";
        $this->itunes->playTrack($this->params[0], (!empty($this->params[1]) ? $this->params[1] : null));
        break;
      
      case "playtrack_current";
        $this->itunes->playTrack($this->params[0]);
        break;
      
      case "pause";
        $this->itunes->pause();
        break;
      
      case "playpause";
        $this->itunes->playpause();
        break;
      
      case "next";
        $this->itunes->nextTrack();
        break;
      
      case "prev";
        $this->itunes->prevTrack();
        break;
      
      case "volume";
        if(!empty($this->params))
          $this->itunes->setVolume($this->params[0]);
        else
          echo $this->itunes->getVolume();
        break;
      
      case "info";
        echo $this->itunes->getTrackInfo();
        break;
      
      case "position";
        echo $this->itunes->getPositionInfo();
        break;
      
      case "set_position";
        $this->itunes->setPosition($this->params[0]);
        break;
      
      case "duration";
        echo $this->itunes->getDurationInfo();
        break;
      
      case "playlist";
        echo $this->itunes->getPlaylistInfo();
        break;
      
      case "all_playlists";
        echo $this->itunes->getPlaylists();
        break;
        
      case "search";
        echo $this->itunes->getSearch($this->params[0], (!empty($this->params[1]) ? $this->params[1] : null));
        break;
      
      default:
        echo "You need to send me a command, then I shall execute it";
        break;
        
    }
    
  }
  
  
}

?>
