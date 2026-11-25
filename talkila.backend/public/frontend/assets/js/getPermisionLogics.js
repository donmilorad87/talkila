function getPermisionsPopupLogics() {

    if (navigator.mediaDevices && navigator.mediaDevices.enumerateDevices) {
        // Firefox 38+ seems having support of enumerateDevicesx
        navigator.enumerateDevices = function (callback) {
            navigator.mediaDevices.enumerateDevices().then(callback);
        };
    }

    var MediaDevices = [];
    var isHTTPs = location.protocol === 'https:';
    var canEnumerate = false;

    if (typeof MediaStreamTrack !== 'undefined' && 'getSources' in MediaStreamTrack) {
        canEnumerate = true;
    } else if (navigator.mediaDevices && !!navigator.mediaDevices.enumerateDevices) {
        canEnumerate = true;
    }

    var hasMicrophone = false;
    var hasSpeakers = false;
    var hasWebcam = false;

    var isMicrophoneAlreadyCaptured = false;
    var isWebcamAlreadyCaptured = false;

    function checkDeviceSupport(callback) {
        if (!canEnumerate) {
            return;
        }

        if (!navigator.enumerateDevices && window.MediaStreamTrack && window.MediaStreamTrack.getSources) {
            navigator.enumerateDevices = window.MediaStreamTrack.getSources.bind(window.MediaStreamTrack);
        }

        if (!navigator.enumerateDevices && navigator.enumerateDevices) {
            navigator.enumerateDevices = navigator.enumerateDevices.bind(navigator);
        }

        if (!navigator.enumerateDevices) {
            if (callback) {
                callback();
            }
            return;
        }

        MediaDevices = [];

        navigator.enumerateDevices(function (devices) {
            devices.forEach(function (_device) {
                var device = {};
                for (var d in _device) {
                    device[d] = _device[d];
                }

                if (device.kind === 'audio') {
                    device.kind = 'audioinput';
                }

                if (device.kind === 'video') {
                    device.kind = 'videoinput';
                }

                var skip;
                MediaDevices.forEach(function (d) {
                    if (d.id === device.id && d.kind === device.kind) {
                        skip = true;
                    }
                });

                if (skip) {
                    return;
                }

                if (!device.deviceId) {
                    device.deviceId = device.id;
                }

                if (!device.id) {
                    device.id = device.deviceId;
                }

                if (!device.label) {
                    device.label = getPoTranslate('INVOKE_USERMEDIA')
                    if (!isHTTPs) {
                        device.label = getPoTranslate('HTTP_REQUIRED') + getPoTranslate('DEVICE')
                    }
                } else {
                    if (device.kind === 'videoinput' && !isWebcamAlreadyCaptured) {
                        isWebcamAlreadyCaptured = true;

                    }

                    if (device.kind === 'audioinput' && !isMicrophoneAlreadyCaptured) {
                        isMicrophoneAlreadyCaptured = true;


                    }
                }

                if (device.kind === 'audioinput') {
                    hasMicrophone = true;
                }

                if (device.kind === 'audiooutput') {
                    hasSpeakers = true;
                }

                if (device.kind === 'videoinput') {
                    hasWebcam = true;
                }

                // there is no 'videoouput' in the spec.

                MediaDevices.push(device);
            });
            if (isMicrophoneAlreadyCaptured) {

                document.getElementsByClassName('microPhone ')[0].getElementsByClassName('buttonField')[0].getElementsByTagName('button')[0].classList.add('dn')
                document.getElementsByClassName('microPhone ')[0].getElementsByClassName('buttonField')[0].getElementsByTagName('p')[0].classList.remove('dn')
            }

            if (isWebcamAlreadyCaptured) {

                document.getElementsByClassName('webCam')[0].getElementsByClassName('buttonField')[0].getElementsByTagName('button')[0].classList.add('dn')
                document.getElementsByClassName('webCam')[0].getElementsByClassName('buttonField')[0].getElementsByTagName('p')[0].classList.remove('dn')
            }
            if (callback) {
                callback();
            }
        });
    }

    // check for microphone/camera support!
    checkDeviceSupport(function () {
        /* document.write('hasWebCam: ', hasWebcam, '<br>');
        document.write('hasMicrophone: ', hasMicrophone, '<br>');
        document.write('isMicrophoneAlreadyCaptured: ', isMicrophoneAlreadyCaptured, '<br>');
        document.write('isWebcamAlreadyCaptured: ', isWebcamAlreadyCaptured, '<br>'); */

        document.getElementsByClassName('webCamButton')[0].addEventListener('click', function () {
            getPermsions({
                video: true
            })

        })

        document.getElementsByClassName('microphoneButton')[0].addEventListener('click', function () {
            getPermsions({
                audio: true
            })

        })

        function getPermsions(obj) {
            navigator.getUserMedia = navigator.getUserMedia ||
                navigator.webkitGetUserMedia ||
                navigator.mozGetUserMedia;

            if (navigator.getUserMedia) {
                navigator.getUserMedia(obj,
                    function (stream) {
                        var video = document.createElement('video');
                        video.srcObject = stream;
                        showLoading()
                        location.assign(location.href + '?openPopup=permision_popup')

                    },
                    function (err) {
                        console.log("The following error occurred: " + err.name);
                    }
                );
            } else {
                console.log("getUserMedia not supported");
            }
        }

        function checkPermision(hasDevice, hasDeviceAlreadyCaptured, domElement) {

            if (hasDevice) {
                let buttonField = domElement.getElementsByClassName('buttonField')[0]
                if (hasDeviceAlreadyCaptured) {
                    buttonField.getElementsByTagName('button')[0].classList.add('dn')
                    buttonField.getElementsByTagName('p')[0].classList.remove('dn')
                } else {
                    buttonField.getElementsByTagName('button')[0].classList.remove('dn')
                    buttonField.getElementsByTagName('p')[0].classList.add('dn')
                }
            } else {
                let hideFields = domElement.getElementsByClassName('diss')

                for (let i = 0; i < hideFields.length; i++) {
                    hideFields[i].classList.add('dn')
                }

                document.getElementById('webCameraIsNotPressent').classList.remove('dn')
            }
        }

        function checkFullPermisions(isMicrophoneAlreadyCaptured, isWebcamAlreadyCaptured) {
            if (isMicrophoneAlreadyCaptured && isWebcamAlreadyCaptured) {
                document.getElementsByClassName('framePermision')[0].classList.add('dn')
                document.getElementsByClassName('framePermision')[1].classList.remove('dn')

                document.getElementsByClassName('dfpermision')[0].getElementsByTagName('h6')[0].textContent = getPoTranslate('PERMISSION_SUFFICIENT')
            }else{
                document.getElementById('orrangeDivPermissionMessage')?.classList.remove('hiddenView')

            }
        }

        checkPermision(hasWebcam, isWebcamAlreadyCaptured, document.getElementsByClassName('webCam')[0])
        checkPermision(hasMicrophone, isMicrophoneAlreadyCaptured, document.getElementsByClassName('microPhone')[0])

        checkFullPermisions(isMicrophoneAlreadyCaptured, isWebcamAlreadyCaptured)


    });

    let urlParam = new URLSearchParams(location.search);

    if (urlParam.get('openPopup')) {
        showLoading()
        document.getElementById('permision_popup').style.transition = '0s'
        document.getElementById('permision_popup').getElementsByClassName('popuper')[0].style.transition = '0s'

        openPopup(urlParam.get('openPopup'))


        history.pushState({}, document.title, location.origin + location.pathname);

        setTimeout(function () {
            hideLoading()
            document.getElementById('permision_popup').style.transition = '0.3s'
            document.getElementById('permision_popup').getElementsByClassName('popuper')[0].style.transition = '0.3s'
        }, 310)
    }
}

(function () {
    getPermisionsPopupLogics()
})()
