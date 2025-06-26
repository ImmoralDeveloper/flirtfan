// VideoPlayer Component
export class VideoPlayer {
    constructor(type) {
        this.type = type;
        this.element = null;
    }

    create() {
        this.element = document.createElement('div');
        this.element.className = `videos__player videos__player--${this.type} videos__player--reel`;
        this.element.innerHTML = this.getTemplate();
        return this.element;
    }

    getTemplate() {
        return `
            <div class="videos__player-options">
                <button type="button" aria-label="Toggle play" data-action="play">
                    <i class="icon icon-play"></i>
                </button>
                <div>
                    <button type="button" aria-label="Toggle volume" data-action="volume">
                        <i class="icon icon-volume-mute"></i>
                    </button>
                    <input type="range" id="volume" value="50" />
                </div>
                <button type="button" aria-label="Toggle autoplay" data-action="autoplay" data-autoplay="on">
                    <span>
                        <i class="icon icon-play"></i>
                        <i class="icon icon-pause"></i>
                    </span>
                </button>
                <button type="button" aria-label="Enter fullscreen" data-action="fullscreen">
                    <i class="icon icon-fullscreen"></i>
                </button>
            </div>

            <video playsinline muted preload="auto"></video>

            <div class="videos__meta">
                <div class="videos__user">
                    <div class="user-avatar">
                        <a href="">
                        </a>
                    </div>
                    <h2 class="videos__username"></h2>
                    <button class="button" type="button">Follow</button>
                </div>
                <p class="videos__description"></p>
            </div>

            <div class="videos__player-btns">
                <div class="user-avatar">
                    <a href="">
                    </a>
                </div>
                <button type="button" aria-label="Like">
                    <i class="icon icon-like"></i>
                </button>
                <button type="button" aria-label="Comments">
                    <i class="icon icon-comment"></i>
                </button>
                <button type="button" aria-label="Save">
                    <i class="icon icon-save"></i>
                </button>
                <button type="button" aria-label="More options">
                    <i class="icon icon-more"></i>
                </button>
            </div>
        `;
    }

    destroy() {
        if (this.element) {
            // Pause any playing video
            const video = this.element.querySelector('video');
            if (video) {
                video.pause();
                video.src = '';
            }

            // Remove the element
            this.element.remove();
            this.element = null;
        }
    }

    getElement() {
        return this.element;
    }

    getVideo() {
        return this.element?.querySelector('video');
    }

    getPlayButton() {
        return this.element?.querySelector('[data-action="play"]');
    }

    getVolumeButton() {
        return this.element?.querySelector('[data-action="volume"]');
    }

    getVolumeRange() {
        return this.element?.querySelector('input[type="range"]#volume');
    }

    getFullscreenButton() {
        return this.element?.querySelector('[data-action="fullscreen"]');
    }

    getAutoplayButton() {
        return this.element?.querySelector('[data-action="autoplay"]');
    }

    getUsername() {
        return this.element?.querySelector('.videos__username');
    }

    getDescription() {
        return this.element?.querySelector('.videos__description');
    }

    updateContent(videoData) {
        
        if (!videoData || !this.element) return;

        // Update video source
        const video = this.getVideo();
        if (video) {
            video.src = videoData.url;
            video.load();
        }

        // Update user info
        const username = this.getUsername();
        if (username) {
            username.textContent = videoData.user?.name || 'Desconocido';
        }

        // Update avatar
        // const avatarImg = this.element.querySelector('.videos__user .user-avatar img');
        // if (avatarImg) {
        //     avatarImg.src = videoData.user?.avatar || '/img/avatar.webp';
        // }

        // // Update href
        // const anchorPlayer = this.element.querySelector('.videos__user .user-avatar a');
        // if (anchorPlayer) {
        //     anchorPlayer.href = videoData.user?.username;
        // }
        const avatarContainers = this.element.querySelectorAll('.user-avatar');
        if(avatarContainers){
            avatarContainers.forEach(container=>{
                const html = `
                    <a href="${videoData.user?.username}">
                        <img src="${videoData.user?.avatar || '/img/avatar.webp'}" alt="Avatar">
                    </a>
                `
                container.innerHTML = html;
            })
        }

        // Update description
        const description = this.getDescription();
        if (description) {
            const fullText = videoData.description || '';
            if (fullText.length > 100) {
                const shortText = fullText.slice(0, 100) + '...';
                description.innerHTML = `<span class="desc-short" style="display:inline;">${shortText}</span><span class="desc-full" style="display:none;">${fullText}</span> <button class="desc-toggle" style="background:none; border:none; color:#007bff; cursor:pointer;">Ver más</button>`;
                const toggleBtn = description.querySelector('.desc-toggle');
                const shortSpan = description.querySelector('.desc-short');
                const fullSpan = description.querySelector('.desc-full');
                toggleBtn.addEventListener('click', () => {
                    if (fullSpan.style.display === 'none') {
                        shortSpan.style.display = 'none';
                        fullSpan.style.display = 'inline';
                        toggleBtn.textContent = 'Ver menos';
                    } else {
                        fullSpan.style.display = 'none';
                        shortSpan.style.display = 'inline';
                        toggleBtn.textContent = 'Ver más';
                    }
                });
            } else {
                description.textContent = fullText;
            }
        }
    }

    addEventListeners(callbacks) {
        if (!this.element) return;

        const video = this.getVideo();
        const playBtn = this.getPlayButton();
        const volumeBtn = this.getVolumeButton();
        const volumeRange = this.getVolumeRange();
        const fullscreenBtn = this.getFullscreenButton();
        const autoplayBtn = this.getAutoplayButton();

        // Video click
        video?.addEventListener('click', callbacks.onVideoClick || (() => { }));

        // Play button
        playBtn?.addEventListener('click', callbacks.onPlayClick || (() => { }));

        // Volume button
        volumeBtn?.addEventListener('click', callbacks.onVolumeClick || (() => { }));

        // Volume range
        volumeRange?.addEventListener('input', callbacks.onVolumeChange || (() => { }));

        // Fullscreen button
        fullscreenBtn?.addEventListener('click', callbacks.onFullscreenClick || (() => { }));

        // Autoplay button
        autoplayBtn?.addEventListener('click', callbacks.onAutoplayClick || (() => { }));

        // Video events
        video?.addEventListener('loadstart', callbacks.onLoadStart || (() => { }));
        video?.addEventListener('canplay', callbacks.onCanPlay || (() => { }));
        video?.addEventListener('error', callbacks.onError || (() => { }));
    }
} 