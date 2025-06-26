import { VideoPlayer } from './components/VideoPlayer.js';

// TikTok-like Reels Video Player
class ReelsPlayer {
    constructor() {
        this.currentIndex = 0;
        this.loadedVideos = {};
        this.videoIds = [];
        this.isLoading = false;
        this.hasMoreVideos = true;
        this.isTransitioning = false;
        this.wheelTimeout = null;

        // DOM elements
        this.container = document.querySelector('.videos__container');
        this.playersContainer = document.querySelector('.videos__players');
        this.prevBtn = document.querySelector('[data-dir="prev"]');
        this.nextBtn = document.querySelector('[data-dir="next"]');

        // Player references (will be set after creation)
        this.prevPlayer = null;
        this.currentPlayer = null;
        this.nextPlayer = null;

        this.init();
    }

    init() {
        this.createInitialPlayers();
        this.bindEvents();
        this.loadInitialVideos();
    }

    createInitialPlayers() {
        // Create prev player
        this.prevPlayer = new VideoPlayer('prev');
        this.playersContainer.appendChild(this.prevPlayer.create());

        // Create current player
        this.currentPlayer = new VideoPlayer('current');
        this.playersContainer.appendChild(this.currentPlayer.create());

        // Create next player
        this.nextPlayer = new VideoPlayer('next');
        this.playersContainer.appendChild(this.nextPlayer.create());

        // Add event listeners to all players
        this.bindPlayerControls();

        // Sincroniza autoplay con localStorage
        this.syncAutoplayFromStorage();
    }

    bindEvents() {
        // Navigation buttons
        this.prevBtn?.addEventListener('click', () => this.navigate('prev'));
        this.nextBtn?.addEventListener('click', () => this.navigate('next'));

        // Mouse wheel navigation
        this.container?.addEventListener('wheel', (e) => {
            e.preventDefault();

            // Throttle wheel events to prevent too many rapid calls
            if (this.wheelTimeout) return;

            this.wheelTimeout = setTimeout(() => {
                this.wheelTimeout = null;
            }, 300);

            if (e.deltaY > 0) {
                this.navigate('next');
            } else {
                this.navigate('prev');
            }
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowUp') {
                e.preventDefault();
                this.navigate('prev');
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                this.navigate('next');
            } else if ((e.code === 'Space' || e.key === ' ') && !this.isInputFocused()) {
                e.preventDefault();
                this.toggleVideoPlayback();
            }
        });

        // Touch/swipe events for mobile
        let startY = 0;
        let endY = 0;

        this.container?.addEventListener('touchstart', (e) => {
            startY = e.touches[0].clientY;
        });

        this.container?.addEventListener('touchend', (e) => {
            endY = e.changedTouches[0].clientY;
            const diff = startY - endY;

            if (Math.abs(diff) > 50) { // Minimum swipe distance
                if (diff > 0) {
                    this.navigate('next');
                } else {
                    this.navigate('prev');
                }
            }
        });
    }

    bindPlayerControls() {
        // Bind controls for current player
        this.currentPlayer?.addEventListeners({
            onVideoClick: () => this.toggleVideoPlayback(),
            onPlayClick: () => this.toggleVideoPlayback(),
            onVolumeClick: () => this.toggleVolume(),
            onVolumeChange: (e) => this.handleVolumeChange(e),
            onFullscreenClick: () => this.toggleFullscreen(),
            onAutoplayClick: () => this.toggleAutoplay(),
            onLoadStart: () => this.handleVideoLoadStart(),
            onCanPlay: () => this.handleVideoCanPlay(),
            onError: () => this.handleVideoError()
        });
    }

    toggleVideoPlayback() {
        const video = this.currentPlayer?.getVideo();
        const playBtn = this.currentPlayer?.getPlayButton();

        if (!video) return;

        if (video.paused) {
            video.play().then(() => {
                if (playBtn) {
                    playBtn.innerHTML = '<i class="icon icon-pause"></i>';
                }
            }).catch(error => {
                console.log('Play failed:', error);
            });
        } else {
            video.pause();
            if (playBtn) {
                playBtn.innerHTML = '<i class="icon icon-play"></i>';
            }
        }
    }

    toggleVolume() {
        const video = this.currentPlayer?.getVideo();
        const volumeBtn = this.currentPlayer?.getVolumeButton();

        if (video.muted) {
            video.muted = false;
            volumeBtn.innerHTML = '<i class="icon icon-volume"></i>';
        } else {
            video.muted = true;
            volumeBtn.innerHTML = '<i class="icon icon-volume-mute"></i>';
        }
    }

    toggleFullscreen() {
        if (document.fullscreenElement) {
            document.exitFullscreen();
        } else {
            this.container.requestFullscreen();
        }
    }

    toggleAutoplay() {
        const autoplayBtn = this.currentPlayer?.getAutoplayButton();
        const video = this.currentPlayer?.getVideo();
        if (!autoplayBtn || !video) return;
        const current = autoplayBtn.getAttribute('data-autoplay');
        const next = current === 'on' ? 'off' : 'on';
        autoplayBtn.setAttribute('data-autoplay', next);
        video.loop = next === 'off';
        // Guarda el estado en localStorage
        localStorage.setItem('reels-autoplay', next);
    }

    handleVideoLoadStart() {
        const video = this.currentPlayer?.getVideo();
        if (video) {
            video.style.opacity = '0.5';
        }
    }

    handleVideoCanPlay() {
        const video = this.currentPlayer?.getVideo();
        if (video) {
            video.style.opacity = '1';
        }
    }

    handleVideoError() {
        console.error('Error loading video');
        const video = this.currentPlayer?.getVideo();
        if (video) {
            video.style.opacity = '0.5';
        }
    }

    handleVolumeChange(e) {
        const video = this.currentPlayer?.getVideo();
        const volumeBtn = this.currentPlayer?.getVolumeButton();
        if (video) {
            const value = Number(e.target.value);
            video.volume = value / 100;
            if (value === 0) {
                video.muted = true;
                if (volumeBtn) volumeBtn.innerHTML = '<i class="icon icon-volume-mute"></i>';
            } else {
                video.muted = false;
                if (volumeBtn) volumeBtn.innerHTML = '<i class="icon icon-volume"></i>';
            }
        }
    }

    showLoading() {
        this.container?.classList.add('loading');
    }

    hideLoading() {
        this.container?.classList.remove('loading');
    }

    async loadInitialVideos() {
        this.hasMoreVideos = true;
        this.showLoading();
        await this.loadVideos();
        this.hideLoading();
        
        setTimeout(() => this.playCurrentVideo(), 100);
    }
    

    async loadVideos() {
        if (this.isLoading || !this.hasMoreVideos) return;

        this.isLoading = true;
        this.showLoading();

        try {
            const response = await fetch('/videos/toLoad', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    exclude: Object.keys(this.loadedVideos).map(Number)
                })
            });

            if (!response.ok) throw new Error('Failed to load videos');

            const data = await response.json();
            const videos = data.videos || [];

            videos.forEach(video => {
                this.loadedVideos[video.id] = video;
                this.videoIds.push(video.id);
            });

            this.hasMoreVideos = data.hasMore;

            this.updatePlayers();

        } catch (error) {
            console.error('Error loading videos:', error);
            this.showError('Failed to load videos. Please try again.');
        } finally {
            this.isLoading = false;
            this.hideLoading();
        }
    }



    showError(message) {
        // Create error notification
        const errorDiv = document.createElement('div');
        errorDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ff4444;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            z-index: 1000;
            animation: slideIn 0.3s ease;
        `;
        errorDiv.textContent = message;

        document.body.appendChild(errorDiv);

        // Remove after 3 seconds
        setTimeout(() => {
            errorDiv.remove();
        }, 3000);
    }

    async loadMoreVideos() {
        if (!this.hasMoreVideos || this.isLoading) return;
        await this.loadVideos();
    }

    updatePlayers() {
        // Update current player
        this.updatePlayerContent(this.currentPlayer, this.currentIndex);
        this.syncAutoplayFromStorage();
        this.setupAutoplayEndedHandler();

        // Update prev player
        if (this.currentIndex > 0) {
            this.updatePlayerContent(this.prevPlayer, this.currentIndex - 1);
            this.prevBtn.disabled = false;
        } else {
            this.prevBtn.disabled = true;
        }

        // Update next player
        if (this.currentIndex < this.videoIds.length - 1) {
            this.updatePlayerContent(this.nextPlayer, this.currentIndex + 1);
            this.nextBtn.disabled = false;
        } else {
            this.nextBtn.disabled = false; // Keep enabled to load more
        }
    }

    updatePlayerContent(player, index) {
        if (!player || index < 0 || index >= this.videoIds.length) return;

        const videoId = this.videoIds[index];
        const videoData = this.loadedVideos[videoId];

        if (!videoData) return;

        // Update player content using the component method
        player.updateContent(videoData);

        // Sincroniza el input range con el volumen actual del video
        const video = player.getVideo();
        const volumeRange = player.getVolumeRange && player.getVolumeRange();
        if (video && volumeRange) {
            volumeRange.value = Math.round((video.volume ?? 1) * 100);
        }

        // Adjust container size based on video orientation if this is the current player
        if (player.getElement()?.classList.contains('videos__player--current')) {
            this.adjustContainerForOrientation(videoData.orientation);
        }
    }

    adjustContainerForOrientation(orientation) {
        if (!this.playersContainer) return;

        // Remove existing orientation classes
        this.playersContainer.classList.remove('videos__players--horizontal', 'videos__players--vertical');

        // Add appropriate class based on orientation
        if (orientation === 'horizontal') {
            this.playersContainer.classList.add('videos__players--horizontal');
        } else {
            this.playersContainer.classList.add('videos__players--vertical');
        }
    }

    async navigate(direction) {
        if (this.isTransitioning) return;

        this.isTransitioning = true;

        if (direction === 'prev' && this.currentIndex > 0) {
            await this.transitionToPrev();
        } else if (direction === 'next') {
            // Check if we need to load more videos
            if (this.currentIndex >= this.videoIds.length - 1) {
                await this.loadMoreVideos();
            }

            if (this.currentIndex < this.videoIds.length - 1) {
                await this.transitionToNext();
            }
        }

        this.isTransitioning = false;
    }

    async transitionToPrev() {
        // Pause current video
        const currentVideo = this.currentPlayer?.getVideo();
        if (currentVideo) {
            currentVideo.pause();
        }

        // Update indices
        this.currentIndex--;

        // Update player content
        this.updatePlayers();

        // Play new current video
        this.playCurrentVideo();
    }

    async transitionToNext() {
        // Pause current video
        const currentVideo = this.currentPlayer?.getVideo();
        if (currentVideo) {
            currentVideo.pause();
        }

        // Update indices
        this.currentIndex++;

        // Update player content
        this.updatePlayers();

        // Play new current video
        this.playCurrentVideo();
    }

    playCurrentVideo() {
        const video = this.currentPlayer?.getVideo();
        const playBtn = this.currentPlayer?.getPlayButton();

        if (video) {
            // Try to play the video
            video.play().then(() => {
                // Successfully started playing
                if (playBtn) {
                    playBtn.innerHTML = '<i class="icon icon-pause"></i>';
                }
            }).catch(error => {
                console.log('Auto-play prevented:', error);
                // Auto-play was blocked, update play button to show play state
                if (playBtn) {
                    playBtn.innerHTML = '<i class="icon icon-play"></i>';
                }
            });
        }
    }

    // Method to remove old player HTML and clean up
    cleanupOldPlayer(playerType) {
        const player = this[`${playerType}Player`];
        if (player) {
            // Destroy the old player
            player.destroy();

            // Create a new player
            const newPlayer = new VideoPlayer(playerType);
            this.playersContainer.appendChild(newPlayer.create());

            // Update reference
            this[`${playerType}Player`] = newPlayer;

            // Rebind controls for the new player
            this.bindPlayerControls();
        }
    }

    setupAutoplayEndedHandler() {
        const video = this.currentPlayer?.getVideo();
        const autoplayBtn = this.currentPlayer?.getAutoplayButton();
        if (video && autoplayBtn) {
            video.onended = () => {
                if (autoplayBtn.getAttribute('data-autoplay') === 'on') {
                    this.navigate('next');
                }
            };
            video.loop = autoplayBtn.getAttribute('data-autoplay') === 'off';
        }
    }

    syncAutoplayFromStorage() {
        const autoplay = localStorage.getItem('reels-autoplay') || 'on';
        const autoplayBtn = this.currentPlayer?.getAutoplayButton();
        const video = this.currentPlayer?.getVideo();
        if (autoplayBtn) {
            autoplayBtn.setAttribute('data-autoplay', autoplay);
        }
        if (video) {
            video.loop = autoplay === 'off';
        }
    }

    /**
     * Devuelve true si el foco está en un input, textarea o elemento editable
     */
    isInputFocused() {
        const active = document.activeElement;
        if (!active) return false;
        const tag = active.tagName.toLowerCase();
        return (
            tag === 'input' ||
            tag === 'textarea' ||
            active.isContentEditable
        );
    }
}

// Add CSS animation for error notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new ReelsPlayer();
});
