var currentTrack = "", currentPos = 0, currentDuration = 0, currentPlaylist = "";

var getTime = function(pos) {
  
  if(typeof pos == 'undefined' || pos <= 0)
    return {'hours':0, 'minutes':0, 'seconds':0, 'position': 0};
  
  var minute; 
  var hour;
  var second;


  hour = Math.floor(pos/3600);
  
  if(pos%3600 != 0) {
    minute = Math.floor((pos - (hour * 3600))/60);
    if((pos-(hour*3600))%60 == 0)
      second = pos;
    else
      second = Math.floor((pos-(hour*3600))%60)
  }
  
  return {'hours':hour, 'minutes':minute, 'seconds':second, 'position': pos};
  
};

var getAllPlaylists = function() {
  $.get('/webtunes/cmd.php?q=all_playlists', function(all) {
    var playlists = all.split(";#;");
    var sidebar_width = $('.player .main .sidebar').outerWidth();
    var l = 1, scrollTo = 1;
    
    $.each(playlists, function(key, playlist) {
          
          var playlistLn = $('<li />').attr('title', playlist).attr('id', l++);
          
          playlistLn.addClass('playlist');
          
          if(playlist == currentPlaylist) {
            playlistLn.addClass('active-playlist');
            scrollTo = l;
          }
          
          playlistLn.data('playlist', playlist);
          
          if(playlist.length >= 35)
            var playlist = playlist.substr(0, 32) + '...';
          
          playlistLn.append('<span>' + playlist + '</span>');
          
      $('.player .main .sidebar ul').append(playlistLn);
    });
    
    $('.player .main .sidebar .playlist').click(function() {
      $.get('/webtunes/cmd.php?q=playtrack&p[]=1&p[]=' + encodeURI($(this).data('playlist')));
    });
    
    window.location = '#' + (scrollTo - 2);
    
  });
};

var getPlaylist = function() {
  $.get('/webtunes/cmd.php?q=playlist', function(playlist) {
      
      playlist = playlist.substr(0, (playlist.length - 3));
        $('.player .main .tracklist table tbody').html("");
      
      var tracks = playlist.split(";#;");
      var i = 1;
      
      currentPlaylist = tracks[0].split("|");
      currentPlaylist = currentPlaylist[3];
      
      $.each(tracks, function(key, track) {
        
        var singleTrack = track.split("|");
        var trackLn = $('<tr />');
        
        if(i%2 == 1)
          trackLn.addClass('odd');
        
        trackLn.addClass('track');
        
        if(singleTrack[1] == currentTrack[1])
          trackLn.addClass('active-track');
        
        trackLn.data('playlist', currentPlaylist);
        trackLn.data('track-no', i);
        
        trackLn.append('<td class="track-no">' + (i++) + '</td>');
        trackLn.append('<td class="track-name">' + singleTrack[1] + '</td>');
        trackLn.append('<td class="track-artist">' + singleTrack[0] + '</td>');
        trackLn.append('<td class="track-album">' + singleTrack[2] + '</td>');
        
        $('.player .main .tracklist table tbody').append(trackLn);
        
      });
      
      if($('.player .sidebar ul li.active-playlist').length > 0 && $('.player .sidebar ul li.active-playlist').attr('title') != currentPlaylist) {
        $('.player .sidebar ul li.active-playlist').removeClass('active-playlist');
        var scrollTo = $('.player .sidebar ul li[title="' + currentPlaylist + '"]').addClass('active-playlist').attr('id');
        window.location = '#' + (scrollTo - 1);
      }
      
      $('.player .main .tracklist .track').click(function() {
        $.get('/webtunes/cmd.php?q=playtrack&p[]=' + $(this).data('track-no') + '&p[]=' + encodeURI($(this).data('playlist')));
      });
      
  });
};

var getTrackInfo = function() {
  $.get('/webtunes/cmd.php?q=info', function(track) {
      currentTrack = track.split('|');
      setTrackInfo();
  });
  $.get('/webtunes/cmd.php?q=duration', function(duration) {
      currentDuration = getTime(duration);
  });
};

var getCurrentPosition = function() {
  $.get('/webtunes/cmd.php?q=position', function(pos) {
      
      if(currentPos > pos) {
        getTrackInfo();
        getPlaylist();
      }
      
      currentPos = pos;
      currentTime = getTime(pos);
      
      setTrackPosition();
      
  });
};

var setTrackInfo = function() {
  
  if(currentTrack[0] == 'false') {
    $('.player .toolbar .info-window .window #artist-album').text('-');
    $('.player .toolbar .info-window .window #title').text('Player stopped!');
    $('.player .toolbar .circle-button#playpause').removeClass('pause-button').addClass('play-button');
    
  } else {
    
    $('.player .toolbar .info-window .window #artist-album').text(currentTrack[0] + ' - ' + currentTrack[2]);
    $('.player .toolbar .info-window .window #title').text(currentTrack[1]);
    
    switch(currentTrack[3]) {
      case 'play':
        $('.player .toolbar .circle-button#playpause').removeClass('play-button').addClass('pause-button');
        break;
      case 'stop':
      case 'pause':
        $('.player .toolbar .circle-button#playpause').removeClass('pause-button').addClass('play-button');
        break;
    }
          
  }
  
}

var setTrackPosition = function() {
  
  if(currentTime.position == 'missing value') {
    $('.player .toolbar .info-window .window #track-position').text('0:00');
  } else {
    $('.player .toolbar .info-window .window #track-position').text((currentTime.hours > 0 ? currentTime.hours + ':' : '') + currentTime.minutes + ':' + (currentTime.seconds < 10 ? '0' + currentTime.seconds : currentTime.seconds));
  }
          
  if(currentDuration.position == 'missing value') {
    $('.player .toolbar .info-window .window #track-duration').text('0:00');
    var progress = 0;
  } else {
    $('.player .toolbar .info-window .window #track-duration').text((currentDuration.hours > 0 ? currentDuration.hours + ':' : '') + currentDuration.minutes + ':' + (currentDuration.seconds < 10 ? '0' + currentDuration.seconds : currentDuration.seconds));
    var progress = Math.round(currentTime.position / currentDuration.position * 100);
  }
  
  $('.player .toolbar .info-window .window #track-bar div').width(progress + '%');
  
}

var setClickEvents = function() {
  
  $('.player .toolbar .circle-button#playpause').click(function() {
    if($(this).hasClass('play-button'))
      $('.player .toolbar .circle-button#playpause').removeClass('play-button').addClass('pause-button');
    else
      $('.player .toolbar .circle-button#playpause').removeClass('pause-button').addClass('play-button');
    $.get('/webtunes/cmd.php?q=playpause');
  });
  
  $('.player .toolbar .circle-button#prev').click(function() {
    $.get('/webtunes/cmd.php?q=prev');
  });
  
  $('.player .toolbar .circle-button#next').click(function() {
    $.get('/webtunes/cmd.php?q=next');
  });
  
};

var getVolumeProgress = function() {
  
  $.get('/webtunes/cmd.php?q=volume', function(volume) {
    
    $( ".player .volume-bar" ).slider({
        range: "min",
        value: volume,
        min: 1,
        max: 100,
        change: function( event, ui ) {
            setVolumeProgress(ui.value);
        }
    });
  
  });
  
};

var setVolumeProgress = function(volume) {
  $.get('/webtunes/cmd.php?q=volume&p[]=' + volume);
};

$(document).ready(function() {

    getTrackInfo();
    getPlaylist();
    getAllPlaylists();
    
    setClickEvents();
    getVolumeProgress();
    
    window.setInterval(getTrackInfo, 5000);
    window.setInterval(getCurrentPosition, 1000);
    
});
