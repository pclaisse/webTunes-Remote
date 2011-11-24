<?
$q = $_GET['q'];
$p = $_GET['p'];

switch ($q)
{
case "":
echo "You need to send me a command, then I shall execute it";
break;

case "play";
exec("osascript -e 'tell app \"iTunes\" to play'");
echo "Playing";
break;

case "playtrack";
if(!empty($p[0]) && !empty($p[1]))
  exec("osascript -e 'tell app \"iTunes\" to play track " . $p[0] . " of user playlist \"" . stripslashes($p[1]) . "\"'");
echo "Playing Track";
break;

case "playtrack_current";
if(!empty($p[0]))
  exec("osascript -e 'tell app \"iTunes\" to play track " . $p[0] . " of current playlist'");
echo "Playing Track";
break;

case "pause";
exec("osascript -e 'tell app \"iTunes\" to pause'");
echo "Pausing";
break;

case "playpause";
exec("osascript -e 'tell app \"iTunes\" to playpause'");
echo "Toggling Play";
break;

case "next";
exec("osascript -e 'tell app \"iTunes\" to next track'");
echo "Next Track";
break;

case "prev";
exec("osascript -e 'tell app \"iTunes\" to previous track'");
echo "Previous Track";
break;

case "louder";
exec("osascript -e 'tell app \"iTunes\" to set sound volume to sound volume + 5'");
echo "Turning Up the Volume";
break;

case "quieter";
exec("osascript -e 'tell app \"iTunes\" to set sound volume to sound volume - 5'");
echo "Turning Down the Volume";
break;

case "volume";
if(!empty($p))
  exec("osascript -e 'tell app \"iTunes\" to set sound volume to " . $p[0] . "'");
else
  echo exec("osascript -e 'tell app \"iTunes\" to get sound volume'");
break;

case "info";
echo exec("osascript '/Applications/MAMP/htdocs/webtunes/scpts/current_track.scpt'");
break;

case "position";
echo exec("osascript '/Applications/MAMP/htdocs/webtunes/scpts/current_position.scpt'");
break;

case "set_position";
if(!empty($p[0]))
  exec("osascript -e 'tell app \"iTunes\" to set player position to " . $p[0] . "'");
break;

case "duration";
echo exec("osascript '/Applications/MAMP/htdocs/webtunes/scpts/current_duration.scpt'");
break;

case "playlist";
echo exec("osascript '/Applications/MAMP/htdocs/webtunes/scpts/current_playlist.scpt'");
break;

case "all_playlists";
echo exec("osascript '/Applications/MAMP/htdocs/webtunes/scpts/all_playlists.scpt'");
break;

//case "mute";
//mutev();
//echo "Muting the Volume";
//break;

}

?>
