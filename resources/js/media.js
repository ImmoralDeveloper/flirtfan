document.addEventListener('DOMContentLoaded', function () {
    const mediaList = document.querySelector('.media-list');
    let page = 1;
    let loading = false;
    let hasMore = true;


    function renderMediaItems(items) {
        items.forEach(item => {
            const li = document.createElement('li');
            let html = '';
            if (item.type === 'image') {
                html = `<a href="${item.url}" target="_blank"><img src="${item.url}" alt="Media Item"></a>`;
            } else if (item.type === 'video') {
                html = `<a href="${item.url}" target="_blank"><img src="${item.thumbnail || '/img/media-video-thumb.png'}" alt="Video Thumbnail" class="media-video-thumb"><i class="icon icon-play"></i></a>`;
            }
            li.innerHTML = html;
            mediaList.appendChild(li);
        });
    }

    
    async function loadMedia() {
        if (loading || !hasMore) return;
        loading = true;
        try {
            const response = await fetch(window.profileMediaLoadRoute, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ page })
            });
            const data = await response.json();
            renderMediaItems(data.media);
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
    loadMedia();

    // Infinite scroll
    window.addEventListener('scroll', function () {
        if (!hasMore || loading) return;
        const rect = mediaList.getBoundingClientRect();
        const distanceToBottom = rect.bottom - window.innerHeight;
        if (distanceToBottom < 50) {
            loadMedia();
        }
    });
});
