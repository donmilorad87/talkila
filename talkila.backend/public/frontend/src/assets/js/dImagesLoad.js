function dImageIEFunction(dimage, pointer) {

    let isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    let isIE11 = !!window.MSInputMethodContext && !!document.documentMode;

    if (isSafari || isIE11) {
        if (dimage.dataset.img === 'png') {
            dimage.src = '/frontend/assets/img/' + pointer + '/' + dimage.dataset.srcs + '.png'
            dimage.style.display = 'block'
        } else if (dimage.dataset.img === 'svg') {
            dimage.src = '/frontend/assets/img/' + pointer + '/' + dimage.dataset.srcs + '.svg'
            dimage.style.display = 'block'
        } else if (dimage.dataset.img === 'jpg') {
            dimage.src = '/frontend/assets/img/' + pointer + '/' + dimage.dataset.srcs + '.jpg'
            dimage.style.display = 'block'
        }
    } else {
        dimage.src = '/frontend/assets/img/webp/' + pointer + '/' + dimage.dataset.srcs + '.webp'
        dimage.style.display = 'block'
    }

    dimage.style.display = 'block'

}

function dimagesShow(i, dimage, pointer) {

    setTimeout(function () {
        dImageIEFunction(dimage, pointer)
    }, 10 * i);
}

export function initLoadingImages() {


    let isTinyPicturesLoaded = 0;
    let isMinPictureLoaded = 0;
    let isBigPictureLoaded = 0;


    let loadingImages = function (event) {


        let dimages = document.getElementsByClassName('dimages')

        if (window.innerWidth < 768) {
            if (isTinyPicturesLoaded == 0) {

                for (let i = 0; i < dimages.length; i++) {

                    if (dimages[i].dataset.device !== "d") {
                        (function () {
                            dimagesShow(i, dimages[i], 'tiny')
                        })(i);

                    }
                }

                isTinyPicturesLoaded = 1
                isMinPictureLoaded = 0
                isBigPictureLoaded = 0

            }
        } else if (window.innerWidth > 767 && window.innerWidth < 2560) {
            if (isMinPictureLoaded == 0) {

                for (let i = 0; i < dimages.length; i++) {

                    if (dimages[i].dataset.device !== "m") {
                        (function () {

                            dimagesShow(i, dimages[i], 'min')

                        })(i);

                    }
                }
                isTinyPicturesLoaded = 0
                isMinPictureLoaded = 1
                isBigPictureLoaded = 0
            }
        } else if (window.innerWidth > 2559) {
            if (isBigPictureLoaded === 0) {

                for (let i = 0; i < dimages.length; i++) {

                    if (dimages[i].dataset.device !== "m") {
                        (function () {

                            dimagesShow(i, dimages[i], 'big')

                        })(i);

                    }
                }
                isTinyPicturesLoaded = 0
                isMinPictureLoaded = 0
                isBigPictureLoaded = 1
            }
        }
    }


    var loadingImagesOnResize = loadingImages.bind(this);
    loadingImages()
    window.addEventListener('resize', loadingImagesOnResize, {
        passive: true
    });

}
