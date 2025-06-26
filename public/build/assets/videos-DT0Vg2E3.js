class c{constructor(e){this.type=e,this.element=null}create(){return this.element=document.createElement("div"),this.element.className=`videos__player videos__player--${this.type} videos__player--reel`,this.element.innerHTML=this.getTemplate(),this.element}getTemplate(){return`
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
        `}destroy(){if(this.element){const e=this.element.querySelector("video");e&&(e.pause(),e.src=""),this.element.remove(),this.element=null}}getElement(){return this.element}getVideo(){var e;return(e=this.element)==null?void 0:e.querySelector("video")}getPlayButton(){var e;return(e=this.element)==null?void 0:e.querySelector('[data-action="play"]')}getVolumeButton(){var e;return(e=this.element)==null?void 0:e.querySelector('[data-action="volume"]')}getVolumeRange(){var e;return(e=this.element)==null?void 0:e.querySelector('input[type="range"]#volume')}getFullscreenButton(){var e;return(e=this.element)==null?void 0:e.querySelector('[data-action="fullscreen"]')}getAutoplayButton(){var e;return(e=this.element)==null?void 0:e.querySelector('[data-action="autoplay"]')}getUsername(){var e;return(e=this.element)==null?void 0:e.querySelector(".videos__username")}getDescription(){var e;return(e=this.element)==null?void 0:e.querySelector(".videos__description")}updateContent(e){var s;if(!e||!this.element)return;const t=this.getVideo();t&&(t.src=e.url,t.load());const n=this.getUsername();n&&(n.textContent=((s=e.user)==null?void 0:s.name)||"Desconocido");const i=this.element.querySelectorAll(".user-avatar");i&&i.forEach(r=>{var l,d;const a=`
                    <a href="${(l=e.user)==null?void 0:l.username}">
                        <img src="${((d=e.user)==null?void 0:d.avatar)||"/img/avatar.webp"}" alt="Avatar">
                    </a>
                `;r.innerHTML=a});const o=this.getDescription();if(o){const r=e.description||"";if(r.length>100){const a=r.slice(0,100)+"...";o.innerHTML=`<span class="desc-short" style="display:inline;">${a}</span><span class="desc-full" style="display:none;">${r}</span> <button class="desc-toggle" style="background:none; border:none; color:#007bff; cursor:pointer;">Ver más</button>`;const l=o.querySelector(".desc-toggle"),d=o.querySelector(".desc-short"),u=o.querySelector(".desc-full");l.addEventListener("click",()=>{u.style.display==="none"?(d.style.display="none",u.style.display="inline",l.textContent="Ver menos"):(u.style.display="none",d.style.display="inline",l.textContent="Ver más")})}else o.textContent=r}}addEventListeners(e){if(!this.element)return;const t=this.getVideo(),n=this.getPlayButton(),i=this.getVolumeButton(),o=this.getVolumeRange(),s=this.getFullscreenButton(),r=this.getAutoplayButton();t==null||t.addEventListener("click",e.onVideoClick||(()=>{})),n==null||n.addEventListener("click",e.onPlayClick||(()=>{})),i==null||i.addEventListener("click",e.onVolumeClick||(()=>{})),o==null||o.addEventListener("input",e.onVolumeChange||(()=>{})),s==null||s.addEventListener("click",e.onFullscreenClick||(()=>{})),r==null||r.addEventListener("click",e.onAutoplayClick||(()=>{})),t==null||t.addEventListener("loadstart",e.onLoadStart||(()=>{})),t==null||t.addEventListener("canplay",e.onCanPlay||(()=>{})),t==null||t.addEventListener("error",e.onError||(()=>{}))}}class p{constructor(){this.currentIndex=0,this.loadedVideos={},this.videoIds=[],this.isLoading=!1,this.hasMoreVideos=!0,this.isTransitioning=!1,this.wheelTimeout=null,this.container=document.querySelector(".videos__container"),this.playersContainer=document.querySelector(".videos__players"),this.prevBtn=document.querySelector('[data-dir="prev"]'),this.nextBtn=document.querySelector('[data-dir="next"]'),this.prevPlayer=null,this.currentPlayer=null,this.nextPlayer=null,this.init()}init(){this.createInitialPlayers(),this.bindEvents(),this.loadInitialVideos()}createInitialPlayers(){this.prevPlayer=new c("prev"),this.playersContainer.appendChild(this.prevPlayer.create()),this.currentPlayer=new c("current"),this.playersContainer.appendChild(this.currentPlayer.create()),this.nextPlayer=new c("next"),this.playersContainer.appendChild(this.nextPlayer.create()),this.bindPlayerControls(),this.syncAutoplayFromStorage()}bindEvents(){var n,i,o,s,r;(n=this.prevBtn)==null||n.addEventListener("click",()=>this.navigate("prev")),(i=this.nextBtn)==null||i.addEventListener("click",()=>this.navigate("next")),(o=this.container)==null||o.addEventListener("wheel",a=>{a.preventDefault(),!this.wheelTimeout&&(this.wheelTimeout=setTimeout(()=>{this.wheelTimeout=null},300),a.deltaY>0?this.navigate("next"):this.navigate("prev"))}),document.addEventListener("keydown",a=>{a.key==="ArrowUp"?(a.preventDefault(),this.navigate("prev")):a.key==="ArrowDown"?(a.preventDefault(),this.navigate("next")):(a.code==="Space"||a.key===" ")&&!this.isInputFocused()&&(a.preventDefault(),this.toggleVideoPlayback())});let e=0,t=0;(s=this.container)==null||s.addEventListener("touchstart",a=>{e=a.touches[0].clientY}),(r=this.container)==null||r.addEventListener("touchend",a=>{t=a.changedTouches[0].clientY;const l=e-t;Math.abs(l)>50&&(l>0?this.navigate("next"):this.navigate("prev"))})}bindPlayerControls(){var e;(e=this.currentPlayer)==null||e.addEventListeners({onVideoClick:()=>this.toggleVideoPlayback(),onPlayClick:()=>this.toggleVideoPlayback(),onVolumeClick:()=>this.toggleVolume(),onVolumeChange:t=>this.handleVolumeChange(t),onFullscreenClick:()=>this.toggleFullscreen(),onAutoplayClick:()=>this.toggleAutoplay(),onLoadStart:()=>this.handleVideoLoadStart(),onCanPlay:()=>this.handleVideoCanPlay(),onError:()=>this.handleVideoError()})}toggleVideoPlayback(){var n,i;const e=(n=this.currentPlayer)==null?void 0:n.getVideo(),t=(i=this.currentPlayer)==null?void 0:i.getPlayButton();e&&(e.paused?e.play().then(()=>{t&&(t.innerHTML='<i class="icon icon-pause"></i>')}).catch(o=>{console.log("Play failed:",o)}):(e.pause(),t&&(t.innerHTML='<i class="icon icon-play"></i>')))}toggleVolume(){var n,i;const e=(n=this.currentPlayer)==null?void 0:n.getVideo(),t=(i=this.currentPlayer)==null?void 0:i.getVolumeButton();e.muted?(e.muted=!1,t.innerHTML='<i class="icon icon-volume"></i>'):(e.muted=!0,t.innerHTML='<i class="icon icon-volume-mute"></i>')}toggleFullscreen(){document.fullscreenElement?document.exitFullscreen():this.container.requestFullscreen()}toggleAutoplay(){var o,s;const e=(o=this.currentPlayer)==null?void 0:o.getAutoplayButton(),t=(s=this.currentPlayer)==null?void 0:s.getVideo();if(!e||!t)return;const i=e.getAttribute("data-autoplay")==="on"?"off":"on";e.setAttribute("data-autoplay",i),t.loop=i==="off",localStorage.setItem("reels-autoplay",i)}handleVideoLoadStart(){var t;const e=(t=this.currentPlayer)==null?void 0:t.getVideo();e&&(e.style.opacity="0.5")}handleVideoCanPlay(){var t;const e=(t=this.currentPlayer)==null?void 0:t.getVideo();e&&(e.style.opacity="1")}handleVideoError(){var t;console.error("Error loading video");const e=(t=this.currentPlayer)==null?void 0:t.getVideo();e&&(e.style.opacity="0.5")}handleVolumeChange(e){var i,o;const t=(i=this.currentPlayer)==null?void 0:i.getVideo(),n=(o=this.currentPlayer)==null?void 0:o.getVolumeButton();if(t){const s=Number(e.target.value);t.volume=s/100,s===0?(t.muted=!0,n&&(n.innerHTML='<i class="icon icon-volume-mute"></i>')):(t.muted=!1,n&&(n.innerHTML='<i class="icon icon-volume"></i>'))}}showLoading(){var e;(e=this.container)==null||e.classList.add("loading")}hideLoading(){var e;(e=this.container)==null||e.classList.remove("loading")}async loadInitialVideos(){this.hasMoreVideos=!0,this.showLoading(),await this.loadVideos(),this.hideLoading(),setTimeout(()=>this.playCurrentVideo(),100)}async loadVideos(){if(!(this.isLoading||!this.hasMoreVideos)){this.isLoading=!0,this.showLoading();try{const e=await fetch("/videos/toLoad",{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify({exclude:Object.keys(this.loadedVideos).map(Number)})});if(!e.ok)throw new Error("Failed to load videos");const t=await e.json();(t.videos||[]).forEach(i=>{this.loadedVideos[i.id]=i,this.videoIds.push(i.id)}),this.hasMoreVideos=t.hasMore,this.updatePlayers()}catch(e){console.error("Error loading videos:",e),this.showError("Failed to load videos. Please try again.")}finally{this.isLoading=!1,this.hideLoading()}}}showError(e){const t=document.createElement("div");t.style.cssText=`
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ff4444;
            color: white;
            padding: 15px 20px;
            border-radius: 5px;
            z-index: 1000;
            animation: slideIn 0.3s ease;
        `,t.textContent=e,document.body.appendChild(t),setTimeout(()=>{t.remove()},3e3)}async loadMoreVideos(){!this.hasMoreVideos||this.isLoading||await this.loadVideos()}updatePlayers(){this.updatePlayerContent(this.currentPlayer,this.currentIndex),this.syncAutoplayFromStorage(),this.setupAutoplayEndedHandler(),this.currentIndex>0?(this.updatePlayerContent(this.prevPlayer,this.currentIndex-1),this.prevBtn.disabled=!1):this.prevBtn.disabled=!0,this.currentIndex<this.videoIds.length-1?(this.updatePlayerContent(this.nextPlayer,this.currentIndex+1),this.nextBtn.disabled=!1):this.nextBtn.disabled=!1}updatePlayerContent(e,t){var r;if(!e||t<0||t>=this.videoIds.length)return;const n=this.videoIds[t],i=this.loadedVideos[n];if(!i)return;e.updateContent(i);const o=e.getVideo(),s=e.getVolumeRange&&e.getVolumeRange();o&&s&&(s.value=Math.round((o.volume??1)*100)),(r=e.getElement())!=null&&r.classList.contains("videos__player--current")&&this.adjustContainerForOrientation(i.orientation)}adjustContainerForOrientation(e){this.playersContainer&&(this.playersContainer.classList.remove("videos__players--horizontal","videos__players--vertical"),e==="horizontal"?this.playersContainer.classList.add("videos__players--horizontal"):this.playersContainer.classList.add("videos__players--vertical"))}async navigate(e){this.isTransitioning||(this.isTransitioning=!0,e==="prev"&&this.currentIndex>0?await this.transitionToPrev():e==="next"&&(this.currentIndex>=this.videoIds.length-1&&await this.loadMoreVideos(),this.currentIndex<this.videoIds.length-1&&await this.transitionToNext()),this.isTransitioning=!1)}async transitionToPrev(){var t;const e=(t=this.currentPlayer)==null?void 0:t.getVideo();e&&e.pause(),this.currentIndex--,this.updatePlayers(),this.playCurrentVideo()}async transitionToNext(){var t;const e=(t=this.currentPlayer)==null?void 0:t.getVideo();e&&e.pause(),this.currentIndex++,this.updatePlayers(),this.playCurrentVideo()}playCurrentVideo(){var n,i;const e=(n=this.currentPlayer)==null?void 0:n.getVideo(),t=(i=this.currentPlayer)==null?void 0:i.getPlayButton();e&&e.play().then(()=>{t&&(t.innerHTML='<i class="icon icon-pause"></i>')}).catch(o=>{console.log("Auto-play prevented:",o),t&&(t.innerHTML='<i class="icon icon-play"></i>')})}cleanupOldPlayer(e){const t=this[`${e}Player`];if(t){t.destroy();const n=new c(e);this.playersContainer.appendChild(n.create()),this[`${e}Player`]=n,this.bindPlayerControls()}}setupAutoplayEndedHandler(){var n,i;const e=(n=this.currentPlayer)==null?void 0:n.getVideo(),t=(i=this.currentPlayer)==null?void 0:i.getAutoplayButton();e&&t&&(e.onended=()=>{t.getAttribute("data-autoplay")==="on"&&this.navigate("next")},e.loop=t.getAttribute("data-autoplay")==="off")}syncAutoplayFromStorage(){var i,o;const e=localStorage.getItem("reels-autoplay")||"on",t=(i=this.currentPlayer)==null?void 0:i.getAutoplayButton(),n=(o=this.currentPlayer)==null?void 0:o.getVideo();t&&t.setAttribute("data-autoplay",e),n&&(n.loop=e==="off")}isInputFocused(){const e=document.activeElement;if(!e)return!1;const t=e.tagName.toLowerCase();return t==="input"||t==="textarea"||e.isContentEditable}}const h=document.createElement("style");h.textContent=`
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
`;document.head.appendChild(h);document.addEventListener("DOMContentLoaded",()=>{new p});
