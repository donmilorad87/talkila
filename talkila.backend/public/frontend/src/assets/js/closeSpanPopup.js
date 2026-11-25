window.maxPopup = 0

export function showPopup() {
    let mainPopup
    let popupTrigers = document.getElementsByClassName('cp')

    let helperClose

    for (let i = 0; i < popupTrigers.length; i++) {
        popupTrigers[i].addEventListener('click', function (e) {
            let popupBases = document.getElementsByClassName('popupBase')

            if (this.dataset.popup === 'addCardPopUp') {

            } else if (this.dataset.popup === 'time-slot-popup') {
                if (this.dataset.jtctimeslot === "1") {
                    window.poperClickedZ = 1
                }
                //this list is for not closing popup when new one is opened in front
            } else if (this.dataset.popup === 'uploadDropArea') {

            } else if (this.dataset.popup === 'editFullName') {

            } else if (this.dataset.popup === 'editEmail') {

            } else if (this.dataset.popup === 'professionEdit') {

            } else if (this.dataset.popup === 'addShortDescription') {

            } else if (this.dataset.popup === 'addYouTubeVideo') {

            } else if (this.dataset.popup === 'setPrivateProfile') {

            } else if (this.dataset.popup === 'takePictureWithWebCam') {

            } else if (this.dataset.popup === 'editPassword') {

            } else if (this.dataset.popup === 'add_cv_work_experience') {

            } else if (this.dataset.popup === 'add_education') {

            } else if (this.dataset.popup === 'cardPopUp') {

            } else if (this.dataset.popup === 'addPrivateTalk') {

            } else if (this.dataset.popup === 'deleteTalkPopup') {

            } else if (this.dataset.popup === 'cv_popup') {

            } else if (this.dataset.popup === 'calendar_popup') {

            } else if (this.dataset.popup === 'social_verify') {

            } else if (this.dataset.popup === 'connected_calendars') {

            } else if (this.dataset.popup === 'deleteProfilePopup') {

            } else {
                if (window.popupIsShowing === 1) {

                    closePopupBeforeOpenOtherOne()
                }
            }

            for (let i = 0; i < popupBases.length; i++) {

                if (document.getElementById(this.dataset.popup)) {
                    let that = this.dataset.popup
                    if (helperClose === 1) {

                        setTimeout(function () {
                            if (that === 'extendCall') {
                                let extCal = document.getElementById('extendCall').getElementsByClassName('extCal')
                                for (let i = 0; i < extCal.length; i++) {
                                    if (extCal[i].classList.contains('hollow')) {
                                        extCal[i].classList.toggle('hollow')
                                    }
                                    document.getElementById('extendLesson').disabled = true
                                }
                            }
                            openPopup(that)
                        }, 410)
                    } else {
                        if (that === 'extendCall') {
                            let extCal = document.getElementById('extendCall').getElementsByClassName('extCal')
                            for (let i = 0; i < extCal.length; i++) {
                                if (extCal[i].classList.contains('hollow')) {
                                    extCal[i].classList.toggle('hollow')
                                }
                                document.getElementById('extendLesson').disabled = true
                            }
                        }
                        openPopup(this.dataset.popup)
                    }
                    return;
                }

            }

        })
    }

    let notificationBeforeMeeting = document.getElementsByClassName('notificationBeforeMeeting')

    for (let i = 0; i < notificationBeforeMeeting.length; i++) {
        notificationBeforeMeeting[i].addEventListener('click', function (e) {

            let bookingId = this.getAttribute('data-booking-id');
            let notification_state = this.checked ? 1 : 0;
            let xhttp = new XMLHttpRequest();
            let url = '/set-booking/notification/?booking_id=' + bookingId + '&notification_state=' + notification_state;

            xhttp.onreadystatechange = function () {
                if (this.readyState == 1) {
                    document.getElementsByTagName('html')[0].style.cursor = 'progress'
                }
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementsByTagName('html')[0].style.cursor = 'default'

                    let response = JSON.parse(xhttp.responseText)
                    Toastify({
                        text: response.message,
                        className: "notification",
                        gravity: "bottom",
                        position: "left",
                        close: true,
                        duration: 3000,
                        stopOnFocus: true,
                        escapeMarkup: false
                        // avatar: "/frontend/assets/img/user-img.png"
                    }).showToast()

                }
            }

            xhttp.onerror = function (error) {
                Sentry.captureException(new setBookingNotificationError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
            }

            xhttp.open("GET", url, true)
            xhttp.send()

        })
    }

    let cancelBooking = document.getElementsByClassName('cancelBooking')
    for (let i = 0; i < cancelBooking.length; i++) {
        cancelBooking[i].addEventListener('click', function (e) {

            let reasons = document.getElementsByClassName('reason')
            let checkedReason = 0
            Array.prototype.forEach.call(reasons, function (element) {
                if (element.checked) {
                    checkedReason = element.value
                }
            });

            let bookingId = this.getAttribute('data-booking-id');
            let xhttp = new XMLHttpRequest();
            let url = '/cancel-booking/?booking_id=' + bookingId + '&reason_id=' + checkedReason


            xhttp.onreadystatechange = function () {
                if (this.readyState == 1) {
                    document.getElementsByTagName('html')[0].style.cursor = 'progress'
                }
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementsByTagName('html')[0].style.cursor = 'default'

                    let response = JSON.parse(xhttp.responseText)
                    Toastify({
                        text: response.message,
                        className: "notification",
                        gravity: "bottom",
                        position: "left",
                        close: true,
                        duration: 3000,
                        stopOnFocus: true,
                        escapeMarkup: false
                        // avatar: "/frontend/assets/img/user-img.png"
                    }).showToast();

                    if (response.success) {
                        let closeSpanPopus = document.getElementsByClassName('closeSpanPopup')
                        for (let i = 0; i < closeSpanPopus.length; i++) {
                            closePopup(closeSpanPopus[i].parentNode.parentNode.id)

                        }
                        showLoading()
                        location.reload()
                    }
                }
            };

            xhttp.onerror = function (error) {
                Sentry.captureException(new CancelBookingError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
            };

            xhttp.open("GET", url, true);
            xhttp.send();

        })
    }


    // left: 37, up: 38, right: 39, down: 40,
    // spacebar: 32, pageup: 33, pagedown: 34, end: 35, home: 36
    var keys = { 37: 1, 38: 1, 39: 1, 40: 1 };

    function preventDefault(e) {
        e.preventDefault();
    }

    function preventDefaultForScrollKeys(e) {
        if (keys[e.keyCode]) {
            preventDefault(e);
            return false;
        }
    }

    // modern Chrome requires { passive: false } when adding event
    var supportsPassive = false;
    try {
        window.addEventListener("test", null, Object.defineProperty({}, 'passive', {
            get: function () { supportsPassive = true; }
        }));
    } catch (e) { }

    var wheelOpt = supportsPassive ? { passive: false } : false;
    var wheelEvent = 'onwheel' in document.createElement('div') ? 'wheel' : 'mousewheel';

    // call this to Disable
    function disableScroll() {
        window.addEventListener('DOMMouseScroll', preventDefault, false); // older FF
        window.addEventListener(wheelEvent, preventDefault, wheelOpt); // modern desktop
        window.addEventListener('touchmove', preventDefault, wheelOpt); // mobile
        window.addEventListener('keydown', preventDefaultForScrollKeys, false);
    }

    // call this to Enable
    function enableScroll() {
        window.removeEventListener('DOMMouseScroll', preventDefault, false);
        window.removeEventListener(wheelEvent, preventDefault, wheelOpt);
        window.removeEventListener('touchmove', preventDefault, wheelOpt);
        window.removeEventListener('keydown', preventDefaultForScrollKeys, false);
    }

    window.openPopup = function (x) {

        if (document.getElementById(x)) {

            document.documentElement.style.overflow = 'hidden'

            let mainPopup = document.getElementById(x)
            mainPopup.style.display = 'flex'

            if (mainPopup.id === 'extendCall') {
                mainPopup.classList.add('extendCallPopupCorrection')
            } else if (mainPopup.id === 'paymentWalletPopUp') {
                mainPopup.classList.add('extendCallPopupCorrection')
            } else if (mainPopup.id === 'paymentCompletedPopUp') {
                mainPopup.classList.add('extendCallPopupCorrection')
                mainPopup.classList.add('extendCallPopupCorrection2')
            }else if (mainPopup.id === 'time-slot-popup') {

                mainPopup.style.alignItems = 'center'
            }  else {
                mainPopup.style.alignItems = 'center'
            }



            if (mainPopup.getElementsByClassName('popuper')[0]) {
                mainPopup.getElementsByClassName('popuper')[0].style.padding = '0'
            } else {
                mainPopup.getElementsByClassName('popuper2')[0].style.padding = '0'
            }


            setTimeout(function () {

                if (mainPopup.id === "callSetting") {

                    //mainPopup.getElementsByClassName('popuper')[0].style.height = elHight + 'px'
                    calculatePopUpHeight(mainPopup, 35)

                } else if (mainPopup.id === "time-slot-popup") {

                    calculatePopUpHeight(mainPopup, 52)
                    document.getElementById('timeSlotValidation').textContent = ''
                    if (window.poperClickedZ === 1) {

                        if (document.getElementById('time-slot-popup')) {
                            setDrums(document.getElementById('time-slot-popup'), '10', '00', '11', '00')
                        }
                        window.poperClickedZ = 0
                    }



                } else if (mainPopup.id === "setPrivateProfile") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "addGroupTalk") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "appStorePupUp") {

                    calculatePopUpHeight(mainPopup)

                } else if (mainPopup.id === "addPrivateTalk") {
                    setTimeout(function () {
                        if (window.clickedEdit === 1) {
                            calculatePopUpHeight(mainPopup, 94)
                        } else {
                            calculatePopUpHeight(mainPopup, 94)
                        }

                    }, 100)



                } else if (mainPopup.id === "cv_popup") {

                    calculatePopUpHeight(mainPopup, 52)


                } else if (mainPopup.id === "newFilterPopup") {

                    /*  document.getElementsByClassName('credit-model')[0].style.height = document.getElementById('newFilterForm').getElementsByClassName('pb4')[0].offsetHeight + 'px'
                     document.getElementById('newFilterPopup').getElementsByClassName('popuper')[0].style.height = document.getElementsByClassName('credit-model')[0].offsetHeight +
                     document.getElementsByClassName('zzswe')[0].offsetHeight + document.getElementById('newFilterForm').getElementsByClassName('bbut')[0].offsetHeight + 'px' */



                } else if (mainPopup.id === "profileSettings") {
                    window.profileSettings = 1
                } else if (mainPopup.id === "editPassword") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "uploadDropArea") {
                    document.getElementsByClassName('checkImageBeforeUpload')[0].classList.remove('dn')
                    if (document.getElementById('uploadDropArea')?.getElementsByClassName('popuper')[0]) {
                        document.getElementById('uploadDropArea').getElementsByClassName('popuper')[0].style.height = 'auto'
                    }

                } else if (mainPopup.id === "takePictureWithWebCam") {

                    calculatePopUpHeight(mainPopup, 82)

                } else if (mainPopup.id === "editEmail") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "chosePaymentMethodPopup") {

                    calculatePopUpHeight(mainPopup, 52)


                } else if (mainPopup.id === "connected_calendars") {

                    calculatePopUpHeight(mainPopup, 72)


                } else if (mainPopup.id === "calendar_popup") {
                    calculatePopUpHeight(mainPopup, 52)
                } else if (mainPopup.id === "languagePopUp") {

                    calculatePopUpHeight(mainPopup, 52)


                } else if (mainPopup.id === "social_verify") {

                    calculatePopUpHeight(mainPopup, 52)


                } else if (mainPopup.id === "permision_popup") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "blockedUsersPopup") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "privateFollowingPopup") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "cardPopUp") {

                    calculatePopUpHeight(mainPopup, 0)

                } else if (mainPopup.id === "editFullName") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "extendCall") {

                    calculatePopUpHeight(mainPopup, 10)

                } else if (mainPopup.id === "paymentCompletedPopUp") {

                    calculatePopUpHeight(mainPopup, 10)

                } else if (mainPopup.id === "paymentWalletPopUp") {

                    calculatePopUpHeight(mainPopup, 10)

                } else if (mainPopup.id === "deleteTalkPopup") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "addCompleteTalk") {

                    calculatePopUpHeight(mainPopup, 94)

                } else if (mainPopup.id === "addShortDescription") {

                    mainPopup.getElementsByClassName('b0')[0].textContent = '(' + mainPopup.getElementsByTagName('textarea')[0].textContent.length + '/1000)'
                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "add_education") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "addYouTubeVideo") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "changeAvailability") {

                    calculatePopUpHeight(mainPopup, 52)

                } else if (mainPopup.id === "shareProfilePopUp") {

                    window.sharePopupTakl = 1

                    let k1ffs = document.getElementsByClassName('k1ff')
                    for (let i = 0; i < k1ffs.length; i++) {
                        k1ffs[i].classList.remove('dn')
                    }

                    let qrCodes = document.getElementsByClassName('qrcode')
                    for (let i = 0; i < qrCodes.length; i++) {
                        qrCodes[i].classList.add('dn')
                    }
                    let closeQR = document.getElementsByClassName('closeQR')
                    for (let i = 0; i < closeQR.length; i++) {
                        closeQR[i].classList.add('dn')
                    }
                    calculatePopUpHeight(mainPopup)
                } else if (mainPopup.id === "shareProfilePopUp2") {

                    window.sharePopupTakl = 0

                    let k1ffs = document.getElementsByClassName('k1ff')
                    for (let i = 0; i < k1ffs.length; i++) {
                        k1ffs[i].classList.remove('dn')
                    }

                    let qrCodes = document.getElementsByClassName('qrcode')
                    for (let i = 0; i < qrCodes.length; i++) {
                        qrCodes[i].classList.add('dn')
                    }
                    let closeQR = document.getElementsByClassName('closeQR')
                    for (let i = 0; i < closeQR.length; i++) {
                        closeQR[i].classList.add('dn')
                    }
                    calculatePopUpHeight(mainPopup)
                } else if (mainPopup.id === "shareProfilePopUp4") {

                    window.sharePopupTakl = 2

                    let k1ffs = document.getElementsByClassName('k1ff')
                    for (let i = 0; i < k1ffs.length; i++) {
                        k1ffs[i].classList.remove('dn')
                    }

                    let qrCodes = document.getElementsByClassName('qrcode')
                    for (let i = 0; i < qrCodes.length; i++) {
                        qrCodes[i].classList.add('dn')
                    }
                    let closeQR = document.getElementsByClassName('closeQR')
                    for (let i = 0; i < closeQR.length; i++) {
                        closeQR[i].classList.add('dn')
                    }
                    calculatePopUpHeight(mainPopup)
                } else if (mainPopup.id === "add_cv_work_experience") {

                    calculatePopUpHeight(mainPopup, 52)
                    window.experienceHelperCV = 1
                    window.professionHelper = 1

                    let inputs = document.getElementById('work-expirence-cv-form').elements
                    for (let i = 0; i < inputs.length; i++) {
                        if (inputs[i].type === 'checkbox') {
                            inputs[i].checked = false
                        } else {
                            inputs[i].value = ''
                            inputs[i].classList.remove('ok')
                        }
                    }

                } else if (mainPopup.id === "blankPopup") {
                    calculatePopUpHeight(mainPopup, 52)
                } else if (mainPopup.id === "professionEdit") {
                    calculatePopUpHeight(mainPopup, 52)

                    if (window.experienceHelperCV === 1) {
                        let proff = document.getElementById('edit_profession_form').elements['profession']
                        proff.value = ''
                        proff.classList.remove('ok')
                    }

                } else if (mainPopup.id === "call-popup") {

                    /* if(document.getElementsByTagName('main')[0]){
                        document.getElementsByTagName('main')[0].style.filter = 'blur(2px)'
                    }

                    if(document.getElementsByTagName('footer')[0]){
                        document.getElementsByTagName('footer')[0].style.filter = 'blur(2px)'
                    }

                    if(document.getElementsByTagName('header')[0]){
                        document.getElementsByTagName('header')[0].style.filter = 'blur(2px)'
                    }

                    if(document.getElementById('scroll')){
                        document.getElementById('scroll').style.filter = 'blur(2px)'
                    }
                    if(document.getElementsByClassName('ptbo')[0]){
                        document.getElementsByClassName('ptbo')[0].style.filter = 'blur(2px)'
                    }
                    if(document.getElementsByClassName('footer-tabs')[0]){
                       document.getElementsByClassName('footer-tabs')[0].style.filter = 'blur(2px)'
                    } */

                    setTimeout(function () {
                        setSizeOfCallingPopup()
                    }, 100)

                    function setSizeOfCallingPopup() {
                        let elHight, elHight1, elHight2

                        elHight1 = document.getElementById('call-popup').getElementsByClassName('form-option')[0].offsetHeight
                        elHight2 = document.getElementById('call-popup').getElementsByClassName('calling-model')[0].offsetHeight

                        elHight1 > elHight2 ? elHight = elHight1 + 20 : elHight = elHight2 + 20

                        let popuper
                        if (mainPopup.getElementsByClassName('popuper')[0]) {
                            popuper = mainPopup.getElementsByClassName('popuper')[0]
                        } else {
                            popuper = mainPopup.getElementsByClassName('popuper2')[0]
                        }

                        if (elHight > (window.innerHeight * 0.85)) {
                            popuper.style.height = '90%'
                            popuper.style.maxHeight = '90%'
                            popuper.style.marginTop = '5%'
                        } else {

                            popuper.style.maxHeight = '100%'
                            popuper.style.marginTop = '0'
                        }
                    }

                    window.addEventListener("resize", setSizeOfCallingPopup)

                } else {
                    calculatePopUpHeight(mainPopup)
                }
            }, 100)

            setTimeout(() => {
                if (mainPopup.id === "editFullName") {
                    document.getElementById('edit_full_name_form').elements['name'].focus()
                } else if (mainPopup.id === "editEmail") {
                    document.getElementById('edit_email_form').elements['email'].focus()
                } else if (mainPopup.id === "professionEdit") {
                    document.getElementById('edit_profession_form').elements['profession'].focus()
                } else if (mainPopup.id === "addShortDescription") {
                    document.getElementById('add-bio-form').elements['addBio'].focus()
                } else if (mainPopup.id === "editPassword") {
                    document.getElementById('edit_password_form').elements['password'].focus()
                }
            }, 200);


            setTimeout(function () {

                mainPopup.style.opacity = 1

                if (mainPopup.getElementsByClassName('popuper')[0]) {
                    mainPopup.getElementsByClassName('popuper')[0].style.transform = 'scale(1)'
                    mainPopup.getElementsByClassName('popuper')[0].style.padding = '0'
                } else {
                    mainPopup.getElementsByClassName('popuper2')[0].style.transform = 'scale(1)'
                    mainPopup.getElementsByClassName('popuper2')[0].style.padding = '0'
                }


            }, 110)

            mainPopup.dataset.opened = 1
            window.popupIsShowing = 1
            helperClose = 0
            mainPopup.style.zIndex = '99999999'
            if (window.mainPopuper123 === '' || typeof window.mainPopuper123 === 'undefined') {
                window.mainPopuper123 = mainPopup


            } else {

                if (window.mainPopuper1233 !== '' && typeof window.mainPopuper1233 !== 'undefined') {
                    window.mainPopuper1234 = window.mainPopuper1233
                    window.mainPopuper1233 = window.mainPopuper1232
                    window.mainPopuper1232 = window.mainPopuper123
                    window.mainPopuper123 = mainPopup

                } else {
                    if (window.mainPopuper1232 !== '' && typeof window.mainPopuper1232 !== 'undefined') {
                        window.mainPopuper1233 = window.mainPopuper1232
                        window.mainPopuper1232 = window.mainPopuper123
                        window.mainPopuper123 = mainPopup

                    } else {
                        if (window.mainPopuper123 !== '' && typeof window.mainPopuper123 !== 'undefined') {
                            window.mainPopuper1232 = window.mainPopuper123
                            window.mainPopuper123 = mainPopup

                        }
                    }
                }

            }
        } else {
            console.log('that popup is not on the page')
        }



    }




    function closePopupBeforeOpenOtherOne() {


        let popupBases = document.getElementsByClassName('popupBase')
        for (let i = 0; i < popupBases.length; i++) {

            if (popupBases[i].dataset.opened === "1") {

                closePopup(popupBases[i].id)
                helperClose = 1
            }
        }

    }

    window.closePopup = function (closePopupIdString) {

        if (document.getElementById(closePopupIdString)) {
            /* enableScroll() */


            document.documentElement.style.overflow = 'auto'
            let x = document.getElementById(closePopupIdString)

            //only for share popups, hide qr code before close popup
            if(x.getElementsByClassName('closeQR')[0]){

                if(!x.getElementsByClassName('closeQR')[0].classList.contains('dn')){
                    x.getElementsByClassName('closeQR')[0].click()
                }
            }

            if (x.getElementsByClassName('popuper')[0]) {
                x.getElementsByClassName('popuper')[0].style.transform = 'scale(0)'


                x.style.opacity = 0

                setTimeout(function () {
                    x.style.display = 'none'
                    x.style.zIndex = '1'
                }, 310)

                x.dataset.opened = 0

                if (x.id === "addCardPopUp") {
                    window.popupIsShowing = 1
                } else if (x.id === "call-popup") {
                    /*  if(document.getElementsByTagName('main')[0]){
                         document.getElementsByTagName('main')[0].style.filter = 'blur(0px)'
                     }

                     if(document.getElementsByTagName('footer')[0]){
                         document.getElementsByTagName('footer')[0].style.filter = 'blur(0px)'
                     }

                     if(document.getElementsByTagName('header')[0]){
                         document.getElementsByTagName('header')[0].style.filter = 'blur(0px)'
                     }

                     if(document.getElementById('scroll')){
                         document.getElementById('scroll').style.filter = 'blur(0px)'
                     }
                     if(document.getElementsByClassName('ptbo')[0]){
                         document.getElementsByClassName('ptbo')[0].style.filter = 'blur(0px)'
                     }
                     if(document.getElementsByClassName('footer-tabs')[0]){
                        document.getElementsByClassName('footer-tabs')[0].style.filter = 'blur(0px)'
                    } */
                } else if (x.id === "blankPopup") {
                    if (document.body.className === "book_slot") {
                        document.getElementById('funnelReviewWrapTotal').appendChild(document.getElementById('funnelReviewWrap'))
                        window.popupIsShowing = 0
                    }

                } else if (x.id === "private-talk-form") {

                    clearForm(document.getElementById('private-talk-form'))
                } else if (x.id === "time-slot-popup") {

                    document.getElementById('timeSlotValidation').style.height = '0px'

                } else {
                    window.popupIsShowing = 0
                }
            }


            if (
                (window.mainPopuper1234 !== '' && typeof window.mainPopuper1234 !== 'undefined') &&
                (window.mainPopuper1233 !== '' && typeof window.mainPopuper1233 !== 'undefined') &&
                (window.mainPopuper1232 !== '' && typeof window.mainPopuper1232 !== 'undefined') &&
                (window.mainPopuper123 !== '' && typeof window.mainPopuper123 !== 'undefined')
            ) {

                window.mainPopuper123 = window.mainPopuper1232
                window.mainPopuper1232 = window.mainPopuper1233
                window.mainPopuper1233 = window.mainPopuper1234
                window.mainPopuper1234 = ''
            } else if (
                (window.mainPopuper1234 === '' || typeof window.mainPopuper1234 === 'undefined') &&
                (window.mainPopuper1233 !== '' && typeof window.mainPopuper1233 !== 'undefined') &&
                (window.mainPopuper1232 !== '' && typeof window.mainPopuper1232 !== 'undefined') &&
                (window.mainPopuper123 !== '' && typeof window.mainPopuper123 !== 'undefined')
            ) {

                window.mainPopuper123 = window.mainPopuper1232
                window.mainPopuper1232 = window.mainPopuper1233
                window.mainPopuper1233 = ''
                window.mainPopuper1234 = ''
            } else if (
                (window.mainPopuper1234 === '' || typeof window.mainPopuper1234 === 'undefined') &&
                (window.mainPopuper1233 === '' || typeof window.mainPopuper1233 === 'undefined') &&
                (window.mainPopuper1232 !== '' && typeof window.mainPopuper1232 !== 'undefined') &&
                (window.mainPopuper123 !== '' && typeof window.mainPopuper123 !== 'undefined')
            ) {

                window.mainPopuper123 = window.mainPopuper1232
                window.mainPopuper1232 = ''
                window.mainPopuper1233 = ''
                window.mainPopuper1234 = ''
            } else if (
                (window.mainPopuper1234 === '' || typeof window.mainPopuper1234 === 'undefined') &&
                (window.mainPopuper1233 === '' || typeof window.mainPopuper1233 === 'undefined') &&
                (window.mainPopuper1232 === '' || typeof window.mainPopuper1232 === 'undefined') &&
                (window.mainPopuper123 !== '' && typeof window.mainPopuper123 !== 'undefined')
            ) {

                window.mainPopuper123 = ''
                window.mainPopuper1232 = ''
                window.mainPopuper1233 = ''
                window.mainPopuper1234 = ''
            }
        } else {
            console.log('that popup is not exist on this page')
        }



    }

    let closer = document.getElementsByClassName('closer')
    for (let i = 0; i < closer.length; i++) {
        closer[i].addEventListener('click', function () {
            if (this.dataset.close) {
                closePopup(this.dataset.close)
            }
        })
    }

    let closeSpanPopus = document.getElementsByClassName('closeSpanPopup')
    for (let i = 0; i < closeSpanPopus.length; i++) {
        closeSpanPopus[i].addEventListener('click', function (e) {
            closePopup(e.target.parentNode.parentNode.id)
            if (e.target.parentNode.parentNode.id === 'professionEdit') {

                document.getElementById('edit_profession_form').elements['profession'].value = ''
                document.getElementById('professionn').style.opacity = '0'

                document.getElementById('professionn').style.height = '0px'

                document.getElementById('professionn').innerHTML = ''
                setTimeout(function () {
                    document.getElementById('editProfessionSubmit').parentElement.style.opacity = '1'
                    document.getElementById('editProfessionSubmit').parentElement.style.transform = 'scale(1)'
                }, 310)

            }
        })
    }



    let popupers = document.getElementsByClassName('popuper')
    for (let i = 0; i < popupers.length; i++) {
        popupers[i].addEventListener('click', function (e) {
            e.stopPropagation()
        })
    }

    let popupBases = document.getElementsByClassName('popupBase')

    for (let i = 0; i < popupBases.length; i++) {
        popupBases[i].addEventListener('click', function () {

            // THIs popups wont close when you click dark transparent bacgkround
            if (this.id.trim() === 'call-popup' ||
                this.id.trim() === 'time-slot-popup' ||
                this.id.trim() === 'professionEdit' ||
                this.id.trim() === 'addPrivateTalk' ||
                this.id.trim() === 'addGroupTalk' ||
                this.id.trim() === 'reviewPopUp' ||
                this.id.trim() === 'addCoinsPopUp' ||
                this.id.trim() === 'cardPopUp' ||
                this.id.trim() === 'newFilterPopup' ||
                this.id.trim() === 'specialLoading' ||
                this.id.trim() === 'loadingPopup' ||
                this.id.trim().includes("classDetails")

            ) {

            } else if (this.id.trim() === 'blankPopup') {

                closePopup(this.id)
                setTimeout(function () {
                    if (document.getElementById('funnelReviewWrapTotal')) {
                        document.getElementById('funnelReviewWrapTotal').appendChild(document.getElementById('funnelReviewWrap'))
                    }
                }, 310)
            } else {

                closePopup(this.id)
            }
        })
    }

    document.getElementById('declineCall')?.addEventListener('click', function () {
        closePopup('call-popup')
    })

    document.getElementById('acceptCall')?.addEventListener('click', function () {
        location.assign(window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/talk/incall');
    })




}

window.addEventListener("resize", function () {


    if (window.mainPopuper123 !== '' && typeof window.mainPopuper123 !== 'undefined') {
        if (window.mainPopuper123.id !== "newFilterPopup" || 'appStorePupUp') {
            if (window.mainPopuper123.getElementsByClassName('popuper')[0]) {
                calculatePopUpHeight(window.mainPopuper123, window.mainPopuper123.getElementsByClassName('popuper')[0].dataset.offset)
            } else if (window.mainPopuper123.getElementsByClassName('popuper2')[0]) {
                calculatePopUpHeight(window.mainPopuper123, window.mainPopuper123.getElementsByClassName('popuper2')[0].dataset.offset)
            }
        }
    }




})

window.calculatePopUpHeight = function (mainPopup, offset, minHeight) {
    setTimeout(function () {
        if (mainPopup) {

            if (!offset) {
                offset = 0
            } else {
                offset = parseInt(offset)
            }

            if (minHeight) {

                let elHight = minHeight + 5
                if (mainPopup.id === "calendar_popup" && window.innerWidth < 640) {
                    return
                } else {
                    calculatePopUpHeightHelper(mainPopup, elHight)

                }

            } else {

                if (mainPopup.getElementsByClassName('popuper')[0]) {

                    let elHight = mainPopup.getElementsByClassName('popuper')[0].getElementsByTagName('div')[0].offsetHeight + 5 + offset


                    if (offset) {
                        mainPopup.getElementsByClassName('popuper')[0].dataset.offset = offset
                    }

                    if (minHeight) {
                        mainPopup.getElementsByClassName('popuper')[0].dataset.minHeight = minHeight
                    }


                    if (mainPopup.id === "calendar_popup" && window.innerWidth < 640) {
                        return
                    } else {
                        calculatePopUpHeightHelper(mainPopup, elHight)

                    }
                } else {
                    let elHight = mainPopup.getElementsByClassName('popuper2')[0].getElementsByTagName('div')[0].offsetHeight + 5 + offset

                    if (offset) {
                        mainPopup.getElementsByClassName('popuper2')[0].dataset.offset = offset
                    }

                    if (minHeight) {
                        mainPopup.getElementsByClassName('popuper2')[0].dataset.minHeight = minHeight
                    }

                    if (mainPopup.id === "calendar_popup" && window.innerWidth < 640) {
                        return
                    } else {
                        calculatePopUpHeightHelper(mainPopup, elHight)

                    }
                }

            }
        }

    }, 310)


}

function calculatePopUpHeightHelper(mainPopup, elHight) {

    let popuper
    if (mainPopup.getElementsByClassName('popuper')[0]) {
        popuper = mainPopup.getElementsByClassName('popuper')[0]
    } else {
        popuper = mainPopup.getElementsByClassName('popuper2')[0]
    }



    if (elHight > (window.innerHeight * 0.85)) {
        //popuper.style.height = '90%'
        popuper.style.maxHeight = '90%'
        //popuper.dataset.height = '90%'Њ
        popuper.getElementsByTagName('div')[0].style.overflow = 'hidden'
    } else {
        popuper.style.maxHeight = '100%'
        //popuper.style.height = elHight + 'px'
        /* popuper.style.marginTop = '0px' */

        popuper.dataset.height = elHight
    }



}

class setBookingNotificationError extends Error {
    constructor(message) {
        super(message)
        this.name = "setBookingNotificationError"
    }
}

class CancelBookingError extends Error {
    constructor(message) {
        super(message)
        this.name = "CancelBookingError"
    }
}
