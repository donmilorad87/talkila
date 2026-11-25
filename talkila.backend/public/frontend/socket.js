//browserify socket.js | uglifyjs -cm > socketBundle.js
//browserify socket.js -o socketBundle.js


import Echo from 'laravel-echo'

window.Pusher = require('pusher-js')

window.Echo = new Echo({
    broadcaster: 'pusher',
    wsHost: document.getElementById('socketServerUrlShort').textContent.trim(),
    wssPort: document.getElementById('socketServerPort').value,
    forceTLS: true,
    // From .env via configuration_parameters.blade.php: Reverb locally, Pusher Channels in production.
    key: document.getElementById('pusherAppKey').value,
    cluster: document.getElementById('pusherAppCluster').value,
    enabledTransports: ['ws', 'wss']
});

const {
    connect,
    createLocalTracks,
    createLocalVideoTrack,
    createLocalAudioTrack,
    LocalVideoTrack
} = require("twilio-video")


function startSockets() {
    if (document.body.className === "video_conference") {

        loadScript('/frontend/assets/js/talk/socketEventFunctions.js' + version, function () {
            loadScript('/frontend/assets/js/talk/videoCallBase.js' + version, function () {



                // loadScript('/frontend/assets/js/optionButton.js' + version, function () { })
                // option button sghould be implemented in the socket bundle for video talk - now is inside route controller but it shouldnt be


                loadScript('/frontend/assets/js/talk/reviewLogics.js' + version, function () {
                    loadScript('/frontend/assets/js/talk/socketListenFunctions.js' + version, function () {
                        loadScript('/frontend/assets/js/talk/videoCallExtendLogics.js' + version, function () {

                            loadScript('/frontend/assets/js/talk/videoTalkMuteUnmuteFunctions.js' + version, function () {

                                loadScript('/frontend/assets/js/talk/videoCallErrorFunctions.js' + version, function () {
                                    loadScript('/frontend/assets/js/talk/participantsConnectDisconect.js' + version, function () {
                                        loadScript('/frontend/assets/js/talk/trackSubscribed.js' + version, function () {
                                            loadScript('/frontend/assets/js/talk/screenShare.js' + version, function () {
                                                loadScript('/frontend/assets/js/talk/videoCall.js' + version, function () {
                                                    connectToSocket(connect, createLocalTracks, createLocalVideoTrack, createLocalAudioTrack, LocalVideoTrack)
                                                    loadScript('/frontend/assets/js/talk/reviewLogics.js' + version, function () {

                                                    })
                                                })
                                            })
                                        })
                                    })
                                })
                            })
                        })
                    })
                })


            })
        })
    }
}


startSockets()

class GetTokenForExtendCallItemList extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenForExtendCallItemList"
    }
}
class GetExtendCallItemListError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetExtendCallItemListError"
    }
}

class GetTokenForGettingFirstUpcomingBooking extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenForGettingFirstUpcomingBooking"
    }
}
class GettingFirstUpcomingBookingError extends Error {
    constructor(message) {
        super(message)
        this.name = "GettingFirstUpcomingBookingError"
    }
}


class GetStripeCardsTryCatchError1 extends Error {
    constructor(message) {
        super(message)
        this.name = "GetStripeCardsTryCatchError1"
    }
}
class GetStripeCardsTryCatchError2 extends Error {
    constructor(message) {
        super(message)
        this.name = "GetStripeCardsTryCatchError2"
    }
}
class GetWalletBalanceError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetWalletBalanceError"
    }
}
class TryCatchGetWalletBalanceError extends Error {
    constructor(message) {
        super(message)
        this.name = "TryCatchGetWalletBalanceError"
    }
}
class GetWalletBalanceError2 extends Error {
    constructor(message) {
        super(message)
        this.name = "GetWalletBalanceError2"
    }
}
class TryCatchGetWalletBalanceError2 extends Error {
    constructor(message) {
        super(message)
        this.name = "TryCatchGetWalletBalanceError2"
    }
}
class ExtendPaymentUsingWalletError extends Error {
    constructor(message) {
        super(message)
        this.name = "ExtendPaymentUsingWalletError"
    }
}

class SettingsDepositCoinsError extends Error {
    constructor(message) {
        super(message)
        this.name = "SettingsDepositCoinsError"
    }
}

class SettingsAddCardError extends Error {
    constructor(message) {
        super(message)
        this.name = "SettingsAddCardError"
    }
}

class TryCatchSettingsAddCardError extends Error {
    constructor(message) {
        super(message)
        this.name = "TryCatchSettingsAddCardError"
    }
}

class SettingsDefaultCardError extends Error {
    constructor(message) {
        super(message)
        this.name = "SettingsDefaultCardError"
    }
}

class TryCatchSettingsDefaultCardError extends Error {
    constructor(message) {
        super(message)
        this.name = "TryCatchSettingsDefaultCardError"
    }
}

class TryCatchSubmitReviewXMLHttpRequestFunction extends Error {
    constructor(message) {
        super(message)
        this.name = "TryCatchSubmitReviewXMLHttpRequestFunction"
    }
}


class FeedbackSubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "FeedbackSubmitError"
    }
}
