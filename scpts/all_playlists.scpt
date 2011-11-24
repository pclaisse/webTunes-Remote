set playlistList to ""

tell application "iTunes"
  repeat with singleSource in sources
    set allPlaylists to user playlists of singleSource
    repeat with singlePlaylist in allPlaylists
		
		set playlistName to (get name of singlePlaylist)
	    set playlistList to playlistList & playlistName & ";#;"
	    
    end repeat
  end repeat
end tell

return playlistList

