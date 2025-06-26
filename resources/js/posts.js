import Slider from './Slider.js';

document.addEventListener('DOMContentLoaded', function () {
    const postsContainer = document.querySelector('.posts');
    const sliders = new Map();
    let page = 1;
    let loading = false;
    let hasMore = true;

    function getSliderInstance(container) {
        if (!sliders.has(container)) {
            sliders.set(container, new Slider(container, {
                loop: false,
                autoplay: false,
                interval: 5000,
            }));
        }
        return sliders.get(container);
    }

    function renderPosts(postsData) {
        postsData.forEach(post => {
            let html = window.postComponent;
            // User avatar
            const avatar = `<a href="/profile/${post.user.username}" class="user-avatar"><img src=\"${post.user.avatar_url}\" alt=\"Avatar\" onerror=\"this.onerror=null;this.src='/img/avatar.webp';\"></a>`;
            html = html.replace('__USER_AVATAR__', avatar);
            // User info
            html = html.replace('__PROFILE_URL__', `/${post.user.username}`);
            html = html.replace('__USER_NAME__', post.user.short_name);
            html = html.replace('__CREATED_AT__', post.created_at);
            html = html.replace('__CREATED_AT_HUMAN__', post.created_at_human);
            // Post type
            html = html.replace('__POST_TYPE__', (post.payment_required || post.subscription_required)
                ? '<i class="icon icon-dollar"></i> Exclusive'
                : '<i class="icon icon-globe"></i> Public');
            // Post body (limit 200 chars, simple truncation)
            let body = post.body;
            if (body.length > 200) {
                body = body.substring(0, 200) + '<a href="#"><b>... See more</b></a>';
            }
            html = html.replace('__POST_BODY__', body);
            // Media
            let mediaHtml = '';
            if (post.media.length > 0) {
                const total = post.media.length;
                mediaHtml += `<div class="post__media-container${total > 1 ? ' slider-container' : ''}" data-current-index="0" data-slides-count="${total}">`;
                mediaHtml += `<div class="post__media-wrapper${total > 1 ? ' slider-wrapper' : ''}" style="grid-template-columns: repeat(${total}, 100%);">`;
                post.media.forEach(media => {
                    mediaHtml += `<div class="post__media${total > 1 ? ' slide' : ''}">`;
                    if (media.type === 'image') {
                        mediaHtml += `<img loading="lazy" src="${media.url}" alt="Post image">`;
                    } else if (media.type === 'video') {
                        mediaHtml += `<div class="custom-video-player"><video class="custom-video" preload="metadata"><source src="${media.url}" type="video/mp4">Your browser does not support the video tag.</video><div class="controls"><button type="button" class="play-pause"><i class="icon icon-play" style="--iconSizePercent:.5"></i></button><input type="range" class="progress-bar" value="0" min="0" step="1"><span class="duration">0:00</span><div class="speed-control"><button type="button" class="speed-btn"><span class="speed-label">1x</span></button><ul class="speed-menu"><li data-speed="0.5">0.5x</li><li data-speed="0.75">0.75x</li><li data-speed="1" class="active">1x</li><li data-speed="1.25">1.25x</li><li data-speed="1.5">1.5x</li><li data-speed="1.75">1.75x</li><li data-speed="2">2x</li></ul></div><div class="volume-control"><button type="button" class="volume-btn"><i class="icon icon-volume" style="--iconSizePercent:.5"></i></button><input type="range" class="volume-bar" min="0" max="1" step="0.01" value="1"></div><button type="button" class="fullscreen"><i class="icon icon-fullscreen" style="--iconSizePercent:.5"></i></button></div></div>`;
                    }
                    mediaHtml += `</div>`;
                });
                mediaHtml += `</div>`;
                if (total > 1) {
                    mediaHtml += `<button class="slider-btn disabled" data-dir="prev" data-action="swipeSlider"><i class="icon icon-left-angle-bracket"></i></button>`;
                    mediaHtml += `<button class="slider-btn" data-dir="next" data-action="swipeSlider"><i class="icon icon-right-angle-bracket"></i></button>`;
                }
                mediaHtml += `</div>`;
            }
            html = html.replace('__MEDIA_CONTAINER__', mediaHtml);
            // Like button
            html = html.replace('__LIKE_ACTIVE__', post.has_liked ? 'active' : '');
            // Tip button
            html = html.replace('__TIP_BUTTON__', post.user.is_performer ? `<button type="button" class="post__tip button"><i class="icon icon-tip"></i><span>Tip</span></button>` : '');

            const temp = document.createElement('div');
            temp.innerHTML = html;
            const postEl = temp.firstElementChild;
            postsContainer.appendChild(postEl);
            // Inicializar slider si es necesario
            if (postEl.querySelector('.slider-container')) {
                getSliderInstance(postEl.querySelector('.slider-container'));
            }
            // Inicializar custom video player si hay videos
            postEl.querySelectorAll('.custom-video-player').forEach(player => {
                if (window.initCustomVideoPlayer) {
                    window.initCustomVideoPlayer(player);
                }
            });
        });
    }

    async function loadPosts() {

        if (loading || !hasMore) return;
        loading = true;
        try {
            const response = await fetch(window.postsLoadRoute, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ page })
            });
            const data = await response.json();
            renderPosts(data.posts);
            hasMore = data.hasMore;
            page++;
        } catch (e) {
            // handle error
            console.log(e);
        } finally {
            loading = false;
        }
    }

    // Inicial load
    loadPosts();

    // Infinite scroll
    window.addEventListener('scroll', function () {
        if (!hasMore || loading) return;
        const rect = postsContainer.getBoundingClientRect();
        const distanceToBottom = rect.bottom - window.innerHeight;
        if (distanceToBottom < 400) {
            loadPosts();
        }
    });

    // Delegación de clics
    postsContainer.addEventListener('click', function (e) {
        const target = e.target.closest('[data-action="swipeSlider"]');
        if (!target) return;

        const btn = target.closest(".slider-btn");
        if (!btn) return;

        const container = btn.closest(".slider-container");
        const slider = getSliderInstance(container);
        const dir = btn.dataset.dir;
        slider.move(dir);
    });
});
