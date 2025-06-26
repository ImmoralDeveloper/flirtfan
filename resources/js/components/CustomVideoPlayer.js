function initCustomVideoPlayer(player) {
    const video = player.querySelector('.custom-video');
    const playPause = player.querySelector('.play-pause');
    const playPauseIcon = playPause.querySelector('.icon');
    const progressBar = player.querySelector('.progress-bar');
    const currentTime = player.querySelector('.current-time');
    const duration = player.querySelector('.duration');
    const speedControl = player.querySelector('.speed-control');
    const speedBtn = speedControl.querySelector('.speed-btn');
    const speedLabel = speedBtn.querySelector('.speed-label');
    const speedMenu = speedControl.querySelector('.speed-menu');
    const volumeControl = player.querySelector('.volume-control');
    const volumeBtn = volumeControl.querySelector('.volume-btn');
    const volumeIcon = volumeBtn.querySelector('.icon');
    const volumeBar = volumeControl.querySelector('.volume-bar');
    const fullscreen = player.querySelector('.fullscreen');
    let lastVolume = 1;

    // Play/Pause
    playPause.onclick = () => {
        if (video.paused) {
            video.play();
            playPauseIcon.className = 'icon icon-pause';
            playPauseIcon.style.setProperty('--iconSizePercent', '.5');
        } else {
            video.pause();
            playPauseIcon.className = 'icon icon-play';
            playPauseIcon.style.setProperty('--iconSizePercent', '.5');
        }
    };
    video.onplay = () => {
        playPauseIcon.className = 'icon icon-pause';
        playPauseIcon.style.setProperty('--iconSizePercent', '.5');
    };
    video.onpause = () => {
        playPauseIcon.className = 'icon icon-play';
        playPauseIcon.style.setProperty('--iconSizePercent', '.5');
    };
    // Click en el video para pausar/reanudar
    video.onclick = () => {
        if (video.paused) {
            video.play();
        } else {
            video.pause();
        }
    };

    // Progress (solo tiempo restante)
    video.ontimeupdate = () => {
        progressBar.value = video.currentTime;
        duration.textContent = formatTime(video.duration - video.currentTime);
    };
    video.onloadedmetadata = () => {
        progressBar.max = video.duration;
        duration.textContent = formatTime(video.duration);
    };
    progressBar.oninput = () => {
        video.currentTime = progressBar.value;
        duration.textContent = formatTime(video.duration - video.currentTime);
    };

    // Speed
    speedBtn.onclick = (e) => {
        e.stopPropagation();
        speedControl.classList.toggle('open');
    };
    speedMenu.querySelectorAll('li').forEach(li => {
        li.onclick = (e) => {
            e.stopPropagation();
            video.playbackRate = li.dataset.speed;
            speedLabel.textContent = li.textContent;
            speedMenu.querySelectorAll('li').forEach(l => l.classList.remove('active'));
            li.classList.add('active');
            speedControl.classList.remove('open');
        };
    });
    document.addEventListener('click', e => {
        if (!speedControl.contains(e.target)) speedControl.classList.remove('open');
    });

    // Volume
    volumeBar.value = video.volume;
    volumeBar.oninput = () => {
        video.volume = volumeBar.value;
        updateVolumeIcon();
        if (video.volume > 0) lastVolume = video.volume;
    };
    volumeBtn.onclick = () => {
        if (video.volume > 0) {
            lastVolume = video.volume;
            video.volume = 0;
        } else {
            video.volume = lastVolume || 1;
        }
        volumeBar.value = video.volume;
        updateVolumeIcon();
    };
    function updateVolumeIcon() {
        if (video.volume == 0) {
            volumeIcon.className = 'icon icon-volume-mute';
            volumeIcon.style.setProperty('--iconSizePercent', '.5');
        } else {
            volumeIcon.className = 'icon icon-volume';
            volumeIcon.style.setProperty('--iconSizePercent', '.5');
        }
    }
    updateVolumeIcon();

    // Fullscreen
    fullscreen.onclick = () => {
        if (video.requestFullscreen) video.requestFullscreen();
    };

    // Doble click en el video para fullscreen
    video.ondblclick = () => {
        if (document.fullscreenElement === video) {
            document.exitFullscreen();
        } else if (video.requestFullscreen) {
            video.requestFullscreen();
        }
    };

    function formatTime(sec) {
        const m = Math.floor(sec / 60);
        const s = Math.floor(sec % 60).toString().padStart(2, '0');
        return `${m}:${s}`;
    }

    // Pausar video si no está visible en el viewport
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting && !video.paused) {
                video.pause();
            }
        });
    }, { threshold: 0.7 }); // 70% visible
    observer.observe(video);

    // Soporte para pausar/reproducir con la tecla de espacio
    player.addEventListener('keydown', function(e) {
        if (e.code === 'Space' || e.key === ' ') {
            e.preventDefault();
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        }
    });
    // Permitir que el player reciba foco por teclado
    player.tabIndex = 0;
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.custom-video-player').forEach(player => {
        window.initCustomVideoPlayer(player);
    });
});

window.initCustomVideoPlayer = initCustomVideoPlayer; 