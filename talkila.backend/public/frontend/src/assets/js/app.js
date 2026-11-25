require('./lib/foundation-explicit-pieces')

import {
    isPresent
} from './isComponentPresentChecker.js'
import {
    routeController
} from './routeController.js'

import {
    mobileMenu
} from './mobileMenu.js'
import {
    showPopup
} from './closeSpanPopup.js'


import {
    openProfileMenu
} from './profileMenu.js'

class CheckCache {

    constructor(name, version, apiUrl, lang = false) {

        this.name = name
        this.version = version
        this.apiUrl = apiUrl
        this.lang = lang

        this.check_local_storadge_for_data()
    }

    check_local_storadge_for_data() {
        if (localStorage.getItem(`app_${this.name}${this.lang ? '_' + this.lang : ''}`) === null) {
            this.get_data_from_json_file(this.apiUrl, this.name, this.version, this.lang)
        } else {
            if (localStorage.getItem(`app_${this.name}${this.lang ? '_' + this.lang : ''}_version`) !== document.getElementById(`app_${this.name}_version`).value) {

                this.get_data_from_json_file(this.apiUrl, this.name, this.version, this.lang)
            } else {
                this.get_data_from_cache(JSON.parse(localStorage.getItem(`app_${this.name}`)))
            }
        }


    }

    get_data_from_json_file(url, localStorageName, version, lang) {

        var xhttp = new XMLHttpRequest()

        xhttp.onreadystatechange = function () {


            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.response)

                localStorage.setItem(`app_${localStorageName}${lang ? '_' + lang : ''}`, JSON.stringify(response))
                localStorage.setItem(`app_${localStorageName}${lang ? '_' + lang : ''}_version`, version)

            }
        }

        xhttp.onerror = function () {
            Sentry.captureException(new GetDataError('status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))
        }
        xhttp.open("GET", url, true)

        xhttp.setRequestHeader('Content-Type', 'application/json');
        xhttp.setRequestHeader('Accept', 'application/json')
        xhttp.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
        xhttp.setRequestHeader('Application-Language', appLanguage);
        xhttp.setRequestHeader('X-CSRF-TOKEN', token)
        xhttp.setRequestHeader('Authorization', bearerToken)

        xhttp.send()
    }

    get_data_from_cache(obj) {
        /* console.log(obj, 'kari') */
    }
}



window.Toastify = require('toastify-js')



window.addEventListener('load', function () {
    if (loggedIn) {
        if (document.body.className !== "video_conference") {
            loadScript('/frontend/assets/js/talk/callingScreen.js' + version, function () {

            })
        }


        try {



            const checkCacheLanguages = new CheckCache("languages", app_languages_version.value, envAppBackendUrl + "/languages", getCookie('activeLang'))
            const checkCacheTalkCategories = new CheckCache("talk_categories", app_talk_categories_version.value, "/category-subcategories", getCookie('activeLang'))

        } catch (error) {
            console.log('error', error)
        }
    }




    try { showPopup() } catch(e) { console.error('showPopup error:', e) }

    try { mobileMenu() } catch(e) { console.error('mobileMenu error:', e) }

    try { openProfileMenu() } catch(e) { console.error('openProfileMenu error:', e) }

    try { isPresent() } catch(e) { console.error('isPresent error:', e) }

    try { routeController() } catch(e) { console.error('routeController error:', e) }

    try {


        const checkCacheFlags = new CheckCache("flags", app_flags_version.value, "/frontend/assets/js/lang.json")


    } catch (error) {
        console.log('error', error)
    }




})


window.addEventListener("resize", mobileMenu.menuResponsiveCheck);

window.sendEvents = function (event, options = {}, call) {

    let data = options

    if (!data['user_id']) {
        data['user_id'] = call.user_id
    }

    data['event'] = event


    fetch(socketServerUrl + '/api/socket-event', {
        method: "POST",
        body: JSON.stringify(data),
        headers: {
            "Content-type": "application/json; charset=UTF-8",
            "Authorization": document.querySelector("meta[name='access_token']").content
        }
    }).then(response => response.json())
        .then(data => {
            toastify(data.message)
        })
        .catch(function (e) {
            console.error('sendEvents error:', e)
            if (typeof Sentry !== 'undefined') {
                Sentry.captureException(new SocketSendEventsError(e))
            }
        })

}


//unutrasnja
window.getCategoriesCeheckboxes = function (pointer) {

    if (pointer) {
        if (location.pathname.split('/')[location.pathname.split('/').length - 2] === 'talks') {
            if (getCategoryId(location.pathname.split('/')[location.pathname.split('/').length - 1])) {
                return (getCategoryId(location.pathname.split('/')[location.pathname.split('/').length - 1])).toString()
            } else {
                return null
            }
        } else if (location.pathname.split('/')[location.pathname.split('/').length - 3] === 'talks') {
            if (getCategoryId(location.pathname.split('/')[location.pathname.split('/').length - 2])) {
                return (getCategoryId(location.pathname.split('/')[location.pathname.split('/').length - 2])).toString()
            } else {
                return null
            }
        }



    } else {
        let checkedCategoryArray = []
        let categories = document.getElementById('categoriesHolder').getElementsByClassName('filter_category')

        for (let i = 0; i < categories.length; i++) {
            if (categories[i].checked) {
                checkedCategoryArray.push(categories[i].dataset.categoryId)
            }
        }

        return checkedCategoryArray
    }
}

function getCategoryId(categoryString) {

    let obj = JSON.parse(document.getElementById('talkCategoriesObj').textContent)
    for (let i = 0; i < obj.data.length; i++) {

        if (obj.data[i].value.trim() === categoryString.trim()) {
            return obj.data[i].id

        }
    }
}
//unutrasnja
window.getSubCategoriesCheckboxes = function (pointer) {
    if (pointer) {
        if (location.pathname.split('/')[location.pathname.split('/').length - 3] === 'talks') {
            if (getSubCategoryId(location.pathname.split('/')[location.pathname.split('/').length - 2], location.pathname.split('/')[location.pathname.split('/').length - 1])) {
                return (getSubCategoryId(location.pathname.split('/')[location.pathname.split('/').length - 2], location.pathname.split('/')[location.pathname.split('/').length - 1])).toString()
            } else {
                return false
            }
        } else {
            return false
        }


    } else {
        let checkedSubCategoryArray = []
        let subCategories = document.getElementById('categoriesHolder').getElementsByClassName('filter_subcategory')

        for (let i = 0; i < subCategories.length; i++) {

            if (subCategories[i].checked) {
                checkedSubCategoryArray.push(subCategories[i].dataset.subCategoryId)
            }
        }
        return checkedSubCategoryArray
    }

}

function getSubCategoryId(categoryString, subCategoryString) {
    let obj = JSON.parse(document.getElementById('talkCategoriesObj').textContent)
    for (let i = 0; i < obj.data.length; i++) {
        if (obj.data[i].value.trim() === categoryString.trim()) {
            for (let j = 0; j < obj.data[i].subcategories.length; j++) {
                if (obj.data[i].subcategories[j].value.trim() === subCategoryString.trim()) {
                    return obj.data[i].subcategories[j].id
                }
            }
        }
    }
}





//both
window.getDateWithMonthName = function (dateString) {
    let monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ]
    let realDateString = isSafari ? dateString.replaceAll('-', '/') : dateString
    let d = new Date(realDateString)

    return addZero(d.getDate()) + '. ' + monthNames[d.getMonth()] + ' ' + d.getFullYear()
}

//unutrasnja
window.setDrums = function (parentElementOfTimeSelect, t1h, t1m, t2h, t2m) {

    let from_hoursDrum = parentElementOfTimeSelect.getElementsByClassName('from_hours')[0]
    let from_minutesDrum = parentElementOfTimeSelect.getElementsByClassName('from_minutes')[0]
    let to_hoursDrum = parentElementOfTimeSelect.getElementsByClassName('to_hours')[0]
    let to_minutesDrum = parentElementOfTimeSelect.getElementsByClassName('to_minutes')[0]

    jQuery(from_hoursDrum).drum('setIndex', getIndex(t1h, from_hoursDrum))
    jQuery(from_minutesDrum).drum('setIndex', getIndex(t1m, from_minutesDrum))
    jQuery(to_hoursDrum).drum('setIndex', getIndex(t2h, to_hoursDrum))
    jQuery(to_minutesDrum).drum('setIndex', getIndex(t2m, to_minutesDrum))

    function getIndex(time, element) {
        let index = 0
        for (let i = 0; i < element.length; i++) {

            if (element[i].value === time) {

                return index
            } else {
                index++
            }
        }
    }

}
//unutrasnja
window.setAndClearDay = function (parentElementOfSevenDays, x) {
    parentElementOfSevenDays.getElementsByClassName('date-scheduler-wrap')[0].getElementsByClassName('active')[0].classList.remove('active')
    let days = parentElementOfSevenDays.getElementsByClassName('date-scheduler-wrap')[0].getElementsByTagName('div')
    for (let j = 0; j < days.length; j++) {
        if (days[j].dataset.index == x) {
            days[j].classList.add('active')
        }
    }
}

window.toastify = function (x) {
    Toastify({
        text: '<div class="fr toastContMain"><div class="lefter"><p class="fl cw m0 pr20 cc1"> ' + x + ' </p><h5 class="fl cw"></h5></div></div>',
        className: "notification",
        gravity: "top",
        position: "right",
        close: true,
        duration: 4000,
        stopOnFocus: true,
        escapeMarkup: false
    }).showToast();
}
//both

//both
window.chekToShowButton = function () {

    if (

        document.body.className === "logged_in" ||
        document.body.className === "jtc2_add_your_first_talk"
    ) {



        if (
            document.getElementById('talkInputP').classList.contains('ok') &&
            document.getElementById('categoryP').classList.contains('ok') &&
            document.getElementById('subCategoryP').classList.contains('ok')
        ) {
            document.getElementById('privateSubmit').classList.remove('dn')
        } else {
            document.getElementById('privateSubmit').classList.add('dn')
        }
    }
}
//both
window.getBookingTalkAvailability = function (date) {

    if (document.body.className === 'book_slot') {

        let teacherAvailabilityDatesTime = JSON.parse(document.getElementById('teacherAvailabilityDatesTime').value)

        document.getElementsByClassName('weekly-time')[0].innerHTML = ''

        for (let i = 0; i < Object.keys(teacherAvailabilityDatesTime).length; i++) {

            if (date === Object.keys(teacherAvailabilityDatesTime)[i]) {
                for (let i = 0; i < teacherAvailabilityDatesTime[date].length; i++) {

                    let time = teacherAvailabilityDatesTime[date][i].split(' ')

                    let button = document.createElement("button")

                    button.className = 'hollow btn'
                    button.textContent = time[1].slice(0, -3)
                    let bookingPaymentButton = document.getElementById('booking-payment')

                    button.addEventListener('click', function (e) {
                        e.stopPropagation()
                        bookingPaymentButton.style.right = '-50%'

                        if (document.getElementsByClassName('weekly-time')[0].getElementsByClassName('activee')[0]) {
                            document.getElementsByClassName('weekly-time')[0].getElementsByClassName('activee')[0].textContent =
                                document.getElementsByClassName('weekly-time')[0].getElementsByClassName('activee')[0].dataset.time

                            document.getElementsByClassName('weekly-time')[0].getElementsByClassName('activee')[0].classList.remove('activee')
                        }
                        this.classList.add('activee')

                        this.dataset.time = this.textContent

                        let isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent)

                        let dateHelper

                        isSafari ? dateHelper = new Date('2021/04/01 ' + this.textContent + ':00') : dateHelper = new Date('2021-04-01 ' + this.textContent + ':00')


                        let dateHelperToTime = addMinutes(dateHelper, document.getElementById('talkMinutes').textContent.match(/\d+/g).join(''))



                        this.textContent += ' - ' + addZero(dateHelperToTime.getHours()) + ':' + addZero(dateHelperToTime.getMinutes())
                        this.dataset.endTime = addZero(dateHelperToTime.getHours()) + ':' + addZero(dateHelperToTime.getMinutes())
                        this.innerHTML = '<span class="bookingCalendarFunnelButton mr8">' + document.getElementById('talkMinutes').textContent + ' | </span>' + this.textContent
                        let timeSlots = document.getElementsByClassName('weekly-time')[0].getElementsByTagName('button')

                        for (let i = 0; i < timeSlots.length; i++) {
                            timeSlots[i].style.width = "100%"
                            if (timeSlots[i].getElementsByClassName('bookingAnonCont')[0]) {
                                timeSlots[i].getElementsByClassName('bookingAnonCont')[0].style.transform = 'scale(0)'
                                timeSlots[i].getElementsByClassName('bookingAnonCont')[0].style.opacity = '0'
                            }
                            timeSlots[i].parentElement.style.height = 'auto'
                        }

                        this.style.width = '49%'


                        if (document.getElementById('bookingAnonCont')) {
                            this.parentElement.append(document.getElementById('bookingAnonCont'))
                            this.parentElement.style.height = 'auto'
                        } else {
                            this.parentElement.style.height = 'auto'
                        }

                        let that = this

                        setTimeout(function () {

                            that.parentElement.insertBefore(bookingPaymentButton, that.parentElement.getElementsByClassName('bookingAnonCont')[0])

                            setTimeout(function () {
                                bookingPaymentButton.style.right = "0%"
                            }, 10)

                            bookingPaymentButton.classList.add('activeButtoner')

                        }, 310)


                        setBookingTimeToLocalStoradge(this.dataset.time, addZero(dateHelperToTime.getHours()) + ':' + addZero(dateHelperToTime.getMinutes()))
                    })

                    let diver = document.createElement('div')
                    diver.className = "divItemTransition"
                    diver.append(button)

                    document.getElementsByClassName('weekly-time')[0].append(diver)

                }

                if (teacherAvailabilityDatesTime[date].length === 1) {

                    eventFire(document.getElementsByClassName('weekly-time')[0].getElementsByTagName('button')[0], 'click')
                }
            }
        }

    }
}
//both


window.setBookingTimeToLocalStoradge = function (startTime, endTime) {

    let obj

    if (window.localStorage.getItem('bookingObj') === null) {
        obj = {}

    } else {
        obj = JSON.parse(window.localStorage.getItem('bookingObj'))
    }

    obj.bookingTime = [startTime, endTime]

    window.localStorage.setItem('bookingObj', JSON.stringify(obj))

    setCookie("bookingObj", JSON.stringify(obj), 900, "/booking-payment")
    setCookie("bookingObjHelp", JSON.stringify(obj), 900, "/booking-summary")
    setCookie("bookingObj", JSON.stringify(obj), 900, "/booking-postpone")
}

window.removeProfilePhoto = function () {
    if (document.getElementById('removePhoto')) {
        document.getElementById('removePhoto').style.cursor = 'pointer'
        document.getElementById('removePhoto').addEventListener('click', function () {

            jQuery.ajax({
                type: 'POST',

                url: '/frontend/api/remove-user-image',
                data: {
                    "_token": document.getElementsByClassName('uploadPhotoTextHolder')[0].getElementsByTagName('input')[0].value
                },
                beforeSend: function () {
                    // Handle the beforeSend event
                    showLoading()
                },
                complete: function () {
                    hideLoading()
                },
                success: function (response) {

                    if (response.success) {
                        toastify(response.message)

                        document.getElementsByClassName('middleLine')[0].remove()
                        document.getElementById('removePhoto').remove()

                        if (document.getElementsByClassName('profPict')[0]) {
                            let profPict = document.getElementsByClassName('profPict')
                            for (let i = 0; i < profPict.length; i++) {
                                profPict[i].getElementsByTagName('img')[0].remove()

                                let noProfPict = document.createElement('div')
                                noProfPict.innerHTML = '<svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg"> <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="72" height="72"> <rect width="72" height="72" rx="36" fill="white"></rect> </mask> <g mask="url(#mask0)"> <rect width="72" height="72" rx="36" fill="white"></rect> <path opacity="0.15" fill-rule="evenodd" clip-rule="evenodd" d="M48 36C48 29.3726 42.6274 24 36 24C29.3726 24 24 29.3726 24 36C24 42.6274 29.3726 48 36 48C42.6274 48 48 42.6274 48 36ZM60 63C60 54.99 44.01 51 36 51C27.99 51 12 54.99 12 63V72H60V63Z" fill="#172B4D"></path> </g></svg>'

                                profPict[i].appendChild(noProfPict.getElementsByTagName('svg')[0])
                                noProfPict.remove()

                            }
                        }

                    } else {
                        toastify(response.message)
                        return response.message
                    }
                },
                error: function (errorMessage) {
                    Sentry.captureException(new RemoveUserImageError(errorMessage + ' url: ' + location.href));
                }
            });
        })
    }
}


//TODO
window.favoriteAndUnFavoriteTalk = function () {
    if (document.getElementsByClassName('favoriteHeart')[0]) {

        if (document.getElementsByClassName('favoriteHeart')[0].getElementsByTagName('svg')[0]) {

            let favoriteTalkButtons = document.getElementsByClassName('favoriteHeart')

            for (let i = 0; i < favoriteTalkButtons.length; i++) {

                if (typeof favoriteTalkButtons[i].dataset.eventAdded === 'undefined') {

                    favoriteTalkButtons[i].dataset.eventAdded = "1"

                    favoriteTalkButtons[i].getElementsByTagName('svg')[0].addEventListener('click', function (e) {
                        e.preventDefault()

                        let that = this
                        let index = i


                        if (that.parentElement.dataset.fallowing === '0') {
                            fallowTalk(that.parentElement.dataset.id, index)
                            that.parentElement.dataset.fallowing = '1'
                            if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {

                                let thxer = document.body.className === 'talkCategorySubcategory' ?
                                    document.getElementsByClassName('innerResultsSearch')[0].getElementsByClassName('pBottomItemsSearch') :
                                    document.getElementsByClassName('thxer')[0].getElementsByClassName('pBottomItemsSearch')
                                for (let i = 0; i < thxer.length; i++) {
                                    if (thxer[i].dataset.talkId === document.getElementsByClassName('dataTalkId')[index].dataset.talkId) {

                                        document.body.className === 'talkCategorySubcategory' ?
                                            thxer[i].getElementsByClassName('favoriteHeart2')[0].dataset.fallowing = '1' :
                                            thxer[i].getElementsByClassName('favoriteHeart2')[0].dataset.fallowing = '1'
                                    }

                                }

                            }
                        } else {

                            unfallowTalk(that.parentElement.dataset.id, index)

                            that.parentElement.dataset.fallowing = '0'
                            if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {


                                let thxer = document.body.className === 'talkCategorySubcategory' ?
                                    document.getElementsByClassName('innerResultsSearch')[0].getElementsByClassName('pBottomItemsSearch') :
                                    document.getElementsByClassName('thxer')[0].getElementsByClassName('pBottomItemsSearch')


                                for (let i = 0; i < thxer.length; i++) {
                                    if (thxer[i].dataset.talkId === document.getElementsByClassName('dataTalkId')[index].dataset.talkId) {

                                        document.body.className === 'talkCategorySubcategory' ?
                                            thxer[i].getElementsByClassName('favoriteHeart2')[0].dataset.fallowing = '0' :
                                            thxer[i].getElementsByClassName('favoriteHeart2')[0].dataset.fallowing = '0'
                                    }

                                }

                            }
                        }

                    })
                }
            }

            function fallowTalk(id, index) {

                jQuery.ajax({
                    type: 'POST',
                    headers: {
                        "Accept": 'application/json',

                    },
                    url: '/frontend/api/user-bookmarked-talks',
                    data: {
                        'talks_id': id,
                        '_token': token
                    },
                    beforeSend: function () {
                        // Handle the beforeSend event

                        showLoading()
                    },
                    complete: function () {
                        hideLoading()
                    },
                    success: function (response) {

                        if (response.success) {

                            let svgHeart = document.getElementsByClassName('favoriteHeart')[index].getElementsByTagName('svg')[0]

                            svgHeart.parentElement.style.transform = 'scale(0)'

                            setTimeout(function () {
                                svgHeart.innerHTML = '<path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>'
                                svgHeart.setAttribute('width', '1em')
                                svgHeart.setAttribute('height', '1em')
                                svgHeart.setAttribute('viewBox', '0 0 16 16')
                                svgHeart.setAttribute('fill', '#172b4d')
                                svgHeart.setAttribute('class', 'bi bi-heart-fill')
                                svgHeart.parentElement.style.transform = 'scale(1)'
                            }, 310)

                            if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {
                                let svgHeart = document.getElementsByClassName('favoriteHeart2')[index].getElementsByTagName('svg')[0]

                                svgHeart.parentElement.style.transform = 'scale(0)'

                                setTimeout(function () {
                                    svgHeart.innerHTML = '<path d="M7 1.5L10.5 4L11.5 3.5L12.5 2.5L14 1.5H17.5C18.3 1.5 19.1667 2.83333 19.5 3.5C19.8333 4.66667 20.5 7.1 20.5 7.5C20.5 7.9 18.1667 10.6667 17 12C15 13.8333 10.9 17.6 10.5 18C10.1 18.4 6 13.8333 4 11.5L1.5 9L1 6.5L2 3.5L4.5 1.5H7Z" fill="#DF1818" stroke="black"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#DF1818"></path>'
                                    svgHeart.setAttribute('width', '22')
                                    svgHeart.setAttribute('height', '20')
                                    svgHeart.setAttribute('viewBox', '0 0 22 20')
                                    svgHeart.setAttribute('fill', 'none')
                                    svgHeart.parentElement.style.transform = 'scale(1)'
                                }, 310)

                            }
                        } else {
                            toastify(response.message)
                        }
                    },
                    error: function (errorMessage) {
                        Sentry.captureException(new FallowTalkError(errorMessage + ' url: ' + location.href));
                    }
                });
            }

            function unfallowTalk(id, index) {

                let token = document.querySelector('meta[name="csrf-token"]').content
                jQuery.ajax({
                    type: 'POST',
                    headers: {
                        "Accept": 'application/json',
                    },
                    url: '/frontend/api/unfollow-single-talk',
                    data: {
                        'talks_id': id,
                        '_token': token
                    },
                    beforeSend: function () {
                        // Handle the beforeSend event

                        showLoading()
                    },
                    complete: function () {
                        hideLoading()
                    },
                    success: function (response) {

                        if (response.success) {

                            let svgHeart = document.getElementsByClassName('favoriteHeart')[index].getElementsByTagName('svg')[0]

                            svgHeart.parentElement.style.transform = 'scale(0)'

                            setTimeout(function () {
                                svgHeart.innerHTML = '<path fill-rule="evenodd" clip-rule="evenodd" d="M4.5815 1.51975C2.89268 1.51975 1.54 2.85165 1.54 4.47482C1.54 5.2654 1.85865 5.98355 2.38198 6.51577L7.69992 11.8357L12.9293 6.6024L12.9375 6.59465C13.5086 6.05567 13.86 5.30499 13.86 4.47482C13.86 2.85165 12.5073 1.51975 10.8185 1.51975C10.5562 1.51975 10.2576 1.62255 9.92037 1.84897C9.58404 2.07485 9.25417 2.39398 8.94586 2.7497C8.29467 3.50092 7.10533 3.50092 6.45414 2.7497C6.14582 2.39398 5.816 2.07485 5.4796 1.84897C5.14241 1.62255 4.84378 1.51975 4.5815 1.51975ZM0 4.47482C0 1.99457 2.06025 0 4.5815 0C5.25577 0 5.85426 0.262354 6.34595 0.592489C6.83837 0.923164 7.26919 1.35198 7.62446 1.76183C7.64009 1.77993 7.66496 1.79336 7.7 1.79336C7.73503 1.79336 7.75991 1.77993 7.77554 1.76183C8.13081 1.35198 8.56163 0.923164 9.05404 0.592489C9.54577 0.262354 10.1442 0 10.8185 0C13.3397 0 15.4 1.99457 15.4 4.47482C15.4 5.73546 14.8654 6.87375 14.0104 7.68491L7.70008 14L1.27956 7.57701C0.488881 6.77428 0 5.68021 0 4.47482Z" fill="#172B4D"></path>'
                                svgHeart.setAttribute('width', '16')
                                svgHeart.setAttribute('height', '14')
                                svgHeart.setAttribute('viewBox', '0 0 16 16')
                                svgHeart.setAttribute('fill', 'none')
                                svgHeart.setAttribute('class', '')
                                svgHeart.parentElement.style.transform = 'scale(1)'
                            }, 310)

                            if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {
                                let svgHeart = document.getElementsByClassName('favoriteHeart2')[index].getElementsByTagName('svg')[0]

                                svgHeart.parentElement.style.transform = 'scale(0)'

                                setTimeout(function () {
                                    svgHeart.innerHTML = '<path d="M7 1.5L10.5 4L11.5 3.5L12.5 2.5L14 1.5H17.5C18.3 1.5 19.1667 2.83333 19.5 3.5C19.8333 4.66667 20.5 7.1 20.5 7.5C20.5 7.9 18.1667 10.6667 17 12C15 13.8333 10.9 17.6 10.5 18C10.1 18.4 6 13.8333 4 11.5L1.5 9L1 6.5L2 3.5L4.5 1.5H7Z" fill="#F4F9FF" stroke="black"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#172B4D"/>'
                                    svgHeart.setAttribute('width', '22')
                                    svgHeart.setAttribute('height', '20')
                                    svgHeart.setAttribute('viewBox', '0 0 22 20')
                                    svgHeart.setAttribute('fill', 'none')
                                    svgHeart.setAttribute('class', '')
                                    svgHeart.parentElement.style.transform = 'scale(1)'
                                }, 310)


                            }
                        } else {
                            toastify(response.message)
                        }
                    },
                    error: function (errorMessage) {
                        Sentry.captureException(new UnfallowTalkError(errorMessage + ' url: ' + location.href));
                    }
                });
            }

        }
        if (document.getElementsByClassName('favoriteHeart2')[0]) {
            if (document.getElementsByClassName('favoriteHeart2')[0].getElementsByTagName('svg')[0]) {

                let favoriteTalkButtons2 = document.getElementsByClassName('favoriteHeart2')

                for (let i = 0; i < favoriteTalkButtons2.length; i++) {

                    if (typeof favoriteTalkButtons2[i].dataset.eventAdded === 'undefined') {

                        favoriteTalkButtons2[i].dataset.eventAdded = "1"

                        favoriteTalkButtons2[i].getElementsByTagName('svg')[0].addEventListener('click', function (e) {
                            e.preventDefault()

                            let that = this
                            let index = i
                            jQuery.ajax({
                                type: 'GET',
                                url: '/my-tokens',
                                success: function (res) {
                                    if (res.length > 0) {


                                        if (that.parentElement.dataset.fallowing === '0') {
                                            fallowTalk2(res, document.getElementsByClassName('dataTalkId')[index].dataset.talkId, index)
                                            that.parentElement.dataset.fallowing = '1'

                                            if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {

                                                let thxer = document.body.className === 'talkCategorySubcategory' ?
                                                    document.getElementsByClassName('searcTalksContainer')[0].getElementsByClassName('course-item') :
                                                    document.getElementsByClassName('favorites_holder')[0].getElementsByClassName('course-item')

                                                for (let i = 0; i < thxer.length; i++) {


                                                    if (thxer[i].getElementsByTagName('a')[0].dataset.talkId === document.getElementsByClassName('dataTalkId')[index].dataset.talkId) {

                                                        document.body.className === 'talkCategorySubcategory' ?
                                                            thxer[i].getElementsByClassName('favoriteHeart')[0].dataset.fallowing = '1' :
                                                            thxer[i].getElementsByClassName('favoriteHeart')[0].dataset.fallowing = '1'
                                                    }

                                                }

                                            }

                                        } else {

                                            unfallowTalk2(res, document.getElementsByClassName('dataTalkId')[index].dataset.talkId, index)
                                            that.parentElement.dataset.fallowing = '0'


                                            if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {

                                                let thxer = document.body.className === 'talkCategorySubcategory' ?
                                                    document.getElementsByClassName('searcTalksContainer')[0].getElementsByClassName('course-item') :
                                                    document.getElementsByClassName('favorites_holder')[0].getElementsByClassName('course-item')
                                                for (let i = 0; i < thxer.length; i++) {
                                                    if (thxer[i].getElementsByTagName('a')[0].dataset.talkId === document.getElementsByClassName('dataTalkId')[index].dataset.talkId) {

                                                        document.body.className === 'talkCategorySubcategory' ?
                                                            thxer[i].getElementsByClassName('favoriteHeart')[0].dataset.fallowing = '0' :
                                                            thxer[i].getElementsByClassName('favoriteHeart')[0].dataset.fallowing = '0'
                                                    }

                                                }

                                            }

                                        }


                                    }
                                },
                                error: function (errorMessage) {
                                    Sentry.captureException(new GetTokenForFallowUnfallowError(errorMessage + ' url: ' + location.href));
                                }
                            });
                        })
                    }
                }


                function fallowTalk2(res, id, index) {

                    jQuery.ajax({
                        type: 'POST',
                        headers: {
                            "Accept": 'application/json',
                            "Authorization": res,
                        },
                        url: envAppBackendUrl + '/user-bookmarked-talks',
                        data: {
                            'talks_id': id
                        },
                        beforeSend: function () {
                            // Handle the beforeSend event

                            showLoading()
                        },
                        complete: function () {
                            hideLoading()
                        },
                        success: function (response) {

                            if (response.success) {

                                let svgHeart = document.getElementsByClassName('favoriteHeart2')[index].getElementsByTagName('svg')[0]

                                /*       let svgHeart =  document.body.className === 'talkCategorySubcategory' ?
                                      document.getElementsByClassName('searcTalksContainer')[0].getElementsByClassName('course-item')
                                      :
                                      document.getElementsByClassName('favorites_holder')[0].getElementsByClassName('course-item') */
                                svgHeart.parentElement.style.transform = 'scale(0)'

                                setTimeout(function () {
                                    svgHeart.innerHTML = '<path d="M7 1.5L10.5 4L11.5 3.5L12.5 2.5L14 1.5H17.5C18.3 1.5 19.1667 2.83333 19.5 3.5C19.8333 4.66667 20.5 7.1 20.5 7.5C20.5 7.9 18.1667 10.6667 17 12C15 13.8333 10.9 17.6 10.5 18C10.1 18.4 6 13.8333 4 11.5L1.5 9L1 6.5L2 3.5L4.5 1.5H7Z" fill="#DF1818" stroke="black"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#DF1818"></path>'
                                    svgHeart.setAttribute('width', '22')
                                    svgHeart.setAttribute('height', '20')
                                    svgHeart.setAttribute('viewBox', '0 0 22 20')
                                    svgHeart.setAttribute('fill', 'none')
                                    svgHeart.parentElement.style.transform = 'scale(1)'
                                }, 310)


                                if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {
                                    let svgHeart = document.getElementsByClassName('favoriteHeart')[index].getElementsByTagName('svg')[0]

                                    svgHeart.parentElement.style.transform = 'scale(0)'

                                    setTimeout(function () {
                                        svgHeart.innerHTML = '<path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"></path>'
                                        svgHeart.setAttribute('width', '22')
                                        svgHeart.setAttribute('height', '20')
                                        svgHeart.setAttribute('viewBox', '0 0 22 20')
                                        svgHeart.setAttribute('fill', '#172B4D')
                                        svgHeart.parentElement.style.transform = 'scale(1)'
                                    }, 310)

                                }

                            } else {
                                toastify(response.message)
                            }
                        },
                        error: function (errorMessage) {
                            Sentry.captureException(new FallowTalkError(errorMessage + ' url: ' + location.href));
                        }
                    });
                }

                function unfallowTalk2(res, id, index) {
                    jQuery.ajax({
                        type: 'POST',
                        headers: {
                            "Accept": 'application/json',
                            "Authorization": res,
                        },
                        url: envAppBackendUrl + '/unfollow-single-talk',
                        data: {
                            'talks_id': id
                        },
                        beforeSend: function () {
                            // Handle the beforeSend event

                            showLoading()
                        },
                        complete: function () {
                            hideLoading()
                        },
                        success: function (response) {

                            if (response.success) {

                                let svgHeart = document.getElementsByClassName('favoriteHeart2')[index].getElementsByTagName('svg')[0]

                                svgHeart.parentElement.style.transform = 'scale(0)'

                                setTimeout(function () {
                                    svgHeart.innerHTML = '<path d="M7 1.5L10.5 4L11.5 3.5L12.5 2.5L14 1.5H17.5C18.3 1.5 19.1667 2.83333 19.5 3.5C19.8333 4.66667 20.5 7.1 20.5 7.5C20.5 7.9 18.1667 10.6667 17 12C15 13.8333 10.9 17.6 10.5 18C10.1 18.4 6 13.8333 4 11.5L1.5 9L1 6.5L2 3.5L4.5 1.5H7Z" fill="#F4F9FF" stroke="black"/><path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#172B4D"/>'
                                    svgHeart.setAttribute('width', '22')
                                    svgHeart.setAttribute('height', '20')
                                    svgHeart.setAttribute('viewBox', '0 0 22 20')
                                    svgHeart.setAttribute('fill', 'none')
                                    svgHeart.setAttribute('class', '')
                                    svgHeart.parentElement.style.transform = 'scale(1)'
                                }, 310)

                                if (document.body.className === 'favorites_talks' || document.body.className === 'talkCategorySubcategory') {
                                    let svgHeart = document.getElementsByClassName('favoriteHeart')[index].getElementsByTagName('svg')[0]

                                    svgHeart.parentElement.style.transform = 'scale(0)'

                                    setTimeout(function () {
                                        svgHeart.innerHTML = '<path fill-rule="evenodd" clip-rule="evenodd" d="M4.5815 1.51975C2.89268 1.51975 1.54 2.85165 1.54 4.47482C1.54 5.2654 1.85865 5.98355 2.38198 6.51577L7.69992 11.8357L12.9293 6.6024L12.9375 6.59465C13.5086 6.05567 13.86 5.30499 13.86 4.47482C13.86 2.85165 12.5073 1.51975 10.8185 1.51975C10.5562 1.51975 10.2576 1.62255 9.92037 1.84897C9.58404 2.07485 9.25417 2.39398 8.94586 2.7497C8.29467 3.50092 7.10533 3.50092 6.45414 2.7497C6.14582 2.39398 5.816 2.07485 5.4796 1.84897C5.14241 1.62255 4.84378 1.51975 4.5815 1.51975ZM0 4.47482C0 1.99457 2.06025 0 4.5815 0C5.25577 0 5.85426 0.262354 6.34595 0.592489C6.83837 0.923164 7.26919 1.35198 7.62446 1.76183C7.64009 1.77993 7.66496 1.79336 7.7 1.79336C7.73503 1.79336 7.75991 1.77993 7.77554 1.76183C8.13081 1.35198 8.56163 0.923164 9.05404 0.592489C9.54577 0.262354 10.1442 0 10.8185 0C13.3397 0 15.4 1.99457 15.4 4.47482C15.4 5.73546 14.8654 6.87375 14.0104 7.68491L7.70008 14L1.27956 7.57701C0.488881 6.77428 0 5.68021 0 4.47482Z" fill="#172B4D"></path>'
                                        svgHeart.setAttribute('width', '22')
                                        svgHeart.setAttribute('height', '20')
                                        svgHeart.setAttribute('viewBox', '0 0 22 20')
                                        svgHeart.setAttribute('fill', 'none')
                                        svgHeart.setAttribute('class', '')
                                        svgHeart.parentElement.style.transform = 'scale(1)'
                                    }, 310)


                                }
                            } else {
                                toastify(response.message)
                            }
                        },
                        error: function (errorMessage) {
                            Sentry.captureException(new UnfallowTalkError(errorMessage + ' url: ' + location.href));
                        }
                    });
                }

            }
        }

    }
}


window.getLanguageId = function () {

    switch (appLanguage) {
        case 'en':
            return 38;

        case 'hr':
            return 60;

        case 'de':
            return 33;

        case 'pl':
            return 127;

    }
}

window.getCategoryLanguageId = function () {

    switch (appLanguage) {
        case 'en':
            return 3;

        case 'hr':
            return 2;

        case 'de':
            return 1;

        case 'pl':
            return 17;

    }
}

window.clearGroupForm = function (form) {
    let ele = form.elements

    //clear category
    let optionsParticipantsG = ele['participantsG'].options

    for (let i = 0; i < optionsParticipantsG.length; i++) {
        if(optionsParticipantsG[i].value === '5'){
            ele['participantsG'].selectedIndex = i
        }

    }

    ele['participantsG'].classList.add('ok')


    //clear talk name

    ele['nameG'].value = ''
    ele['nameG'].classList.remove('ok')
    ele['nameG'].classList.remove('error')
    ele['nameG'].parentElement.getElementsByClassName('default-warn')[0].classList.remove('active')
    ele['nameG'].parentElement.getElementsByClassName('verified-svg')[0].style.right = '-55px'
    ele['nameG'].parentElement.getElementsByClassName('input-label')[0].style.color = ''
    ele['nameG'].parentElement.getElementsByClassName('clear-button')[0].style.right = '-55px'

    //clear category

    ele['categoryG'].selectedIndex = -1
    ele['categoryG'].classList.remove('ok')
    ele['categoryG'].classList.remove('error')
    ele['categoryG'].parentElement.getElementsByClassName('default-warn')[0].classList.remove('active')
    ele['categoryG'].parentElement.getElementsByClassName('verified-svg')[0].style.right = '-55px'
    ele['categoryG'].parentElement.getElementsByClassName('input-label')[0].style.color = ''
    ele['categoryG'].parentElement.getElementsByClassName('clear-button')[0].style.right = '-55px'


    //clear subCategory
    ele['subCategoryG'].parentElement.parentElement.classList.add('dn')
    ele['subCategoryG'].selectedIndex = -1
    ele['subCategoryG'].classList.remove('ok')
    ele['subCategoryG'].classList.remove('error')
    ele['subCategoryG'].parentElement.getElementsByClassName('default-warn')[0].classList.remove('active')
    ele['subCategoryG'].parentElement.getElementsByClassName('verified-svg')[0].style.right = '-55px'
    ele['subCategoryG'].parentElement.getElementsByClassName('input-label')[0].style.color = ''
    ele['subCategoryG'].parentElement.getElementsByClassName('clear-button')[0].style.right = '-55px'

    //reset description

    ele['descriptionG'].value = ''
    ele['descriptionG'].classList.remove('ok')
    ele['descriptionG'].classList.remove('error')
    ele['descriptionG'].parentElement.getElementsByClassName('default-warn')[0].classList.remove('active')
    ele['descriptionG'].parentElement.getElementsByClassName('verified-svg')[0].style.right = '-55px'
    ele['descriptionG'].parentElement.getElementsByClassName('input-label')[0].style.color = ''
    ele['descriptionG'].parentElement.getElementsByClassName('clear-button')[0].style.right = '-55px'


    //reset language


    //reset price
    ele['priceG'].value = ''
    ele['priceG'].classList.remove('ok')
    ele['priceG'].classList.remove('error')
    ele['priceG'].parentElement.getElementsByClassName('default-warn')[0].classList.remove('active')
    ele['priceG'].parentElement.getElementsByClassName('verified-svg')[0].style.right = '-55px'
    ele['priceG'].parentElement.getElementsByClassName('input-label')[0].style.color = ''
    ele['priceG'].parentElement.getElementsByClassName('clear-button')[0].style.right = '-55px'

    //reset anon and video/audio switches
    ele['allowVideoTalkG'].checked = true
    ele['allowAnonimousTalkG'].checked = false

    //reset days
    if (form.getElementsByClassName('date-scheduler-wrap')[0].getElementsByClassName('active')[0]) {
        form.getElementsByClassName('date-scheduler-wrap')[0].getElementsByClassName('active')[0].classList.remove('active')
        form.getElementsByClassName('date-scheduler-wrap')[0].getElementsByTagName('div')[0].classList.add('active')
    }

    //reset time selectors
    setDrums(form, '10', '00', '11', '00')

    //reset talk interaction type
    document.getElementById('talkInteractionTypeG').selectedIndex = -1

    //reset add to group talk button
    document.getElementById('groupSubmit').parentElement.parentElement.classList.add('dn')
}


window.clearForm = function (form) {
    let ele = form.elements
    if (form.getElementsByClassName('deleteTalkButtoner')[0]) {
        form.getElementsByClassName('deleteTalkButtoner')[0].classList.add('dn')
    }
    for (let i = 0; i < ele.length; i++) {

        ele[i].value = ''


        if (ele[i].id != "languageP") {
            ele[i].classList.remove('ok')
        }

        ele[i].classList.remove('error')

        if (ele[i].id === "exampleSwitch8" || ele[i].id === "exampleSwitch4") {
            ele[i].checked = true
        } else {
            ele[i].checked = false
        }

    }

    let defaultWarn = form.getElementsByClassName('default-warn')
    for (let i = 0; i < defaultWarn.length; i++) {
        defaultWarn[i].classList.remove('active')
    }

    let inputLabel = form.getElementsByClassName('input-label')
    for (let i = 0; i < inputLabel.length; i++) {
        inputLabel[i].style.color = ''
    }

    form.getElementsByTagName('textarea')[0].style.height = '120px'

    if (document.body.className === "logged_in") {

        if (form.id === "private-talk-form") {
            if (document.body.className !== "logged_in") {
                document.getElementById('privateSubmit').textContent = getPoTranslate('ADD_PRIVATE_TALK')
                document.getElementsByClassName('mainTitlePrivate')[0].textContent = getPoTranslate('ADD_PRIVATE_TALK')
            }

            document.getElementById('mobilePrivateTalkTitle').textContent = getPoTranslate('ADD_PRIVATE_TALK')
            document.getElementById('addPrivateTalk').getElementsByClassName('pageTitlePoperAva')[0].textContent = getPoTranslate('ADD_PRIVATE_TALK')
            document.getElementById('addPrivateTalk').getElementsByClassName('saveButtonPrivateTalk')[0].textContent = getPoTranslate('ADD_PRIVATE_TALK')




        }

    }



    if (form.id === 'private-talk-form') {
        selectOptionByValue(document.getElementById('durationP'), "45")
        selectOptionByValue(document.getElementById('languageP'), "33")

        document.getElementById('talkInputP').parentElement.style.height = '84px'
        document.getElementById('talkInputP').parentElement.style.marginTop = '8px'
        //document.getElementById('talkInputP').classList.add('ok')
        document.getElementById('talkInputP').style.background = 'white'
        document.getElementById('talkInputP').parentElement.getElementsByClassName('count-label')[0].style.color = 'white'
        document.getElementById('talkInputP').parentElement.getElementsByClassName('clear-button')[0].style.opacity = 0
        document.getElementById('talkInputP').parentElement.getElementsByClassName('verified-svg')[0].style.opacity = 0
        document.getElementById('private-talk-form').getElementsByTagName('textarea')[0].style.height = '120px'

        document.getElementById('talkInputP').focus()


    }

}




window.selectOptionByValue = function (selectOptionElement, valueForSelect) {
    if (document.body.className !== "profile" && document.body.className !== "settings_reviews") {
        for (var i = 0; i < selectOptionElement.options.length; i++) {
            if (selectOptionElement.options[i].value == valueForSelect) {
                selectOptionElement.selectedIndex = i;
                selectOptionElement.classList.add('ok')
                break;
            }
        }
    }
}

window.showTimePupup = function () {

    document.getElementById('submit-btn').textContent = getPoTranslate('ADD_TIME_SLOT')
    if (document.getElementById('time-slot-popup').getElementsByClassName('add-time-title')[0]) {
        document.getElementById('time-slot-popup').getElementsByClassName('add-time-title')[0].textContent = getPoTranslate('ADD_TIME_SLOT')

    }

    document.getElementById('submit-btn').dataset.timeSlotId = ''
    document.getElementsByClassName('endTime')[0].style.border = '1px solid transparent'
    openPopup('time-slot-popup')
}

//TODO
window.allClickableTimeSlot = function (addtionalElementsToAddEvent) {


    let allTableFieldsa, array1a, array2a, array3a

    if (document.body.className === "logged_in") {

        if (document.getElementById('changeAvailability').getElementsByClassName('date-time')[0]) {

            allTableFieldsa = document.getElementById('changeAvailability').getElementsByClassName('date-time')
        }

    }


}

window.closeFilter = function () {
    if (document.getElementById('bgFilter')) {

        setTimeout(function () {
            document.getElementById('bgFilter').style.left = '-1250px'
        }, 0)
        setTimeout(function () {
            document.getElementById('filterTalks').style.left = '-1250px'

            document.getElementsByClassName('submitFilterParent')[0].style.bottom = '-200px'
        }, 240)
        setTimeout(function () {
            document.getElementById('filterTalks').classList.remove('filterOpens')
            document.getElementsByClassName('pointerForFilter')[0].parentElement.parentElement.insertBefore(document.getElementById('filterTalks'), document.getElementsByClassName('pointerForFilter')[0].parentElement)
            document.getElementById('bgFilter').parentNode.removeChild(document.getElementById('bgFilter'))
        }, 610)

        document.getElementsByClassName('fButtonCont')[0].dataset.opened = "0"
        document.getElementsByClassName('fButtonCont')[0].getElementsByTagName('p')[0].textContent = getPoTranslate('FILTER')
        document.getElementsByClassName('svgFilterDiv')[0].getElementsByTagName('svg')[0].style.left = '12px'
        document.getElementsByClassName('svgFilterDiv')[0].getElementsByTagName('svg')[1].style.left = '-100px'
    }

    window.filterOpened = 0

}



class GetBookingError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetBookingError"
    }
}

class GetTokenForFallowUnfallowError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenForFallowUnfallowError"
    }
}

class FallowTalkError extends Error {
    constructor(message) {
        super(message)
        this.name = "FallowTalkError"
    }
}

class UnfallowTalkError extends Error {
    constructor(message) {
        super(message)
        this.name = "UnfallowTalkError"
    }
}

class GetTokenForCancelationReasonsError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenForCancelationReasonsError"
    }
}

class CallCancelationReasonsError extends Error {
    constructor(message) {
        super(message)
        this.name = "CallCancelationReasonsError"
    }
}

class GetTokenForRemoveProfilePhotoError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenForRemoveProfilePhotoError"
    }
}

class RemoveUserImageError extends Error {
    constructor(message) {
        super(message)
        this.name = "RemoveUserImageError"
    }
}
