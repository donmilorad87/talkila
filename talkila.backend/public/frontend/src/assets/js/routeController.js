import {
    calendarLogics,
    followFunction,
    followUnfollowUserOptions,
    showMoreFavoriteUsers,
    showMoreNotifications,
    removePrivateFollower,
    acceptFollowRequest,
    showHideCalendarBigSmall
} from './routeHelpers.js';



import {
    deleteCards,
    extendTalkPaymentInitialize,
    initializePayPal,
    initializeStripe,
    selectCardForPayment,
    selectDefaultCard
} from './payment.js';

import {
    deleteTalk,
    pauseTalks
} from './talks.js';

import {
    loggedOutHome,
    showMoreTalks
} from './loggedOut.js';

import {
    getTalkData
} from './comunicationControler.js';



function logged_inF() {


    talksAndAvailabilityF();
    pauseTalks();

    //intersectionObserveer for scrolling header
    const target = document.getElementById('buttonConta');

    function handleIntersection(entries) {
        entries.map((entry) => {
            if (entry.isIntersecting) {

                document.getElementById('intersectTester').style.top = '-100px'
            } else {

                document.getElementById('intersectTester').style.top = '0px'

            }
        });
    }

    const observer = new IntersectionObserver(handleIntersection);

    observer.observe(target);

    calendarLogics()

    const queryString = window.location.search
    const urlParams = new URLSearchParams(queryString)
    const code = urlParams.get('code')

    if (code) {
        history.pushState({}, document.title, location.origin + location.pathname)
    }

    if (document.getElementsByClassName('shareTalk')[0]) {
        let shareTalks = document.getElementsByClassName('shareTalk')
        for (let i = 0; i < shareTalks.length; i++) {
            shareTalks[i].addEventListener('click', function () {

                let talkId = shareTalks[i].parentElement.getElementsByClassName('dataTalkId')[0].dataset.talkId
                let talkName = shareTalks[i].parentElement.getElementsByClassName('headlineTextSpecific')[0].textContent
                let talkIdHolder = document.getElementById('shareProfilePopUp').getElementsByClassName('profile-path-holder22')[0]

                talkIdHolder.value = talkIdHolder.value.substring(0, talkIdHolder.value.lastIndexOf('/')) + '/' + talkId

                let nativeShareLink = document.getElementById('shareProfilePopUp').getElementsByClassName('nativeSharez')[0]
                nativeShareLink.dataset.link = nativeShareLink.dataset.linker + talkId

                let talkSherers = document.getElementById('shareProfilePopUp').getElementsByClassName('talkSherer')
                for (let i = 0; i < talkSherers.length; i++) {
                    talkSherers[i].href = talkSherers[i].href + talkId

                }

                let talk_headline = document.getElementById('shareProfilePopUp').getElementsByClassName('talk_headline')[0]
                talk_headline.textContent = talkName
            })

        }

        if (document.getElementById('shareProfilePopUp')) {
            document.getElementById('shareProfilePopUp').addEventListener('click', function () {
                closeQrs()
            })

            document.getElementById('shareProfilePopUp').getElementsByClassName('closeSpanPopup')[0].addEventListener('click', function () {
                closeQrs()
            })
        }

        function closeQrs() {
            document.getElementById('shareProfilePopUp').getElementsByClassName('closeQR')[0].click()
        }
    }

}

function homeF() {
    loggedOutHome();

    loadScript('/frontend/assets/js/accordion.js' + version, function () {

    });
}

function faqF() {

    loadScript('/frontend/assets/js/accordion.js' + version, function () {

    });
}

function profileF() {

    loadScript('/frontend/assets/js/accordion.js' + version, function () {

    });

    followUnfollowUserOptions();
    showMoreTalks();

    if (document.getElementsByClassName('playButtonProfile')[0]) {
        document.getElementsByClassName('playButtonProfile')[0].addEventListener('click', function () {
            showLoading()



            let helpDiv = document.createElement('div')
            helpDiv.innerHTML = document.getElementById('youTubeIframe').value

            let srcs = helpDiv.getElementsByTagName('iframe')[0].src
            helpDiv.getElementsByTagName('iframe')[0].src = srcs.split('?')[0].split('&')[0].split('#')[0]


            document.getElementById('innerVideoContainer').innerHTML = helpDiv.innerHTML
            setTimeout(function () {
                openPopup('videoPopup')
                setTimeout(function () {
                    hideLoading()
                })
            }, 510)

        })
    }
    if (document.getElementsByClassName('closinger')[0]) {
        document.getElementsByClassName('closinger')[0].addEventListener('click', function () {
            closePopup('videoPopup');
            document.getElementById('innerVideoContainer').innerHTML = '';
        });
    }

    if (document.getElementsByClassName('userBlcok')[0]) {

        let userBlocks = document.getElementsByClassName('userBlcok')


        window.userUnblock = function (e) {


            showLoading()
            let xhr = new XMLHttpRequest()
            let url = envAppBackendUrl + '/user-unblock'

            let params = {
                '_token': token,
                'teacher_id': e.dataset.userId
            }


            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.response)

                    if (response.success === true) {
                        for (let j = 0; j < userBlocks.length; j++) {
                            userBlocks[j].textContent = getPoTranslate('BLOCK')
                            userBlocks[j].removeEventListener('click', userUnblock)
                            userBlocks[j].setAttribute('onClick', 'userBlock(this)')
                        }

                        document.getElementsByClassName('thisUserIsBlocked')[0].classList.add('dn')


                        toastify(response.message)


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

        window.userBlock = function (e) {

            showLoading()
            let xhr = new XMLHttpRequest()
            let url = envAppBackendUrl + '/user-block'

            let params = {
                '_token': token,
                'teacher_id': e.dataset.userId
            }


            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.response)

                    if (response.success === true) {
                        for (let j = 0; j < userBlocks.length; j++) {
                            userBlocks[j].textContent = getPoTranslate('UNBLOCK')
                            userBlocks[j].removeEventListener('click', userBlock)
                            userBlocks[j].setAttribute('onClick', 'userUnblock(this)')
                        }

                        document.getElementsByClassName('thisUserIsBlocked')[0].classList.remove('dn')



                        toastify(response.message)


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


    }


    if (document.getElementsByClassName('openShareForTeacher')[0]) {
        let openShareForTeacher = document.getElementsByClassName('openShareForTeacher')
        for (let i = 0; i < openShareForTeacher.length; i++) {

            openShareForTeacher[i].addEventListener('click', function () {
                window.sharePopupTakl = 1
                openPopup('shareProfilePopUpEr')
                let hiddenElements = document.getElementById('shareProfilePopUpEr').getElementsByClassName('k1ff')
                for (let i = 0; i < hiddenElements.length; i++) {
                    hiddenElements[i].classList.remove('dn')

                }
            })

        }

    }

    // block unblock flow
    if (document.getElementsByClassName('cancelRequest')[0]) {

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

                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response)

                        if (response.success === true) {

                            let followingPendingButtons = document.getElementsByClassName('followingPending')
                            for (let i = (followingPendingButtons.length - 1); i >= 0; i--) {
                                let newFollowButton = document.createElement('button')
                                newFollowButton.dataset.user = followingPendingButtons[i].dataset.user
                                newFollowButton.dataset.private = followingPendingButtons[i].dataset.private
                                newFollowButton.className = 'hollow btn w-100 secondary follow_user mb0'
                                newFollowButton.textContent = getPoTranslate('FOLLOW')
                                newFollowButton.addEventListener('click', followFunction)
                                followingPendingButtons[i].parentElement.insertBefore(newFollowButton, followingPendingButtons[i])
                                followingPendingButtons[i].remove()
                            }
                            closePopup('privatePopupCancel')
                            toastify(response.message)



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
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.setRequestHeader('Authorization', bearerToken)
                xhr.setRequestHeader('X-CSRF-TOKEN', token)

                xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
                xhr.setRequestHeader('Content-Type', 'application/json')




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
}

function privacyPolicyF() { }

function loginF() {


    loadScript('/frontend/assets/js/loginValidation.js' + version, function () {
        loadScript('/frontend/assets/js/formValidators.js' + version, function () {

        });
        loadScript('/frontend/assets/js/loginRegisterForgot.js' + version, function () {
            showHidePassword();
        });
    });

    if (getCookie('registrationMessage') !== '') {
        if (document.getElementsByClassName('messageForEmail')[0]) {
            let m = document.getElementsByClassName('messageForEmail')[0];
            m.textContent = getPoTranslate('PLEASE_CHECK_EMAIL')
            m.classList.add('messageForEmailCorrection');
            document.cookie = 'registrationMessage=; Path=/account/login; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        }


    }


    const queryString = window.location.search
    const urlParams = new URLSearchParams(queryString)
    const email = urlParams.has('email') ? urlParams.get('email') : false
    const message = urlParams.has('message') ? urlParams.get('message') : false
    if (email) {
        document.getElementsByClassName('email-input')[0].value = email
        history.pushState({}, document.title, location.origin + location.pathname)

        document.getElementById('login-form').getElementsByClassName('password-input')[0].focus()
    }

    if (message) {

        if (document.getElementsByClassName('messageForEmail')[0]) {
            let m = document.getElementsByClassName('messageForEmail')[0];
            m.textContent = message
            m.classList.add('messageForEmailCorrection')


        }


    }

}

function forgotPasswordF() {

    loadScript('/frontend/assets/js/forgotValidation.js' + version, function () {
        loadScript('/frontend/assets/js/formValidators.js' + version, function () {

        });
        loadScript('/frontend/assets/js/loginRegisterForgot.js' + version, function () {
            showHidePassword();
        });
    });
}

function signUpF() {


    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/signUpValidation.js' + version, function () {
            window.onSubmit = function (token) {
                handleSubmitto();
                grecaptcha.reset();
            };
        });
        loadScript('/frontend/assets/js/loginRegisterForgot.js' + version, function () {
            showHidePassword();
        });

    });
}

function settingsProfileF() {
    const queryString = window.location.search
    const urlParams = new URLSearchParams(queryString)
    const code = urlParams.get('code')

    if (code) {
        history.pushState({}, document.title, location.origin + location.pathname)
    }


    loadScript('/frontend/assets/js/loginRegisterForgot.js' + version, function () {

        showHidePasswordSettings();

        loadScript('/frontend/assets/js/formValidators.js' + version, function () {

            loadScript('/frontend/assets/js/fullNameValidation.js' + version, function () {

            });
            loadScript('/frontend/assets/js/addBioValidation.js' + version, function () {

            });
            loadScript('/frontend/assets/js/emailValidation.js' + version, function () {

            });


            loadScript('/frontend/assets/js/setPrivateProfile.js' + version, function () {

            });
            loadScript('/frontend/assets/js/getPermisionLogics.js' + version, function () {

            })
            loadScript('/frontend/assets/js/passwordValidation.js' + version, function () {

            });
        });

    });


    removeProfilePhoto()

    if (document.getElementById('languagePopUp')) {
        if (!getCookie('activeLang')) {
            document.getElementById('german').checked = true
            return
        }

        let languageItemLists = document.getElementById('languagePopUp').getElementsByClassName('languageItemList')

        for (let i = 0; i < languageItemLists.length; i++) {

            languageItemLists[i].addEventListener('click', function () {

                languageItemLists[i].getElementsByTagName('input')[0].checked = true

                location.assign(location.origin + location.pathname + '?hl=' + languageItemLists[i].getElementsByTagName('input')[0].value.toLocaleLowerCase())
            });


            if (getCookie('activeLang') === languageItemLists[i].getElementsByTagName('input')[0].value.toLocaleLowerCase()) {
                languageItemLists[i].getElementsByTagName('input')[0].checked = true
            }
        }



    }

    if (document.getElementById('feedbackPopUp')) {
        let rateApp = document.getElementById('feedbackPopUp').getElementsByClassName('rateApp');
        for (let i = 0; i < rateApp.length; i++) {
            rateApp[i].addEventListener('click', function () {
                if (document.getElementById('feedbackPopUp').getElementsByClassName('selected')[0]) {
                    document.getElementById('feedbackPopUp').getElementsByClassName('selected')[0].classList.remove('selected');
                }
                this.classList.add('selected');
            });

        }
    }

    if (document.getElementById('showAppFeedbacPopup')) {
        document.getElementById('showAppFeedbacPopup').addEventListener('click', getAppFeedback);
    }

    if (document.getElementById('feedbackAppButton')) {
        document.getElementById('feedbackAppButton').addEventListener('click', submitAppFeedback);
    }

    function getAppFeedback() {
        try {
            getReviewXMLHttpRequestFunction()
        } catch (err) {
            Sentry.captureException(new TryCatchGetFeedbackReviewXMLHttpRequestFunction(err));
        }
    }

    function submitAppFeedback() {
        try {
            submitReviewXMLHttpRequestFunction()
        } catch (err) {
            Sentry.captureException(new TryCatchSubmitFeedbackReviewXMLHttpRequestFunction(err));
        }
    }

    function getReviewXMLHttpRequestFunction() {

        let xhr = new XMLHttpRequest()

        xhr.onloadend = function () {
            hideLoading()
        }
        xhr.onloadstart = function () {
            showLoading()
        }

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.response);

                if (response.success === true) {


                    if (response.data) {
                        let rateApps = document.getElementById('feedbackPopUp').getElementsByClassName('rateApp');
                        for (let i = 0; i < rateApps.length; i++) {
                            if (rateApps[i].dataset.feedback == response.data.rating) {
                                rateApps[i].classList.add('selected')
                            }
                            document.getElementById('feedbackText').value = response.data.comment
                        }

                        openPopup('feedbackPopUp')
                    } else {
                        openPopup('feedbackPopUp')
                    }


                } else if (response.success === false) {
                    toastify(response.message)
                }

                hideLoading()
            }
        }



        xhr.onerror = function (error) {
            toastify(this.statusText)
            Sentry.captureException(new SubmitFeedbackSubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))
        }

        xhr.open('GET', envAppBackendUrl + '/app-feedback', true)

        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
        xhr.setRequestHeader('Authorization', bearerToken)
        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

        xhr.send()


    }

    function submitReviewXMLHttpRequestFunction() {

        let xhr = new XMLHttpRequest();

        let data = {
            'rating': document.getElementById('feedbackPopUp').getElementsByClassName('selected')[0].dataset.feedback,
            'comment': document.getElementById('feedbackText').value,
        };

        xhr.onloadend = function () {
            hideLoading()
        }
        xhr.onloadstart = function () {
            showLoading()
        }

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.response)

                if (response.success === true) {
                    toastify(response.message)

                } else if (response.success === false) {
                    toastify(response.message)
                }
                closePopup('feedbackPopUp')

            }
        }

        xhr.onerror = function (error) {

            toastify(this.statusText);
            Sentry.captureException(new SubmitFeedbackSubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
        }

        xhr.open('POST', envAppBackendUrl + '/send-feedback', true)

        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
        xhr.setRequestHeader('Authorization', bearerToken)
        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

        xhr.send(JSON.stringify(data));

    }


    moveForm()
    window.addEventListener("resize", moveForm);


    function moveForm() {

        if (document.getElementsByClassName('form-wrapperZ')[0]) {

            let form = document.getElementsByClassName('form-wrapperZ')[0]

            if (window.innerWidth < 640) {
                document.getElementsByClassName('setPageForm')[0].appendChild(form)
                form.classList.remove('dn')
            } else if (window.innerWidth > 639) {
                document.getElementById('Profile').getElementsByClassName('largingZ')[0].getElementsByClassName(
                    'setting-inner')[0].appendChild(form)
                form.classList.remove('dn')
                if (window.profileSettings === 1) {
                    closePopup('profileSettings')
                }
            }

        }
    }

    followUnfollowUserOptions()

    //logics for setting calendar states
    calendarLogics()


}

function settingsNotificationF() {
    showMoreNotifications();
    if (document.getElementById('readAllNotifications')) {
        document.getElementById('readAllNotifications').addEventListener('click', function () {
            showLoading()


            let xhr = new XMLHttpRequest()

            xhr.onloadstart = function () {
                showLoading()
            }

            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.response);

                    if (response.success === true) {
                        let notificationWrappers = document.getElementById('notificationWrapper')
                            .getElementsByTagName('a')
                        for (let i = 0; i < notificationWrappers.length; i++) {
                            notificationWrappers[i].getElementsByTagName('small')[0].classList.remove(
                                'addDot')

                        }
                        toastify(response.message)


                    } else if (response.success === false) {
                        toastify(response.message)

                    }

                    hideLoading()

                }
            }

            xhr.onloadend = function () {
                console.log('The request has completed.');
            }

            xhr.onerror = function (error) {
                hideLoading()
                toastify(this.statusText)
                Sentry.captureException(new ReadAllNotificationsError(error + 'status: ' + this
                    .statusText +
                    '|| response: ' + this.statusText + ' || url: ' + location.href));
            }

            xhr.open('POST', envAppBackendUrl + '/read-all-notifications', true)

            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
            xhr.setRequestHeader('Authorization', bearerToken)
            xhr.setRequestHeader('X-CSRF-TOKEN', token)

            xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
            xhr.send()
        })

    }

    class ReadAllNotificationsError extends Error {
        constructor(message) {
            super(message);
            this.name = 'ReadAllNotificationsError';
        }
    }

    if (document.getElementById('deleteAllNotifications')) {
        document.getElementById('deleteAllNotifications').addEventListener('click', function () {


            showLoading()


            let xhr = new XMLHttpRequest()

            xhr.onloadstart = function () {
                showLoading()
            }

            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.response);

                    if (response.success === true) {
                        document.getElementById('notificationWrapper').remove()
                        document.getElementById('noNotificationsCont').classList.remove('dn')

                        document.getElementById('notificationsOptions').classList.add('dn')

                        toastify(response.message)

                    } else if (response.success === false) {
                        toastify(response.message)

                    }

                    hideLoading()

                }
            }

            xhr.onloadend = function () {
                console.log('The request has completed.');
            }

            xhr.onerror = function (error) {
                hideLoading()
                toastify(this.statusText)
                Sentry.captureException(new DeleteAllNotificationsError(error + 'status: ' + this
                    .statusText +
                    '|| response: ' + this.statusText + ' || url: ' + location.href));
            }

            xhr.open('DELETE', envAppBackendUrl + '/delete-all-notifications', true)

            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
            xhr.setRequestHeader('Authorization', document.querySelector('meta[name="access_token"]').content);
            xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

            xhr.send()
        })

    }

    class DeleteAllNotificationsError extends Error {
        constructor(message) {
            super(message);
            this.name = 'DeleteAllNotificationsError';
        }
    }
}

function talks() {
    const target = document.getElementById('mainCategoriesCarousel');

    function handleIntersection(entries) {
        entries.map((entry) => {
            if (entry.isIntersecting) {
                document.getElementsByClassName('fixedPositionMobile')[0].dataset.fixed = '0'
                document.getElementsByClassName('fixedPositionMobile')[0].style.top = '-200px'
            } else {

                if (window.innerWidth < 640) {
                    document.getElementsByClassName('fixedPositionMobile')[0].style.top = document.querySelector('main .steperko').offsetHeight + 'px'
                } else {

                    document.getElementsByClassName('fixedPositionMobile')[0].style.top = document.querySelector('main .steperko').offsetHeight + 'px'
                }

                document.getElementsByClassName('fixedPositionMobile')[0].dataset.fixed = '1'

            }
        });
    }

    const observer = new IntersectionObserver(handleIntersection);

    observer.observe(target);


    const divElem = document.getElementsByClassName('fixedPositionMobile')[0]

    const resizeObserver = new ResizeObserver((entries) => {
        for (const entry of entries) {
            if (window.innerWidth > 639) {

                if (divElem.dataset.fixed === '1') {
                    divElem.style.top = document.querySelector('main .steperko').offsetHeight + 'px'
                }
            } else {
                if (divElem.dataset.fixed === '1') {

                    divElem.style.top = document.querySelector('main .steperko').offsetHeight + 'px'
                }
            }

        }
    });

    resizeObserver.observe(divElem);

    if (document.getElementsByClassName('searchPageLinks')[0]) {
        let searchPageLinks = document.getElementsByClassName('searchPageLinks')
        for (let i = 0; i < searchPageLinks.length; i++) {
            searchPageLinks[i].addEventListener('click', function (e) {
                if (window.innerWidth < 768) {
                    e.preventDefault()
                    location.assign(searchPageLinks[i].dataset.mobileHref)
                }
            })


        }
    }

}

function favoriteUsers() {
    followUnfollowUserOptions();

    showMoreFavoriteUsers();



}

function favoriteTalks() {
    loadScript('/frontend/assets/js/searchFilters.js' + version, function () {

    })
}

function talkCategorySubcategoryF() {

    loadScript('/frontend/assets/js/searchFilters.js' + version, function () {

    })

    let items = document.getElementById('categoryCarousel').getElementsByClassName('tabs-title');

    for (let i = 0; i < items.length; i++) {

        //set active carousel item
        /*      if (items[i].getElementsByTagName('a')[0].getElementsByTagName('p')[0].textContent.trim() === location.href.split('/')[location.href.split('/').length - 1]) {
         items[i].style.textDecoration = 'underline'
         items[i].getElementsByTagName('p')[0].style.color = '#313131'
         items[i].getElementsByTagName('p')[1].style.color = '#313131'
         }
         */
        //location change on click o carousel item
        items[i].addEventListener('click', function () {

            let items2 = document.getElementById('categoryCarousel').getElementsByClassName('tabs-title');

            for (let i = 0; i < items2.length; i++) {

                if (items2[i].getElementsByTagName('a')[0].getElementsByTagName('p')[0].textContent.trim() === location.href.split('/')[location.href.split('/').length - 1]) {
                    items2[i].style.textDecoration = 'underline';
                    items2[i].getElementsByTagName('p')[0].style.color = '#8C97AC';
                    items2[i].getElementsByTagName('p')[1].style.color = '#8C97AC';
                }

            }

            items[i].style.textDecoration = 'underline';
            items[i].getElementsByTagName('p')[0].style.color = '#313131';
            items[i].getElementsByTagName('p')[1].style.color = '#313131';
            //showLoading()
            //location.assign('/search-talks/' + location.href.split('/')[location.href.split('/').length - 2] + '/' + this.getElementsByClassName('innerTitlesForCarouselSlider')[0].textContent.trim())
        });
    }
}

function accountVerificationF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/addBioValidation.js' + version, function () {

        });

        loadScript('/frontend/assets/js/fullNameValidation.js' + version, function () {

        });

        loadScript('/frontend/assets/js/verificationValidation.js' + version, function () {
            if (document.getElementsByClassName('imagePointerForCropper')[0]) {
                document.getElementsByClassName('imagePointerForCropper')[0].addEventListener('click', function () {
                    window.clickOnUploadImageOnVerificationPage = true
                })
            }
        });

    });

    let urlParams = new URLSearchParams(location.search);
    let myParam = urlParams.get('opensharepopup');

    if (myParam === '1') {
        openPopup('shareProfilePopUp2');
        history.pushState({}, document.title, location.origin + location.pathname)
    }


}

function jtcSetPayoutOptions() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {

        loadScript('/frontend/assets/js/step4Validation.js' + version, function () {

        });
    });
}

function jtcSetPayoutOptionsF() {


    let paypalEnv = document.getElementById('ppenv').value



    let settingsPayoutPayPalReturnUrl = document.getElementById('appUrl').value + '/settings/payout';
    let settingsPayoutPayPalAppid = document.getElementById('settingsAppId').value;

    paypal.use(['login'], function (login) {
        login.render({
            'appid': settingsPayoutPayPalAppid,
            'authend': paypalEnv,
            'scopes': 'email',
            'containerid': 'paypal-button-container2',
            'responseType': 'code',
            'locale': 'en-us',
            'buttonType': 'CWP',
            'buttonShape': 'pill',
            'buttonSize': 'lg',
            'fullPage': 'true',
            'returnurl': settingsPayoutPayPalReturnUrl,
        })
    })




}

function talksAndAvailabilityF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/talksAndAvailabilityValidation.js' + version, function () {



            let courseItem = document.getElementsByClassName('dataTalkId');

            for (let i = 0; i < courseItem.length; i++) {
                courseItem[i].addEventListener('click', function () {

                    window.clickedEdit = 1
                    getTalkData(courseItem[i].dataset.talkId)
                    document.getElementsByClassName('addNewTalkDescription')[0].classList.add('dn')

                    document.getElementsByClassName('editnewTalkDescription')[0].classList.remove('dn')

                });
            }

            let talk = location.href.split('talk=')[1];

            if (talk != undefined) {
                let modal = document.querySelector('[data-talk-id="' + talk + '"]');
                modal.click();
            }
        });

        loadScript('/frontend/assets/js/step3Validation.js' + version, function () {



        });

        if (document.getElementsByClassName('addPrivateTalk')[0]) {
            document.getElementsByClassName('addPrivateTalk')[0].addEventListener('click', function () {

                window.clickedEdit = 0

                clearForm(document.getElementById('private-talk-form'))

                document.getElementsByClassName('addNewTalkDescription')[0].classList.remove('dn')
                document.getElementsByClassName('editnewTalkDescription')[0].classList.add('dn')
                document.getElementsByClassName('pauseWrap')[0].classList.add('dn')
                document.getElementById('privateSubmit').classList.add('dn')
                document.getElementById('privateSubmit').textContent = getPoTranslate('ADD_PRIVATE_TALK')




            })
        }



        document.getElementsByClassName('loadAboutMe')[0].addEventListener('click', function () {

            showLoading()

            let xhr = new XMLHttpRequest()

            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {

                    document.getElementById('blankPopupPopuper').innerHTML = this.response;

                    if (document.getElementsByClassName('testimonialAboutMe')[0]) {
                        let owls = document.getElementsByClassName('testimonialAboutMe')

                        for (let i = 0; i < owls.length; i++) {

                            let owl1 = jQuery(owls[i])

                            owl1.owlCarousel({
                                margin: 10,
                                dots: true,
                                nav: false,
                                stagePadding: 40,
                                items: 1,
                            })

                            owls[i].style.opacity = '1'
                        }


                    }

                    openPopup('blankPopup')
                    calculatePopUpHeight(document.getElementById('blankPopup'))
                    hideLoading()

                    let groupC = document.getElementsByClassName('groupC')[0];
                    let privateC = document.getElementsByClassName('privateC')[0];

                    let buttons = document.getElementsByClassName('bMySlotsButtonsCont');
                    let bottomLine = document.getElementsByClassName('buttonLine')[0];

                    for (let i = 0; i < buttons.length; i++) {
                        buttons[i].addEventListener('click', function () {

                            if (this.dataset.pointer === 'gc') {


                                this.classList.add('active');
                                buttons[0].classList.remove('active');

                                bottomLine.style.left = '50%';

                                groupC.style.left = '0';
                                privateC.style.left = '200%';

                                document.getElementById('aboutMeContaR').style.height =
                                    document.getElementsByClassName('bMySlotsButtons')[0].offsetHeight + document.getElementsByClassName('groupC')[0].offsetHeight + 'px';

                            } else if (this.dataset.pointer === 'pc') {


                                this.classList.add('active');
                                buttons[1].classList.remove('active');

                                bottomLine.style.left = '0%';

                                bottomLine.style.left = '0%';

                                groupC.style.left = '-200%';
                                privateC.style.left = '0%';

                                document.getElementById('aboutMeContaR').style.height =
                                    document.getElementsByClassName('bMySlotsButtons')[0].offsetHeight + document.getElementsByClassName('privateC')[0].offsetHeight + 'px';

                            }
                        })
                    }

                    let switches = document.getElementsByClassName('switch');
                    for (let i = 0; i < switches.length; i++) {
                        switches[i].addEventListener('click', function () {

                            let input = switches[i].getElementsByTagName('input')[0];

                            if (input.checked) {
                                input.checked = false;
                            } else {
                                input.checked = true;
                            }

                        })
                    }

                    if (document.getElementsByClassName('teacherDescOpenBios')[0]) {
                        document.getElementsByClassName('teacherDescOpenBios')[0].addEventListener('click', function () {
                            openPopup('addShortDescription')
                            document.getElementById('addShortDescription').style.zIndex = '214743643'
                        })
                    }

                }
            }

            xhr.onerror = function (error) {
                console.log(error);
            };

            xhr.open('GET', '/about-me-partial', true);
            xhr.send();


        });
    });


    deleteTalk();



}

function book_slotF() {

    window.localStorage.removeItem('bookingObj')

    loadScript('/frontend/assets/js/calendar.js' + version, function () {

    })

    hideLoading()
    document.getElementsByClassName('bookingSlotCalendarHolder')[0].getElementsByClassName('booking-slot')[0].style.opacity = '1';

    showHideCalendarBigSmall()
    //ako bi ova stranica bila za logged out
    /* loadScript('/frontend/assets/js/loginRegisterForgot.js' + version, function () {
        showHidePassword()
    })
    loadScript('/frontend/assets/js/loginValidation.js' + version, function () {
        loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        })
    }) */

    if (document.getElementById('teacherAvailabilityDatesTime')) {
        if (document.getElementById('teacherAvailabilityDatesTime').value) {

            let teacherAvailabilityDatesTime = JSON.parse(document.getElementById('teacherAvailabilityDatesTime').value.trim())

            getBookingTalkAvailability(Object.keys(teacherAvailabilityDatesTime)[0])

        }
    }

    // ova sekcija je za rebook time, pokusavamo da nadjemo isto vreme
    // da bi se ovo trigerovalo korisnik mora da ode na rebook preko booking stranice

    let urlParams = new URLSearchParams(window.location.search);
    let reebok_time = urlParams.get('reebok_time');

    if (reebok_time) {
        if (reebok_time.length > 1) {
            let d = new Date(reebok_time)
            d = addZero(d.getHours()) + ':' + addZero(d.getMinutes())


            let weeklyTimes = document.getElementsByClassName('weekly-time')[0].getElementsByTagName('button')
            for (let i = 0; i < weeklyTimes.length; i++) {

                if (weeklyTimes[i].textContent === d) {

                    history.pushState({}, document.title, location.origin + (location.pathname).split('&reebok_time=')[0])
                    eventFire(weeklyTimes[i], 'click')
                } else {

                    history.pushState({}, document.title, location.origin + (location.pathname).split('&reebok_time=')[0])

                }

            }
        }
    }

    //prikupljamo rating za prikazivanje ratinga sa leve strane
    setTimeout(function () {

        let xhr = new XMLHttpRequest()
        let user_id = document.getElementsByClassName('step1name')[0].dataset.id
        let url = '/get-rating/' + user_id

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {


                document.getElementById('reviewWrap').innerHTML = this.response
                document.getElementById('funnelReviewWrap').style.opacity = '1'
                feedbackComments()

            }

        }

        xhr.onerror = function (error) {
            console.log(error)
        }

        xhr.open('GET', url, true)
        xhr.send()


    }, 1000)

    //logics for setting calendar states
    calendarLogics()

    if (document.getElementsByClassName('calendarFunnelHighlightingState')[0]) {
        let calendarFunnelHighlightingState = document.getElementsByClassName('calendarFunnelHighlightingState')[0]

        calendarFunnelHighlightingState.addEventListener('click', function () {
            if (calendarFunnelHighlightingState.dataset.clicked === '1') {

                removeHighlightedAvailabilites()

                calendarFunnelHighlightingState.dataset.clicked = '0'
            } else if (calendarFunnelHighlightingState.dataset.clicked === '0') {


                calculateUserAvailabilites()

                hideLoading()
                calendarFunnelHighlightingState.dataset.clicked = '1'
            }
        })
    }



}

function bookingF() {
    loadScript('/frontend/assets/js/calendar.js' + version, function () {

    })
    loadScript('/frontend/assets/js/optionButton.js' + version, function () {
        showHideCalendarBigSmall()
    })
}

function feedbackComments() {

    let buttons = document.getElementsByClassName('bMySlotsButtonsCont')

    for (let i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener('click', function () {
            if (buttons[i].dataset.pointer === "pc") {

                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresReceived').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

            } else if (buttons[i].dataset.pointer === "gc") {

                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresGiven').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

            }
        })

    }



    let star = 0;

    ratingLogics();

    function ratingLogics() {


        function getFeedbackCommentss(target, offset) {

            let pointer = target.dataset.reviews // pointer is 1 for
            let url = '/settings/reviews-partial' + '?offset=' + offset + '&limit=2' + '&pointer=' + pointer


            let xhr = new XMLHttpRequest()

            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {

                    let response = JSON.parse(this.response);

                    target.closest('.review-right').getElementsByClassName('feedback-comments')[0].innerHTML += response.html

                    if (response.totalReviews <= target.closest('.review-right').getElementsByClassName('feedback-comments')[0].getElementsByClassName('each-review').length) {
                        target.classList.add('dn')
                    }


                    document.getElementById('reviewHeighter').style.height = (target.closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'



                }
            }

            xhr.onloadend = function () {
                hideLoading()
            }
            xhr.onerror = function (error) {
                hideLoading()
                toastify(this.statusText)
                Sentry.captureException(new FeedbackCommentsUrlError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))
            }

            xhr.open('GET', url, true)
            xhr.send()


        }

        if (document.getElementsByClassName('seeMores')[0]) {

            let seeMores = document.getElementsByClassName('seeMores')
            for (let i = 0; i < seeMores.length; i++) {

                if (typeof seeMores[i].dataset.eventLoaded === 'undefined') {
                    seeMores[i].addEventListener('click', function () {

                        showLoading()

                        let offset = seeMores[i].closest('.review-right').getElementsByClassName('feedback-comments')[0].getElementsByClassName('each-review').length


                        if (this.dataset.type === "1") {

                            getFeedbackCommentss(this, offset)
                        } else if (this.dataset.type === "2") {
                            getFeedbackComments(this.dataset.star, offset, this.dataset.reviews, true);
                        }


                    });

                    seeMores[i].dataset.eventLoaded = '1';
                }
            }

        }



        function getFeedbackComments(star, offset, pointer, sourcePointer) {

            let totalFeedbacks = parseInt(document.getElementById('totalFeedbackCount').value)
            let limit = 2
            star = star ? star : 5

            offset = offset ? offset : 0

            let pointer2 = pointer ? '&pointer=' + pointer : ''

            let url = document.getElementById('feedbackCommentsUrl').value + '?star=' + star + '&offset=' + offset + '&limit=' + limit + pointer2

            let xhr = new XMLHttpRequest()

            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {


                    let response = JSON.parse(this.response)

                    if (response.hasOwnProperty('noData')) {
                        if (response.noData === true) {

                            toastify(response.message)
                            if (pointer === '1') {

                                document.getElementById('showMoresReceived').closest('.inner-review').getElementsByClassName('no-found-heading')[0].classList.remove('dn')
                                document.getElementById('recievedComentsFalback').innerHTML = '';
                                document.getElementById('showMoresReceived').classList.add('dn')
                                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresReceived').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

                            } else if (pointer === '2') {

                                document.getElementById('showMoresGiven').closest('.inner-review').getElementsByClassName('no-found-heading')[0].classList.remove('dn')
                                document.getElementById('givenComentsFalback').innerHTML = '';
                                document.getElementById('showMoresGiven').classList.add('dn')
                                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresGiven').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

                            }
                        }
                    } else {
                        if (response.total_items == 0) {

                            if (pointer == 1) {

                                document.getElementById('bookingNoFoundRecieved').classList.remove('dn');
                                document.getElementById('recievedComentsFalback').innerHTML = '';
                                document.getElementById('showMoresReceived').classList.add('dn')
                                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresReceived').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

                            } else if (pointer == 2) {

                                document.getElementById('bookingNoFoundGiven').classList.remove('dn');
                                document.getElementById('givenComentsFalback').innerHTML = '';
                                document.getElementById('showMoresGiven').classList.add('dn')
                                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresGiven').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

                            }

                        } else {

                            if (pointer == 1) {

                                if (sourcePointer) {
                                    document.getElementById('recievedComentsFalback').innerHTML += response.html;
                                } else {
                                    document.getElementById('recievedComentsFalback').innerHTML = response.html;
                                }

                                document.getElementById('bookingNoFoundRecieved').classList.add('dn')

                                let commentsPresent = document.getElementById('recievedComentsFalback').getElementsByClassName('each-review').length
                                if (response.stars_total > commentsPresent) {

                                    document.getElementById('showMoresReceived').classList.remove('dn')
                                } else if (response.stars_total <= commentsPresent) {

                                    document.getElementById('showMoresReceived').classList.add('dn')
                                }

                                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresReceived').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'


                            } else if (pointer == 2) {

                                if (sourcePointer) {
                                    document.getElementById('givenComentsFalback').innerHTML += response.html;
                                } else {
                                    document.getElementById('givenComentsFalback').innerHTML = response.html;
                                }

                                document.getElementById('bookingNoFoundGiven').classList.add('dn');

                                let commentsPresent = document.getElementById('givenComentsFalback').getElementsByClassName('each-review').length

                                if (response.stars_total > commentsPresent) {
                                    document.getElementById('showMoresGiven').classList.remove('dn')
                                } else if (response.stars_total <= commentsPresent) {
                                    document.getElementById('showMoresGiven').classList.add('dn')
                                }

                                document.getElementById('reviewHeighter').style.height = (document.getElementById('showMoresGiven').closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

                            }



                        }
                    }



                    hideLoading();

                }
            }


            xhr.onerror = function (error) {
                hideLoading()
                toastify(this.statusText)
                Sentry.captureException(new FeedbackCommentsUrlError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))
            }

            xhr.open('GET', url, true)
            xhr.send()


        }

        let progresStars = document.getElementsByClassName('progress-star');
        for (let i = 0; i < progresStars.length; i++) {
            if (progresStars[i].dataset.eventAdded !== "1") {
                progresStars[i].addEventListener('click', function () {
                    if (document.body.className !== 'book_slot') {


                        showLoading();


                        for (let i = 0; i < progresStars.length; i++) {
                            if (progresStars[i].getElementsByClassName('progress-meter')[0]) {
                                if (
                                    progresStars[i].getElementsByClassName('progress-meter')[0].closest('.ratingS') ===
                                    this.parentElement
                                ) {
                                    progresStars[i].getElementsByClassName('progress-meter')[0].style.width = '0%';
                                }

                            }

                            progresStars[i].classList.remove('pon');
                        }

                        this.classList.add('pon');

                        //document.getElementById('totalFeedbackCount').value = progresStars[i].dataset.total;
                        star = progresStars[i].dataset.id;

                        progresStars[i].closest('.inner-review').getElementsByClassName('seeMores')[0].dataset.type = "2"
                        progresStars[i].closest('.inner-review').getElementsByClassName('seeMores')[0].dataset.star = star

                        getFeedbackComments(star, 0, this.dataset.rating)

                        if (progresStars[i].getElementsByClassName('progress-meter')[0]) {
                            progresStars[i].getElementsByClassName('progress-meter')[0].style.width = '100%';
                        }




                    }
                })
                progresStars[i].dataset.eventAdded = 1
            }


        }

    }

    if (document.getElementsByClassName('allRating')[0]) {

        let allRatingS = document.getElementsByClassName('allRating');

        for (let i = 0; i < allRatingS.length; i++) {
            allRatingS[i].addEventListener('click', function () {

                if (document.body.className === 'book_slot') {


                    document.getElementById('blankPopupPopuper').appendChild(document.getElementById('funnelReviewWrap'));
                    setTimeout(function () {
                        openPopup('blankPopup');

                    }, 10);


                } else {




                    let pointer = this.dataset.pointer; //pointer for recieved = 1; pointer for given = 2;
                    showLoading();
                    let xhttp = new XMLHttpRequest();
                    let url = '/settings/reviews?pointer=' + pointer

                    xhttp.onreadystatechange = function () {

                        if (this.readyState == 4 && this.status == 200) {

                            let response = JSON.parse(this.response)


                            if (response.hasOwnProperty('noData')) {
                                if (response.noData === true) {
                                    if (pointer === '1') {
                                        allRatingS[i].closest('.inner-review').getElementsByClassName('no-found-heading')[0].classList.remove('dn')
                                        document.getElementById('showMoresReceived').classList.add('dn')
                                    } else if (pointer === '2') {
                                        allRatingS[i].closest('.inner-review').getElementsByClassName('no-found-heading')[0].classList.remove('dn')
                                        document.getElementById('showMoresGiven').classList.add('dn')
                                    }
                                    toastify(response.message)
                                }
                            } else {
                                if (pointer === '1') {

                                    document.getElementsByClassName('ratingS')[0].innerHTML = response.reviewBars
                                    document.getElementsByClassName('feedback-comments')[0].innerHTML = response.feedbackComments
                                    document.getElementById('ratingBigReceived').textContent = Number((response.teacherAverageRating).toFixed(1))
                                    document.getElementById('totalRatingsRecieved').textContent = response.totalRatings
                                    document.getElementById('totalReviewsRecieved').textContent = response.totalReviews
                                    document.getElementById('showMoresReceived').dataset.type = "1"
                                    allRatingS[i].closest('.inner-review').getElementsByClassName('no-found-heading')[0].classList.add('dn')
                                    if (response.numberOfComments >= 2) {
                                        document.getElementById('showMoresReceived').classList.remove('dn')
                                    }


                                } else if (pointer === '2') {


                                    document.getElementsByClassName('ratingS')[1].innerHTML = response.reviewBars
                                    document.getElementsByClassName('feedback-comments')[1].innerHTML = response.feedbackComments
                                    document.getElementById('ratingBigGiven').textContent = Number((response.teacherAverageRating).toFixed(1))
                                    document.getElementById('totalRatingsGiven').textContent = response.totalRatings
                                    document.getElementById('totalReviewsGiven').textContent = response.totalReviews
                                    document.getElementById('showMoresGiven').dataset.type = "1"
                                    allRatingS[i].closest('.inner-review').getElementsByClassName('no-found-heading')[0].classList.add('dn')
                                    if (response.numberOfComments >= 2) {
                                        document.getElementById('showMoresGiven').classList.remove('dn')
                                    }
                                }
                            }

                            document.getElementById('reviewHeighter').style.height = (allRatingS[i].closest('.coursesBlock').offsetHeight + document.getElementById('bMySlotsButtons').offsetHeight + 32) + 'px'

                            ratingLogics()

                            hideLoading()

                        }
                    }

                    xhttp.onerror = function (error) {
                        Sentry.captureException(new GetRatingFullError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))
                    }

                    xhttp.open('GET', url, true)
                    xhttp.send()
                }
            });
        }
    }



}

function videoConferenceF() {

    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/step5Validation.js' + version, function () {
            loadScript('/frontend/assets/js/optionButton.js' + version, function () {

                loadScript('/frontend/assets/js/talk/socketBundle.js' + version, function () {

                    initializeStripe()

                    extendTalkPaymentInitialize()

                    selectCardForPayment()

                    if (document.getElementsByClassName('extendLessonDuration')[0]) {
                        let extendLessonDuration = document.getElementsByClassName('extendLessonDuration');
                        for (let i = 0; i < extendLessonDuration.length; i++) {
                            extendLessonDuration[i].addEventListener('click', function () {

                                showLoading()

                                //document.getElementById('extendLesson').disabled = true
                                document.getElementById('extendLessonTime').value = '';
                                document.getElementById('priceHours').value = '';

                                let that = this;

                                submitValidationForm(that.dataset.popup);

                                function submitValidationForm(popupPointer) {

                                    jQuery.ajax({
                                        type: 'POST',
                                        headers: {
                                            'Accept': 'application/json',
                                            'Time-Zone-Offset-UTC': getCookie('timezone'),
                                        },
                                        data: {
                                            '_token': token,
                                        },
                                        url: '/frontend/api/teacher-available-extensions',

                                        complete: function () {
                                            hideLoading()
                                        },

                                        success: function (response) {

                                            if (response.success) {

                                                document.getElementById('extendCall').getElementsByClassName('buttons')[0].textContent = '';

                                                if (document.getElementsByClassName('infoAboutExtend')[0]) {
                                                    document.getElementsByClassName('infoAboutExtend')[0].remove();
                                                }

                                                toastify(response.message);

                                                window.dataca = response;
                                                let count = 0;

                                                if (response.data) {

                                                    document.getElementsByClassName('textForExtend')[0].classList.remove('dn');
                                                    document.getElementsByClassName('submitButtonsForExtend')[0].classList.remove('dn');

                                                    let obj = response.data;

                                                    for (let i = 0; i < Object.keys(obj).length; i++) {

                                                        if (obj[Object.keys(obj)[i]].success === true) {

                                                            /* <span class="btn extCal"><span class="minutes">15</span> Minutes - <span class="prices">15</span> €</span> */

                                                            let extendionItem = document.createElement('div');
                                                            extendionItem.className = 'btn mt16 posrelative expanded extCal';


                                                            let firsterDiv = document.createElement('div')
                                                            firsterDiv.className = 'firsterDivier'

                                                            let minutesSpan = document.createElement('span')
                                                            minutesSpan.className = 'minutes'
                                                            let minutes = Object.keys(obj)[i].split('_')
                                                            let minutesLast = minutes[minutes.length - 1]
                                                            minutesSpan.textContent = minutesLast + ' Minutes'

                                                            firsterDiv.append(minutesSpan)

                                                            let seccerDikvie = document.createElement('div')
                                                            seccerDikvie.className = 'rightSideofExtendSlots df aic jcc'

                                                            let pricesSpan = document.createElement('span')
                                                            pricesSpan.className = 'prices mr4'
                                                            pricesSpan.textContent = new Intl.NumberFormat(getCookie('activeLang'), {
                                                                style: 'currency',
                                                                currency: 'EUR'
                                                            }).format(parseFloat(obj[Object.keys(obj)[i]].price).toFixed(2)).replace(/[^0-9.,]/g, '')

                                                            let chartIconDivExtend = document.createElement('div')
                                                            chartIconDivExtend.className = 'chartIconDivExtend'
                                                            chartIconDivExtend.innerHTML = '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M10.591 8.42484H12.6669C12.9816 8.42484 13.2289 8.16461 13.2289 7.8508C13.2289 7.52934 12.9816 7.27677 12.6669 7.27677H10.591C10.2762 7.27677 10.0289 7.52934 10.0289 7.8508C10.0289 8.16461 10.2762 8.42484 10.591 8.42484ZM15.1324 4.44562C15.5896 4.44562 15.8893 4.60635 16.1891 4.95843C16.4889 5.3105 16.5413 5.81565 16.4739 6.27412L15.7619 11.295C15.627 12.2602 14.8177 12.9712 13.8659 12.9712H5.68979C4.69307 12.9712 3.86871 12.1913 3.78627 11.181L3.09681 2.83755L1.96519 2.63855C1.66543 2.58498 1.45559 2.28648 1.50805 1.98032C1.56051 1.66728 1.85278 1.45987 2.16004 1.50655L3.9474 1.78133C4.2022 1.82801 4.38955 2.04156 4.41204 2.30179L4.55443 4.01624C4.57691 4.26193 4.77176 4.44562 5.01157 4.44562H15.1324ZM5.56974 14.1809C4.94023 14.1809 4.43063 14.7014 4.43063 15.3443C4.43063 15.9795 4.94023 16.5 5.56974 16.5C6.19176 16.5 6.70136 15.9795 6.70136 15.3443C6.70136 14.7014 6.19176 14.1809 5.56974 14.1809ZM14.0007 14.1809C13.3712 14.1809 12.8616 14.7014 12.8616 15.3443C12.8616 15.9795 13.3712 16.5 14.0007 16.5C14.6227 16.5 15.1323 15.9795 15.1323 15.3443C15.1323 14.7014 14.6227 14.1809 14.0007 14.1809Z" fill="white"/></svg>';


                                                            seccerDikvie.append(pricesSpan)
                                                            seccerDikvie.innerHTML += ' €'

                                                            extendionItem.prepend(firsterDiv)
                                                            extendionItem.append(seccerDikvie)
                                                            extendionItem.append(chartIconDivExtend)

                                                            document.getElementById('extendCall').getElementsByClassName('buttons')[0].append(extendionItem)

                                                            count++;
                                                        }

                                                    }

                                                    extendCallButtonEvent()
                                                    openPopup(popupPointer)
                                                }

                                                if (count === 0) {
                                                    document.getElementsByClassName('textForExtend')[0].classList.add('dn')
                                                    document.getElementsByClassName('submitButtonsForExtend')[0].classList.add('dn')

                                                    let infoAboutExtend = document.createElement('p')
                                                    infoAboutExtend.className = 'infoAboutExtend'
                                                    infoAboutExtend.textContent = getPoTranslate('NO_TALK_EXTENSION_TIME_SLOT')
                                                    document.getElementsByClassName('innerExtendCall')[0].append(infoAboutExtend)

                                                    openPopup(popupPointer)

                                                    hideLoading()
                                                }
                                            } else {

                                                document.getElementsByClassName('innerExtendCall')[0].textContent = ''

                                                let infoAboutExtend = document.createElement('p')
                                                infoAboutExtend.className = 'infoAboutExtend'
                                                infoAboutExtend.textContent = getPoTranslate('NO_TALK_EXTENSION_TIME_SLOT')
                                                document.getElementsByClassName('innerExtendCall')[0].append(infoAboutExtend)

                                                openPopup(popupPointer)

                                                toastify(response.message)
                                                hideLoading()
                                            }


                                        },
                                        error: function (errorMessage) {

                                            hideLoading();

                                            Sentry.captureException(new TeacherAvailableExtensionsError(errorMessage + ' || URL: ' + location.href))
                                        },

                                    });
                                }
                            });

                        }

                    }

                    if (document.getElementsByClassName('closePopup')[0]) {
                        let closePopups = document.getElementsByClassName('closePopup');
                        for (let i = 0; i < closePopups.length; i++) {
                            closePopups[i].addEventListener('click', function () {
                                if (this.dataset.closePopup) {
                                    closePopup(this.dataset.closePopup);
                                }
                            });
                        }
                    }

                    if (document.getElementsByClassName('pencilOpener')[0]) {
                        let pencilOpener = document.getElementsByClassName('pencilOpener')[0]

                        pencilOpener.addEventListener('click', function () {

                            if (pencilOpener.dataset.opened === '0') {
                                document.getElementsByClassName('hiddenForm')[0].style.maxHeight = '1000px'
                                pencilOpener.dataset.opened = '1'
                                calculatePopUpHeight(document.getElementById('paymentWalletPopUp'), 6)

                            } else if (pencilOpener.dataset.opened === '1') {
                                document.getElementsByClassName('hiddenForm')[0].style.maxHeight = '0px'
                                pencilOpener.dataset.opened = '0'
                                calculatePopUpHeight(document.getElementById('paymentWalletPopUp'), 6)

                            }

                        })

                    }
                })

            })
        })
    })

}


function book_slot_paymentF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        const params = new URLSearchParams(window.location.search);

        if (params.has('success')) {
            if (params.get('success') === 'true') {

                /* let dzens = document.getElementsByClassName('dzen');
                for (let i = 0; i < dzens.length; i++) {
                    dzens[i].classList.add('dn');
                }
                document.getElementsByClassName('payButton')[0].classList.add('dn'); */
                openPaymentPopuper(getPoTranslate('YOUR_PAYMENT_SUCCESS'))
                toastify(getPoTranslate('YOUR_PAYMENT_SUCCESS'))

                setTimeout(function () {
                    location.assign(location.origin + '/booking-thank-you')
                }, 2000)


                document.cookie = 'bookingObj=; Path=/booking-payment; Expires=Thu, 01 Jan 1970 00:00:01 GMT;'
                document.cookie = 'bookingObj=; Path=/booking-summary; Expires=Thu, 01 Jan 1970 00:00:01 GMT;'
                window.localStorage.removeItem('bookingObj')
            }
        }


        if (document.getElementById('shouldShowPayPalAndStripe').value === '1') {
            selectCardForPayment()

            initializePayPal('authorize')
        }

        initializeStripe()

        if (document.getElementById('vat_id')) {
            let vatSelect = document.querySelector('#vat_id');
            let vatInput = document.querySelector('input#vat_id');
            let base = document.querySelector('#bookingBase');
            let VAT = document.querySelector('#bookingVAT');
            let percentage = document.querySelector('#bookingVATPercentage');
            let price = parseFloat(document.getElementById('moneyConta').textContent.substring(0, document.getElementById('moneyConta').textContent.length - 1))

            if (document.querySelector('#bookingBase')) {
                vatSelect.addEventListener('change', updateVAT)
                window.addEventListener('load', updateVAT)
            }


            /**
             * Update VAT values in the Payment Header.
             */
            function updateVAT() {
                let vat = vatSelect.options[vatSelect.selectedIndex];

                base.innerHTML = setBase(vat);
                VAT.innerHTML = setVAT(vat);
                percentage.innerHTML = setPercentage(vat);
                vatInput.value = vat.value;
            }

            /**
             * Set Base Cost before VAT.
             *
             * @param vat Country of Residence VAT.
             *
             * @returns {string}
             */
            function setBase(vat) {
                return parseFloat(price - setVAT(vat)).toFixed(2);
            }

            /**
             * Set Country of Residence VAT value from the total price.
             *
             * @param vat Country of Residence VAT.
             *
             * @returns {string}
             */
            function setVAT(vat) {
                return parseFloat(price / 100 * vat.getAttribute('data-value')).toFixed(2);
            }

            /**
             * Set Country of Residence VAT percentage
             *
             * @param vat Country of Residence VAT.
             *
             * @returns {string}
             */
            function setPercentage(vat) {
                return parseFloat(vat.getAttribute('data-value')).toFixed(2);

            }
        }


        let payPallButtonPay = document.getElementsByClassName('payPallButtonPay')
        for (let i = 0; i < payPallButtonPay.length; i++) {
            payPallButtonPay[i].addEventListener('click', function () {

                showLoading()

                let form = payPallButtonPay[i].parentElement.getElementsByTagName('form')[0].elements

                let xhr = new XMLHttpRequest();

                let params = {
                    account_id: form['account_id'].value,
                    talk_id: form['talk_id'].value,
                    amount: form['amount'].value,
                    date_time: form['date_time'].value,
                    payment_type: form['payment_type'].value,
                    vat_id: form['vat_id'].value,
                    _token: token
                }



                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {

                        let response = JSON.parse(this.response);

                        if (response.success === true) {

                            toastify(response.message)
                            location.assign('/booking-thank-you')
                        } else if (response.success === false) {


                            hideLoading()
                            openPopup('specialLoading')
                            document.getElementById('loadingText').textContent = response.message

                            let helperButton = document.createElement('a')
                            helperButton.className = 'btn'
                            helperButton.textContent = 'Please try pay directly on PayPal'
                            helperButton.href = response.data.errors.approval_link

                            document.getElementById('specialLoadingContainer').insertBefore(helperButton, document.getElementById('loadingText').nextSibling)

                        }

                    }
                };

                xhr.onerror = function (error) {
                    hideLoading()
                    toastify(this.statusText);
                    Sentry.captureException(new SubmitFeedbackSubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
                };

                xhr.open('POST', '/v1/paypal-payment', true);

                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('Authorization', token);
                xhr.send(JSON.stringify(params));

            })

        }


        loadScript('/frontend/assets/js/step5Validation.js' + version, function () {
            if (document.getElementsByClassName('pencilOpener')[0]) {
                let pencilOpener = document.getElementsByClassName('pencilOpener')[0]

                pencilOpener.addEventListener('click', function () {

                    if (pencilOpener.dataset.opened === '0') {
                        document.getElementsByClassName('hiddenForm')[0].style.maxHeight = '1000px'
                        pencilOpener.dataset.opened = '1'
                    } else if (pencilOpener.dataset.opened === '1') {
                        document.getElementsByClassName('hiddenForm')[0].style.maxHeight = '0px'
                        pencilOpener.dataset.opened = '0'
                    }

                })

            }
        })

    })
}

function settings_wallets() {

    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/addCoinsToWalletValidation.js' + version, function () {
            //initialize stripe SDK
            initializeStripe()

            //reseting add coins form
            if (document.getElementsByClassName('addCoinsToWalletPage')[0]) {
                document.getElementsByClassName('addCoinsToWalletPage')[0].addEventListener('click', function () {
                    document.getElementById('coins').value = ''
                    document.getElementById('coins').classList.remove('ok')
                })

            }

            //initialize PayPal SDK
            initializePayPal('capture')

            if (document.getElementsByClassName('calculateHeighter')[0]) {
                let calculateHeighters = document.getElementsByClassName('calculateHeighter')
                for (let i = 0; i < calculateHeighters.length; i++) {
                    calculateHeighters[i].addEventListener('click', function () {
                        setTimeout(function () {
                            calculatePopUpHeight(document.getElementById('addCoinsPaymentPopUp'))
                        })
                    })
                }
            }

            deleteCards()
            selectDefaultCard()
            selectCardForPayment()

        })

    })

    //when 3ds payment is done we put succes query parameter to show message to user
    let params = new URLSearchParams(window.location.search)
    if (params.has('success')) {
        toastify(getPoTranslate('YOUR_PAYMENT_SUCCESS'))
        history.pushState({}, document.title, location.origin + location.pathname)
    }

    if (params.has('openAddCoins')) {
        openPopup('addCoinsPopUp')
        history.pushState({}, document.title, location.origin + location.pathname)
    }
}

function settings_payouts() {
    hideLoading()
    let transactionHistoryTrLinks = document.getElementsByClassName('transactionHistoryLink')
    for (let i = 0; i < transactionHistoryTrLinks.length; i++) {
        transactionHistoryTrLinks[i].addEventListener('click', function () {

            if (typeof transactionHistoryTrLinks[i].dataset.booking !== 'undefined') {
                showLoading()

                //let newUrlConstructor = new URL(feurl.value + '/booking/' + 512);

                location.assign(transactionHistoryTrLinks[i].dataset.booking)

            }


        })

    }
}

function billing_ingormations() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/step5Validation.js' + version, function () {

        });





    })
}


function talkCategoryF() {

    loadScript('/frontend/assets/js/searchFilters.js' + version, function () {

    })

    let items = document.getElementById('categoryCarousel').getElementsByClassName('tabs-title');
    for (let i = 0; i < items.length; i++) {

        items[i].addEventListener('click', function () {

            this.style.textDecoration = 'underline';
            this.getElementsByTagName('span')[0].style.color = '#313131';
            this.getElementsByTagName('span')[1].style.color = '#313131';
            showLoading();
            location.assign(location.href + '/' + this.getElementsByClassName('innerTitlesForCarouselSlider')[0].textContent.trim());
        });

    }

}

function booking_thank_you_page() {

    /* if (document.getElementsByClassName('dateHolderBookingToShow')[0]) {
     document.getElementsByClassName('dateHolderBookingToShow')[0].style.visibility = 'visible'
     }
     if (document.getElementsByClassName('dateToShowOnThankYou')[0]) {
     let dateToShowOnThankYou = document.getElementsByClassName('dateToShowOnThankYou')
     for (let i = 0; i < dateToShowOnThankYou.length; i++) {
     dateToShowOnThankYou[i].textContent = getDateWithMonthName(dateToShowOnThankYou[i].textContent.trim())
     }
     } */

    window.localStorage.removeItem('bookingObj');

    window.addEventListener('resize', resizeDots);
    resizeDots();

    function resizeDots() {
        let maxHeight;
        if (document.getElementsByClassName('thankyou-item')[0]) {
            let heights = document.getElementsByClassName('thankyou-item');
            maxHeight = heights[0].offsetHeight;
            for (let i = 0; i < heights.length; i++) {
                if (heights[i].offsetHeight > maxHeight) {
                    maxHeight = heights[i].offsetHeight;
                }

            }
        }

        if (document.getElementById('styledResizer')) {
            document.getElementById('styledResizer').remove();
        }

        let style = document.createElement('style');
        style.id = 'styledResizer';
        style.innerHTML = '.icon-re-size::before {height:' + (maxHeight - 64) + 'px!important}';

        document.getElementsByClassName('thankyou-item')[0].appendChild(style);

    }

}

function about_meF() {
    loadScript('/frontend/assets/js/step3Validation.js' + version, function () {

    })
}


function talkDetailFunction() {
    let follow_user = document.getElementsByClassName('follow_user');
    for (let i = 0; i < follow_user.length; i++) {
        follow_user[i].addEventListener('click', function () {
            followFunction(this, false);
        })

    }

}

function jtc_welcomeF() {


    if (document.getElementById('getStartedJtc')) {
        let getStartedJtc = document.getElementById('getStartedJtc');
        getStartedJtc.addEventListener('click', function () {
            let xhr = new XMLHttpRequest()

            let params = {
                '_token': token,
            };

            xhr.onloadstart = function () {
                showLoading();
            };

            xhr.onreadystatechange = function () {

                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.response);

                    if (response.success === true) {
                        let partnerId = document.querySelector("meta[name='partner_id']")
                        if (loggedIn) {
                            location.href = '/jtc/create-profile';
                        } else {

                            location.href = '/jtc/create-profile';
                        }


                    } else if (response.success === false) {
                        toastify(response.message)
                    }


                }
            };

            xhr.onerror = function (error) {
                toastify(this.statusText);
                Sentry.captureException(new SubmitFeedbackSubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
            };

            xhr.open('POST', '/jtc/start', true);

            xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8');

            xhr.send(JSON.stringify(params));
        });
    }


}

function settingsPayoutExclusive() {
    let cpPayments = document.getElementsByClassName('cpPayment');
    let hasEventListener = false;

    for (let i = 0; i < cpPayments.length; i++) {
        cpPayments[i].addEventListener('click', function () {
            //this.dataset.date, uzimamo date i saljemo ga preko ajaxa serveru, server nam vraca podatke za payment popup
            let xhr = new XMLHttpRequest();

            // Payout Data from clicked element.
            let data = {
                payout: this.getAttribute('data-payout'),
            };

            let url = '/v1/payouts/' + data.payout;

            // Popup element.
            let popup = document.getElementById(cpPayments[i].dataset.popup);


            if (data.payout === 'currentEarnings') {
                url = '/v1/payouts/current-earnings';
            }

            xhr.open('GET', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.setRequestHeader('Authorization', document.querySelector('meta[name="access_token"]').content);
            xhr.setRequestHeader('Accept-Language', document.querySelector('meta[name="app_language"]').content);

            xhr.send();

            xhr.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.response);

                    populatePopup(response.data)

                    calculatePopUpHeight(document.getElementById('payoutPopup'), 52)
                }
            }

            /**
             * Populate Payout Modal with the Data from the response.
             *
             * @param data
             */
            function populatePopup(data) {
                let popupBookingsContainer = popup.querySelector('.paymentItemsContainer');
                let popupBookings = popup.querySelectorAll('.paymentItemsPaymentPopup');

                popup.querySelector('.add-time-title').innerHTML = (url !== '/v1/payouts/current-earnings' ? getPoTranslate('PAYOUT') : getPoTranslate('TOTAL')) + ' ' + getPoTranslate('MONTH_' + data.month.toUpperCase() + '_LONG') + ' ' + data.year;
                popup.querySelector('.payoutPopupMethodTotal').innerHTML = '€ ' + data.payout;
                popup.querySelector('.payoutPopupMethodTotalSub').innerHTML = data.talks_count + ' ' + getPoTranslate('TALKS') + ' / ' + data.duration;
                popup.querySelector('.payoutPopupBoldText').innerHTML = data.payout_date ? getPoTranslate('PAYOUT_MODAL_SUBTITLE').replace(':method', 'IBAN').replace(':date', data.payout_date) : 'Current earnings';
                popup.querySelector('.payoutTableBlackText.iban').innerHTML = data.iban;
                popup.querySelector('.payoutTableBlackText.name').innerHTML = data.name;

                if (!hasEventListener) {
                    popup.querySelector('.btn').addEventListener('click', sendPayoutMail.bind(event, data.payout_id));
                    hasEventListener = true;
                }

                popup.querySelector('.btn').style.display = (url !== '/v1/payouts/current-earnings' ? 'inline-block' : 'none');

                if (url === '/v1/payouts/current-earnings') {
                    popup.querySelector('div').style.overflowY = 'hidden';
                    popupBookingsContainer.style.maxHeight = '200px';
                    popupBookingsContainer.style.overflowY = 'auto';
                }

                data.bookings.forEach(booking => {
                    let popupBooking = popupBookings[0].cloneNode(true);

                    popupBooking.querySelector('.payoutTableBlackText').innerHTML = booking.headline;
                    popupBooking.querySelector('.stateOfPaymentPayout').innerHTML = booking.date + ' ' + (booking.extension ? '(Extension)' : '');
                    popupBooking.querySelector('.pricePayment').innerHTML = booking.price + ' €';

                    popupBookingsContainer.appendChild(popupBooking.cloneNode(true));
                });

                popupBookings.forEach(booking => booking.outerHTML = '');
            }

            /**
             * Send Payout Summary to the Client.
             *
             * @param payout
             */
            function sendPayoutMail(payout) {
                let xhr = new XMLHttpRequest();
                xhr.open('POST', '/v1/payouts/' + payout + '/send-payout-summary');
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('Authorization', bearerToken);
                xhr.setRequestHeader('Accept-Language', document.querySelector('meta[name="app_language"]').content);
                xhr.send();

                xhr.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response);
                        toastify(response.message);
                    }
                };
            }

            setTimeout(function () {
                calculatePopUpHeight(document.getElementById(cpPayments[i].dataset.popup), 52);
            }, 310);

            openPopup(this.dataset.popup);
        });

    }
}

function settings_followingF() {

    //reject user from private fallowing list
    if (document.getElementsByClassName('rejectFollowerPrivate')[0]) {

        let rejectFollowerPrivate = document.getElementsByClassName('rejectFollowerPrivate')

        for (let i = 0; i < rejectFollowerPrivate.length; i++) {

            rejectFollowerPrivate[i].addEventListener('click', function (e) {
                e.preventDefault()
                showLoading()
                let xhr = new XMLHttpRequest()
                let url = envAppBackendUrl + '/reject-follow-request/' + e.currentTarget.dataset.userId

                let params = {
                    '_token': token
                }

                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {
                        let response = JSON.parse(this.response)

                        if (response.success === true) {


                            let parent = rejectFollowerPrivate[i].parentElement.parentElement.parentElement
                            parent.style.scale = '0'
                            parent.style.opacity = '0'
                            setTimeout(function () {
                                parent.remove()

                                if (document.getElementById('privatePendingContainer').getElementsByClassName('followRequestContainer').length === 0) {
                                    document.getElementById('privatePendingContainer').innerHTML = ''
                                } else {
                                    let numberOfFollowers = document.getElementsByClassName('numberOfFollowers')
                                    for (let i = 0; i < numberOfFollowers.length; i++) {
                                        numberOfFollowers[i].textContent = parseInt(numberOfFollowers[i].textContent) - 1
                                    }
                                }
                            }, 310)

                            toastify(response.message)
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
                    Sentry.captureException(new SubmitRejectPrivateFallowing(error + 'status: ' + this
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



        class SubmitRejectPrivateFallowing extends Error {
            constructor(message) {
                super(message)
                this.name = "SubmitRejectPrivateFallowing"
            }
        }
    }

    //remove user from private fallowing list
    if (document.getElementsByClassName('removeUserFromFollowingList')[0]) {

        let removeUserFromFollowingList = document.getElementsByClassName('removeUserFromFollowingList')

        for (let i = 0; i < removeUserFromFollowingList.length; i++) {

            removeUserFromFollowingList[i].addEventListener('click', removePrivateFollower)

        }

    }

    //accept user to private fallowing list



    if (document.getElementsByClassName('acceptFollowerPrivate')[0]) {
        let acceptFollowerPrivate = document.getElementsByClassName('acceptFollowerPrivate')

        for (let i = 0; i < acceptFollowerPrivate.length; i++) {

            acceptFollowerPrivate[i].addEventListener('click', acceptFollowRequest)

        }

    }
}


function jtc2_create_profileF() {

    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/jtc2Step1Validators.js' + version, function () {
            loadScript('/frontend/assets/js/loginRegisterForgot.js' + version, function () {
                showHidePassword()


            })

        })
    })

}

function jtc2_email_verificationF() {

    loadScript('/frontend/assets/js/jtc2Step2Validators.js' + version, function () {

    })

}



function jtc2_add_your_first_talkF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/talksAndAvailabilityValidation.js' + version, function () {
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

            let courseItem = document.getElementsByClassName('dataTalkId');

            for (let i = 0; i < courseItem.length; i++) {
                courseItem[i].addEventListener('click', function () {

                    window.clickedEdit = 1;
                    getTalkData(courseItem[i].dataset.talkId);
                    document.getElementsByClassName('addNewTalkDescription')[0].classList.add('dn');

                    document.getElementsByClassName('editnewTalkDescription')[0].classList.remove('dn');


                });
            }

            deleteTalk()
        })
    })
}

function jtc2_set_availabilitiesF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/jtc2Step3Validators.js' + version, function () {




        })
    })

}

function jtc2_verify_accountF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/verificationValidation.js' + version, function () {
            document.getElementsByClassName('imagePointerForCropper')[0].addEventListener('click', function () {
                window.verificationSuccess = 2
            })
            document.getElementsByClassName('my-form')[0].addEventListener('click', function () {
                window.verificationSuccess = 1
            })

        });
    });
}

function password_resetF() {
    loadScript('/frontend/assets/js/formValidators.js' + version, function () {
        loadScript('/frontend/assets/js/forgotPasswordValidation.js' + version, function () {


        });
    });
}


export function routeController() {

    let pageName = document.body.className

    switch (pageName) {

        case 'header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden login-page password_reset':
            password_resetF()
            break
        case 'account_verification':
            accountVerificationF();
            break;

        case 'jtc2_verify_account':
            jtc2_verify_accountF()
            break
        case 'jtc2_set_availabilities':
            jtc2_set_availabilitiesF()
            break
        case 'jtc2_add_your_first_talk':
            jtc2_add_your_first_talkF()
            break
        case 'jtc2_create_profile':
            jtc2_create_profileF()
            break
        case 'jtc2_email_verification':
            jtc2_email_verificationF()
            break
        case 'jtc_welcome':
            jtc_welcomeF();
            break;
        case 'home':
            homeF();
            break;
        case 'settings_following':
            followUnfollowUserOptions();
            settings_followingF()
            break;
        case 'faq':
            faqF();
            break;
        case 'logged_in':
            logged_inF();
            break;
        case 'talk_details':
            talkDetailFunction();
            break;
        case 'profile':
            profileF();
            break;
        case 'privacy-policy':
            privacyPolicyF();
            break;
        case 'about_me':
            about_meF();
            break;
        case 'logout':
            loginF();
            break;
        case 'login':
            loginF();
            break;
        case 'forgot_password':
            forgotPasswordF();
            break;
        case 'signup':
            signUpF();
            break;
        case 'settings_profile':
            settingsProfileF();
            break;
        case 'settings_notifications':
            settingsNotificationF();
            break;
        case 'booking':
            bookingF();
            break;
        case 'courses':
            talks();
            break;
        case 'settings_reviews':
            feedbackComments();
            break;
        case 'video_conference':
            videoConferenceF();
            break;
        case 'book_slot':
            book_slotF();
            break;
        case 'favorites_users':
            favoriteUsers();
            break;
        case 'favorites_talks':
            favoriteTalks();
            break;
        case 'book_slot_payment':
            book_slot_paymentF();
            break;
        case 'settings_wallets':
            settings_wallets();
            break;
        case 'billing_ingormations':
            billing_ingormations();
            break;
        case 'talkCategory':
            talkCategoryF();
            break;
        case 'booking_thank_you':
            booking_thank_you_page();
            break;
        case 'settings_transaction_history':
            settings_payouts();
            break;
        case 'settings_payouts_page':
            jtcSetPayoutOptions();
            jtcSetPayoutOptionsF();
            settingsPayoutExclusive();
            break;
        case 'talkCategorySubcategory':
            talkCategorySubcategoryF();
            break;

    }
}

class SubmitFeedbackSubmitError extends Error {
    constructor(message) {
        super(message);
        this.name = 'SubmitFeedbackSubmitError';
    }
}

class TryCatchGetFeedbackReviewXMLHttpRequestFunction extends Error {
    constructor(message) {
        super(message);
        this.name = 'TryCatchGetFeedbackReviewXMLHttpRequestFunction';
    }
}

class TryCatchSubmitFeedbackReviewXMLHttpRequestFunction extends Error {
    constructor(message) {
        super(message);
        this.name = 'TryCatchSubmitFeedbackReviewXMLHttpRequestFunction';
    }
}

class GetRatingFullError extends Error {
    constructor(message) {
        super(message);
        this.name = 'GetRatingFullError';
    }
}


class FeedbackCommentsUrlError extends Error {
    constructor(message) {
        super(message);
        this.name = 'FeedbackCommentsUrlError';
    }
}



class TeacherAvailableExtensionsError extends Error {
    constructor(message) {
        super(message);
        this.name = 'TeacherAvailableExtensionsError';
    }
}


