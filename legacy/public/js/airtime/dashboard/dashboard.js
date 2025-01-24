//approximate server time, because once we receive it from the server,
//there way have been a great amount of latency and it is no longer accurate.
var approximateServerTime = null;
var localRemoteTimeOffset = null;

var previousSong = null;
var currentSong = null;
var nextSong = null;

var currentShow = new Array();
var nextShow = new Array();

var showName = null;

var currentElem;

var serverUpdateInterval = 5000;
var uiUpdateInterval = 200;

var master_dj_on_air = false;
var live_dj_on_air = false;
var scheduled_play_on_air = false;
var scheduled_play_source = false;

//a reference returned by setTimeout. Useful for when we want clearTimeout()
var newSongTimeoutId = null;

//a reference returned by setTimeout. Useful for when we want clearTimeout()
var newShowTimeoutId = null;

//keep track of how many UI refreshes the ON-AIR light has been off for.
//For example, the uiUpdateInterval is every 200ms, so if onAirOffIterations
//is 25, then that means 5 seconds have gone by.
var onAirOffIterations = 0;

/* boolean flag to let us know if we should prepare to execute a function
 * that flips the playlist to the next song. This flag's purpose is to
 * make sure the function is only executed once*/
var nextSongPrepare = true;
var nextShowPrepare = true;

function secondsTimer() {
  /* This function constantly calls itself every 'uiUpdateInterval'
   * micro-seconds and is responsible for updating the UI. */
  if (localRemoteTimeOffset !== null) {
    var date = new Date();
    approximateServerTime = date.getTime() - localRemoteTimeOffset;
    updateProgressBarValue();
    updatePlaybar();
    controlOnAirLight();
    controlSwitchLight();
  }
  setTimeout(secondsTimer, uiUpdateInterval);
}

function newSongStart() {
  nextSongPrepare = true;
  if (nextSong.type == "track") {
    currentSong = nextSong;
    nextSong = null;
  }
}

function nextShowStart() {
  nextShowPrepare = true;
  currentShow[0] = nextShow.shift();
}

/* Called every "uiUpdateInterval" mseconds. */
function updateProgressBarValue() {
  var showPercentDone = 0;
  if (currentShow.length > 0) {
    showPercentDone =
      ((approximateServerTime - currentShow[0].showStartPosixTime) /
        currentShow[0].showLengthMs) *
      100;
    if (showPercentDone < 0 || showPercentDone > 100) {
      showPercentDone = 0;
      currentShow = new Array();
      currentSong = null;
    }
  }
  $("#progress-show").attr("style", "width:" + showPercentDone + "%");

  var songPercentDone = 0;
  var scheduled_play_div = $("#scheduled_play_div");
  var scheduled_play_line_to_switch = scheduled_play_div
    .parent()
    .find(".line-to-switch");

  if (currentSong !== null) {
    var songElapsedTime = 0;
    songPercentDone =
      ((approximateServerTime - currentSong.songStartPosixTime) /
        currentSong.songLengthMs) *
      100;
    songElapsedTime = approximateServerTime - currentSong.songStartPosixTime;
    if (songPercentDone < 0) {
      songPercentDone = 0;
      //currentSong = null;
    } else if (songPercentDone > 100) {
      songPercentDone = 100;
    } else {
      if (
        (currentSong.media_item_played == true && currentShow.length > 0) ||
        (songElapsedTime < 5000 && currentShow[0].record != 1)
      ) {
        scheduled_play_line_to_switch.attr("class", "line-to-switch on");
        scheduled_play_div.addClass("ready");
        scheduled_play_source = true;
      } else {
        scheduled_play_source = false;
        scheduled_play_line_to_switch.attr("class", "line-to-switch off");
        scheduled_play_div.removeClass("ready");
      }
      $("#progress-show").attr("class", "progress-show");
    }
  } else {
    scheduled_play_source = false;
    scheduled_play_line_to_switch.attr("class", "line-to-switch off");
    scheduled_play_div.removeClass("ready");
    $("#progress-show").attr("class", "progress-show-error");
  }
  $("#progress-bar").attr("style", "width:" + songPercentDone + "%");
}

function updatePlaybar() {
  /* Column 0 update */
  if (previousSong !== null) {
    $("#previous").text(previousSong.name + ",");
    $("#prev-length").text(convertToHHMMSSmm(previousSong.songLengthMs));
  } else {
    $("#previous").empty();
    $("#prev-length").empty();
  }

  if (currentSong !== null && !master_dj_on_air && !live_dj_on_air) {
    if (currentSong.record == "1") {
      $("#current").html(
        "<span style='color:red; font-weight:bold'>" +
        $.i18n._("Recording:") +
        "</span>" +
        currentSong.name +
        ",",
      );
    } else {
      $("#current").text(currentSong.name + ",");
      if (currentSong.metadata && currentSong.metadata.artwork_data) {
        var check_current_song = Cookies.get("current_track");
        var loaded = Cookies.get("loaded");

        if (check_current_song != currentSong.name) {
          $("#now-playing-artwork_containter").html(
            "<img height='75' width='75' class'artwork' src='" +
            currentSong.metadata.artwork_data +
            "' />",
          );
          Cookies.remove("current_track");
          Cookies.set("current_track", currentSong.name);
        }
        // makes sure it stays updated with current track if page loads
        if (loaded != UNIQID) {
          Cookies.remove("current_track");
          Cookies.remove("loaded");
          Cookies.set("loaded", UNIQID);
        }
      }
    }
  } else {
    if (master_dj_on_air) {
      if (showName) {
        $("#current").html(
          $.i18n._("Current") +
          ": <span style='color:red; font-weight:bold'>" +
          showName +
          " - " +
          $.i18n._("Master Stream") +
          "</span>",
        );
      } else {
        $("#current").html(
          $.i18n._("Current") +
          ": <span style='color:red; font-weight:bold'>" +
          $.i18n._("Master Stream") +
          "</span>",
        );
      }
    } else if (live_dj_on_air) {
      if (showName) {
        $("#current").html(
          $.i18n._("Current") +
          ": <span style='color:red; font-weight:bold'>" +
          showName +
          " - " +
          $.i18n._("Live Stream") +
          "</span>",
        );
      } else {
        $("#current").html(
          $.i18n._("Current") +
          ": <span style='color:red; font-weight:bold'>" +
          $.i18n._("Live Stream") +
          "</span>",
        );
      }
    } else {
      $("#current").html(
        $.i18n._("Current") +
        ": <span style='color:red; font-weight:bold'>" +
        $.i18n._("Nothing Scheduled") +
        "</span>",
      );
    }
  }

  if (nextSong !== null) {
    $("#next").text(nextSong.name + ",");
    $("#next-length").text(convertToHHMMSSmm(nextSong.songLengthMs));
  } else {
    $("#next").empty();
    $("#next-length").empty();
  }

  $("#start").empty();
  $("#end").empty();
  $("#time-elapsed").empty();
  $("#time-remaining").empty();
  $("#song-length").empty();
  if (currentSong !== null && !master_dj_on_air && !live_dj_on_air) {
    $("#start").text(currentSong.starts.split(" ")[1]);
    $("#end").text(currentSong.ends.split(" ")[1]);

    /* Get rid of the millisecond accuracy so that the second counters for both
     * show and song change at the same time. */
    var songStartRoughly =
      parseInt(Math.round(currentSong.songStartPosixTime / 1000), 10) * 1000;
    var songEndRoughly =
      parseInt(Math.round(currentSong.songEndPosixTime / 1000), 10) * 1000;

    $("#time-elapsed").text(
      convertToHHMMSS(approximateServerTime - songStartRoughly),
    );
    $("#time-remaining").text(
      convertToHHMMSS(songEndRoughly - approximateServerTime),
    );
    $("#song-length").text(convertToHHMMSS(currentSong.songLengthMs));
  }
  /* Column 1 update */
  $("#playlist").text($.i18n._("Current Show:"));
  var recElem = $(".recording-show");
  if (currentShow.length > 0) {
    $("#playlist").text(currentShow[0].name);
    currentShow[0].record == "1" ? recElem.show() : recElem.hide();
  } else {
    recElem.hide();
  }

  $("#show-length").empty();
  if (currentShow.length > 0) {
    $("#show-length").text(
      convertDateToHHMM(currentShow[0].showStartPosixTime) +
      " - " +
      convertDateToHHMM(currentShow[0].showEndPosixTime),
    );
  }

  /* Column 2 update */
  $("#time").text(convertDateToHHMMSS(approximateServerTime));
}

function calcAdditionalData(currentItem) {
  currentItem.songStartPosixTime = convertDateToPosixTime(currentItem.starts);
  currentItem.songEndPosixTime = convertDateToPosixTime(currentItem.ends);
  currentItem.songLengthMs =
    currentItem.songEndPosixTime - currentItem.songStartPosixTime;
}

function calcAdditionalShowData(show) {
  if (show.length > 0) {
    show[0].showStartPosixTime = convertDateToPosixTime(
      show[0].start_timestamp,
    );
    show[0].showEndPosixTime = convertDateToPosixTime(show[0].end_timestamp);
    show[0].showLengthMs =
      show[0].showEndPosixTime - show[0].showStartPosixTime;
  }
}

function calculateTimeToNextSong() {
  if (approximateServerTime === null) {
    return;
  }

  if (newSongTimeoutId !== null) {
    /* We have a previous timeout set, let's unset it */
    clearTimeout(newSongTimeoutId);
    newSongTimeoutId = null;
  }

  var diff = nextSong.songStartPosixTime - approximateServerTime;
  if (diff < 0) diff = 0;
  nextSongPrepare = false;
  newSongTimeoutId = setTimeout(newSongStart, diff);
}

function calculateTimeToNextShow() {
  if (approximateServerTime === null) {
    return;
  }

  if (newShowTimeoutId !== null) {
    /* We have a previous timeout set, let's unset it */
    clearTimeout(newShowTimeoutId);
    newShowTimeoutId = null;
  }

  var diff = nextShow[0].showStartPosixTime - approximateServerTime;
  if (diff < 0) diff = 0;
  nextShowPrepare = false;
  newShowTimeoutId = setTimeout(nextShowStart, diff);
}

function parseItems(obj) {
  previousSong = obj.previous;
  currentSong = obj.current;
  nextSong = obj.next;

  if (previousSong !== null) {
    calcAdditionalData(previousSong);
  }
  if (currentSong !== null) {
    calcAdditionalData(currentSong);
  }
  if (nextSong !== null) {
    calcAdditionalData(nextSong);
    calculateTimeToNextSong();
  }

  currentShow = new Array();
  if (obj.currentShow.length > 0) {
    calcAdditionalShowData(obj.currentShow);
    currentShow = obj.currentShow;
  }

  nextShow = new Array();
  if (obj.nextShow.length > 0) {
    calcAdditionalShowData(obj.nextShow);
    nextShow = obj.nextShow;
    calculateTimeToNextShow();
  }

  var schedulePosixTime = convertDateToPosixTime(obj.schedulerTime);
  var date = new Date();
  localRemoteTimeOffset = date.getTime() - schedulePosixTime;
}

function parseSourceStatus(obj) {
  var live_div = $("#live_dj_div");
  var master_div = $("#master_dj_div");
  var live_li = live_div.parent();
  var master_li = master_div.parent();

  if (obj.live_dj_source == false) {
    live_li.find(".line-to-switch").attr("class", "line-to-switch off");
    live_div.removeClass("ready");
  } else {
    live_li.find(".line-to-switch").attr("class", "line-to-switch on");
    live_div.addClass("ready");
  }

  if (obj.master_dj_source == false) {
    master_li.find(".line-to-switch").attr("class", "line-to-switch off");
    master_div.removeClass("ready");
  } else {
    master_li.find(".line-to-switch").attr("class", "line-to-switch on");
    master_div.addClass("ready");
  }
}

function parseSwitchStatus(obj) {
  if (obj.live_dj_source == "on") {
    live_dj_on_air = true;
  } else {
    live_dj_on_air = false;
  }

  if (obj.master_dj_source == "on") {
    master_dj_on_air = true;
  } else {
    master_dj_on_air = false;
  }

  if (obj.scheduled_play == "on") {
    scheduled_play_on_air = true;
  } else {
    scheduled_play_on_air = false;
  }

  var scheduled_play_switch = $("#scheduled_play.source-switch-button");
  var live_dj_switch = $("#live_dj.source-switch-button");
  var master_dj_switch = $("#master_dj.source-switch-button");

  scheduled_play_switch.find("span").html(obj.scheduled_play);
  if (scheduled_play_on_air) {
    scheduled_play_switch.addClass("active");
  } else {
    scheduled_play_switch.removeClass("active");
  }

  live_dj_switch.find("span").html(obj.live_dj_source);
  if (live_dj_on_air) {
    live_dj_switch.addClass("active");
  } else {
    live_dj_switch.removeClass("active");
  }

  master_dj_switch.find("span").html(obj.master_dj_source);
  if (master_dj_on_air) {
    master_dj_switch.addClass("active");
  } else {
    master_dj_switch.removeClass("active");
  }
}

function controlOnAirLight() {
  if (
    (scheduled_play_on_air && scheduled_play_source) ||
    live_dj_on_air ||
    master_dj_on_air
  ) {
    $("#on-air-info").attr("class", "on-air-info on");
    onAirOffIterations = 0;
  } else if (onAirOffIterations < 20) {
    //if less than 4 seconds have gone by (< 20 executions of this function)
    //then keep the ON-AIR light on. Only after at least 3 seconds have gone by,
    //should we be allowed to turn it off. This is to stop the light from temporarily turning
    //off between tracks: CC-3725
    onAirOffIterations++;
  } else {
    $("#on-air-info").attr("class", "on-air-info off");
  }
}

function controlSwitchLight() {
  var live_li = $("#live_dj_div").parent();
  var master_li = $("#master_dj_div").parent();
  var scheduled_play_li = $("#scheduled_play_div").parent();

  if (
    scheduled_play_on_air &&
    scheduled_play_source &&
    !live_dj_on_air &&
    !master_dj_on_air
  ) {
    scheduled_play_li
      .find(".line-to-on-air")
      .attr("class", "line-to-on-air on");
    live_li.find(".line-to-on-air").attr("class", "line-to-on-air off");
    master_li.find(".line-to-on-air").attr("class", "line-to-on-air off");
  } else if (live_dj_on_air && !master_dj_on_air) {
    scheduled_play_li
      .find(".line-to-on-air")
      .attr("class", "line-to-on-air off");
    live_li.find(".line-to-on-air").attr("class", "line-to-on-air on");
    master_li.find(".line-to-on-air").attr("class", "line-to-on-air off");
  } else if (master_dj_on_air) {
    scheduled_play_li
      .find(".line-to-on-air")
      .attr("class", "line-to-on-air off");
    live_li.find(".line-to-on-air").attr("class", "line-to-on-air off");
    master_li.find(".line-to-on-air").attr("class", "line-to-on-air on");
  } else {
    scheduled_play_li
      .find(".line-to-on-air")
      .attr("class", "line-to-on-air off");
    live_li.find(".line-to-on-air").attr("class", "line-to-on-air off");
    master_li.find(".line-to-on-air").attr("class", "line-to-on-air off");
  }
}

function getScheduleFromServer() {
  $.ajax({
    url: baseUrl + "Schedule/get-current-playlist/format/json",
    dataType: "json",
    success: function (data) {
      parseItems(data.entries);
      parseSourceStatus(data.source_status);
      parseSwitchStatus(data.switch_status);
      showName = data.show_name;
    },
    error: function (jqXHR, textStatus, errorThrown) { },
  });
}

function setupQtip() {
  var qtipElem = $("#about-link");

  if (qtipElem.length > 0) {
    qtipElem.qtip({
      content: $("#about-txt").html(),
      show: "mouseover",
      hide: { when: "mouseout", fixed: true },
      position: {
        corner: {
          target: "center",
          tooltip: "topRight",
        },
      },
      style: {
        border: {
          width: 0,
          radius: 4,
        },
        name: "light", // Use the default light style
      },
    });
  }
}

function setSwitchListener(ele) {
  var sourcename = $(ele).attr("id");
  var status_span = $(ele).find("span");
  var status = status_span.html();
  $.get(
    baseUrl +
    "Dashboard/switch-source/format/json/sourcename/" +
    sourcename +
    "/status/" +
    status,
    function (data) {
      if (data.error) {
        alert(data.error);
      } else {
        if (data.status == "ON") {
          $(ele).addClass("active");
        } else {
          $(ele).removeClass("active");
        }
        status_span.html(data.status);
      }
    },
  );
}

function kickSource(ele) {
  var sourcename = $(ele).attr("id");

  $.get(
    baseUrl +
    "Dashboard/disconnect-source/format/json/sourcename/" +
    sourcename,
    function (data) {
      if (data.error) {
        alert(data.error);
      }
    },
  );
}

var stream_window = null;

function init() {
  //begin producer "thread"
  setInterval(getScheduleFromServer, serverUpdateInterval);

  //begin consumer "thread"
  secondsTimer();

  setupQtip();

  $(".listen-control-button").click(function () {
    if (stream_window == null || stream_window.closed)
      stream_window = window.open(
        baseUrl + "Dashboard/stream-player",
        "name",
        "width=400,height=158",
      );
    stream_window.focus();
    return false;
  });
}

/* We never retrieve the user's password from the db
 * and when we call isValid($params) the form values are cleared
 * and repopulated with $params which does not have the password
 * field. Therefore, we fill the password field with 6 x's
 */
function setCurrentUserPseudoPassword() {
  $("#cu_password").val("xxxxxx");
  $("#cu_passwordVerify").val("xxxxxx");
}

/*$(window).resize(function() {
 */ /* If we don't do this, the menu can stay hidden after resizing */ /*
   if ($(this).width() > 970) {
       $("#nav .responsive-menu").show();
   }
});*/

function writeString(view, offset, string) {
  console.log(" string.length ", string.length);
  console.log("offset ", offset);
  console.log("view ", view);
  for (let i = 0; i < string.length; i++) {
    view.setUint8(offset + i, string.charCodeAt(i));
  }
}

// Step 1: Create an AudioContext
const audioContext = new (window.AudioContext || window.webkitAudioContext)();

// Function to extract 5-second audio from Blob
async function extractAudioSegment(blob, startTime, duration) {
  // Step 2: Convert Blob to ArrayBuffer
  const arrayBuffer = await blob.arrayBuffer();

  // // Decode the audio data
  const audioBuffer = await audioContext.decodeAudioData(arrayBuffer);

  // Step 3: Extract the desired segment
  const sampleRate = audioBuffer.sampleRate;
  const startSample = startTime * sampleRate;
  const endSample = startSample + duration * sampleRate;
  const segment = audioBuffer.getChannelData(0).slice(startSample, endSample);

  // Create a new AudioBuffer for the segment
  const segmentBuffer = audioContext.createBuffer(1, segment.length, sampleRate);
  segmentBuffer.copyToChannel(segment, 0);
  // Step 4: Encode the segment back to Blob
  const offlineContext = new OfflineAudioContext(1, segmentBuffer.length, sampleRate);
  // const source = offlineContext.createBufferSource();
  // source.buffer = segmentBuffer;
  // source.connect(offlineContext.destination);
  // source.start();
  const renderedBuffer = await offlineContext.startRendering();
  const audioBlob = await new Promise(resolve => {
    renderedBuffer.copyToChannel(segment, 0);
    resolve(renderedBuffer);

  });

  return audioBlob;
}

// Usage example


function audioBufferToBlob(audioBuffer, type) {
  const numberOfChannels = audioBuffer.numberOfChannels;
  const length = audioBuffer.length * numberOfChannels * 2 + 44;
  const buffer = new ArrayBuffer(length);
  const view = new DataView(buffer);

  // Write WAV header
  writeString(view, 0, 'RIFF');
  view.setUint32(4, 36 + audioBuffer.length * numberOfChannels * 2, true);
  writeString(view, 8, 'WAVE');
  writeString(view, 12, 'fmt ');
  view.setUint32(16, 16, true);
  view.setUint16(20, 1, true);
  view.setUint16(22, numberOfChannels, true);
  view.setUint32(24, audioBuffer.sampleRate, true);
  view.setUint32(28, audioBuffer.sampleRate * 4, true);
  view.setUint16(32, numberOfChannels * 2, true);
  view.setUint16(34, 16, true);
  writeString(view, 36, 'data');
  view.setUint32(40, audioBuffer.length * numberOfChannels * 2, true);

  // Write audio data
  let offset = 44;
  for (let i = 0; i < audioBuffer.length; i++) {
    for (let channel = 0; channel < numberOfChannels; channel++) {
      const sample = audioBuffer.getChannelData(channel)[i];
      view.setInt16(offset, sample * 0x7FFF, true);
      offset += 2;
    }
  }

  return new Blob([buffer], { type: type });
}

function appendBuffer(buffer1, buffer2) {
  var numberOfChannels = Math.min(buffer1.numberOfChannels, buffer2.numberOfChannels);
  var tmp = context.createBuffer(numberOfChannels, (buffer1.length + buffer2.length), buffer1.sampleRate);
  for (var i = 0; i < numberOfChannels; i++) {
    var channel = tmp.getChannelData(i);
    channel.set(buffer1.getChannelData(i), 0);
    channel.set(buffer2.getChannelData(i), buffer1.length);
  }
  return tmp;
}
$(window).load(function() {
  setTimeout(function () {
    let triggerAudioId = $("#library_display > tbody").children(":contains('Trigger-Audio')").attr("id");
    $("#triggerDisplayId").val(triggerAudioId);
    $("#"+triggerAudioId).hide();
    $("#recent_uploads_table > tbody").children(":contains('Trigger-Audio')").hide();
  }, 3000);
  setTimeout(function () {
    $("#recent_uploads_table > tbody").children(":contains('Trigger-Audio')").hide();
    let triggerAudioId = $("#library_display > tbody").children(":contains('Trigger-Audio')").attr("id");
    $("#triggerDisplayId").val(triggerAudioId);
    $("#"+triggerAudioId).hide();
  }, 1000);
 });

$(document).ready(function () {
  $("body").on("click", '#add_media_btn', function (e) {
    $("#recent_uploads_table > tbody").children(":contains('Trigger-Audio')").hide();
  });
  $("body").on("click", '.media_type_selector a[href="/showbuilder#tracks"]', function (e) {
    setTimeout(function () {
      let triggerAudioId = $("#library_display > tbody").children(":contains('Trigger-Audio')").attr("id");
      console.log(" href trigger triggerAudioId ", triggerAudioId);
      $("#"+triggerAudioId).hide();
    }, 1300);
  });
  
  $("body").on("submit", "#idForm", function (e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    $('#gif').css('visibility', 'visible');
    $(".form-group").removeClass("has-error");
    $(".help-block").remove();
    var formData = new FormData();
    const submitError = document.querySelector('.submit-error')
    const submitSuccess = document.querySelector('.submit-success')
    const successclosebtn = document.querySelector('.successclosebtn')
    const audioTrackId = $("#au_id").val();
    const tuneurlName = $(".playlist_name_display").val();
   
    console.log("audioTrackId111 : ", audioTrackId);
    var formData2 = {
      website: $("#website").val(),
      msg: $("#msg").val()
    };
    if (formData2.website === "") {
      $("#website-group").addClass("has-error");
      $("#website-group").append(
        '<div class="help-block"> Website is required </div>'
      );
    }

    if (formData2.msg === "") {
      $("#msg-group").addClass("has-error");
      $("#msg-group").append(
        '<div class="help-block"> Message is required </div>'
      );
    }
      let triggerAudioID =  $("#triggerDisplayId").val() || "au_1";
    
    let triggerTrackData = {
      "aItems": [[triggerAudioID.split("_")[1], "audioclip"]],
      afterItem: parseInt($("#spl_id").val())
    }

    formData.append("name", tuneurlName + "-" + Date.now()); 
    formData.append("description", formData2.msg);
    formData.append("type", "open_page");
    formData.append("info", formData2.website);
    formData.append("triggerSoundId", "7");
    formData.append("source_libretime", "1");
    formData.append("uid", "6580fe87-6c66-4360-bb91-42692627ff15");

    //alert("hello", formData);
    var form = $(this);
    let blob;
    let actionUrl = "https://pnz3vadc52.execute-api.us-east-2.amazonaws.com/dev/create-tuneurl";


    fetch(baseUrl + "api/get-media/file/" + audioTrackId + "/download/true")
      .then(response => response.blob())
      .then(blobdata => { blob = blobdata; return extractAudioSegment(blob, 0, 5);  })
      // .then(arrayBuffer => audioContext.decodeAudioData(arrayBuffer))
      .then(trimmedBuffer => {
        formData.append("mp3file", audioBufferToBlob(trimmedBuffer, blob.type));

        $.ajax({
          type: "POST",
          url: actionUrl,
          data: formData,
          cors: true,
          processData: false,
          contentType: false,
          // headers: {
          //   'Access-Control-Allow-Origin': '*',
          // },
          success: function (data2, textStatus, jqXHR) {
            console.log(" headerresponse x-tuneurl-id ", jqXHR.getResponseHeader('x-tuneurl-id'));
            const tuneurlId = jqXHR.getResponseHeader('x-tuneurl-id');
            if ( $(".spl_sortable>li").length > 1 &&  triggerTrackData.afterItem) {
              AIRTIME.playlist.fnAddItems(triggerTrackData.aItems, triggerTrackData.afterItem, "after", tuneurlId);
            } else {
              AIRTIME.playlist.fnAddItems(triggerTrackData.aItems, null, "before", tuneurlId);
            }
          //  setTimeout(function () { 
          //   let listItems = $(".spl_sortable>li");
          //   listItems.each(function(idx, li) { 
          //       let title = $(li).find(".spl_title").text(); 
          //       if(title.includes("Trigger-Audio")){  
          //           $(li).find(".spl_title").text("Trigger-Audio"+"_"+tuneurlId+".mp3");
          //     }
          //   });
          //  }, 2000);

            $('#gif').css('visibility', 'hidden');
            setTimeout(function () { successclosebtn.click(); }, 800);
            submitSuccess.setAttribute('data-submit', "success");
            successclosebtn.setAttribute('data-submit', "success");
            $('.form-group').fadeOut();
            $("#pl-bl-tuneurl").removeClass("btn-warning");
            $("#pl-bl-tuneurl").attr("data-target", "");
            //.catch((error) => { submitError.setAttribute('data-submit', error) });
            //alert(data); // show response from the php script.
          },
          error: function (err) {
            $('#gif').css('visibility', 'hidden');
            $('.submit-error p').append("Someting went wrong while creating the TuneURL: "+err.responseText);
            submitError.setAttribute('data-submit', "error");
            console.log("ajax error", err.status);
            console.log("ajax error", err.responseText);
          }
        });

      });






  });

  if ($("#master-panel").length > 0) init();
  if ($(".errors").length === 0) {
    setCurrentUserPseudoPassword();
  }

  $("body").on("click", ".spl_sortable>li", function () {
    console.log(" clicked ");
    $(".spl_sortable>li").removeClass("active");
    let prev = $(this).prev();
    // Add the 'active' class to the clicked list item
    var dataUri = $(this).children().eq(1).children().eq(0).children().eq(0).attr("data-uri");
    const trackTitle = $(this).children().find(".spl_title").text();
    var audioTrackId = dataUri.split("/").reverse()[0];
    console.log("audioTrackId: ", audioTrackId);
    // $(this).next('div > dl> dd').attr("data-uri", "#myModal");
    $("#au_id").val(audioTrackId);
    if(prev && prev.attr("id")){
      $("#spl_id").val(prev.attr("id").split("_")[1]);
    }
    $("#trackName").val(trackTitle);

    $(this).addClass("active");
    $(this).next().next('div > dl> dd').attr("data-uri", "#myModal");
    $("#pl-bl-tuneurl").addClass("btn-warning");
    $("#pl-bl-tuneurl").attr("data-target", "#myModal");

  });

  $("body").on("click", "#pl-bl-tuneurl", function () {
    $('#gif').css('visibility', 'hidden');
    document.querySelector('.submit-error').setAttribute('data-submit', "");
    document.querySelector('.submit-success').setAttribute('data-submit', "");
    document.querySelector('.successclosebtn').setAttribute('data-submit', "");
    $('.submit-error').hide();
    $('.submit-success').hide();
    $('.successclosebtn').hide();
    $("#website").val(''),
    $("#msg").val('')
    $('.form-group').fadeIn();
  });

  $("body").on("click", ".ui-icon-closethick", function () { 
    let trackName = $(this).parent().parent().children().eq(0).children().eq(1).find(".spl_title").text();
    console.log(" trackName ", trackName);
    if(trackName.includes("Trigger-Audio")){
      let tuneurlId = trackName.split("_").reverse()[0];
      fetch("https://pnz3vadc52.execute-api.us-east-2.amazonaws.com/dev/delete-tuneurl?id="+tuneurlId+"&uid=6580fe87-6c66-4360-bb91-42692627ff15")
        .then(response => response.text());
    }
      
  });

  $("body").on("click", "#current-user", function () {
    $.ajax({
      url: baseUrl + "user/edit-user/format/json",
    });
  });

  $("body").on("click", "#cu_save_user", function () {
    Cookies.set("airtime_locale", $("#cu_locale").val(), { path: "/" });
  });

  // When the 'Listen' button is clicked we set the width
  // of the share button to the width of the 'Live Stream'
  // text. This differs depending on the language setting
  $("#popup-link").css("width", $(".jp-container h1").css("width"));

  /*$('#menu-btn').click(function() {
        $('#nav .responsive-menu').slideToggle();
    });*/
});
