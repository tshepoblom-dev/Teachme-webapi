(function ($) {
    "use strict";

    var liveEndedHtml = `<div class="no-result default-no-result d-flex align-items-center justify-content-center flex-column w-100 h-100">
        <div class="no-result-logo">
            <img src="/assets/default/img/no-results/support.png" alt="">
        </div>
        <div class="d-flex align-items-center flex-column mt-30 text-center">
            <h2 class="text-dark-blue">${liveEndedLang}</h2>
            <p class="mt-5 text-center text-gray font-weight-500">${redirectToPanelInAFewMomentLang}</p>
        </div>
    </div>`;

    var featherIconsConf = { width: 20, height: 20 };
    let maximizeIcon = feather.icons['maximize-2'].toSvg(featherIconsConf);

    // Create Agora client
    var client = AgoraRTC.createClient({
        mode: "rtc",
        codec: "vp8",
    });

    var localTracks = {
        videoTrack: null,
        audioTrack: null,
        screenAudioTrack: null,
        screenVideoTrack: null,
        shareScreenActived: false
    };

    var remoteUsers = {};

    var options = {
        appid: appId,
        channel: channelName,
        uid: accountName,
        token: rtcToken,
        role: 'host',
        audienceLatency: 2
    };

    var $remoteStreamPlayerEl = $('#remote-stream-player');

   async function republishTracks() {
        const tracks = [];
        if (localTracks.videoTrack) tracks.push(localTracks.videoTrack);
        if (localTracks.audioTrack) tracks.push(localTracks.audioTrack);
        if (localTracks.screenVideoTrack) tracks.push(localTracks.screenVideoTrack);

        // Only unpublish if something is actually published
        const publishedTracks = client.localTracks || [];
        if (publishedTracks.length > 0) {
            await client.unpublish(publishedTracks);
        }

        if (tracks.length > 0) {
            await client.publish(tracks);
        }
    }


    async function handleJoinOrCreateStream() {
        try {
            client.on("user-published", handleUserPublished);
            client.on("user-unpublished", handleUserUnpublished);
            client.on("user-left", handleHostEndLive);
            client.on("user-joined", handlePeerOnline);

            options.uid = await client.join(
                options.appid,
                options.channel,
                options.token || null,
                authUserId
            );

            if (streamRole === "host" || sessionStreamType === 'multiple') {
                localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
                localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack();

                if (streamRole === "host") {
                    localTracks.videoTrack.play("stream-player");
                } else {
                    const playerHtml = await getRemoteUserCardHtml(authUserId);
                    const player = $(playerHtml);
                    $remoteStreamPlayerEl.append(player);
                    localTracks.videoTrack.play(`remote-player-${authUserId}`);
                }

                await republishTracks();

                const startAt = (streamStartAt && streamStartAt > 0)
                    ? (new Date().getTime() / 1000) - streamStartAt
                    : 0;
                handleTimer(startAt);

                $(".agora-stream-loading").addClass('d-none');
            }
        } catch (error) {
            console.error("Join stream failed:", error);
        }
    }

    handleJoinOrCreateStream();

    function handlePeerOnline(evt) { }

    window.getUserInfoCache = {};

    window.getUserInfo = function (uid) {
        return new Promise((resolve, reject) => {
            if (getUserInfoCache && typeof getUserInfoCache[uid] !== "undefined") {
                resolve(getUserInfoCache[uid])
            } else {
                $.get(`/panel/users/${uid}/getInfo`, function (result) {
                    if (result && result.user) {
                        getUserInfoCache[uid] = result.user;
                        resolve(result.user)
                    } else {
                        reject(null)
                    }
                });
            }
        });
    }

    async function subscribe(user, mediaType) {
        const uid = user.uid;
        await client.subscribe(user, mediaType);

        if (mediaType === 'video') {
            if (uid === hostUserId) {
                user.videoTrack.play("stream-player");
            } else {
                const playerHtml = await getRemoteUserCardHtml(uid);
                const player = $(playerHtml);
                $remoteStreamPlayerEl.append(player);
                user.videoTrack.play(`remote-player-${uid}`);
            }
        }

        if (mediaType === 'audio') {
            user.audioTrack.play();
        }

        $(".agora-stream-loading").addClass('d-none');
        $("#notStartedAlert").removeClass('d-flex').addClass('d-none');

        const startAt = (streamStartAt && streamStartAt > 0) ? (new Date().getTime() / 1000) - streamStartAt : 0;
        handleTimer(startAt);
    }

    async function leave() {
        for (let trackName in localTracks) {
            const track = localTracks[trackName];
            if (track) {
                track.stop();
                track.close();
                localTracks[trackName] = null;
            }
        }

        await client.leave();
        if (redirectAfterLeave) window.location = redirectAfterLeave;
        console.log("client leaves channel success");
    }

    function handleUserPublished(user, mediaType) {
        const id = user.uid;
        remoteUsers[id] = user;
        subscribe(user, mediaType);
    }

    function handleUserUnpublished(user, mediaType) {
        if (mediaType === 'video') {
            const id = user.uid;
            delete remoteUsers[id];
            $(`#remote-player-${id}`).html('');
        }
    }

    function handleHostEndLive(user) {
        const id = user.uid;
        $(`#remote-player-${id}`).html(liveEndedHtml);
        setTimeout(() => {
            if (redirectAfterLeave) window.location = redirectAfterLeave;
        }, 5000);
    }

    async function handleShareScreen() {
        if (localTracks.shareScreenActived) return;

        if (localTracks.videoTrack) {
            localTracks.videoTrack.stop();
            localTracks.videoTrack.close();
            localTracks.videoTrack = null;
        }

        const screenTrack = await AgoraRTC.createScreenVideoTrack({
            encoderConfig: { framerate: 30, height: 720, width: 1280 }
        }, "auto");

        if (screenTrack instanceof Array) {
            localTracks.screenVideoTrack = screenTrack[0];
            localTracks.screenAudioTrack = screenTrack[1];
        } else {
            localTracks.screenVideoTrack = screenTrack;
        }

        localTracks.screenVideoTrack.play("stream-player");
        localTracks.shareScreenActived = true;

        await republishTracks();

        localTracks.screenVideoTrack.on("track-ended", async () => {
            await handleEndShareScreen();
        });
    }

    async function handleEndShareScreen() {
        if (!localTracks.shareScreenActived) return;

        if (localTracks.screenVideoTrack) {
            localTracks.screenVideoTrack.stop();
            localTracks.screenVideoTrack.close();
            localTracks.screenVideoTrack = null;
        }

        localTracks.shareScreenActived = false;

        localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack();

        if (streamRole === "host") {
            localTracks.videoTrack.play("stream-player");
        } else {
            const playerHtml = await getRemoteUserCardHtml(authUserId);
            const player = $(playerHtml);
            $remoteStreamPlayerEl.append(player);
            localTracks.videoTrack.play(`remote-player-${authUserId}`);
        }

        await republishTracks();
    }

    $('body').on('click', '#leave', async function () {
        const $this = $(this);
        const sessionId = $this.attr('data-id');
        $this.addClass('loadingbar primary').prop('disabled', true);

        const path = '/panel/sessions/' + sessionId + '/endAgora';
        $.get(path, function (result) {
            if (result && result.code === 200) leave();
        });
    });

    $('body').on('click', '#shareScreen', function () {
        handleShareScreen();
        $(this).removeClass('d-flex').addClass('d-none')
        $('#endShareScreen').removeClass('d-none').addClass('d-flex')
    });

    $('body').on('click', '#endShareScreen', function () {
        handleEndShareScreen();
        $(this).removeClass('d-flex').addClass('d-none')
        $('#shareScreen').removeClass('d-none').addClass('d-flex')
    });

    $('body').on('click', '#microphoneEffect', async function () {
        const $this = $(this);
        let icon = feather.icons['mic'].toSvg(featherIconsConf);

        if ($this.hasClass('active')) {
            $this.removeClass('active').addClass('disabled');
            icon = feather.icons['mic-off'].toSvg(featherIconsConf);
            if (localTracks.audioTrack) {
                localTracks.audioTrack.stop();
                localTracks.audioTrack.close();
                localTracks.audioTrack = null;
            }
        } else {
            $this.addClass('active').removeClass('disabled');
            localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
        }

        await republishTracks();
        $this.find('.icon').html(icon);
    });

    async function handleCameraEffect(isActive = false) {
        const $button = $('#cameraEffect');
        let icon = feather.icons['video'].toSvg(featherIconsConf);

        if (isActive) {
            $button.removeClass('active').addClass('disabled');
            icon = feather.icons['video-off'].toSvg(featherIconsConf);
            if (localTracks.videoTrack) {
                localTracks.videoTrack.stop();
                localTracks.videoTrack.close();
                localTracks.videoTrack = null;
            }
        } else {
            $button.addClass('active').removeClass('disabled');

            if (localTracks.videoTrack) {
                localTracks.videoTrack.stop();
                localTracks.videoTrack.close();
                localTracks.videoTrack = null;
            }

            localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack();

            if (streamRole === "host") {
                localTracks.videoTrack.play("stream-player");
            } else {
                const playerHtml = await getRemoteUserCardHtml(authUserId);
                const player = $(playerHtml);
                $remoteStreamPlayerEl.append(player);
                localTracks.videoTrack.play(`remote-player-${authUserId}`);
            }
        }

        await republishTracks();
        $button.find('.icon').html(icon);
    }

    async function getRemoteUserCardHtml(uid) {
        const userInfo = await getUserInfo(uid);
        return `<div id="remote-player-${uid}" class="remote-stream">
                    <span class="remote-stream-fullscreen">${maximizeIcon}</span>
                    ${userInfo ? `<span class="remote-stream-user-info">${userInfo.full_name}</span>` : ''}
                </div>`;
    }

    function handleTimer(startAt = 0) {
        const streamTimer = $('#streamTimer');
        const hoursLabel = streamTimer.find('.hours');
        const minutesLabel = streamTimer.find('.minutes');
        const secondsLabel = streamTimer.find('.seconds');
        let totalSeconds = startAt;

        setInterval(setTime, 1000);

        function setTime() {
            ++totalSeconds;
            const seconds = pad(Math.floor((totalSeconds) % 60));
            const minutes = pad(Math.floor((totalSeconds / 60) % 60));
            const hours = pad(Math.floor((totalSeconds / (60 * 60)) % 24));

            hoursLabel.html(hours);
            minutesLabel.html(minutes);
            secondsLabel.html(seconds);
        }

        function pad(val) {
            var valString = val + "";
            return valString.length < 2 ? "0" + valString : valString;
        }
    }

    $('body').on('click', '#collapseBtn', function () {
        $('.agora-tabs').toggleClass('show');
    });

    $('body').on('click', '.remote-stream-fullscreen', function () {
        const $parent = $(this).closest('.remote-stream');
        $parent.toggleClass('is-fullscreen');
        $remoteStreamPlayerEl.toggleClass('is-fullscreen');
    });

    $('body').on('click', '#handleUsersJoin', function () {
        const $this = $(this);
        const notActive = $this.hasClass('dont-join-users');

        $this.find('span').text(notActive ? joinIsActiveLang : joiningIsDisabledLang);
        $this.toggleClass('dont-join-users');
        $this.prop('disabled', true);

        $.get(`/panel/sessions/${sessionId}/toggleUsersJoinToAgora`, function (result) {
            if (result) {
                $.toast({
                    heading: result.heading,
                    text: result.text,
                    bgColor: (result.icon === 'error') ? '#f63c3c' : '#43d477',
                    textColor: 'white',
                    hideAfter: 10000,
                    position: 'bottom-right',
                    icon: result.icon
                });
            }
            $this.prop('disabled', false);
        });
    });
})(jQuery);
