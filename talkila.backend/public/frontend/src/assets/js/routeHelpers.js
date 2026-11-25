import $ from 'jquery';

window.jQuery = $;


export function calendarLogics() {

    //select default calendar
    if (document.getElementsByClassName('defaultCalendarSelection')[0]) {

        let defaultCalendarSelection = document.getElementsByClassName('defaultCalendarSelection')
        for (let i = 0; i < defaultCalendarSelection.length; i++) {
            defaultCalendarSelection[i].addEventListener('click', function (e) {
                if (document.body.className !== 'book_slot') {
                    let that = e.currentTarget

                    showLoading()
                    let calendar_id = that.dataset.calendarId

                    let xhr = new XMLHttpRequest()

                    xhr.onloadstart = function () {
                        showLoading()
                    }

                    xhr.onreadystatechange = function () {

                        if (this.readyState == 4 && this.status == 200) {
                            let response = JSON.parse(this.response);

                            if (response.success === true) {

                                if (that.parentElement.parentElement.parentElement.getElementsByClassName('active')[0]) {
                                    that.parentElement.parentElement.parentElement.getElementsByClassName('active')[0].parentElement.getElementsByClassName('buttoneroKalendar')[0].classList.remove('dn')
                                    that.parentElement.parentElement.parentElement.getElementsByClassName('active')[0].classList.remove('active')

                                }

                                if (that.parentElement.parentElement.parentElement.getElementsByClassName('pon')[0]) {
                                    that.parentElement.parentElement.parentElement.getElementsByClassName('pon')[0].classList.remove('pon')
                                }

                                that.classList.add('active')
                                that.classList.add('pon')


                                that.parentElement.getElementsByClassName('garbage_can')[0].classList.add('dn')

                                //buttoneroKale

                            } else if (response.success === false) {
                                toastify(response.message)
                            }
                            if (document.getElementById('feedbackPopUp')) {
                                closePopup('feedbackPopUp')
                            }

                            hideLoading()
                        }
                    }

                    xhr.onloadend = function () {
                        hideLoading()

                    }

                    xhr.onerror = function (error) {
                        hideLoading()
                        toastify(this.statusText)
                        Sentry.captureException(new SubmitFeedbackSubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
                    }

                    xhr.open('POST', envAppBackendUrl + '/set-primary-calendar/' + calendar_id, true)

                    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
                    xhr.setRequestHeader('Authorization', bearerToken);
                    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

                    xhr.send()
                } else {

                    e.currentTarget.parentElement.getElementsByClassName('buttoneroKale')[0].click()
                }


            })

        }
    }

    if (document.getElementsByClassName('gear')) {

        let gears = document.getElementsByClassName('gear')
        for (let i = 0; i < gears.length; i++) {
            gears[i].addEventListener('click', function () {

                if (gears[i].dataset.opened === '1') {
                    gears[i].getElementsByTagName('svg')[0].style.rotate = '0deg'
                    gears[i].parentElement.parentElement.getElementsByClassName('tranzicioniHeight')[0].style.maxHeight = '0px'
                    gears[i].dataset.opened = '0'
                    /*       setTimeout(function(){
                              calculatePopUpHeight(document.getElementById('calendarNavigation'),52)
                          },310) */

                } else if (gears[i].dataset.opened === '0') {
                    gears[i].getElementsByTagName('svg')[0].style.rotate = '45deg'
                    gears[i].parentElement.parentElement.getElementsByClassName('tranzicioniHeight')[0].style.maxHeight = '500px'
                    gears[i].dataset.opened = '1'
                    /*      setTimeout(function(){
                             calculatePopUpHeight(document.getElementById('calendarNavigation'),52)
                         },310) */

                }


            })

        }

    }

    if (document.getElementById('connected_calendars')) {
        document.getElementById('connected_calendars').addEventListener('click', function () {
            if (document.getElementsByClassName('buttoneroKale')[0]) {
                let buttoneroKale = document.getElementsByClassName('buttoneroKale')
                for (let i = 0; i < buttoneroKale.length; i++) {
                    if (buttoneroKale[i].dataset.opened === '1') {
                        buttoneroKale[i].click()
                    }

                }
            }
        })
    }

    if (document.getElementsByClassName('swp1')[0]) {
        let calendarStatesSwitch = document.getElementsByClassName('swp1'),
            state
        for (let i = 0; i < calendarStatesSwitch.length; i++) {
            calendarStatesSwitch[i].addEventListener('click', function () {
                if (this.dataset.clicked === '0' || this.dataset.clicked === ' 0 ') {
                    let that = this



                    if (this.dataset.pointer === 'cli') {

                        setTimeout(function () {

                            state = getStateForCalendar(
                                that.parentElement.parentElement.parentElement.getElementsByClassName('clientCaleInputState')[0],
                                that.parentElement.parentElement.parentElement.getElementsByClassName('supplierCaleInputState')[0]
                            )
                        })

                    } else if (this.dataset.pointer === 'sup') {

                        setTimeout(function () {



                            state = getStateForCalendar(
                                that.parentElement.parentElement.parentElement.getElementsByClassName('clientCaleInputState')[0],
                                that.parentElement.parentElement.parentElement.getElementsByClassName('supplierCaleInputState')[0]
                            )
                        })

                    }

                    this.dataset.clicked = '1'


                    setTimeout(function () {

                        submitCalendarState(state, that.dataset.calendarId /* calendar_id */)
                    })

                } else if (this.dataset.clicked === '1' || this.dataset.clicked === ' 1 ') {
                    let that = this

                    if (this.dataset.pointer === 'cli') {

                        setTimeout(function () {
                            state = getStateForCalendar(
                                that.parentElement.parentElement.parentElement.getElementsByClassName('clientCaleInputState')[0],
                                that.parentElement.parentElement.parentElement.getElementsByClassName('supplierCaleInputState')[0]
                            )
                        })




                    } else if (this.dataset.pointer === 'sup') {

                        setTimeout(function () {
                            state = getStateForCalendar(
                                that.parentElement.parentElement.parentElement.getElementsByClassName('clientCaleInputState')[0],
                                that.parentElement.parentElement.parentElement.getElementsByClassName('supplierCaleInputState')[0]
                            )
                        })

                    }

                    this.dataset.clicked = '0'


                    setTimeout(function () {

                        submitCalendarState(state, that.dataset.calendarId, that.parentElement.parentElement.parentElement.parentElement.getElementsByClassName('gear')[0])
                    })
                }
            })
        }
    }

    function submitCalendarState(state, calendar_id, calendar_to_close = false) {

        showLoading()

        let xhr = new XMLHttpRequest()

        let url = envAppBackendUrl + '/calendar-account-state'

        let params = {
            state,
            calendar_id,
            _token: token
        }

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.response)

                if (response.success === true) {
                    toastify(response.message)

                    if (document.body.className === 'book_slot') {
                        if (state === 0) {
                            if (calendar_to_close) {

                                calendar_to_close.click()
                            }

                        }

                    }

                } else if (response.success === false) {
                    toastify(response.message)
                }
                if (document.body.className !== 'book_slot') {
                    hideLoading()
                }


            }
        }

        xhr.onerror = function (error) {
            hideLoading()
            toastify(this.statusText)
            Sentry.captureException(
                new SubmitCalendarStateError(
                    error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href
                )
            )
        }

        xhr.open('POST', url, true)
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.setRequestHeader('Authorization', bearerToken)
        xhr.send(JSON.stringify(params))

        class SubmitCalendarStateError extends Error {
            constructor(message) {
                super(message)
                this.name = 'SubmitCalendarStateError'
            }
        }
    }

    function getStateForCalendar(clientCaleInputState, supplierCaleInputState) {
        if (document.body.className === '') {

        }
        if (clientCaleInputState.checked === false && (supplierCaleInputState ? supplierCaleInputState.checked : false) === false) {
            return 0
        } else if (clientCaleInputState.checked === true && (supplierCaleInputState ? supplierCaleInputState.checked : false) === false) {
            return 1
        } else if (clientCaleInputState.checked === false && (supplierCaleInputState ? supplierCaleInputState.checked : true) === true) {
            return 2
        } else if (clientCaleInputState.checked === true && (supplierCaleInputState ? supplierCaleInputState.checked : true) === true) {
            return 3
        }
    }

    //turn on whole client calle
    if (
        document.body.className === 'book_slot'
    ) {
        if (document.getElementsByClassName('clientCalendarSwitch')[0]) {
            let clientCalendarSwitch = document.getElementsByClassName('clientCalendarSwitch')

            for (let i = 0; i < clientCalendarSwitch.length; i++) {
                clientCalendarSwitch[i].addEventListener('click', function () {


                    getNewTeacherAvailabilityData()
                })
            }
        }
    }


    //logics for turn off and turn on particular cale

    if (document.getElementsByClassName('caleSwitchesCheckers')[0]) {
        let caleSwitchesCheckers = document.getElementsByClassName('caleSwitchesCheckers')
        for (let i = 0; i < caleSwitchesCheckers.length; i++) {
            caleSwitchesCheckers[i].addEventListener('click', function () {
                if (this.dataset.clicked === '0' || this.dataset.clicked === ' 0 ') {
                    submitSubCallendarChange(1, parseInt(this.dataset.calendarId) /* calendar_id */)
                    this.dataset.clicked = '1'
                } else if (this.dataset.clicked === '1' || this.dataset.clicked === ' 1 ') {

                    submitSubCallendarChange(0, parseInt(this.dataset.calendarId) /* calendar_id */)

                    this.dataset.clicked = '0'
                }
            })
        }
    }

    function submitSubCallendarChange(state, calendar_id) {


        showLoading()

        let xhr = new XMLHttpRequest()

        let url = envAppBackendUrl + '/calendar-state'

        let params = {
            state,
            calendar_id,
            _token: token
        }

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.response)

                if (response.success === true) {

                    if (document.body.className === 'book_slot') {

                        if (document.getElementsByClassName('calendarFunnelHighlightingState')[0]) {
                            let calendarFunnelHighlightingState = document.getElementsByClassName('calendarFunnelHighlightingState')[0]

                            calendarFunnelHighlightingState.addEventListener('click', function () {
                                if (calendarFunnelHighlightingState.dataset.clicked === '1') {

                                    removeHighlightedAvailabilites()

                                    calendarFunnelHighlightingState.dataset.clicked = '0'
                                } else if (calendarFunnelHighlightingState.dataset.clicked === '0') {

                                    if (document.getElementById('calendarFunnelHighlightingState').checked) {
                                        calculateUserAvailabilites()
                                    }
                                    hideLoading()
                                    calendarFunnelHighlightingState.dataset.clicked = '1'
                                }
                            })
                        }

                        getNewTeacherAvailabilityData()

                    } else {

                        toastify(response.message)
                        hideLoading()
                    }

                } else if (response.success === false) {
                    toastify(response.message)
                    hideLoading()
                }

            }

        }

        xhr.onerror = function (error) {
            hideLoading()
            toastify(this.statusText)
            Sentry.captureException(
                new SubmitSubCalendarChangesError(
                    error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href
                )
            )
        }

        xhr.open('POST', url, true)
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.setRequestHeader('Authorization', bearerToken)
        xhr.send(JSON.stringify(params))

        class SubmitSubCalendarChangesError extends Error {
            constructor(message) {
                super(message)
                this.name = 'SubmitSubCalendarChangesError'
            }
        }
    }

    function getNewTeacherAvailabilityData() {

        showLoading()

        let xhr = new XMLHttpRequest()

        let url = envAppBackendUrl + '/supplier-availabilities/' + document.getElementsByClassName('dataTalkId')[0]?.dataset.talkId ?? 0

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.response)

                if (response.success === true) {

                    toastify(response.message)
                    overlapingSlots = {}

                    document.getElementById('newTeacherAvailabilityDatesTime').value = JSON.stringify(response.data)
                    createOverlapingSlotsObject(response.data, document.getElementById('calendar-body').getElementsByClassName('selected')[0].dataset.fullDate)

                    removeHighlightedAvailabilites()
                    if (document.getElementById('calendarFunnelHighlightingState').checked) {
                        calculateUserAvailabilites()
                    }
                    hideLoading()
                } else if (response.success === false) {
                    toastify(response.message)
                    hideLoading()
                }


            }

        }

        xhr.onerror = function (error) {
            hideLoading()
            toastify(this.statusText)
            Sentry.captureException(
                new SubmitCalendarChangeOnBookingFunnel(
                    error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href
                )
            )
        }

        xhr.open('GET', url, true)
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Content-Type', 'application/json')
        xhr.setRequestHeader('Authorization', bearerToken)
        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

        xhr.send()

        class SubmitCalendarChangeOnBookingFunnel extends Error {
            constructor(message) {
                super(message)
                this.name = 'SubmitCalendarChangeOnBookingFunnel'
            }
        }
    }

}

export function acceptFollowRequest(e) {

    e.preventDefault()
    showLoading()
    let target = e.currentTarget
    let xhr = new XMLHttpRequest()
    let url = envAppBackendUrl + '/accept-follow-request/' + target.dataset.userId

    let params = {
        '_token': token
    }

    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.response)

            if (response.success === true) {
                toastify(response.message)

                let parent = target.parentElement.parentElement.parentElement
                parent.style.scale = '0'
                parent.style.opacity = '0'


                setTimeout(function () {

                    if (!document.getElementById('privateFollowersContainer')) {
                        let privateFollowersContainer = document.createElement('div')
                        privateFollowersContainer.id = 'privateFollowersContainer'

                        let privateFollowersContainerHeadline = document.createElement('h5')
                        privateFollowersContainerHeadline.textContent = getPoTranslate('PRIVATE_FOLLOWERS')

                        privateFollowersContainer.append(privateFollowersContainerHeadline)

                        let privateFollowersContainerItems = document.createElement('div')
                        privateFollowersContainerItems.id = 'privateFollowersContainerItems'

                        let privateFollowersContainerDivContainer = createPrivateFollowerContainer(target, parent)

                        privateFollowersContainerItems.append(privateFollowersContainerDivContainer)

                        privateFollowersContainer.append(privateFollowersContainerItems)

                        let privateFollowersHr = document.createElement('hr')
                        privateFollowersHr.className = 'pr24'

                        document.getElementById('fallowingPageMainCont').append(privateFollowersContainer)
                    } else {

                        let privateFollowersContainerDivContainer = createPrivateFollowerContainer(target, parent)

                        document.getElementById('privateFollowersContainerItems').append(privateFollowersContainerDivContainer)


                    }


                }, 310)

            } else if (response.success === false) {
                toastify(response.message)
            }


            hideLoading()
        }
    }

    xhr.onloadend = function () {
        hideLoading()
    }

    xhr.onerror = function (error) {
        hideLoading()
        toastify(this.statusText)
        Sentry.captureException(new SubmitAcceptPrivateFallowing(error + 'status: ' + this
            .statusText +
            '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open('POST', url, true)

    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
    xhr.setRequestHeader('Authorization', bearerToken)
    xhr.setRequestHeader('X-CSRF-TOKEN', token)

    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhr.send(JSON.stringify(params))

}

class SubmitAcceptPrivateFallowing extends Error {
    constructor(message) {
        super(message)
        this.name = "SubmitAcceptPrivateFallowing"
    }
}

function createPrivateFollowerContainer(clickedElement, parent) {

    let privateFollowersContainerDivContainer = document.createElement('div')
    privateFollowersContainerDivContainer.className = 'df aic w-100 followRequestContainer g1rem mb16'

    let privateFollowersContainerDivContainerFirstDiv = document.createElement('div')
    privateFollowersContainerDivContainerFirstDiv.className = 'df aic jcc br12 oh mh82'
    privateFollowersContainerDivContainerFirstDiv.innerHTML = parent.getElementsByClassName('mh82')[0].innerHTML

    privateFollowersContainerDivContainer.append(privateFollowersContainerDivContainerFirstDiv)


    let privateFollowersContainerDivContainerSeccondDiv = document.createElement('div')
    privateFollowersContainerDivContainerSeccondDiv.className = 'df fdc aic jcsa w-100'

    privateFollowersContainerDivContainer.append(privateFollowersContainerDivContainerSeccondDiv)

    let privateFollowersContainerDivContainerSeccondDivP = document.createElement('p')
    privateFollowersContainerDivContainerSeccondDivP.className = 'df jcfs w-100 mb0 pendingFallowersName'
    privateFollowersContainerDivContainerSeccondDivP.innerHTML = parent.getElementsByClassName('pendingFallowersName')[0].innerHTML

    privateFollowersContainerDivContainerSeccondDiv.append(privateFollowersContainerDivContainerSeccondDivP)

    let privateFollowersContainerDivContainerSeccondDivDiv = document.createElement('p')
    privateFollowersContainerDivContainerSeccondDivDiv.className = 'df aic jcfs w-100'

    privateFollowersContainerDivContainerSeccondDiv.append(privateFollowersContainerDivContainerSeccondDivDiv)

    let privateFollowersContainerDivContainerSeccondDivDivButton = document.createElement('button')
    privateFollowersContainerDivContainerSeccondDivDivButton.className = 'btn hollow mr8 lh24 h40 removeUserFromFollowingList'
    privateFollowersContainerDivContainerSeccondDivDivButton.dataset.userId = clickedElement.dataset.userId
    privateFollowersContainerDivContainerSeccondDivDivButton.textContent = getPoTranslate('REMOVE')

    privateFollowersContainerDivContainerSeccondDivDivButton.addEventListener('click', removePrivateFollower)

    privateFollowersContainerDivContainerSeccondDivDiv.append(privateFollowersContainerDivContainerSeccondDivDivButton)

    parent.remove()

    if (document.getElementById('privatePendingContainer')) {
        if (document.getElementById('privatePendingContainer').getElementsByClassName('followRequestContainer').length === 0) {
            document.getElementById('privatePendingContainer').innerHTML = ''
        } else {
            let numberOfFollowers = document.getElementsByClassName('numberOfFollowers')
            for (let i = 0; i < numberOfFollowers.length; i++) {
                numberOfFollowers[i].textContent = parseInt(numberOfFollowers[i].textContent) - 1

            }
        }
    }

    return privateFollowersContainerDivContainer
}

export function removePrivateFollower(e) {

    e.preventDefault()
    showLoading()
    let target = e.currentTarget
    let xhr = new XMLHttpRequest()
    let url = envAppBackendUrl + '/remove-follow-requests/' + target.dataset.userId

    let params = {
        '_token': token,
        'teacher_cancel': true
    }

    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.response)

            if (response.success === true) {
                toastify(response.message)

                let parent = target.parentElement.parentElement.parentElement
                parent.style.scale = '0'
                parent.style.opacity = '0'
                setTimeout(function () {
                    parent.remove()
                }, 310)

            } else if (response.success === false) {
                toastify(response.message)
            }


            hideLoading()
        }
    }

    xhr.onloadend = function () {
        hideLoading()
    }

    xhr.onerror = function (error) {
        hideLoading()
        toastify(this.statusText)
        Sentry.captureException(new SubmitRemovePrivateFallowing(error + 'status: ' + this
            .statusText +
            '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open('POST', url, true)

    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
    xhr.setRequestHeader('Authorization', bearerToken)
    xhr.setRequestHeader('X-CSRF-TOKEN', token)

    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhr.send(JSON.stringify(params))

}

class SubmitRemovePrivateFallowing extends Error {
    constructor(message) {
        super(message)
        this.name = "SubmitRemovePrivateFallowing"
    }
}



export function followUnfollowUserOptions() {

    //put follow events on profile page

    let follow_user = document.getElementsByClassName('follow_user')

    for (let i = 0; i < follow_user.length; i++) {
        if (typeof follow_user[i].dataset.eventAdded === 'undefined') {
            follow_user[i].dataset.eventAdded = "1"
            follow_user[i].addEventListener('click', followFunction)
        }
    }

    let unfollow_user = document.getElementsByClassName('unfollow_user')

    if (document.body.className === 'favorites_users') {
        unfollow_user = Array.from(document.getElementsByClassName('unfollow_user')).concat(Array.from(document.getElementsByClassName('heartSvg')))
    }

    for (let i = 0; i < unfollow_user.length; i++) {
        if (typeof unfollow_user[i].dataset.eventAdded === 'undefined') {
            unfollow_user[i].dataset.eventAdded = "1"
            unfollow_user[i].addEventListener('click', unfallowFunction)
        }
    }

}

export function unfallowFunction(e, t) {

    let target = t ? e : e.currentTarget

    let userId = t ? target.dataset.user : target.dataset.user


    //Route::post('/remove-follow-requests/{id}', [UserFollowedApiController::class, 'removeFollow']);
    let url = envAppBackendUrl + '/unfollow-user-request/' + userId
    let xhr = new XMLHttpRequest();

    let data = {
        '_token': document.querySelector('meta[name="csrf-token"]').content
    };

    xhr.onloadstart = function () {
        showLoading()
    }

    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.response)

            if (response.success === true) {
                if (document.body.className === "favorites_users") {

                    toastify(response.message)

                    if (target.dataset.device === "desktop") {
                        target.closest('.favorites_holder').remove()
                        let heartSvgs = document.getElementsByClassName('heartSvg')
                        for (let i = 0; i < heartSvgs.length; i++) {
                            if (heartSvgs[i].dataset.user === target.dataset.user) {
                                heartSvgs[i].closest('.pBottomItemsSearch').remove()
                            }
                        }

                        if (document.getElementsByClassName('tabDeskFavUsers')[0].getElementsByClassName('favorites_holder').length === 0) {
                            let isShowMoreOnThePage = document.getElementsByClassName('favoritesShowMore')

                            for (let i = 0; i < isShowMoreOnThePage.length; i++) {
                                if (isShowMoreOnThePage[i].classList.contains('dn')) {

                                    let showNoFavorites = document.getElementsByClassName('no-found-heading')
                                    for (let i = 0; i < showNoFavorites.length; i++) {
                                        showNoFavorites[i].classList.remove('dn')
                                    }

                                    hideLoading()
                                    break

                                } else {

                                    showLoading()
                                    isShowMoreOnThePage[i].click()
                                    break

                                }
                            }


                        } else {
                            hideLoading()
                        }
                    } else if (target.dataset.device === "mobile") {
                        target.closest('.pBottomItemsSearch').remove()
                        let unfollow_user = document.getElementsByClassName('tabDeskFavUsers')[0].getElementsByClassName('unfollow_user')
                        for (let i = 0; i < unfollow_user.length; i++) {
                            if (unfollow_user[i].dataset.user === target.dataset.user) {
                                unfollow_user[i].closest('.favorites_holder').remove()
                            }
                        }


                        if (document.getElementsByClassName('tabDeskFavUsers')[0].getElementsByClassName('favorites_holder').length === 0) {
                            let isShowMoreOnThePage = document.getElementsByClassName('favoritesShowMore')

                            for (let i = 0; i < isShowMoreOnThePage.length; i++) {
                                if (isShowMoreOnThePage[i].classList.contains('dn')) {

                                    let showNoFavorites = document.getElementsByClassName('no-found-heading')
                                    for (let i = 0; i < showNoFavorites.length; i++) {
                                        showNoFavorites[i].classList.remove('dn')
                                    }
                                    hideLoading()
                                    break
                                } else {
                                    showLoading()
                                    isShowMoreOnThePage[i].click()
                                    break
                                }
                            }


                        } else {
                            hideLoading()
                        }


                    }


                    /* } else {

                        let parent = target.parentElement
                        let folowersNumber = target.parentElement.parentElement.parentElement.getElementsByClassName('social-box')[0].getElementsByTagName('strong')[0]
                        folowersNumber.textContent = (parseInt(folowersNumber.textContent) - 1) + ' '
                        target.removeEventListener('click', unfallowFunction)

                        target.textContent = getPoTranslate('FOLLOW')

                        target.className = "hollow btn w-100 follow_user mb0"

                        target.addEventListener('click', followFunction)

                        parent.append(target)


                        let svg
                        let that
                        let heartSvgs = document.getElementsByClassName('heartSvg')

                        for (let i = 0; i < heartSvgs.length; i++) {
                            if (heartSvgs[i].dataset.user === target.dataset.user) {
                                that = heartSvgs[i]
                                svg = heartSvgs[i].getElementsByTagName('svg')[0]
                            }
                        }

                        svg.style.transform = 'scale(0)'

                        setTimeout(function () {
                            svg.innerHTML = '<path d="M7 1.5L10.5 4L11.5 3.5L12.5 2.5L14 1.5H17.5C18.3 1.5 19.1667 2.83333 19.5 3.5C19.8333 4.66667 20.5 7.1 20.5 7.5C20.5 7.9 18.1667 10.6667 17 12C15 13.8333 10.9 17.6 10.5 18C10.1 18.4 6 13.8333 4 11.5L1.5 9L1 6.5L2 3.5L4.5 1.5H7Z" fill="#F4F9FF" stroke="black"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#172B4D"></path>'
                            svg.setAttribute('width', '22')
                            svg.setAttribute('height', '20')
                            svg.setAttribute('viewBox', '0 0 22 20')
                            svg.setAttribute('fill', 'none')
                            svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg')

                            that.dataset.follow = 0
                            that.parentElement.getElementsByClassName('numberF')[0].textContent = parseInt(that.parentElement.getElementsByClassName('numberF')[0].textContent) - 1

                            svg.style.transform = 'scale(1)'

                        }, 310)
                    } */



                } else if (document.body.className === "profile") {

                    let faworiteButtonsConts = document.getElementsByClassName('fallowFavCont')
                    for (let i = 0; i < faworiteButtonsConts.length; i++) {
                        if (faworiteButtonsConts[i].getElementsByTagName('button')[0]) {
                            let targetButton = faworiteButtonsConts[i].getElementsByTagName('button')[0]

                            if (targetButton.parentElement) {
                                let parent = targetButton.parentElement
                                let target = targetButton
                                target.removeEventListener('click', unfallowFunction)
                                targetButton.remove()


                                target.textContent = getPoTranslate('FOLLOW')


                                target.className = "hollow btn w-100 secondary follow_user mb0"


                                target.innerHTML = getPoTranslate('FOLLOW')

                                target.addEventListener('click', followFunction)


                                parent.append(target)
                            }

                        }

                    }


                    let folowerS = document.getElementsByClassName('folowerS')
                    for (let i = 0; i < folowerS.length; i++) {
                        folowerS[i].textContent = parseInt(folowerS[i].textContent) - 1

                    }

                    toastify(response.message)
                    hideLoading()
                } else {

                    let parent = e.target.parentElement
                    let userId = e.target.dataset.user
                    e.target.remove()
                    let fallowingButton = document.createElement('button')
                    fallowingButton.className = "button extended expanded secondary follow_user w-100"
                    fallowingButton.dataset.user = userId

                    fallowingButton.innerHTML = getPoTranslate('FOLLOW')

                    fallowingButton.addEventListener('click', followFunction)


                    parent.append(fallowingButton)



                    toastify(response.message)
                }

            } else if (response.success === false) {
                toastify(response.message)
            }

        }
    }

    xhr.onerror = function (error) {
        toastify(this.statusText);
        Sentry.captureException(new UnfollowUserRequestError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open('POST', url, true)
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
    xhr.setRequestHeader('Authorization', bearerToken)
    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhr.send(JSON.stringify(data));



}

export function followFunction(e, t) {

    let target = t ? e : e.currentTarget

    let userId
    if (document.body.className !== 'talk_details') {
        userId = t ? target.dataset.user : target.dataset.user
    } else {
        userId = e.dataset.user
    }


    //Route::post('/remove-follow-requests/{id}', [UserFollowedApiController::class, 'removeFollow']);
    let url = envAppBackendUrl + '/follow-user-request/' + userId
    let xhr = new XMLHttpRequest();

    let data = {
        '_token': token
    };

    xhr.onloadstart = function () {
        showLoading()
    }

    xhr.onreadystatechange = function () {

        if (this.readyState == 4 && this.status == 200) {
            let response = JSON.parse(this.response)
            if (document.body.className === "profile") {

                let faworiteButtonsConts = document.getElementsByClassName('fallowFavCont')
                for (let i = 0; i < faworiteButtonsConts.length; i++) {


                    if (faworiteButtonsConts[i].getElementsByTagName('button')[0]) {
                        let targetButton = faworiteButtonsConts[i].getElementsByTagName('button')[0]


                        let parent = targetButton.parentElement
                        let target = targetButton

                        targetButton.remove()
                        target.removeEventListener('click', followFunction)

                        let privateFollow = getPoTranslate('FOLLOWING')
                        if (target.dataset.private) {
                            if (target.dataset.private === '2') {
                                privateFollow = getPoTranslate('FOLLOWING_PENDING')
                            }
                        }

                        target.innerHTML = '<svg class="mr4" width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.76666 6.13325L9.89991 0L10.8333 0.933373L3.76666 8L0 4.23334L0.933373 3.29997L3.76666 6.13325Z" fill="white"></path></svg> ' + privateFollow

                        target.className = "btn warning followingPending w-100 mb0"
                        if (target.dataset.private) {
                            if (target.dataset.private === '2') {
                                target.classList.add('followingPending')
                                target.classList.add('warning')
                                target.setAttribute('onclick', 'openPopup("privatePopupCancel")')
                            }
                        } else {
                            target.addEventListener('click', unfallowFunction)
                        }



                        parent.append(target)

                    }
                }
                if (!target.dataset.private) {

                    let folowerS = document.getElementsByClassName('folowerS')[0]

                    folowerS.textContent = parseInt(folowerS.textContent) + 1
                }


                toastify(response.message)
                hideLoading()

            } else {
                let parent = e.target.parentElement
                let userId = e.target.dataset.user
                e.target.remove()
                let fallowingButton = document.createElement('button')
                fallowingButton.className = "button extended expanded unfollow_user w-100"
                fallowingButton.dataset.user = userId

                fallowingButton.innerHTML = '<svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.76666 6.13325L9.89991 0L10.8333 0.933373L3.76666 8L0 4.23334L0.933373 3.29997L3.76666 6.13325Z" fill="white"></path></svg> ' + getPoTranslate('FOLLOWING_PENDING')

                fallowingButton.addEventListener('click', unfallowFunction)

                parent.append(fallowingButton)


                toastify(response.message)
            }

        }
    }

    xhr.onerror = function (error) {
        toastify(this.statusText);
        Sentry.captureException(new GetUserFollowError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.open('POST', url, true)
    xhr.setRequestHeader('Accept', 'application/json');
    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
    xhr.setRequestHeader('Authorization', bearerToken)
    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhr.send(JSON.stringify(data));




}



export function showMoreFavoriteUsers() {
    let offsetAdd = parseInt(document.getElementById('default_favorites_show_more_users').value)
    var offset = 0
    let favoritesShowMores = document.getElementsByClassName('favoritesShowMore')
    for (let i = 0; i < favoritesShowMores.length; i++) {
        favoritesShowMores[i].addEventListener('click', function () {
            showLoading()
            if (document.body.className === 'favorites_users') {
                if (document.getElementsByClassName('tabDeskFavUsers')[0].getElementsByClassName('favorites_holder')[0]) {



                    offset = parseInt(document.getElementsByClassName('tabDeskFavUsers')[0].getElementsByClassName('favorites_holder').length)

                }
            } else {

                offset += offsetAdd
            }

            displayFavoriteUsers(offset, this, document.getElementById('filter-form')?.elements ?? false)
        })

    }




    function displayFavoriteUsers(offset, target, filter) {
        let f

        if (filter) {
            f = getFilterObj(filter)
        } else {
            f = {}
        }

        jQuery.ajax({
            type: 'GET',
            url: '/favorites/users',
            data: {
                'offset': offset
            },
            beforeSend: function () {
                // Handle the beforeSend event
                showLoading()
            },
            complete: function () {
                hideLoading()

            },
            success: function (response) {

                if ((offset + offsetAdd) >= response.total_users) {
                    if (document.getElementsByClassName('favoritesShowMore')[0]) {
                        let favoritesShowMore = document.getElementsByClassName('favoritesShowMore')
                        for (let i = 0; i < favoritesShowMore.length; i++) {
                            favoritesShowMore[i].classList.add('dn')

                        }
                    }
                }

                if (response.success) {
                    if (response.html.length > 0) {

                        addUserItemsToList(response.html)
                        addUserItemsToList2(response.html2)

                        if (window.innerWidth < 768) {
                            closeFilter()
                        }


                        document.getElementById('containerFavorites').scrollIntoView({
                            block: "end",
                            behavior: "smooth"
                        });
                    } else {

                        if (document.getElementsByClassName('favoritesShowMore')[0]) {
                            let favoritesShowMore = document.getElementsByClassName('favoritesShowMore')
                            for (let i = 0; i < favoritesShowMore.length; i++) {
                                favoritesShowMore[i].classList.add('dn')

                            }
                        }
                        /* toastify(response.message) */
                        toastify(getPoTranslate('NO_RESULT_FOR_THIS_FILTER'))
                    }

                } else {
                    toastify(response.message)
                }


                favoriteAndUnFavoriteTalk()

                if (document.getElementById('submitFilter')) {
                    document.getElementById('submitFilter').disabled = true
                }

            },
            error: function (errorMessage) {
                Sentry.captureException(new GetFavoriteUsersError(errorMessage + ' || URL: ' + location.href));
            }
        });
    }
}

function addUserItemsToList2(responseHtml) {

    let addUser = document.createElement('div')
    addUser.innerHTML = responseHtml
    let htmlLayout = addUser.getElementsByClassName('pBottomItemsSearch')[0]

    document.getElementsByClassName('thxer')[0].append(htmlLayout)
    /*  document.getElementsByClassName('thxer')[0].innerHTML += responseHtml */
}

export function showHideCalendarBigSmall() {
    if(document.getElementsByClassName('dateDDIner')[0]){
        document.getElementsByClassName('dateDDIner')[0].addEventListener('click', function () {
            if (this.dataset.opened === '1') {
                document.getElementsByClassName('sevDaysCaleWrap')[0].style.height = '0px'

                document.getElementsByClassName('container-calendarCont')[0].style.height = document.getElementsByClassName('container-calendar')[0].offsetHeight + 'px'


                document.getElementById('previous').style.cssText = 'display:block; z-index:100;'
                document.getElementById('next').style.cssText = 'display:block; z-index:100;'
                this.dataset.opened = 0
                this.getElementsByTagName('svg')[0].style.transform = 'scale(1,-1)'
            } else if (this.dataset.opened === '0') {

                document.getElementsByClassName('container-calendarCont')[0].style.height = '0px'
                document.getElementsByClassName('sevDaysCaleWrap')[0].style.height = document.getElementsByClassName('sevDaysCale')[0].offsetHeight + 'px'
                document.getElementById('previous').style.cssText = 'display:none;'
                document.getElementById('next').style.cssText = 'display:none;'
                this.dataset.opened = 1
                this.getElementsByTagName('svg')[0].style.transform = 'scale(1,1)'

            }
        })
    }
}
function addUserItemsToList(responseHtml) {

    let html = document.createElement('div')

    html.innerHTML = responseHtml
    let htmlGrid = html.getElementsByClassName('grid-x')

    let helper = htmlGrid

    for (let i = 0; i < helper.length; i++) {

        let favItem = document.createElement('div')
        favItem.className = 'fav-item favorites_holder'

        let cln = htmlGrid[i].cloneNode(true);

        favItem.insertBefore(cln, favItem.firstChild)
        document.getElementsByClassName('tabDeskFavUsers')[0].insertBefore(favItem, document.getElementsByClassName('tabDeskFavUsers')[0].getElementsByClassName('no-found-heading')[0])


    }

    if (helper.length > 0) {
        document.getElementsByClassName('buttCont')[0].classList.remove('dn')
    } else {
        if (document.getElementsByClassName('buttCont')[0].classList.contains('dn') === false) {
            document.getElementsByClassName('buttCont')[0].classList.add('dn')
        }

    }
}

function getFilterObj(filter, pointer, secPointer) {
    let anon
    let f
    let categoriesCheckboxes
    let subCategoriesCheckboxes

    if (pointer) {
        categoriesCheckboxes = getCategoriesCeheckboxes(pointer)
        subCategoriesCheckboxes = getSubCategoriesCheckboxes(pointer)
        anon = false
    } else {
        categoriesCheckboxes = getCategoriesCeheckboxes()
        subCategoriesCheckboxes = getSubCategoriesCheckboxes()

        for (let i = 0; i < filter['group1'].length; i++) {
            if (filter['group1'][i].checked) {
                if (filter['group1'][i].dataset.value === "0") {
                    anon = false
                } else if (filter['group1'][i].dataset.value === "1") {
                    anon = true
                } else if (filter['group1'][i].dataset.value === "2") {
                    anon = 2
                }
                break
            }
        }
    }


    let durationFilters = document.getElementById('durationFilters').getElementsByTagName('input')

    let arrayFiltersHelper = []

    for (let i = 0; i < durationFilters.length; i++) {
        if (durationFilters[i].checked) {
            arrayFiltersHelper.push(parseInt(durationFilters[i].parentElement.getElementsByTagName('label')[0].dataset.minutes))
        }
    }

    let availabilityFilters = document.getElementById('availabilityFilters').getElementsByTagName('input')

    let availabilityFiltersObject = {}
    for (let i = 0; i < availabilityFilters.length; i++) {

        availabilityFiltersObject[availabilityFilters[i].dataset.day] = availabilityFilters[i].checked
    }

    let priceFilters = document.getElementById('priceFilters').getElementsByTagName('input')
    let priceFiltersPriceFiltersObject = {}
    for (let i = 0; i < priceFilters.length; i++) {
        priceFiltersPriceFiltersObject[priceFilters[i].dataset.pricerange] = priceFilters[i].checked
    }

    let talkTypeFilters = document.getElementById('typeFilters').getElementsByTagName('input')

    let talkTypeFiltersObject = {}
    for (let i = 0; i < talkTypeFilters.length; i++) {
        talkTypeFiltersObject[talkTypeFilters[i].dataset.type] = talkTypeFilters[i].checked
    }
    if (secPointer) {
        f = {
            "categories": categoriesCheckboxes,
            "subCategories": subCategoriesCheckboxes,
            "type": {
                "private": true /* filter['filter[type][private][1]'].checked */,
                "group": false /* filter['filter[type][group][2]'].checked */
            },
            "duration": arrayFiltersHelper,
            "priceRange": priceFiltersPriceFiltersObject,
            "availability": availabilityFiltersObject,
            "talks": talkTypeFiltersObject,
            "order_by": window.orderByFilter[0],
            "order_by_type": window.orderByFilter[1]
        }
    } else {
        f = {
            "categories": categoriesCheckboxes,
            "subCategories": subCategoriesCheckboxes,
            "type": {
                "private": true /* filter['filter[type][private][1]'].checked */,
                "group": false /* filter['filter[type][group][2]'].checked */
            },
            "duration": arrayFiltersHelper,
            "priceRange": priceFiltersPriceFiltersObject,
            "availability": availabilityFiltersObject,
            "talks": talkTypeFiltersObject,
            "anonTalks": anon,
            "order_by": window.orderByFilter[0],
            "order_by_type": window.orderByFilter[1]
        }
    }


    return f
}

function showMoreTeacherTalksOne(element) {

    element.addEventListener('click', function () {


        let teacher = this.dataset.teacher
        if (this.getElementsByTagName('span')[0].classList.contains('showLess')) {
            let courseItems = this.parentElement.getElementsByClassName('course-item')

            for (let i = courseItems.length - 1; i >= 0; i--) {
                if (i > 1) {
                    courseItems[i].remove()
                }

            }

            this.getElementsByTagName('span')[0].textContent = 'Show More'
            this.getElementsByTagName('span')[0].classList.remove('showLess')


        } else {
            displayTalks(this, teacher, document.getElementById('filter-form').elements, 100)
            favoriteAndUnFavoriteTalk()
        }


    });

    function displayTalks(clickedElement, teacher, filter, limit, helper) {

        let f = getFilterObj(filter)

        jQuery.ajax({
            type: 'GET',
            url: '/talks',
            data: {
                'offset': 0,
                'limit': limit,
                'teacherId': teacher,
                'filter': JSON.stringify(f)
            },
            beforeSend: function () {
                // Handle the beforeSend event
                showLoading()
            },
            complete: function () {
                hideLoading()
            },
            success: function (response) {

                let html2 = stringToHTML(response.html, clickedElement.dataset.teacher)

                showMoreTalksSearch(clickedElement, html2, helper)

            },
            error: function (errorMessage) {
                Sentry.captureException(new GetTalksError3(errorMessage + ' || URL: ' + location.href));
            }
        });
    }
}



function showMoreTalksSearch(clickedElement, html, helper) {

    if (html) {

        clickedElement.parentElement.parentElement.parentElement.parentElement.insertBefore(html, clickedElement.parentElement.parentElement.parentElement)

        clickedElement.parentElement.parentElement.parentElement.parentElement.removeChild(clickedElement.parentElement.parentElement.parentElement)




        if (!helper) {

            let showLess = html.getElementsByClassName('show-more-teacher-talks')[0].getElementsByTagName('span')[0]

            showLess.classList.add('showLess')
            showLess.dataset.teacher = clickedElement.dataset.teacher
            clickedElement.parentElement.parentElement.parentElement.id = 'showLess' + clickedElement.dataset.teacher
            showLess.textContent = 'Show Less'

            showMoreTeacherTalksOne(showLess.parentElement)
            return

        }
        showMoreTeacherTalks()
    } else {

        toastify(getPoTranslate('NO_RESULT_FOR_THIS_FILTER'))
    }

}

Element.prototype.scrollIntoViewPromise = function (options) {

    // "this" refers to the current element (el.scrollIntoViewPromise(options): this = el)
    this.scrollIntoView(options);

    // I create a variable that can be read inside the returned object ({ then: f() }) to expose the current element
    let parent = this;

    // I return an object with just a property inside called then
    // then contains a function which accept a function as parameter that will be execute when the scroll ends
    return {
        then: function (x) {
            // Check out https://developer.mozilla.org/en-US/docs/Web/API/Intersection_Observer_API for more informations
            const intersectionObserver = new IntersectionObserver((entries) => {
                let [entry] = entries;

                // When the scroll ends (when our element is inside the screen)
                if (entry.isIntersecting) {

                    // Execute the function into then parameter and stop observing the html element
                    setTimeout(() => {
                        x();
                        intersectionObserver.unobserve(parent)
                    }, 100)
                }
            });

            // I start to observe the element where I scrolled
            intersectionObserver.observe(parent);
        }
    };
}



let stringToHTML = function (str) {
    let parser = new DOMParser()
    let doc = parser.parseFromString(str, 'text/html')

    return doc.body.getElementsByClassName('favorites_holder')[0]
}


export function showMoreNotifications() {
    let total = document.getElementById("total_notifications_count").value
    let limiter = parseInt(document.getElementById('default_notifications_count_show_more').value)
    let limit = limiter

    jQuery(".showMoreNotification").on('click', function () {

        limit += limiter

        if (limit > total) {
            jQuery('.showMoreNotification').hide();
        }
        displayNotifications(limit)
    });

    function displayNotifications(limit) {
        jQuery.ajax({
            type: 'GET',
            url: '/settings/notifications',
            data: {
                'limit': limit,
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
                    jQuery('.notificatoin-wrapper').html(response.html);
                } else {
                    console.log(response)
                }
            },
            error: function (errorMessage) {
                Sentry.captureException(new GetSettingsNotificationsError(errorMessage + ' || URL: ' + location.href));
            }
        });
    }
}



class GetUserFollowError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetUserFollowError"
    }
}


class GetTalksError3 extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTalksError3"
    }
}
class GetTalksError4 extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTalksError4"
    }
}
class GetFavoriteUsersError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetFavoriteUsersError"
    }
}



class GetSettingsNotificationsError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetSettingsNotificationsError"
    }
}
