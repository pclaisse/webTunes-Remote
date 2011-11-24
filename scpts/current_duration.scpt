set currentDuration to 0

tell application "iTunes"
  set currentDuration to (get duration of current track)
end tell

currentDuration
