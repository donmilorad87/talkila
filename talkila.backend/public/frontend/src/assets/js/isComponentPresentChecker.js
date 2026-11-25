
import * as scrollToTop from './scroll-to-top.js'
import * as cookieNotice from './cookieNotice.js'

import * as comunicationControler from './comunicationControler.js'

export function isPresent() {


    if (document.getElementsByClassName('languageCell')[0]) {
        loadScript('/frontend/assets/js/LanguageMenu.js' + version, function () {

        }, 'module')
    }


    if (document.getElementsByClassName('ptbo')[0]) {
        loadScript('/frontend/assets/js/TopHeader.js' + version, function () {

        }, 'module')
    }

    if (document.getElementsByClassName('jtc2_submit')[0]) {
        let jtc_submits = document.getElementsByClassName('jtc2_submit')
        for (let i = 0; i < jtc_submits.length; i++) {

            jtc_submits[i].addEventListener('click', function () {


                jtc2StepComplete(this.dataset.step, this.dataset.redirect)


            })

        }
    }

    if (document.getElementById('cancelRemovingCourse')) {
        document.getElementById('cancelRemovingCourse').addEventListener('click', function () {
            closePopup('deleteTalkPopup');
        });
    }


    if (document.getElementsByClassName('addGroupTalkTalksAndAva')[0]) {
        document.getElementsByClassName('addGroupTalkTalksAndAva')[0].addEventListener('click', function () {

            window.clickedEdit = 0

            clearGroupForm(document.getElementById('group-talk-form'))

            let app_talk_categories = JSON.parse(localStorage.getItem('app_talk_categories_' + getCookie('activeLang')))
            let data = app_talk_categories.talk_categories.data

            inputGroupCategories()

            select_group_category_input_and_select_subcategory(data, 1, getCategoryLanguageId())

            inputGroupLanguages()

            select_group_language(getLanguageId())

            document.getElementById('group-talk-form').getElementsByClassName('pauseWrap')[0].classList.add('dn')
            document.getElementById('group-talk-form').elements['talkIdG'].value = ''

            document.getElementById('talkInputG').focus()

            document.getElementById('groupSubmit').parentElement.parentElement.classList.add('dn')
            document.getElementById('groupSubmit').textContent = getPoTranslate('ADD_GALLERY_TALK')
            let pageTitlePoperAva = document.getElementById('addGroupTalk').getElementsByClassName('pageTitlePoperAva')

            for (let i = 0; i < pageTitlePoperAva.length; i++) {
                pageTitlePoperAva[i].textContent = getPoTranslate('ADD_GALLERY_TALK')
            }

            document.getElementById('group-talk-form').getElementsByClassName('deleteTalkButtoner')[0].classList.add('dn')

            document.getElementById('jtc_add_gallery_talk_description').classList.remove('dn')
            document.getElementById('jtc_edit_gallery_talk_description').classList.add('dn')


        })
    }

    if (document.getElementsByClassName('addPrivateTalk')[0]) {
        document.getElementsByClassName('addPrivateTalk')[0].addEventListener('click', function () {

            window.clickedEdit = 0

            clearForm(document.getElementById('private-talk-form'))

            let app_talk_categories = JSON.parse(localStorage.getItem('app_talk_categories_' + getCookie('activeLang')))
            let data = app_talk_categories.talk_categories.data

            inputCategories()


            select_category_input_and_select_subcategory(data, 1, getCategoryLanguageId())

            inputLanguages()

            select_language(getLanguageId())

            document.getElementsByClassName('addNewTalkDescription')[0].classList.remove('dn')
            document.getElementsByClassName('editnewTalkDescription')[0].classList.add('dn')
            document.getElementsByClassName('pauseWrap')[0].classList.add('dn')
            document.getElementById('privateSubmit').classList.add('dn')
            document.getElementById('privateSubmit').textContent = getPoTranslate('ADD_PRIVATE_TALK')
            document.getElementsByClassName('pageTitlePoperAva').textContent = getPoTranslate('ADD_PRIVATE_TALK')



        })
    }

    window.jtc2StepComplete = function (step, redirect) {
        let xhr = new XMLHttpRequest()


        let url = envAppBackendUrl + '/jtc/complete'

        let params = {

            'step': parseInt(step)
        }

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.response)

                if (response.success === true) {
                    showLoading()
                    location.assign(redirect)
                } else if (response.success === false) {
                    toastify(response.message)
                }



            }
        }

        xhr.onerror = function (error) {

            toastify(this.statusText)
            Sentry.captureException(new RemoveSocialVerify(error + 'status: ' + this
                .statusText +
                '|| response: ' + this.statusText + ' || url: ' + location.href));
        }

        xhr.open('POST', url, true)
        xhr.setRequestHeader('Accept', 'application/json');
        xhr.setRequestHeader('Authorization', bearerToken)


        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
        xhr.setRequestHeader('Content-Type', 'application/json')




        xhr.send(JSON.stringify(params))
    }

    //social verificaiton flow

    if (document.getElementsByClassName('removeSocialVerification')[0]) {
        let removeSocialVerification = document.getElementsByClassName('removeSocialVerification')

        for (let i = 0; i < removeSocialVerification.length; i++) {
            removeSocialVerification[i].addEventListener('click', function (e) {
                let that = this
                e.preventDefault()
                showLoading()
                let xhr = new XMLHttpRequest()


                let url = '/delete/social/verification'

                let params = {
                    '_token': token,
                    'socialVerifyId': that.dataset.verifiedId
                }

                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response)

                        if (response.success === true) {
                            toastify(response.message)

                            that.parentElement.parentElement.parentElement.style.cssText = 'transition:0.3s; scale:(0); opacity:0;'
                            setTimeout(function () {
                                that.parentElement.parentElement.parentElement.remove()
                            }, 310)
                            calculatePopUpHeight(document.getElementById('social_verify'), 52)
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
                    Sentry.captureException(new RemoveSocialVerify(error + 'status: ' + this
                        .statusText +
                        '|| response: ' + this.statusText + ' || url: ' + location.href));
                }

                xhr.open('POST', url, true)
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('Authorization', bearerToken)
                xhr.setRequestHeader('X-CSRF-TOKEN', token)

                xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
                xhr.setRequestHeader('Content-Type', 'application/json')




                xhr.send(JSON.stringify(params))




            })

        }






        class RemoveSocialVerify extends Error {
            constructor(message) {
                super(message)
                this.name = "RemoveSocialVerify"
            }
        }
    }

    // calendar flow
    if (document.getElementsByClassName('removeCalendar')[0]) {

        let removeCalendar = document.getElementsByClassName('removeCalendar')

        for (let i = 0; i < removeCalendar.length; i++) {
            removeCalendar[i].addEventListener('click', function (e) {
                e.preventDefault()
                showLoading()
                let xhr = new XMLHttpRequest()
                let url = envAppBackendUrl + '/disconnect-calendar/' + e.currentTarget.dataset.calendarId

                let params = {
                    '_token': token
                }

                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response)

                        if (response.success === true) {
                            toastify(response.message)

                            removeCalendar[i].parentElement.parentElement.style.cssText = 'transition:0.3s; scale:(0); opacity:0;'
                            setTimeout(function () {
                                removeCalendar[i].parentElement.parentElement.remove()

                                let rCalendar = document.getElementsByClassName('removeCalendar')

                                if (rCalendar.length === 1) {
                                    rCalendar[0].classList.remove('dn')
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
                    Sentry.captureException(new RemoveCalendarError(error + 'status: ' + this
                        .statusText +
                        '|| response: ' + this.statusText + ' || url: ' + location.href));
                }

                xhr.open('POST', url, true)
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('Authorization', bearerToken)
                xhr.setRequestHeader('X-CSRF-TOKEN', token)

                xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
                xhr.setRequestHeader('Content-Type', 'application/json')




                xhr.send(JSON.stringify(params))




            })

        }






        class RemoveCalendarError extends Error {
            constructor(message) {
                super(message)
                this.name = "RemoveCalendarError"
            }
        }
    }

    if (document.getElementsByClassName('scrollToTopArrow')[0]) {
        document.getElementsByClassName('scrollToTopArrow')[0].addEventListener('click', function () {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        })
    }

    if (document.getElementsByClassName('unblockUser')[0]) {

        let unblockUser = document.getElementsByClassName('unblockUser')

        for (let i = 0; i < unblockUser.length; i++) {

            unblockUser[i].addEventListener('click', function (e) {
                e.preventDefault()
                showLoading()
                let xhr = new XMLHttpRequest()
                let url = envAppBackendUrl + '/user-unblock'

                let params = {
                    '_token': token,
                    'teacher_id': parseInt(e.currentTarget.dataset.userId)
                }

                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response)

                        if (response.success === true) {
                            toastify(response.message)

                            let parent = unblockUser[i].parentElement.parentElement.parentElement
                            parent.style.scale = '0'
                            parent.style.opacity = '0'
                            setTimeout(function () {
                                parent.remove()

                                if (!document.getElementById('blockedUsersPopup').getElementsByClassName('followRequestContainer')[0]) {

                                    closePopup('blockedUsersPopup')
                                    let showBlockUserPopupButton = document.getElementById('showBlockUserPopupButton')
                                    showBlockUserPopupButton.style.scale = '0'
                                    setTimeout(function () {
                                        showBlockUserPopupButton.remove()

                                    }, 310)
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
                    Sentry.captureException(new SubmitRemovePrivateFallowing(error + 'status: ' + this
                        .statusText +
                        '|| response: ' + this.statusText + ' || url: ' + location.href));
                }

                xhr.open('POST', url, true)
                xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('Authorization', bearerToken)
                xhr.setRequestHeader('X-CSRF-TOKEN', token)

                xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

                xhr.send(JSON.stringify(params))
            })

        }



        class SubmitRemovePrivateFallowing extends Error {
            constructor(message) {
                super(message)
                this.name = "SubmitRemovePrivateFallowing"
            }
        }
    }

    // redirect after adding paypall flow
    let queryString = window.location.search
    let urlParams = new URLSearchParams(queryString)
    let code = urlParams.get('code')

    if (code) {
        if (
            document.body.className === 'settings_wallets' ||
            document.body.className === 'book_slot_payment' ||
            document.body.className === 'video_conference'
        ) {
            history.pushState({}, document.title, location.origin + location.pathname)
        }
    }


    //private fallow & regular fallow settings flow

    //CancelPendingFallowingRequestUser on 'settings_profile' page and 'settings_following' page
    if (document.getElementsByClassName('cancelRequest')[0]) {
        if (document.body.className === 'settings_profile' || document.body.className === 'settings_following') {
            let cancelRequest = document.getElementsByClassName('cancelRequest')

            for (let i = 0; i < cancelRequest.length; i++) {

                cancelRequest[i].addEventListener('click', function (e) {
                    e.preventDefault()
                    showLoading()
                    let xhr = new XMLHttpRequest()
                    let url = envAppBackendUrl + '/cancel-follow-request/' + e.currentTarget.dataset.user

                    let params = {
                        '_token': token
                    }
                    let that = this
                    xhr.onreadystatechange = function () {

                        if (this.readyState == 4 && this.status == 200) {
                            let response = JSON.parse(this.response)

                            if (response.success === true) {
                                toastify(response.message)

                                let parent = cancelRequest[i].parentElement.parentElement.parentElement
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
                        Sentry.captureException(new CancelPendingFallowingRequestUser(error + 'status: ' + this
                            .statusText +
                            '|| response: ' + this.statusText + ' || url: ' + location.href));
                    }

                    xhr.open('POST', url, true)

                    xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
                    xhr.setRequestHeader('Authorization', bearerToken)
                    xhr.setRequestHeader('X-CSRF-TOKEN', token)

                    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

                    xhr.send(JSON.stringify(params))
                })

            }
        }




        class CancelPendingFallowingRequestUser extends Error {
            constructor(message) {
                super(message)
                this.name = "CancelPendingFallowingRequestUser"
            }
        }
    }






    if (document.getElementsByClassName('removeFollower')[0]) {
        let removeFolower = document.getElementsByClassName('removeFollower')

        for (let i = 0; i < removeFolower.length; i++) {

            removeFolower[i].addEventListener('click', function (e) {
                e.preventDefault()
                showLoading()
                let xhr = new XMLHttpRequest()
                let url = envAppBackendUrl + '/cancel-follow-request/' + e.currentTarget.dataset.userId

                let params = {
                    '_token': token
                }
                let that = this
                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response)

                        if (response.success === true) {
                            toastify(response.message)

                            let parent = removeFolower[i].parentElement.parentElement.parentElement
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
            })

        }
        class SubmitAcceptPrivateFallowing extends Error {
            constructor(message) {
                super(message)
                this.name = "SubmitAcceptPrivateFallowing"
            }
        }
    }

    if (document.getElementById('durationP')) {
        document.getElementById('durationP').addEventListener('input', function () {
            this.classList.add('ok')
        })
    }





    if (document.getElementsByClassName('closeAddTalkFunnel')[0]) {

        let closeSpanPupups = document.getElementsByClassName('closeAddTalkFunnel')

        for (let i = 0; i < closeSpanPupups.length; i++) {
            closeSpanPupups[i].addEventListener('click', function () {
                closePopup(this.getElementsByClassName('closeThisPopup')[0].dataset.close)
            })

        }


    }

    if (document.getElementsByClassName('closeAddTalkFunnel2')[0]) {
        document.getElementsByClassName('closeAddTalkFunnel2')[0].addEventListener('click', function () {
            showLoading()
            location.reload()
        })
    }

    if (document.getElementsByClassName('popuper2')[0]) {
        document.getElementsByClassName('popuper2')[0].parentElement.addEventListener('click', function () {
            showLoading()
            location.reload()
        })
    }

    if (document.getElementById('goBack2')) {
        document.getElementById('goBack2').addEventListener('click', function () {
            location.assign('/')
        })
    }

    if (document.getElementById('newFilterSubmit')) {
        window.newFilterIsOpened = 0
        window.filterOpened = 0
        let newFilterSubmit = document.getElementById('newFilterSubmit')
        if (document.getElementsByClassName('filterOpener')[0]) {

            document.getElementById('newFilterPopup').addEventListener('click', function () {
                document.getElementsByClassName('filterOpener')[0].dataset.opened = "0"
                closeNewFilter()
            })

            document.getElementsByClassName('filterOpener')[0].addEventListener('click', function () {

                if (window.newFilterIsOpened == "0") {

                    openNewFilter()

                } else if (window.newFilterIsOpened == "1") {

                    closeNewFilter()

                }

            })
        }

        window.openNewFilter = function () {

            openPopup('newFilterPopup')

            setTimeout(function () {
                document.getElementById('newFilterPopup').style.left = '0px'
            }, 81)
            setTimeout(function () {
                document.getElementById('newFilterPopup').getElementsByClassName('popuper')[0].style.left = '0px'
            }, 161)

            window.newFilterIsOpened = 1
        }

        window.closeNewFilter = function () {

            document.getElementById('newFilterPopup').getElementsByClassName('popuper')[0].style.left = '1000px'

            setTimeout(function () {
                closePopup('newFilterPopup')
            }, 160)
            setTimeout(function () {
                document.getElementById('newFilterPopup').style.left = '1000px'
            }, 80)

            document.getElementsByClassName('filterOpener')[0].dataset.opened = "0"
            window.newFilterIsOpened = 0
        }



        window.addEventListener('resize', function () {
            if (window.innerWidth > 767) {
                if (window.newFilterIsOpened == 1) {
                    closeNewFilter()
                    openFilter()

                }

            }
        })
    }

    if (document.getElementById('showMoreLanguagesButton')) {
        document.getElementById('showMoreLanguagesButton').addEventListener('click', function () {
            let hiddenCheckboxes = this.parentElement.getElementsByClassName('dno0s0')

            for (let i = 0; i < hiddenCheckboxes.length; i++) {
                hiddenCheckboxes[i].style.transitionDelay = i * 0.05 + 's'
                hiddenCheckboxes[i].classList.remove('dno0s0')
            }
        })
    }

    if (document.getElementsByClassName('lefterZGT')[0]) {
        document.getElementsByClassName('lefterZGT')[0].addEventListener('click', function () {
            closePopup('newFilterPopup')
            document.getElementsByClassName('filterOpener')[0].dataset.opened = '0'
        })
    }

    if (document.getElementsByClassName('filterTypeBadge')[0]) {

        let filterTypeBadge = document.getElementsByClassName('filterTypeBadge')
        for (let i = 0; i < filterTypeBadge.length; i++) {
            filterTypeBadge[i].addEventListener('click', function () {
                if (this.dataset.clicked === "0") {


                    this.classList.add('active')
                    this.dataset.clicked = 1
                } else if (this.dataset.clicked === "1") {

                    this.classList.remove('active')
                    this.dataset.clicked = 0

                }

            })

        }

    }

    if (document.getElementById('lengthAvailability')) {

        var owl1 = jQuery("#lengthAvailability");

        owl1.owlCarousel({
            margin: 4,
            dots: true,
            nav: false,
            items: 7
        });
        document.getElementById('lengthAvailability').style.opacity = '1'

        if (document.getElementsByClassName('filterLengthBadge')[0]) {

            let filterLengthBadge = document.getElementsByClassName('filterLengthBadge')
            for (let i = 0; i < filterLengthBadge.length; i++) {
                filterLengthBadge[i].addEventListener('click', function () {
                    if (this.dataset.checked === "0") {
                        this.classList.add('active')
                        this.dataset.checked = "1"
                    } else {
                        this.classList.remove('active')
                        this.dataset.checked = "0"
                    }

                })

            }
        }

    }

    if (document.getElementsByClassName('filterAvailability')[0]) {

        let filterAvailability = document.getElementsByClassName('filterAvailability')[0].getElementsByClassName('filterDayBadge')
        for (let i = 0; i < filterAvailability.length; i++) {
            filterAvailability[i].addEventListener('click', function () {
                if (this.dataset.checked === "0") {
                    this.classList.add('active')
                    this.dataset.checked = "1"
                } else {
                    this.classList.remove('active')
                    this.dataset.checked = "0"
                }

            })

        }
    }

    if (document.getElementsByClassName('burgerItemMenu')[0]) {
        document.getElementsByClassName('burgerItemMenu')[0].addEventListener('click', function () {
            if (this.dataset.opened === '0') {
                let appendStyle = document.createElement('div')
                appendStyle.id = 'appendStyle'
                appendStyle.innerHTML = '<style>.menuIcon:before{transform: translateY(6px) rotate(135deg)!important;}.menuIcon:after{transform: translateY(-6px) rotate(-135deg)!important;}.menuIcon div{transform: scale(0)!important;}</style>'

                document.body.append(appendStyle)

                document.getElementsByClassName('cs16')[0].style.right = '0px'


                this.dataset.opened = 1
            } else if (this.dataset.opened === '1') {

                document.getElementById('appendStyle').remove()
                document.getElementsByClassName('cs16')[0].style.right = '-250%'


                this.dataset.opened = 0
            }

        })
    }

    if (document.getElementsByClassName('cz')[0]) {
        let closePopupButtons = document.getElementsByClassName('cz')
        for (let i = 0; i < closePopupButtons.length; i++) {
            closePopupButtons[i].addEventListener('click', function () {
                if (this.dataset.closePopup) {
                    closePopup(this.dataset.closePopup)
                }
            })
        }
    }

    if (document.getElementsByClassName('chch')[0]) {
        let checkers = document.getElementsByClassName('chch')
        for (let i = 0; i < checkers.length; i++) {
            checkers[i].addEventListener('click', function () {

                if (this.dataset.checkedCheckbox === "0") {

                    this.dataset.checkedCheckbox = "1"
                    this.getElementsByClassName('afterCheck')[0].classList.add('checkedCheck')
                    this.getElementsByClassName('beforeCheck')[0].classList.add('backgroundCheckedCheck')

                } else {

                    this.dataset.checkedCheckbox = "0"
                    this.getElementsByClassName('afterCheck')[0].classList.remove('checkedCheck')
                    this.getElementsByClassName('beforeCheck')[0].classList.remove('backgroundCheckedCheck')

                }
            })
        }
    }

    if (document.getElementsByClassName('flash-message')[0]) {
        if (document.getElementsByClassName('flash-message')[0].getElementsByTagName('p')[0]) {
            if (document.getElementsByClassName('flash-message')[0].getElementsByTagName('p')[0].textContent.trim().length > 0) {
                getBackgroundColorOfFlashMesage(document.getElementsByClassName('flash-message')[0].getElementsByTagName('p')[0])

                document.getElementsByClassName('flash-message')[0].style.top = '0px'

                setTimeout(function () {
                    document.getElementsByClassName('flash-message')[0].style.top = '-200px'
                }, 8000)

            }
        }
    }

    function getBackgroundColorOfFlashMesage(flashMessagePTag) {

        if (flashMessagePTag.classList.contains('alert-info')) {
            flashMessagePTag.style.background = '#3e80af'
        } else if (flashMessagePTag.classList.contains('alert-success')) {
            flashMessagePTag.style.background = '#2a7749'
        } else if (flashMessagePTag.classList.contains('alert-warning')) {
            flashMessagePTag.style.background = '#f79317'
        } else if (flashMessagePTag.classList.contains('alert-danger')) {
            flashMessagePTag.style.background = '#f71717'
        }
    }



    if (document.getElementById('jtcCarousel')) {


        let jtcCarousel = document.getElementById('jtcCarousel')

        let jtcCarousel2 = jQuery("#jtcCarousel")

        jtcCarousel2.owlCarousel({

            dots: true,
            nav: false,
            stagePadding: 0,
            items: 1,
            onInitialized: counter,
            onTranslated: counter,
            onChanged: onChangedfunct

        })

        document.getElementsByClassName('nextCarousel')[0].addEventListener('click', function nextItem() {
            jtcCarousel2.trigger('next.owl.carousel')
        })

        function onChangedfunct(event) {

            var item = event.item.index + 1

            if (item === 3) {
                document.getElementsByClassName('nextCarousel')[0].style.display = 'none'
                document.getElementById('counter').style.display = 'none'
                if (document.getElementById('jtcCarousel').getElementsByClassName('owl-dots')[0]) {
                    document.getElementById('jtcCarousel').getElementsByClassName('owl-dots')[0].style.display = 'none'
                }

                document.getElementsByClassName('blueButton')[0].style.display = 'block'

            } else {
                document.getElementsByClassName('nextCarousel')[0].style.display = 'block'
                document.getElementById('counter').style.display = 'block'
                if (document.getElementById('jtcCarousel').getElementsByClassName('owl-dots')[0]) {
                    document.getElementById('jtcCarousel').getElementsByClassName('owl-dots')[0].style.display = 'block'
                }
                document.getElementsByClassName('blueButton')[0].style.display = 'none'

            }
        }

        function counter(event) {

            var items = event.item.count
            var item = event.item.index + 1

            if (item > items) {
                item = item - items
            }
            document.getElementById('counter').textContent = item + "|" + items

        }
        jtcCarousel.style.opacity = '1'
        jtcCarousel.style.height = 'auto'
        document.getElementsByClassName('nextCarousel')[0].style.display = 'block'

    }

    if (document.getElementById('otherTeachersCarousel')) {

        let testimonialAboutMeProfile = document.getElementById('otherTeachersCarousel')


        var owl1 = jQuery(testimonialAboutMeProfile)

        owl1.owlCarousel({
            margin: 20,
            dots: false,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            }
        })

        testimonialAboutMeProfile.style.opacity = '1'
        testimonialAboutMeProfile.getElementsByClassName('owl-nav')[0].classList.remove('disabled')

    }

    if (document.getElementById('testimonialAboutMeProfile')) {

        let testimonialAboutMeProfile = document.getElementById('testimonialAboutMeProfile')


        var owl1 = jQuery(testimonialAboutMeProfile)

        owl1.owlCarousel({
            margin: 20,
            dots: false,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1024: {
                    items: 3
                }
            }
        })

        testimonialAboutMeProfile.style.opacity = '1'


    }

    if (document.getElementsByClassName('testimonialAboutMe')[0]) {
        if (document.body.className !== 'profile') {
            let testimonialAboutMe = document.getElementsByClassName('testimonialAboutMe')
            for (let i = 0; i < testimonialAboutMe.length; i++) {

                var owl1 = jQuery(testimonialAboutMe[i])

                owl1.owlCarousel({
                    margin: 20,
                    dots: true,
                    nav: false,

                    responsive: {
                        0: {
                            items: 1
                        },
                        320: {
                            items: 2
                        },
                        1024: {
                            items: 3
                        },
                        1200: {
                            items: 4
                        }
                    }
                })

                testimonialAboutMe[i].style.opacity = '1'
            }
        }


    }

    if (document.getElementById('showMoreDesc')) {
        showMoreThreeDots()
    }


    if (document.getElementsByClassName('bMySlotsButtons')[0]) {
        loadScript('/frontend/assets/js/bookButton.js' + version, function () {

            /*    profileCourses2()
               window.addEventListener("resize", profileCourses2);

               function profileCourses2() {


                   if (window.innerWidth < 768) {
                       if (document.getElementsByClassName('privateC')[0].style.left === '0%' || document.getElementsByClassName('privateC')[0].style.left === '') {

                           document.getElementsByClassName('gropings')[0].style.height = 73 + document.getElementsByClassName('privateC')[0].offsetHeight + 'px'
                       } else {

                           document.getElementsByClassName('gropings')[0].style.height = 73 + document.getElementsByClassName('groupC')[0].offsetHeight + 'px'
                       }
                   }
                   else if (window.innerWidth > 767) {
                       if (document.getElementsByClassName('privateC')[0].style.left === '0%' || document.getElementsByClassName('privateC')[0].style.left === '') {

                           document.getElementsByClassName('gropings')[0].style.height = 73 + document.getElementsByClassName('privateC')[0].offsetHeight + 'px'
                       } else {

                           document.getElementsByClassName('gropings')[0].style.height = document.getElementsByClassName('bMySlotsButtons')[0].offsetHeight + document.getElementsByClassName('groupC')[0].offsetHeight + 'px'
                       }
                   }

               } */
        });
    }

    if (document.getElementsByClassName('copyText')[0]) {

        let copyTexts = document.getElementsByClassName('copyText')
        for (let i = 0; i < copyTexts.length; i++) {
            copyTexts[i].addEventListener('click', function copyTextToClipboard() {
                let copyText = this.parentElement.getElementsByTagName('input')[0]

                copyText.select();
                copyText.setSelectionRange(0, 99999)

                try {
                    navigator.clipboard.writeText(copyText.value);
                    toastify(getPoTranslate('COPIED_TO_CLIPBOARD'))

                } catch (error) {

                    Sentry.captureException(new TryCatchCopyURLPathError(err));

                }
            })

        }

        class TryCatchCopyURLPathError extends Error {
            constructor(message) {
                super(message)
                this.name = "TryCatchCopyURLPathError"
            }
        }


    }



    if (document.getElementsByClassName('backButtonings')[0]) {
        let backButtonings = document.getElementsByClassName('backButtonings')
        for (let i = 0; i < backButtonings.length; i++) {
            backButtonings[i].addEventListener('click', function () {
                history.back()
            })
        }
    }

    if (document.getElementsByClassName('backButtonings2')[0]) {
        let backButtonings = document.getElementsByClassName('backButtonings2')
        for (let i = 0; i < backButtonings.length; i++) {
            backButtonings[i].addEventListener('click', function () {
                closePopup(this.dataset.close)
            })
        }
    }

    if (document.getElementById('loadingCanvas')) {
        processLoading(document.getElementById('loadingCanvas'))
    }

    if (document.getElementById('loadingCanvas2')) {

        processLoading(document.getElementById('loadingCanvas2'))

    }




    if (document.getElementById('loadingCanvas8')) {

        processLoading(document.getElementById('loadingCanvas8'))
    }

    function processLoading(element) {
        let c = element,
            ctx = c.getContext('2d'),
            pi = Math.PI,
            xCenter = c.width / 2,
            yCenter = c.height / 2,
            radius = c.width / 6,
            startSize = radius / 6,
            num = 9,
            posX = [],
            posY = [],
            angle, size, i
        window.setInterval(function () {
            num++
            ctx.clearRect(0, 0, xCenter * 2, yCenter * 2)
            for (i = 0; i < 9; i++) {
                ctx.beginPath()
                ctx.fillStyle = 'rgba(255, 184, 5,.' + i + ')'
                if (posX.length == i) {
                    angle = pi * i * .25
                    posX[i] = xCenter + radius * Math.cos(angle)
                    posY[i] = yCenter + radius * Math.sin(angle)
                }
                ctx.arc(
                    posX[(i + num) % 8],
                    posY[(i + num) % 8],
                    startSize / 9 * i,
                    0, pi * 2, 1)
                ctx.fill()
            }
        }, 50)

    }



    if (document.getElementsByClassName('date_range')[0]) {
        let date_rage = document.getElementsByClassName('date_range')
        loadScript('/frontend/assets/js/lib/hammer.js' + version, function () {

            loadScript('/frontend/assets/js/lib/hammer.fakemultitouch.js' + version, function () {
                loadCss('/frontend/assets/css/drum.css' + version)
                loadScript('/frontend/assets/js/drum.js' + version, function () {
                    function fromHourChange(x) {
                        document.getElementById('fromHours').textContent = x.value
                    }

                    function fromMinuteChange(x) {
                        document.getElementById('fromMinutes').textContent = x.value
                    }

                    function toHourChange(x) {
                        document.getElementById('toHours').textContent = x.value
                    }

                    function toMinuteChange(x) {
                        document.getElementById('toMinutes').textContent = x.value
                    }

                    function pad(number) {
                        if (number < 10) {
                            return '0' + number;
                        }
                        return number;
                    }

                    function update(section, datetime) {

                        jQuery("#" + section + "_hours").drum('setIndex', datetime.getHours());
                        jQuery("#" + section + "_minutes").drum('setIndex', datetime.getMinutes());
                    }

                    let dates = document.getElementsByClassName('date')

                    jQuery(dates).drum({
                        onChange: function (elem) {
                            var section = elem.name.substr(0, elem.name.indexOf("_"));
                            var arr = {
                                'hours': 'setHours',
                                'minutes': 'setMinutes'
                            };
                            var date = new Date();
                            for (var s in arr) {
                                var i = (jQuery("form[name='date_" + section + "'] select[name='" + section + "_" + s + "']"))[0].value;
                                eval("date." + arr[s] + "(" + i + ")");
                            }
                            date.setSeconds(0);
                            update(section, date);

                            var format = pad(date.getHours()) + ':' + pad(date.getMinutes());

                            jQuery('.date_range_' + section + '_header .selection').html(format);
                        }
                    })

                    setTimeout(function () {
                        if (document.getElementById('time-slot-popup')) {
                            setDrums(document.getElementById('time-slot-popup'), '10', '00', '11', '00')
                        }
                        if (document.getElementById('group-talk-form')) {
                            setDrums(document.getElementById('group-talk-form'), '10', '00', '11', '00')
                        }
                    })

                    /* jQuery("select.date").drum({
                        onChange: function (elem) {
                            var section = elem.name.substr(0, elem.name.indexOf("_"));
                            var arr = {
                                'hours': 'setHours',
                                'minutes': 'setMinutes'
                            };
                            var date = new Date();
                            for (var s in arr) {
                                var i = (jQuery("form[name='date_" + section + "'] select[name='" + section + "_" + s + "']"))[0].value;
                                eval("date." + arr[s] + "(" + i + ")");
                            }
                            date.setSeconds(0);
                            update(section, date);

                            var format = pad(date.getHours()) + ':' + pad(date.getMinutes());

                            jQuery('.date_range_' + section + '_header .selection').html(format);
                        }
                    }); */
                    if (document.getElementById('time-slot-popup')) {
                        /* document.getElementById('time-slot-popup').getElementsByClassName('popuper')[0].addEventListener('mouseenter', disableScroll)
                        document.getElementById('time-slot-popup').getElementsByClassName('popuper')[0].addEventListener('mouseleave', enableScroll) */
                    }

                    function disableScroll() {
                        window.addEventListener('DOMMouseScroll', preventDefault, false); // older FF
                        window.addEventListener(wheelEvent, preventDefault, wheelOpt); // modern desktop
                        window.addEventListener('touchmove', preventDefault, wheelOpt); // mobile
                        //window.addEventListener('keydown', preventDefaultForScrollKeys, false);
                    }

                    // call this to Enable
                    function enableScroll() {
                        window.removeEventListener('DOMMouseScroll', preventDefault, false);
                        window.removeEventListener(wheelEvent, preventDefault, wheelOpt);
                        window.removeEventListener('touchmove', preventDefault, wheelOpt);
                        //window.removeEventListener('keydown', preventDefaultForScrollKeys, false);
                    }

                    function preventDefault(e) {
                        e.preventDefault();
                    }

                    function preventDefaultForScrollKeys(e) {
                        if (keys) {


                            if (keys[e.keyCode]) {
                                preventDefault(e);
                                return false;
                            }
                        }
                    }

                    // modern Chrome requires { passive: false } when adding event
                    var supportsPassive = false;
                    try {
                        window.addEventListener("test", null, Object.defineProperty({}, 'passive', {
                            get: function () {
                                supportsPassive = true;
                            }
                        }));
                    } catch (e) { }

                    var wheelOpt = supportsPassive ? {
                        passive: false
                    } : false;
                    var wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';

                    let rollers = document.getElementsByClassName('rollers')

                    for (let i = 0; i < rollers.length; i++) {

                        rollers[i].addEventListener('mouseenter', disableScroll);

                        rollers[i].addEventListener('mouseleave', enableScroll);
                    }

                    function disableScroll2() {
                        // Get the current page scroll position
                        scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                        scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,

                            // if any scroll is attempted, set this to the previous value
                            window.onscroll = function () {
                                window.scrollTo(scrollLeft, scrollTop);
                            };
                    }

                    function enableScroll2() {
                        window.onscroll = function () { };
                    }
                })
            })
        })
        // for(let i = 0; i<date_rage.length; i++){

        // }

    }


    if (document.getElementsByClassName('popuper2')[0]) {
        document.getElementsByClassName('popuper2')[0].addEventListener('click', function (e) {
            e.preventDefault()
            e.stopPropagation()
        })
    }


    if (document.getElementsByClassName('drop-area')[0]) {
        loadScript('/frontend/assets/js/fileUpload.js' + version, function () {

            //this is function for simulating events on html elements
            //we using this function to trigger click on close icon on toastify notifications.
            //i didnt find in toastify documentation where is triggering of close event function, so i added this eventFire function to triger click on close icon
            if (document.getElementById('closeUploadPopup')) {
                document.getElementById('closeUploadPopup').addEventListener('click', function () {
                    eventFire(document.getElementById('uploadImagePopup').getElementsByClassName('closeSpanPopup')[0], 'click');
                })
            }

        })
    }

    if (document.getElementById('firstHeader')) {
        let heightBefore = document.getElementById('textCont').offsetHeight + 'px'

        document.getElementById('textCont').style.height = heightBefore

        if (document.getElementsByClassName('mt161res')[0]) {
            if (window.innerWidth < 768) {
                document.getElementsByClassName('mt161res')[0].style.marginTop = (document.getElementById('firstHeader').offsetHeight + 16) + 'px'
            }
        }

        var handleIntersection = function handleIntersection(entries) {

            entries.map(function (entry) {
                if (entry.isIntersecting) {

                    if (window.innerWidth < 768) {

                        document.getElementById('textCont').style.height = heightBefore
                        document.getElementById('firstHeader').style.height = (32 + 8 + document.getElementById('logoContainers').offsetHeight + document.getElementById('textCont').getElementsByTagName('h4')[0].offsetHeight + document.getElementById('textCont').getElementsByTagName('p')[0].offsetHeight) + 'px'

                        document.getElementById('firstHeader').style.boxShadow = 'none'


                        if (document.getElementsByClassName('ptbo')[0]) {
                            document.getElementById('firstHeader').style.top = '0px'



                        }
                    }

                } else {

                    if (window.innerWidth < 768) {

                        document.getElementById('textCont').style.height = '0px'
                        document.getElementById('firstHeader').style.height = (document.getElementById('logoContainers').offsetHeight + document.getElementById('textCont').offsetHeight + 32) + 'px'
                        document.getElementById('firstHeader').style.boxShadow = '0px 0px 8px -3px, inset 1px -2px 0 -1px rgba(6,4,3,.1)'



                        if (document.getElementsByClassName('ptbo')[0]) {
                            document.getElementById('firstHeader').style.top = '64px'
                        }
                    }
                }
            })
        }

        let targi

        if (document.body.className === 'jtc2_create_profile') {
            targi = document.getElementById('desktopUsername')
        } else if (document.body.className === 'jtc2_add_your_first_talk') {
            targi = document.getElementsByClassName('privateCourseItem')[0] || document.getElementById('intersectActivator')
        } else if (document.body.className === 'jtc2_set_availabilities') {
            targi = document.getElementById('intersectActivator').getElementsByClassName('date-wrap-content')[0]
        } else if (document.body.className === 'jtc2_verify_account') {
            targi = document.getElementById('verification-form')
        } else if (document.body.className === 'jtc2_account_created') {
            targi = document.getElementById('intersectActivator').getElementsByClassName('h3DownloadAppNow')[0]
        }

        var target = targi

        if (target) {
            var observer = new IntersectionObserver(handleIntersection);
            observer.observe(target);
        }



        const divElem = document.querySelector("body");

        const resizeObserver = new ResizeObserver((entries) => {
            for (const entry of entries) {
                if (entry.contentBoxSize) {

                    if (window.innerWidth > 767) {


                        document.getElementById('jtcStep1FormContainer') ? document.getElementById('jtcStep1FormContainer').style.marginTop = '0px' : document.getElementById('intersectActivator').style.marginTop = '0px'
                        let headerText = document.getElementById('textCont')
                        let elementalHeight = (headerText.getElementsByTagName('h4')[0].offsetHeight + headerText.getElementsByTagName('p')[0].offsetHeight + 8)

                        document.getElementById('firstHeader').style.height = (32 + document.getElementById('logoContainers').offsetHeight + elementalHeight) + 'px'

                        headerText.style.height = (headerText.getElementsByTagName('h4')[0].offsetHeight + headerText.getElementsByTagName('p')[0].offsetHeight + 8) + 'px'
                    } else if (window.innerWidth < 768) {


                        let headerText = document.getElementById('textCont')
                        let elementalHeight = (headerText.getElementsByTagName('h4')[0].offsetHeight + headerText.getElementsByTagName('p')[0].offsetHeight + 8)
                        headerText.style.height = elementalHeight + 'px'


                        document.getElementById('firstHeader').style.height = (32 + document.getElementById('logoContainers').offsetHeight + elementalHeight) + 'px'
                        document.getElementById('jtcStep1FormContainer') ? document.getElementById('jtcStep1FormContainer').style.marginTop = (8 + 32 + document.getElementById('logoContainers').offsetHeight + elementalHeight) + 'px' : document.getElementById('intersectActivator').style.marginTop = (8 + 32 + document.getElementById('logoContainers').offsetHeight + elementalHeight) + 'px'
                    }
                }
            }
        });

        resizeObserver.observe(divElem);

    }

    if (document.getElementById('webCamContTakePic')) {
        document.getElementsByClassName('takePictureWithWebCam')[0].addEventListener('click', function () {

            if (document.getElementsByClassName('icon-deletes')[0]) {
                let iconDeletes = document.getElementsByClassName('icon-deletes')
                for (let i = 0; i < iconDeletes.length; i++) {
                    iconDeletes[i].click()
                }
            }

            let width = 320
            let height = 0
            let streaming = false

            let video = document.getElementById('video')
            var canvas = document.getElementById('canvas')
            let photo = document.getElementById('photo')
            let photo2 = document.getElementById('photo2')
            let startbutton = document.getElementById('startbutton')

            const videoElement = document.getElementById('video')
            //const audioInputSelect = document.querySelector('select#audioSource')
            //const audioOutputSelect = document.getElementById('audioOutput')
            const videoSelect = document.getElementById('videoSource')
            const selectors = [ /*audioInputSelect, audioOutputSelect,*/ videoSelect]

            //audioOutputSelect.disabled = !('sinkId' in HTMLMediaElement.prototype)

            function gotDevices(deviceInfos) {
                // Handles being called several times to update labels. Preserve values.
                const values = selectors.map(select => select.value)

                selectors.forEach(select => {
                    while (select.firstChild) {
                        select.removeChild(select.firstChild)
                    }
                });

                for (let i = 0; i !== deviceInfos.length; ++i) {
                    const deviceInfo = deviceInfos[i]
                    const option = document.createElement('option')
                    option.value = deviceInfo.deviceId
                    /* if (deviceInfo.kind === 'audioinput') {
                        option.text = deviceInfo.label || `microphone ${audioInputSelect.length + 1}`;
                        audioInputSelect.appendChild(option);
                    } else if (deviceInfo.kind === 'audiooutput') {
                        option.text = deviceInfo.label || `speaker ${audioOutputSelect.length + 1}`
                        audioOutputSelect.appendChild(option)
                    } else */
                    if (deviceInfo.kind === 'videoinput') {
                        option.text = deviceInfo.label || `camera ${videoSelect.length + 1}`
                        videoSelect.appendChild(option)
                    }
                }
                selectors.forEach((select, selectorIndex) => {
                    if (Array.prototype.slice.call(select.childNodes).some(n => n.value === values[selectorIndex])) {
                        select.value = values[selectorIndex]
                    }
                });
            }

            navigator.mediaDevices.enumerateDevices().then(gotDevices).catch(handleError)


            function gotStream(stream) {
                window.stream = stream // make stream available to console
                videoElement.srcObject = stream
                // Refresh button list in case labels have become available
                return navigator.mediaDevices.enumerateDevices()
            }

            function handleError(error) {
                toastify(error.message)
            }

            function start() {
                if (window.stream) {
                    window.stream.getTracks().forEach(track => {
                        track.stop()
                    });
                }
                //const audioSource = audioInputSelect.value;
                const videoSource = videoSelect.value;
                const constraints = {
                    audio: false,
                    video: { deviceId: videoSource ? { exact: videoSource } : undefined }
                };
                navigator.mediaDevices.getUserMedia(constraints).then(gotStream).then(gotDevices).catch(handleError)
            }

            //audioInputSelect.onchange = start;
            //audioOutputSelect.onchange = changeAudioDestination;

            videoSelect.onchange = start

            video.addEventListener('canplay', function () {
                if (!streaming) {
                    height = video.videoHeight / (video.videoWidth / width);

                    // Firefox currently has a bug where the height can't be read from
                    // the video, so we will make assumptions if this happens.

                    if (isNaN(height)) {
                        height = width / (4 / 3)
                    }
                    /*
                    video.setAttribute('width', width)
                    video.setAttribute('height', height) */
                    video.style.width = '100%'
                    video.style.height = '100%'
                    /*
                    canvas.setAttribute('width', width)
                    canvas.setAttribute('height', height) */
                    canvas.style.width = '100%'
                    canvas.style.height = '100%'
                    streaming = true;

                    calculatePopUpHeight(document.getElementById('takePictureWithWebCam'), 52)

                }
            }, false);

            if (typeof document.getElementById('startbutton').dataset.event === 'undefined') {
                document.getElementById('startbutton').dataset.event = 1
                startbutton.addEventListener('click', takePhotoEvent, false)
            }


            function takePhotoEvent(e) {
                e.currentTarget.dataset.event = 1


                takepicture()
                e.preventDefault()

            }

            function clearphoto(e) {

                var context = canvas.getContext('2d')
                context.fillStyle = "#AAA"
                context.fillRect(0, 0, canvas.width, canvas.height)

                var data = canvas.toDataURL('image/jpeg')
                photo.setAttribute('src', data)
            }

            function takePictureHelper(e) {

                e.currentTarget.dataset.event = 1
                showLoading()

                comunicationControler.uploadFile(window.blobObj)

                window.blobObj = ''


                takePictureAgainFunction(e)

            }

            window.takePictureAgainFunction = function (e) {

                if (document.getElementsByClassName('takePictureAgain')[0]) {
                    let takePictureAgainButtons = document.getElementsByClassName('takePictureAgain')
                    for (let i = 0; i < takePictureAgainButtons.length; i++) {
                        takePictureAgainButtons[i].dataset.event = '0'
                    }
                }

                takePictureAgainHelper()

                start()

                setTimeout(function () {
                    calculatePopUpHeight(document.getElementById('takePictureWithWebCam'), 52)
                }, 310)

                if (window.cropper) {
                    for (let i = 0; i < window.cropper.length; i++) {
                        window.cropper[i].destroy()

                    }
                }
                clearAfterDestroyCropper()
            }

            window.takePictureAgainHelper = function () {

                document.getElementById('videoSourceSelect').classList.remove('dn')
                document.getElementById('videoSourceInput').classList.remove('dn')
                document.getElementById('takePhotoButton').classList.remove('dn')

                document.getElementById('submitButton').classList.add('dn')
                document.getElementById('takePictureAgain').classList.add('dn')
                document.getElementById('photo').src = ''
                document.getElementById('photo2').src = ''
                if (typeof document.getElementById('startbutton').dataset.event === 'undefined') {
                    document.getElementById('startbutton').dataset.event = 1
                    startbutton.addEventListener('click', takePhotoEvent)
                }
                window.blobObj = ''

            }

            // Capture a photo by fetching the current contents of the video
            // and drawing it into a canvas, then converting that to a PNG
            // format data URL. By drawing it on an offscreen canvas and then
            // drawing that to the screen, we can change its size and/or apply
            // other changes before drawing it.
            if (document.getElementsByClassName('webCampPopup')[0]) {
                let webCampPopups = document.getElementsByClassName('webCampPopup')
                for (let i = 0; i < webCampPopups.length; i++) {
                    webCampPopups[i].addEventListener('click', closeWebcam)
                }
            }

            function closeWebcam(e) {

                let webCampPopups = document.getElementsByClassName('webCampPopup')
                for (let i = 0; i < webCampPopups.length; i++) {
                    webCampPopups[i].removeEventListener('click', closeWebcam)
                }

                takePictureAgainHelper()

                if (e.target.classList.contains('closeSpanPopup')) {
                    e.target.parentElement.parentElement.getElementsByClassName('popuper')[0].style.transform = 'scale(0)'
                    e.target.parentElement.parentElement.style.opacity = '0'

                    setTimeout(function () {
                        e.target.parentElement.parentElement.style.display = 'none'
                        e.target.parentElement.parentElement.dataset.opened = "0"
                    }, 310)
                } else {
                    e.target.getElementsByClassName('popuper')[0].style.transform = 'scale(0)'
                    e.target.style.opacity = '0'

                    setTimeout(function () {
                        e.target.style.display = 'none'
                        e.target.dataset.opened = "0"
                    }, 310)
                }


                if (window.stream) {
                    window.stream.getTracks().forEach(track => {
                        track.stop();
                    });
                }
            }

            function takepicture() {


                var context = canvas.getContext('2d');
                if (width && height) {

                    canvas.width = document.getElementById('video').offsetWidth
                    canvas.height = document.getElementById('video').offsetHeight

                    context.drawImage(video, 0, 0, document.getElementById('video').offsetWidth, document.getElementById('video').offsetHeight);

                    canvas.toBlob(function (blob) {

                        var newImg = document.createElement('img'),
                            url = URL.createObjectURL(blob);

                        window.blobObj = blob

                        newImg.onload = function () {
                            // no longer need to read the blob so it's revoked
                            URL.revokeObjectURL(url);
                        }

                        photo2.setAttribute('src', url);



                        let croppero = new Cropper(document.getElementById('photo2'), {
                            aspectRatio: 1 / 1,
                            minCropBoxWidth: 300,
                            minCropBoxHeight: 300,
                            crop(event) {

                                let kr = croppero.getCroppedCanvas()

                                if (kr) {
                                    let initialAvatarURL = kr.toBlob(function (blobObject) {

                                        window.blobObj = blobObject
                                    })
                                }





                            },
                        })
                        window.cropper.push(croppero)









                    })



                    document.getElementById('videoSourceSelect').classList.add('dn')
                    document.getElementById('videoSourceInput').classList.add('dn')
                    document.getElementById('takePhotoButton').classList.add('dn')

                    document.getElementById('submitButton').classList.remove('dn')
                    document.getElementById('takePictureAgain').classList.remove('dn')

                    if (window.stream) {
                        window.stream.getTracks().forEach(track => {
                            track.stop()
                        });
                    }

                    if (typeof document.getElementById('takePictureAgain').dataset.event === 'undefined' || document.getElementById('takePictureAgain').dataset.event === '0') {
                        document.getElementById('takePictureAgain').addEventListener('click', takePictureAgainFunction)
                    }

                    if (typeof document.getElementById('submitButton').dataset.event === 'undefined' || document.getElementById('submitButton').dataset.event === '0') {
                        document.getElementById('submitButton').addEventListener('click', takePictureHelper)
                    }


                    setTimeout(function () {
                        calculatePopUpHeight(document.getElementById('takePictureWithWebCam'), 52)
                    }, 310)


                } else {

                    clearphoto()
                    hideLoading()
                }
            }

            start()

        })

    }

    if (document.getElementsByClassName('qrGeneration')[0]) {
        loadCss("/frontend/assets/css/qrCodeGen.css" + version)
        loadScript("/frontend/assets/js/lib/qrcode.js" + version, function () {

            if (document.getElementsByClassName('shbt')[0]) {

                let shbts = document.getElementsByClassName('shbt')
                for (let i = 0; i < shbts.length; i++) {
                    shbts[i].addEventListener('click', function () {

                        if (shbts[i].classList.contains('shbtt2')) {
                            window.sharePopupTakl = 3
                        } else {
                            window.sharePopupTakl = 1
                        }


                        if (shbts[i].classList.contains('teacherShare')) {
                            if (!window.teacherShareHelper) {
                                window.teacherShareHelper = document.getElementById('shareProfilePopUp2').getElementsByClassName('profile-path-holder')[0].value

                                document.getElementById('shareProfilePopUp2').getElementsByClassName('profile-path-holder')[0].value = document.getElementById('teacherSharingDomain').textContent + document.getElementById('languageTexter').textContent

                            }

                        } else {
                            if (shbts[i].classList.contains('zi999')) {

                            } else {
                                if (window.teacherShareHelper) {
                                    document.getElementById('shareProfilePopUp2').getElementsByClassName('profile-path-holder')[0].value = window.teacherShareHelper
                                }

                            }

                        }
                    })

                }


            }

            if (document.getElementsByClassName('supikar')[0]) {
                document.getElementsByClassName('supikar')[0].addEventListener('click', function () {

                    window.sharePopupTakl = 0
                })
            }




            let k1ffs = document.getElementsByClassName('k1ff')
            for (let i = 0; i < k1ffs.length; i++) {
                k1ffs[i].classList.remove('dn')

            }

            let qrCodes = document.getElementsByClassName('qrGeneration')
            for (let i = 0; i < qrCodes.length; i++) {
                qrCodes[i].addEventListener('click', function () {

                    let parent = qrCodes[i].parentElement.parentElement.parentElement.parentElement.parentElement


                    parent.getElementsByClassName('qrCodeDiv')[0].classList.remove('dn')


                    parent.getElementsByClassName('realQr')[0].innerHTML = ''
                    parent.getElementsByClassName('realQr')[0].title = ''

                    let qrPoint = parent.getElementsByClassName('realQr')[0].id

                    if (window.sharePopupTakl === 3) {
                        qrPoint = 'qrcode4'
                    }

                    let QR_CODE = new QRCode(qrPoint, {
                        width: 260,
                        height: 260,
                        colorDark: "#000000",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H,
                    })

                    parent.getElementsByClassName('qrCodeDiv')[0].getElementsByClassName('realQr')[0].classList.add('dn')

                    let k1ffs = document.getElementsByClassName('k1ff')

                    for (let i = 0; i < k1ffs.length; i++) {
                        k1ffs[i].classList.add('dn')
                    }

                    let closeQRs = document.getElementsByClassName('closeQR')
                    for (let i = 0; i < closeQRs.length; i++) {
                        closeQRs[i].classList.add('dn')
                    }

                    let closeQR = parent.getElementsByClassName('closeQR')[0]

                    if (window.addCompletedTalkToAvailability === 1) {

                        document.getElementsByClassName('white-box-share')[0].classList.add('dn')

                        closeQR.addEventListener('click', function () {

                            let that = this


                            closeQR.classList.add('dn')
                            document.getElementsByClassName('white-box-share')[0].classList.remove('dn')
                            that.parentElement.classList.add('dn')
                            that.parentElement.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')
                            parent.getElementsByClassName('qrCodeDiv')[0].classList.add('dn')

                            calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)



                        })


                        parent.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')
                        generateQRCode(location.origin + '/' + document.getElementById('usernameValue').textContent.trim() + '/talk/' + window.addCompletedTalkToAvailabilityId, QR_CODE)
                        closeQR.classList.remove('dn')
                        calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)

                    } else if (window.sharePopupTakl === 0) {

                        if (typeof closeQR.dataset.added === 'undefined') {
                            closeQR.addEventListener('click', function () {

                                let that = this

                                closeQR.dataset.added = '1'
                                closeQR.classList.add('dn')
                                that.parentElement.parentElement.parentElement.getElementsByClassName('secerr')[0]?.classList.remove('dn')
                                that.parentElement.classList.add('dn')
                                that.parentElement.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')
                                parent.getElementsByClassName('qrCodeDiv')[0].classList.add('dn')
                                parent.parentElement.parentElement.parentElement.parentElement.getElementsByClassName('firsterShare')[0].getElementsByTagName('h5')[0].classList.remove('dn')
                                calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)



                            })
                        }


                        parent.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')

                        generateQRCode(parent.getElementsByClassName('profile-path-holder')[0].value, QR_CODE)


                        closeQR.classList.remove('dn')
                        calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)


                    } else if (window.sharePopupTakl === 1) {

                        if (typeof closeQR.dataset.added === 'undefined') {

                            closeQR.addEventListener('click', function () {

                                let that = this

                                closeQR.classList.add('dn')
                                that.parentElement.parentElement.parentElement.getElementsByClassName('secerr')[0]?.classList.remove('dn')
                                that.parentElement.classList.add('dn')
                                that.parentElement.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')
                                parent.getElementsByClassName('qrCodeDiv')[0].classList.add('dn')
                                if (document.getElementsByClassName('fisterkano')[0]) {


                                    if (document.getElementsByClassName('fisterkano')[0].getElementsByClassName('k1ff')[0]) {


                                        let kifs = document.getElementsByClassName('fisterkano')[0].getElementsByClassName('k1ff')
                                        for (let i = 0; i < kifs.length; i++) {
                                            kifs[i].classList.remove('dn')
                                        }
                                    }
                                }

                                calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)



                            })
                            closeQR.dataset.added = '1'
                        }

                        parent.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')

                        generateQRCode(parent.getElementsByClassName('profile-path-holder')[0].value, QR_CODE)

                        calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)

                        closeQR.classList.remove('dn')
                    } else if (window.sharePopupTakl === 3) {

                        if (typeof closeQR.dataset.added === 'undefined') {

                            closeQR.addEventListener('click', function () {

                                let that = this

                                closeQR.classList.add('dn')
                                that.parentElement.parentElement.parentElement.getElementsByClassName('secerr')[0]?.classList.remove('dn')
                                that.parentElement.classList.add('dn')
                                that.parentElement.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')
                                parent.getElementsByClassName('qrCodeDiv')[0].classList.add('dn')
                                if (document.getElementsByClassName('fisterkano')[0]) {


                                    if (document.getElementsByClassName('fisterkano')[0].getElementsByClassName('k1ff')[0]) {


                                        let kifs = document.getElementsByClassName('fisterkano')[0].getElementsByClassName('k1ff')
                                        for (let i = 0; i < kifs.length; i++) {
                                            kifs[i].classList.remove('dn')
                                        }
                                    }
                                }

                                calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)

                                document.getElementById('profileShareElement').classList.remove('dn')

                            })
                            closeQR.dataset.added = '1'
                        }

                        parent.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')

                        generateQRCode(parent.getElementsByClassName('profile-path-holder')[0].value, QR_CODE)

                        calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)


                    } else {
                        closeQR.classList.remove('dn')
                        if (typeof closeQR.dataset.added === 'undefined') {

                            closeQR.addEventListener('click', function () {

                                let that = this

                                closeQR.classList.add('dn')

                                let firsterShares = document.getElementById('shareProfilePopUp24').getElementsByClassName('firsterShare')
                                for (let i = 0; i < firsterShares.length; i++) {
                                    firsterShares[i].classList.remove('dn')

                                }

                                that.parentElement.parentElement.parentElement.getElementsByClassName('secerr')[0]?.classList.remove('dn')

                                that.parentElement.classList.add('dn')

                                that.parentElement.parentElement.getElementsByClassName('k1ff')[0].classList.remove('dn')

                                parent.getElementsByClassName('qrCodeDiv')[0].classList.add('dn')


                                calculatePopUpHeight(parent.parentElement.parentElement.parentElement.parentElement)



                            })
                            closeQR.dataset.added = '1'
                        }


                    }

                    generateQRCode(parent.getElementsByClassName('profile-path-holder')[0].value, QR_CODE)

                    parent.getElementsByClassName('qrCodeDiv')[0].classList.remove('dn')

                    parent.getElementsByClassName('qrCodeDiv')[0].getElementsByClassName('realQr')[0].classList.remove('dn')





                })

            }

            function generateQRCode(data, QR_CODE) {

                QR_CODE.clear()
                QR_CODE.makeCode(data)

            }

        })
    }

    if (document.getElementsByClassName('bankTansferStuff')[0]) {
        document.getElementsByClassName('bankTansferStuff')[0].addEventListener('click', function () {

            document.getElementsByClassName('bankTansferStuffInner')[0]?.getElementsByClassName('circle-check')[0]?.classList.remove('dn') ?? ''
            document.getElementsByClassName('checekrPayPalPayouout')[0]?.classList.add('dn')
            if (this.dataset.opened === "0") {

                this.style.height = '253px';


                this.getElementsByClassName('mobileStep4Form')[0].style.height = '192px'

                addPreventDefault(document.getElementsByClassName('mobileStep4Form')[0].elements)

                this.dataset.opened = "1"

                if (document.body.className === 'settings_payouts_page') {
                    calculatePopUpHeight(document.getElementById('chosePaymentMethodPopup'), 52, 582)
                }

            } else if (this.dataset.opened === "1") {

                this.style.height = '82px';


                this.getElementsByClassName('mobileStep4Form')[0].style.height = '0px'

                removePreventDefault(document.getElementsByClassName('mobileStep4Form')[0].elements)

                this.dataset.opened = "0"
                if (document.body.className === 'settings_payouts_page') {
                    calculatePopUpHeight(document.getElementById('chosePaymentMethodPopup'), 52, 373)
                }
            }


        })
    }

    function addPreventDefault(arrayOfFormElements) {
        for (let i = 0; i < arrayOfFormElements.length; i++) {
            arrayOfFormElements[i].addEventListener('click', eventHelperFunction)
        }
    }

    function removePreventDefault(arrayOfFormElements) {
        for (let i = 0; i < arrayOfFormElements.length; i++) {
            arrayOfFormElements[i].removeEventListener('click', eventHelperFunction)
        }
    }

    function eventHelperFunction(e) {
        e.preventDefault()
        e.stopPropagation()
        e.stopImmediatePropagation()
    }

    if (document.getElementById('changeAvailability')) {
        if (document.getElementById('changeAvailability').getElementsByClassName('date-time')[0]) {


            allClickableTimeSlot()



        }
    }


    if (document.getElementsByClassName('date-scheduler-wrap')[0]) {

        let dateSchedulerWrap = document.getElementsByClassName('date-scheduler-wrap')

        for (let i = 0; i < dateSchedulerWrap.length; i++) {

            let date7DaysTA = dateSchedulerWrap[i].getElementsByTagName('div')
            for (let i = 0; i < date7DaysTA.length; i++) {
                date7DaysTA[i].addEventListener('click', function () {
                    for (let i = 0; i < date7DaysTA.length; i++) {
                        date7DaysTA[i].className = ''
                    }
                    this.className = 'active'
                })
            }
        }

        let date7DaysTA = document.getElementsByClassName('date-scheduler-wrap')[0].getElementsByTagName('div')
        for (let i = 0; i < date7DaysTA.length; i++) {
            date7DaysTA[i].addEventListener('click', function () {
                for (let i = 0; i < date7DaysTA.length; i++) {
                    date7DaysTA[i].className = ''
                }
                this.className = 'active'
            })
        }
    }

    if (document.getElementsByClassName('optionButton')[0]) {
        /*  optionButton.optionButton() */
        loadScript('/frontend/assets/js/optionButton.js' + version, function () {
            optionButton2()
        })
    }

    if (document.getElementById('cookieCont')) {
        cookieNotice.cookieButtons()
    }

    if (document.getElementById('scroller')) {
        scrollToTop.scrollToTop()
    }



    if (document.getElementById('categoryCarousel')) {

        let categoryCarousel = document.getElementById('categoryCarousel')

        let defaultCarousel = jQuery(categoryCarousel);
        defaultCarousel.owlCarousel({

            loop: false,
            nav: false,
            dots: false,
            stagePadding: 10,
            autoWidth: true,
            responsive: {
                0: {
                    items: 1
                },
                320: {
                    items: 2
                },
                640: {
                    items: 3
                },
                768: {
                    items: 4
                },
                870: {
                    items: 5
                },
                1024: {
                    items: 6
                },
                1280: {
                    items: 7
                }

            }
        });

        setTimeout(function () {
            let w3000 = document.getElementsByClassName('width3000')

            for (let i = 0; i < w3000.length; i++) {
                w3000[i].classList.remove('width3000')
                w3000[i].classList.add('w-100')
            }

            categoryCarousel.style.opacity = '1'
        }, 10)




    }



    if (document.getElementsByClassName('defaultCarousel')[0]) {
        let defaultCarousels = document.getElementsByClassName('defaultCarousel')
        for (let i = 0; i < defaultCarousels.length; i++) {
            let defaultCarousel = jQuery(defaultCarousels[i]);
            defaultCarousel.owlCarousel({

                // autoplay: true,


                center: true,
                loop: true,
                nav: false,
                dots: false,

                responsive: {
                    0: {
                        items: 1,
                        stagePadding: 20,
                        margin: 15
                    },
                    320: {
                        items: 1,
                        stagePadding: 40,
                        margin: 20
                    },
                    360: {
                        items: 1,
                        stagePadding: 60,
                        margin: 30
                    },
                    400: {
                        items: 1,
                        stagePadding: 70,
                        margin: 30
                    },
                    1024: {
                        items: 2,
                        stagePadding: 130,
                        margin: 33

                    },
                    1140: {
                        items: 2,
                        stagePadding: 150,
                        margin: 33

                    }

                }
            });

            setTimeout(function () {
                defaultCarousels[i].style.opacity = '1'
            }, 10)
        }

    }


    if (document.getElementById('payStripeConts')) {
        document.getElementById('payStripeConts')
        if (document.getElementById('stripeerCont') && document.getElementById('paypalerCont')) {
            if (document.getElementById('stripeerButton') && document.getElementById('paypalerButton')) {

                let payPallTabButton = document.getElementById('paypalerButton')
                let stripeTabButton = document.getElementById('stripeerButton')

                payPallTabButton.addEventListener('click', function () {
                    document.getElementById('stripeerCont').classList.add('dn')
                    document.getElementById('paypalerCont').classList.remove('dn')
                    calculatePopUpHeight(document.getElementById('addCoinsPaymentPopUp'))

                    document.getElementById('paymentTabsUl').getElementsByClassName('is-active')[0].classList.remove('is-active')
                    this.parentElement.classList.add('is-active')
                    document.getElementById('add_wallet_booking_cachier')?.parentElement?.classList.add('dn')

                    calculatePopUpHeight(document.getElementById('paymentWalletPopUp'), 10)
                })

                stripeTabButton.addEventListener('click', function () {
                    document.getElementById('stripeerCont').classList.remove('dn')
                    document.getElementById('paypalerCont').classList.add('dn')
                    calculatePopUpHeight(document.getElementById('addCoinsPaymentPopUp'))

                    document.getElementById('paymentTabsUl').getElementsByClassName('is-active')[0].classList.remove('is-active')
                    this.parentElement.classList.add('is-active')
                    document.getElementById('add_wallet_booking_cachier')?.parentElement?.classList.remove('dn')

                    calculatePopUpHeight(document.getElementById('paymentWalletPopUp'), 10)
                })
            }

        }
    }

    if (document.getElementById('goBack')) {
        document.getElementById('goBack').addEventListener('click', function () {
            window.history.back()
        })
    }

    if (document.getElementsByClassName('fButtonCont')[0]) {

        if (document.body.className !== "favorites_talks" && document.body.className !== "favorites_users") {
            window.addEventListener('resize', checkIfFilterButtonIsOpenedBeforeResize)
        } else {
            window.addEventListener('resize', function () {
                if (window.innerWidth < 768) {
                    if (window.filterOpened == "1") {
                        document.getElementsByClassName('desktopContainer')[0].style.opacity = '0'
                        closeFilter()
                    }
                } else if (window.innerWidth > 1023) {
                    if (window.filterOpened == "1") {
                        document.getElementsByClassName('desktopContainer')[0].style.opacity = '0'
                        showLoading()
                        closeFilter()
                        setTimeout(function () {
                            document.getElementsByClassName('desktopContainer')[0].style.opacity = '1'
                            hideLoading()
                        }, 610)
                    } else {
                        document.getElementsByClassName('desktopContainer')[0].style.opacity = '1'
                    }
                }
            })
        }

        function checkIfFilterButtonIsOpenedBeforeResize() {
            if (window.filterOpened === 1) {
                if (window.innerWidth < 769) {
                    window.filterOpenedHelper = 0
                    closeFilter()
                    if (document.body.className === 'talkCategorySubcategory') {
                        openNewFilter()
                    }

                } else if (window.innerWidth > 768 && window.innerWidth < 1024) {

                    if (window.filterOpenedHelper === 1) {

                        openFilter()
                    }



                } else if (window.innerWidth > 1023) {
                    if (window.filterOpenedHelper != 1) {
                        if (document.getElementsByClassName('mainSearchContainerZ')[0]) {
                            document.getElementsByClassName('mainSearchContainerZ')[0].style.opacity = '0'
                        }

                        showLoading()
                        closeFilter()
                        window.filterOpenedHelper = 1

                        setTimeout(function () {
                            if (document.getElementsByClassName('mainSearchContainerZ')[0]) {
                                document.getElementsByClassName('mainSearchContainerZ')[0].style.opacity = '1'
                            }

                            hideLoading()
                        }, 620)
                    }

                }
            } else if (window.filterOpenedHelper === 1) {
                if (window.innerWidth < 769) {


                    if (document.body.className === 'talkCategorySubcategory') {
                        openNewFilter()
                    }
                    window.filterOpenedHelper = 0
                } else if (window.innerWidth > 768 && window.innerWidth < 1024) {

                    openFilter()
                    window.filterOpenedHelper = 0

                } else if (window.innerWidth > 1023) {

                }
            }
        }

        document.getElementsByClassName('fButtonCont')[0].addEventListener('click', function () {

            if (window.filterOpened != "1") {

                openFilter()
            } else if (window.filterOpened == "1") {

                closeFilter()
            }

        })

    }


}

function openFilter() {
    let background = document.createElement('div')
    background.className = 'popupBase'
    background.id = 'bgFilter'
    background.style.cssText = 'left:-1250px; display:block; opacity:1; transition:0.6s; z-index:99999;'

    document.getElementsByTagName('header')[0].append(background)
    document.getElementById('filterTalks').classList.add('filterOpens')

    setTimeout(function () {
        document.getElementById('bgFilter').style.left = '0px'
        document.getElementById('bgFilter').insertBefore(document.getElementById('filterTalks'), document.getElementById('bgFilter').firstChild)
    }, 0)
    setTimeout(function () {
        document.getElementById('filterTalks').style.left = '0px'
        document.getElementsByClassName('submitFilterParent')[0].style.bottom = '0px'
    }, 240)

    document.getElementsByClassName('fButtonCont')[0].getElementsByTagName('p')[0].textContent = getPoTranslate('CLOSE_FILTER')
    document.getElementsByClassName('svgFilterDiv')[0].getElementsByTagName('svg')[0].style.left = '+100px'
    document.getElementsByClassName('svgFilterDiv')[0].getElementsByTagName('svg')[1].style.left = '-12px'

    document.getElementsByClassName('fButtonCont')[0].dataset.opened = "1"
    window.filterOpened = 1
}

