on run argv
  set currentTracks to ""
  
  try
    set searchText to item 1 of argv
  on error
    set searchText to ""
  end try
  
  try
    set searchPlaylist to item 2 of argv
  on error
    set searchPlaylist to ""
  end try
  
  tell application "iTunes"
    if searchPlaylist = "" then
      set searchTracklist to (search current playlist for searchText)
    else
      set searchTracklist to (search playlist searchPlaylist for searchText)
    end if
    set currentPlaylist to name of current playlist
    repeat with singleTrack in searchTracklist
      
      set trackName to (get name of singleTrack)
      set trackArtist to (get artist of singleTrack)
      set trackAlbum to (get album of singleTrack)
      
      set trackText to trackArtist & "|" & trackName & "|" & trackAlbum & "|" & currentPlaylist
      
      set currentTracks to currentTracks & trackText & ";#;"
      
    end repeat
  end tell
  
  return currentTracks
  
end run
