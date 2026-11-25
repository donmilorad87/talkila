import { scrollDirection } from './detectScrollDirection.js';

import { inputRange } from './inputRange.js';

import { calculator } from './calculator.js';



function initCarousels() {

    if (window.innerWidth < 768) {
        mobileCarousels()
    } else if (window.innerWidth > 767) {
        desktopCarousels()
    }

    function removeActiveThumbs(x) {
        for (let i = 0; i < x.length; i++) {
            x[i].classList.remove('active');
        }
    }

    function owlClick(x, y) {
        for (let i = 0; i < x.length; i++) {
            x[i].addEventListener('click', function () {
                y.trigger('to.owl.carousel', this.dataset.owlIndex)
            })
        }
    }

    function owlSwitch(x, y) {
        switch (x) {
            case 0:
                removeActiveThumbs(y)
                y[x].className += " active";
                break;
            case 1:
                removeActiveThumbs(y)
                y[x].className += " active";
                break;
            case 2:
                removeActiveThumbs(y)
                y[x].className += " active";
        }
    }

    function desktopCarousels() {

        setTimeout(function () {
            var owl2 = jQuery("#slider-one");
            owl2.owlCarousel({
                margin: 20,
                dots: true,
                nav: false,
                stagePadding: 0,
                items: 1,
                autoplay: true,
                autoplayHoverPause: true
            });

            let carOne = document.getElementById('carousel-one').getElementsByClassName('slider-item')
            document.getElementById('slider-one').style.opacity = '1'
            owl2.on('changed.owl.carousel', function (event) {
                owlSwitch(event.item.index, carOne)
            })

            owlClick(carOne, owl2)
        }, 30)

        setTimeout(function () {
            var owl3 = jQuery("#slider-two");
            owl3.owlCarousel({
                margin: 20,
                dots: true,
                nav: false,
                items: 1,
                autoplay: true,
                autoplayHoverPause: true

            });

            let carTwo = document.getElementById('carousel-two').getElementsByClassName('slider-item')

            document.getElementById('slider-two').style.opacity = '1'
            owl3.on('changed.owl.carousel', function (event) {

                owlSwitch(event.item.index, carTwo)

            })

            owlClick(carTwo, owl3)

        }, 60)

        setTimeout(function () {
            if (window.desktopCarouselsHelper !== 1) {
                desktopCarouselsHelper()
            }
            window.desktopCarousels = 1

        }, 65)
    }

    function desktopCarouselsHelper() {

        window.desktopCarouselsHelper = 1
    }

    function mobileCarousels() {

        setTimeout(function () {
            var owl4 = jQuery("#mobile-slider-one");
            owl4.owlCarousel({
                margin: 20,
                dots: true,
                nav: false,
                stagePadding: 0,
                items: 1
            });
            document.getElementById('mobile-slider-one').style.opacity = '1'
        }, 30)
        setTimeout(function () {
            var owl5 = jQuery("#mobile-slider-two");
            owl5.owlCarousel({
                margin: 20,
                dots: true,
                nav: false,
                stagePadding: 0,
                items: 1
            });
            document.getElementById('mobile-slider-two').style.opacity = '1'
        }, 60)
        window.mobileCarousels = 1

    }

    function initializeCarousels() {
        if (window.innerWidth < 768) {
            if (window.mobileCarousels !== 1) {

                mobileCarousels()
            }
        } else if (window.innerWidth > 767) {
            if (window.desktopCarousels !== 1) {
                desktopCarousels()
            }
        }
    }

    window.addEventListener("resize", initializeCarousels);




}

export function showMoreTalks() {

    let limit = 500

    let privateShowMore = document.getElementsByClassName('privateShowMore')

    for (let i = 0; i < privateShowMore.length; i++) {
        privateShowMore[i].addEventListener('click', function () {

            displayTalks(this.dataset.userid, this.dataset.type, limit)
        })
    }

    let privateHideMore = document.getElementsByClassName('privateHideMore')
    for (let i = 0; i < privateHideMore.length; i++) {
        privateHideMore[i].addEventListener('click', function () {


            let privateC = document.getElementsByClassName('privateC')

            for (let i = 0; i < privateC.length; i++) {

                let privateCourses = privateC[i].getElementsByClassName('privateCourseItem')

                for (let i = (privateCourses.length - 1); i >= 0; i--) {
                    if (i > 4) {

                        privateCourses[i].parentElement.removeChild(privateCourses[i])
                    }
                }


                let privateShowMore = document.getElementsByClassName('privateShowMore')
                for (let i = 0; i < privateShowMore.length; i++) {
                    privateShowMore[i].parentElement.style.display = 'block'

                }

                let privateHideMore = document.getElementsByClassName('privateHideMore')
                for (let i = 0; i < privateHideMore.length; i++) {
                    privateHideMore[i].parentElement.style.display = 'none'
                }

            }


        })
    }

    function displayTalks(user, type, limit) {
        let offset = document.getElementById('privateTeacherTalks').getElementsByClassName('privateCourseItem').length
        let xhr = new XMLHttpRequest()
        let url = '/teacher-talks?talk_type=' + type + '&limit=' + limit + '&teacherId=' + user + '&offset=' + offset  + '&teacher_username=' + location.pathname.split('/')[1]
        xhr.onloadstart = function () {
            showLoading()
        }
        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.response)

                if (response.success === true) {

                    if (type === "1") {


                        let privateTeacherTalks = document.getElementById('privateTeacherTalks')
                        privateTeacherTalks.innerHTML += response.html

                        let mobilePrivateProfileTeacherTalks = document.getElementById('mobilePrivateProfileTeacherTalks')
                        mobilePrivateProfileTeacherTalks.innerHTML += response.htmlMobile

                        let privateShowMore = document.getElementsByClassName('privateShowMore')
                        for (let i = 0; i < privateShowMore.length; i++) {
                            privateShowMore[i].parentElement.style.display = 'none'

                        }

                        let privateHideMore = document.getElementsByClassName('privateHideMore')
                        for (let i = 0; i < privateHideMore.length; i++) {
                            privateHideMore[i].parentElement.style.display = 'block'
                        }




                    } /* else if (type === "2") {

                        let groupC = document.getElementsByClassName('groupC')
                        for (let i = 0; i < groupC.length; i++) {
                            groupC[i].innerHTML = response.html

                        }

                    } */
                } else {
                    toastify(getPoTranslate('COMUNICATION_WITH_API_SUCCES_FALSE'))
                }

            }
        }
        xhr.onloadend = function () {
            hideLoading()
        }
        xhr.onerror = function (error) {
            hideLoading()
            Sentry.captureException(new GetTeacherTalksError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
        }

        xhr.open("GET", url, true)
        xhr.send()


    }
}


export function loggedOutHome() {
    initCarousels()
    scrollDirection()
    inputRange()
    calculator()

}
