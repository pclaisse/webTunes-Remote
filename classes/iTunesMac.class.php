<?php
/**
 * webTunes Remote
 * 
 * @author     Pascal Claisse <admin@pnkz.biz>
 * @copyright  Copyright (c) 2011, Pascal Claisse
 * @version    0.0.1
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class iTunesMac {
  
  
  /**
   * play
   *
   * @access  public
   * @return  mixed
   */
  public function play() {
    return $this->execute("tell app \"iTunes\" to play");
  }
  
  
  /**
   * pause
   *
   * @access  public
   * @return  mixed
   */
  public function pause() {
    return $this->execute("tell app \"iTunes\" to pause");
  }
  
  
  /**
   * playpause
   *
   * @access  public
   * @return  mixed
   */
  public function playpause() {
    return $this->execute("tell app \"iTunes\" to playpause");
  }
  
  
  /**
   * nextTrack
   *
   * @access  public
   * @return  mixed
   */
  public function nextTrack() {
    return $this->execute("tell app \"iTunes\" to next track");
  }
  
  
  /**
   * prevTrack
   *
   * @access  public
   * @return  mixed
   */
  public function prevTrack() {
    return $this->execute("tell app \"iTunes\" to previous track");
  }
  
  
  /**
   * playTrack
   *
   * @access  public
   * @return  mixed
   */
  public function playTrack($track_no = 1, $playlist = '') {
    if(empty($playlist))
      return $this->execute("tell app \"iTunes\" to play track " . $track_no . " of current playlist");
    else
      return $this->execute("tell app \"iTunes\" to play track " . $track_no . " of user playlist \"" . $playlist . "\"");
  }
  
  
  /**
   * setPosition
   *
   * @access  public
   * @return  mixed
   */
  public function setPosition($position = 0) {
    $this->execute("tell app \"iTunes\" to set player position to " . $position);
  }
  
  
  /**
   * getVolume
   *
   * @access  public
   * @return  mixed
   */
  public function getVolume() {
    return $this->execute("tell app \"iTunes\" to get sound volume");
  }
  
  
  /**
   * setVolume
   *
   * @access  public
   * @return  mixed
   */
  public function setVolume($volume = 0) {
    return $this->execute("tell app \"iTunes\" to set sound volume to " . $volume);
  }
  
  
  /**
   * getTrackInfo
   *
   * @access  public
   * @return  mixed
   */
  public function getTrackInfo() {
    return $this->executeFile('current_track.scpt');
  }
  
  
  /**
   * getPositionInfo
   *
   * @access  public
   * @return  mixed
   */
  public function getPositionInfo() {
    return $this->executeFile('current_position.scpt');
  }
  
  
  /**
   * getDurationInfo
   *
   * @access  public
   * @return  mixed
   */
  public function getDurationInfo() {
    return $this->executeFile('current_duration.scpt');
  }
  
  
  /**
   * getPlaylistInfo
   *
   * @access  public
   * @return  mixed
   */
  public function getPlaylistInfo() {
    return $this->executeFile('current_playlist.scpt');
  }
  
  
  /**
   * getPlaylists
   *
   * @access  public
   * @return  mixed
   */
  public function getPlaylists() {
    return $this->executeFile('all_playlists.scpt');
  }
  
  
  /**
   * getSearch
   *
   * @access  public
   * @return  mixed
   */
  public function getSearch($search = '', $playlist = '') {
    return $this->executeFile('search_playlist.scpt', "'" . $search . "'" . (!empty($playlist) ? " '" . $playlist . "'" : null));
  }
  
  
  /**
   * getArtwork
   *
   * @access  public
   * @return  mixed
   */
  public function getArtwork($track = '', $playlist = '') {
    return $this->executeFile('track_artwork.scpt', "'" . substr(str_replace('/', ':', WT_DOC_PATH), 1) . "' '" . $track . "'" . (!empty($playlist) ? " '" . $playlist . "'" : null));
  }
  
  
  /**
   * execute
   *
   * @access  private
   * @return  mixed
   */
  private function execute($cmd = '') {
    return exec("osascript -e '" . $cmd . "'");
  }
  
  
  /**
   * executeFile
   *
   * @access  private
   * @return  mixed
   */
  private function executeFile($file = '', $params = '') {
    
    if(is_readable(WT_DOC_PATH . '/scpts/' . $file))
      return exec("osascript '" . WT_DOC_PATH . '/scpts/' . $file . "'" . (!empty($params) ? " " . $params : null));
    
    return false;
    
  }
  
  
}
