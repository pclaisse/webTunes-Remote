set currentName to ""
set currentArtist to ""
set currentAlbum to ""
set currentState to ""

tell application "iTunes"
  
  if player state is stopped then 
    set currentState to "stop"
    return false
  end if
  if player state is playing then
    set currentState to "play"
  end if
  if player state is paused then
    set currentState to "pause"
  end if
  
  set currentName to (get name of current track)
  set currentArtist to (get artist of current track)
  set currentAlbum to (get album of current track)
  
end tell

currentArtist & "|" & currentName & "|" & currentAlbum & "|" & currentState
