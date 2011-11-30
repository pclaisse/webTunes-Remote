on run argv
  
  try
    set installPath to item 1 of argv
  on error
    set installPath to ""
  end try
  
  try
    set artworkTrack to item 2 of argv
  on error
    set artworkTrack to ""
  end try
  
  try
    set artworkPlaylist to item 3 of argv
  on error
    set artworkPlaylist to ""
  end try
  
  tell application "iTunes"
    
    if artworkPlaylist = "" then
      set theTrack to track artworkTrack of current playlist
    else
      set theTrack to track artworkTrack of playlist artworkPlaylist
    end if
    
    if (artworks of theTrack exists) then
      set theArt to front artwork of theTrack
      set pic to (raw data of theArt)
      set the_artwork_file to installPath & ":_cache:" & (random number from 1 to 9999) & ".jpg"
      try
        set RefNum to (open for access the_artwork_file with write permission)
        write (pic) to RefNum
        close access RefNum
        return the_artwork_file
      end try
    end if
    
    return ""
    
  end tell
  
end run
