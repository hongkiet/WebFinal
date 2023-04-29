const searchInput = document.getElementById('search-input');
const findingResult = document.querySelector('#finding-result');
const line = document.querySelector('#line');
const searchResults = document.querySelector('#search-results');
const songs = document.querySelectorAll('.baihat');
const index = document.querySelectorAll('.on-screen');
const player = document.getElementById('player');
const playBtn = document.querySelector(".play-inner");
const nextBtn = document.querySelector(".play-forward");
const preBtn = document.querySelector(".play-back");
const durationTime = document.querySelector(".duration");
const remainingTime = document.querySelector(".remaining");
const rangeBar = document.querySelector(".custom-progress-done");
const range = document.querySelector(".progress-bar");
const volumeBtn = document.querySelector(".volume-icon");
const volrange = document.querySelector(".vol-bar-done");
const vol = document.querySelector(".vol-bar");
player.volume = 1;
var voltemp = 100 + "%";
var check = 1;
vol.addEventListener('click', function(e) {
    const progressWidth = vol.offsetWidth;
    const clickX = e.offsetX;
    const progressPercent = (clickX / progressWidth) * 100;
    volrange.style.width = progressPercent + "%";
    let isVolume;
    if(volrange.style.width <= 0 + "%") {
        player.volume = 0;
        voltemp = 0 + "%";
    } else {
        player.volume = (progressPercent / 100);
        voltemp = volrange.style.width;
    }
    if(player.volume == 0) {
        volumeBtn.innerHTML = '<i class="bi bi-volume-mute"></i>';
        isVolume = -1;
    } else if(player.volume <= 0.5) {
        isVolume = 0;
        volumeBtn.innerHTML = '<i class="bi bi-volume-down"></i>';
    } else if(player.volume <= 1) {
        isVolume = 1;
        volumeBtn.innerHTML = '<i class="bi bi-volume-up"></i>';
    }
    check = isVolume;
});
let preCheck;
    

volumeBtn.addEventListener('click', function HandleVolume() {
    if(check == -1) {
        
        if(preCheck == 1) {
            check = 1;
            volumeBtn.innerHTML = '<i class="bi bi-volume-up"></i>';
        } else if(preCheck == 0) {
            check = 0;
            volumeBtn.innerHTML = '<i class="bi bi-volume-down"></i>';
        } else {
            volumeBtn.innerHTML = '<i class="bi bi-volume-mute"></i>';
        }
    } else if(check == 1) {
        preCheck = 1;
        check = -1;
        volumeBtn.innerHTML = '<i class="bi bi-volume-mute"></i>';
    } else if(check == 0) {
        preCheck = 0;
        check = -1;
        volumeBtn.innerHTML = '<i class="bi bi-volume-mute"></i>';
    } else {
        preCheck = -1;
    }
    
    if(check == -1) {
        volrange.style.width = 0 + "%";
    } else {
        volrange.style.width = voltemp;
    }
    player.volume = parseInt(volrange.style.width) / 100;

});
volrange.oninput = function() {
    if(voltemp == 0 + "%") {
        volumeBtn.innerHTML = '<i class="bi bi-volume-mute"></i>';
    }

}
let isShuffle = false;
const playShuffle = document.querySelector(".play-shuffle");

const playRepeat = document.querySelector(".repeat-icon");
let isRepeat = -1;
playRepeat.addEventListener("click", function() {
    if(isRepeat == 0) {
        isRepeat = 1;
        playRepeat.innerHTML = '<i class="bi bi-repeat-1"></i>';
        playRepeat.querySelector("i").setAttribute("style", "color: #ffb86c;");
    } 
    else if(isRepeat == -1){
        isRepeat = 0;
        playRepeat.querySelector("i").setAttribute("style", "color: #ffb86c;");
    } else if(isRepeat == 1){
        isRepeat = -1;
        playRepeat.innerHTML = '<i class="bi bi-repeat"></i>';
    }
});

function handleShuffle() {
    if(isShuffle == true) {
        isShuffle = false;
        playShuffle.removeAttribute("style");
    } else {
        isShuffle = true;
        playShuffle.style.color = "#ffb86c";
    }
}
playShuffle.addEventListener("click", handleShuffle);
function removehandleShuffle() {
    playShuffle.removeEventListener("click", handleShuffle);
}

let currentSongIndex = 0;
isPlaying = true;
Timer();
let timer;
const anh = document.querySelector('.img');
const ten = document.querySelector('.music-name');
const casi = document.querySelector('.actor');
const lyricButton = document.querySelector(".lyric-icon");
const lyricIcon = document.querySelector(".lyric-i");
const lyricsContainer = document.querySelector("#lyrics-container");
const Lyric = document.querySelector("#lyrics");
let isLyric = true;
let lyric = "";
songs.forEach(baihat => {
    baihat.addEventListener('click', () => {
        const id = baihat.dataset.id;
        const title = baihat.dataset.title;
        const file = baihat.dataset.file;
        const image = baihat.dataset.image;
        const actor = baihat.dataset.actor;
        const loi = baihat.dataset.lyric;
        // LYRICS
        lyric = loi;
        anh.setAttribute("src", image);
        ten.innerHTML = title;
        casi.innerHTML = actor;

        player.setAttribute('src', file);
        isPlaying = true;
        playPause();
        currentSongIndex = parseInt(id) - 1;
  });
});

function removeShowLyric() {
    lyricButton.removeEventListener("click", showLyric);
}
preBtn.addEventListener("click", function() {
    playPreSong();
});
nextBtn.addEventListener("click", function() {
    playNextSong();
});
function playNextSong() {
    if(isShuffle == true) {
            let random = Math.floor(Math.random() * songs.length + 1);
            random = Math.floor(Math.random() * songs.length + 1);
            if(random >= songs.length) {
                random = Math.floor(Math.random() * songs.length);
            }
            currentSongIndex = random;
            const randomSong = songs[random];
            
            const file = randomSong.dataset.file;
            const title = randomSong.dataset.title;
            const image = randomSong.dataset.image;
            const actor = randomSong.dataset.actor;
            const loi = randomSong.dataset.lyric;
            
            lyric = loi;
            console.log(lyric);
            anh.setAttribute("src", image);
            ten.innerHTML = title;
            casi.innerHTML = actor;

            player.setAttribute('src', file);
            isPlaying = true;
            playPause();        
    } else {
        let nextIndex = (currentSongIndex + 1) % songs.length;
            if(nextIndex >= songs.length) {
                nextIndex = 0;
            } else {
                const nextSong = songs[nextIndex];
                const file = nextSong.dataset.file;
                const title = nextSong.dataset.title;
                const image = nextSong.dataset.image;
                const actor = nextSong.dataset.actor;
                const loi = nextSong.dataset.lyric;
            
                lyric = loi;
                anh.setAttribute("src", image);
                ten.innerHTML = title;
                casi.innerHTML = actor;
                player.setAttribute('src', file)
                currentSongIndex = nextIndex;
                isPlaying = true;
                playPause();
            }
    }
}
function playPreSong() {
    if(isShuffle == true) {
        let random = Math.floor(Math.random() * songs.length + 1);
        random = Math.floor(Math.random() * songs.length + 1);
        if(random >= songs.length) {
            random = Math.floor(Math.random() * songs.length);
        }
        currentSongIndex = random;
        const randomSong = songs[random];
        const title = randomSong.dataset.title;
        const file = randomSong.dataset.file;
        const image = randomSong.dataset.image;
        const actor = randomSong.dataset.actor;
        const loi = randomSong.dataset.lyric;
        lyric = loi;
        anh.setAttribute("src", image);
        ten.innerHTML = title;
        casi.innerHTML = actor;
        player.setAttribute('src', file);
        isPlaying = true;
        playPause();
    } else {        
        let PreIndex = currentSongIndex - 1;
        if(PreIndex < 0) {
            PreIndex = songs.length - 1;
        }
        const PreSong = songs[PreIndex];
        const file = PreSong.dataset.file;
        const title = PreSong.dataset.title;
        const image = PreSong.dataset.image;
        const actor = PreSong.dataset.actor;
        const loi = PreSong.dataset.lyric;
        lyric = loi;
        anh.setAttribute("src", image);
        ten.innerHTML = title;
        casi.innerHTML = actor;
        player.setAttribute('src', file)
        currentSongIndex = PreIndex;
        isPlaying = true;
        playPause();
    }
}

playBtn.addEventListener("click", playPause);
    function playPause() {
        if(isPlaying) {
            playBtn.innerHTML = '<i class="bi bi-pause-circle"></i>';
            player.play();
            isPlaying = false;
            timer = setInterval(Timer, 500);
        } else {
            playBtn.innerHTML = '<i name="play" class="bi bi-play-circle"></i>';
            player.pause();
            isPlaying = true;
            clearInterval(timer);
    }
}
lyricButton.addEventListener("click", showLyric);
function showLyric() {
    if(isLyric == true) {
        isLyric = false;
        lyricIcon.style.color = "#ffb86c";
        lyricsContainer.style.display = '';
        Lyric.innerHTML = `<p>${lyric}</p>`;
        
    } else {
        isLyric = true;
        
        lyricsContainer.style.display = 'none';
        lyricIcon.removeAttribute("style");
        Lyric.innerHTML = '';
    }
}
function Timer() {
    const {duration, currentTime} = player;
    const progressPercent = (currentTime / duration) * 100;
    rangeBar.style.width = progressPercent + "%";
    remainingTime.textContent = formatTimer(currentTime);
    if(!duration) {
        durationTime.textContent = "00:00";
    } else {
        durationTime.textContent = formatTimer(duration);
    }
}

function formatTimer(time) {
    const minutes = Math.floor(time / 60);
    const seconds = Math.floor(time - minutes * 60);
    return `${minutes < 10 ? '0' + minutes: minutes}:${seconds < 10 ? '0' + seconds: seconds}`;
}
player.addEventListener('ended', () => {
    if(isShuffle == true) {
        let random = Math.floor(Math.random() * songs.length + 1);
        random = Math.floor(Math.random() * songs.length + 1);
        if(random >= songs.length) {
            random = Math.floor(Math.random() * songs.length);
        }
        currentSongIndex = random;
        const randomSong = songs[random];
        console.log(randomSong);
        const file = randomSong.dataset.file;
        player.setAttribute('src', file);
        isPlaying = true;
        playPause();
    } else {
        if(isRepeat == 1) {
            playRepeat.removeAttribute("style");
            isPlaying = true;
            playPause();
        } else if(isRepeat == -1) {
            playNextSong();
        } else if(isRepeat == 0) {
            playNextSong();
        }
    }
});


range.addEventListener('click', function(e) {
    
    const progressWidth = range.offsetWidth;
    const clickX = e.offsetX;
    const progressPercent = (clickX / progressWidth) * 100;
    rangeBar.style.width = progressPercent + "%";
    
    const currentTime = (progressPercent / 100) * player.duration;
        player.currentTime = currentTime;
    console.log(rangeBar.style.width);
});



searchInput.addEventListener('input', function() {
    
    const inputValue = this.value.trim();
    if (inputValue === '') {
        searchResults.innerHTML = '';
        findingResult.innerHTML = '';
        line.innerHTML = '';
        return;
    }
    
  
  const xhr = new XMLHttpRequest();
  xhr.open('GET', `suggest.php?keyword=${encodeURIComponent(inputValue)}`);
  xhr.onload = function() {
    if (xhr.status === 200) {
      const results = JSON.parse(xhr.responseText);
    //   console.log(input);
      // Hiển thị danh sách gợi ý
      findingResult.innerHTML = '';
      searchResults.innerHTML = '';
      for (let i = 0; i < results.length; i++) {
        const song = results[i];
        const songElement = document.createElement('div');
        findingResult.innerHTML = `
          <div style="font-size: 1.5em;padding-left: 50px;font-weight:600;">Kết quả hàng đầu</div>
        `
        songElement.innerHTML = `
          <div style="z-index: 1;" class="focus baihat" data-id="${song.id}" data-title="${song.name}" data-file="${song.file}" 
          data-image="${song.image}" data-actor="${song.actor}" data-lyric="${song.lyric}">
              <div class="card-wrapper" style="padding-left: 40px;display:inline-flex;">
                <div class="card">
                  <a>
                    <img class="card-img-top" src="${song.image}" alt="Card image">
                    <i class="play-icon bi bi-play-circle-fill"></i>
                  </a> 
                  <div class="card-body">
                    <h4 style="font-size: 1.2em; font-weight: 600;" class="card-title">${song.name}</h4>
                    <p class="card-text">${song.actor}</p>
                  </div>
                </div>  
              </div>
          </div>
        `;
        line.innerHTML = `
          <div style="padding-top: 20px;padding-left:50px">
            <hr style="border:none;width: 97%;">
          </div>
        `
        searchResults.appendChild(songElement);

        console.log(currentSongIndex);
        isPlaying = true;
        const anh = document.querySelector('.img');
        const ten = document.querySelector('.music-name');
        const casi = document.querySelector('.actor');
        const baihats = document.querySelectorAll('.focus');
        let isLyric = true;
        let lyric = "";
        baihats.forEach(baihat => {
          baihat.addEventListener('click', () => {
            const id = baihat.dataset.id;
            const title = baihat.dataset.title;
            const file = baihat.dataset.file;
            const image = baihat.dataset.image;
            const actor = baihat.dataset.actor;
            const loi = baihat.dataset.lyric;
            anh.setAttribute("src", image);
            ten.innerHTML = title;
            casi.innerHTML = actor;
            player.setAttribute('src', file);
            lyric = loi;
            isPlaying = true;
            playPause();
            currentSongIndex = parseInt(id) - 1;
          });
        });
        
        lyricButton.addEventListener("click", showLyric);
        function showLyric() {
            if(isLyric == true) {
                isLyric = false;
                lyricIcon.style.color = "#ffb86c";
                lyricsContainer.style.display = '';
                Lyric.innerHTML = `<p>${lyric}</p>`;
                
            } else {
                isLyric = true;
                
                lyricsContainer.style.display = 'none';
                lyricIcon.removeAttribute("style");
                Lyric.innerHTML = '';
            }
        }
        function removeShowLyric() {
            lyricButton.removeEventListener("click", showLyric);
        }
    player.addEventListener('ended', () => {
        if(isShuffle == true) {
            let random = Math.floor(Math.random() * baihats.length + 1);
            random = Math.floor(Math.random() * baihats.length + 1);
            if(random >= baihats.length) {
                random = Math.floor(Math.random() * baihats.length);
            }
            currentSongIndex = random;
            const randomSong = baihats[random];
            console.log(randomSong);
            const file = randomSong.dataset.file;
            player.setAttribute('src', file);
            isPlaying = true;
            playPause();
        } else {
            if(isRepeat == 1) {
                playRepeat.removeAttribute("style");
                isPlaying = true;
                playPause();
            } else if(isRepeat == -1) {
                playNextSong();
            } else if(isRepeat == 0) {
                playNextSong();
            }
        }
    });
    
      }
      searchResults.style.display = 'inline-flex';
    } else {
      console.error(xhr.statusText);
    }
  };
  xhr.onerror = function() {
    console.error(xhr.statusText);
  };
  xhr.send();
});