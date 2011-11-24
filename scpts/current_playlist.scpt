set currentTracks to ""

tell application "iTunes"
  set allTracksList to file tracks of current playlist
  set currentPlaylist to name of current playlist
  repeat with singleTrack in allTracksList
  
	set trackName to (get name of singleTrack)
	set trackArtist to (get artist of singleTrack)
	set trackAlbum to (get album of singleTrack)
    
    set trackText to trackArtist & "|" & trackName & "|" & trackAlbum & "|" & currentPlaylist
    
    set currentTracks to currentTracks & trackText & ";#;"
    
  end repeat
end tell

currentTracks
