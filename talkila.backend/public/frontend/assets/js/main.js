const d = new Date()
let timeZoneOffset



let appLanguage = document.querySelector('meta[name="app_language"]').content
let bearerToken = document.querySelector('meta[name="access_token"]').content
let token = document.querySelector('meta[name="csrf-token"]').content

let loggedIn =  document.querySelector('meta[name="user_id"]') ? (document.querySelector('meta[name="user_id"]').content ? true : false) : false


window.consts = {
    private_status_ON: 1,
    private_status_OFF: 2,
    audio_talk_ON: 1,
    video_talk_ON: 2,
    ONE_TO_ONE: 1,
    GROUP: 2,
    VOICE_CALL: 1,
    VIDEO_CALL: 2,
    HANGUP: 11,
    TALK_PAUSED: 1,
    DECLINE:9
}

if( d.getTimezoneOffset() < 0){
    timeZoneOffset = Math.abs(d.getTimezoneOffset())
}else{
    timeZoneOffset = '-' + d.getTimezoneOffset()
}
document.cookie = "timezone=" + timeZoneOffset

window.deCapitalizeFirstLetter = function(string) {
    return string.charAt(0).toLowerCase() + string.slice(1);
}

window.capitalizeFirstLetter = function(word){
    return word.charAt(0).toUpperCase() + word.slice(1)
}


window.select_group_language = function(languageId){
    let options = languageG.options

        for (let k = 0; k < options.length; k++) {

            if (options[k].value == languageId) {

                options[k].parentElement.classList.add('ok')
                languageG.selectedIndex = k
                break
            }
        }

}


window.select_language = function(languageId){
    let options = languageP.options

        for (let k = 0; k < options.length; k++) {

            if (options[k].value == languageId) {

                options[k].parentElement.classList.add('ok')
                languageP.selectedIndex = k
                break
            }
        }

}

window.select_group_category_input_and_select_subcategory = function(data, category_id = 0, talk_sub_category_id = 0){


    let options = categoryG.options
    if(category_id){
        for (let k = 0; k < options.length; k++) {

            if (options[k].value == category_id) {

                categoryG.classList.add('ok')

                subCategoryG.parentElement.parentElement.classList.remove('dn')

                categoryG.selectedIndex = k
                break
            }
        }
    }

    for (let i = 0; i < data.length; i++) {

        if (data[i].id === category_id) {

            //input sub category

            let subcategories = data[i].subcategories
            let option = document.createElement('option')
            option.className = "dn"
            document.getElementById('subCategoryG').appendChild(option)
            for (let j = 0; j < subcategories.length; j++) {
                const element = subcategories[j];
                let option = document.createElement('option')
                option.value = element.id
                option.text = element.value
                document.getElementById('subCategoryG').appendChild(option)
            }
            //select subcategory
            let options = subCategoryG.options
            if(talk_sub_category_id){
                for (let k = 0; k < options.length; k++) {

                    if (options[k].value == talk_sub_category_id) {

                        options[k].parentElement.classList.add('ok')
                        subCategoryG.selectedIndex = k
                        break
                    }
                }
            }

        }

    }
}

window.select_category_input_and_select_subcategory = function(data, category_id = 0, talk_sub_category_id = 0){


    let options = categoryP.options
    if(category_id){
        for (let k = 0; k < options.length; k++) {

            if (options[k].value == category_id) {

                categoryP.classList.add('ok')
                subCategoryP.parentElement.parentElement.classList.remove('dn')

                categoryP.selectedIndex = k
                break
            }
        }
    }

    for (let i = 0; i < data.length; i++) {

        if (data[i].id === category_id) {

            //input sub category

            let subcategories = data[i].subcategories
            let option = document.createElement('option')
            option.className = "dn"
            document.getElementById('subCategoryP').appendChild(option)
            for (let j = 0; j < subcategories.length; j++) {
                const element = subcategories[j];
                let option = document.createElement('option')
                option.value = element.id
                option.text = element.value
                document.getElementById('subCategoryP').appendChild(option)
            }
            //select subcategory
            let options = subCategoryP.options
            if(talk_sub_category_id){
                for (let k = 0; k < options.length; k++) {

                    if (options[k].value == talk_sub_category_id) {

                        options[k].parentElement.classList.add('ok')
                        subCategoryP.selectedIndex = k
                        break
                    }
                }
            }

        }

    }
}

window.inputGroupLanguages = function(){
    let app_languages = JSON.parse(localStorage.getItem('app_languages_' + getCookie('activeLang')))
    let languages = app_languages.data.languages
        if(app_languages){

            document.getElementById('languageG').innerHTML = ''
            let option = document.createElement('option')
            option.className = "dn"
            document.getElementById('languageG').appendChild(option)

            for (let i = 0; i < languages.length; i++) {
                const element = languages[i];
                let option = document.createElement('option')
                option.value = element.id
                option.text = element.value

                document.getElementById('languageG').appendChild(option)
            }

            let languageGOptions = document.getElementById('languageG').options

            for (let k = 0; k < languageGOptions.length; k++) {

                if (languageGOptions[k].value == '33') {

                    languageGOptions[k].parentElement.classList.add('ok')
                    languageG.selectedIndex = k
                    break
                }
            }
        }
}

window.inputLanguages = function(){
    let app_languages = JSON.parse(localStorage.getItem('app_languages_' + getCookie('activeLang')))
    let languages = app_languages.data.languages
        if(app_languages){

            document.getElementById('languageP').innerHTML = ''
            let option = document.createElement('option')
            option.className = "dn"
            document.getElementById('languageP').appendChild(option)

            for (let i = 0; i < languages.length; i++) {
                const element = languages[i];
                let option = document.createElement('option')
                option.value = element.id
                option.text = element.value

                document.getElementById('languageP').appendChild(option)
            }

            let languagePOptions = document.getElementById('languageP').options

            for (let k = 0; k < languagePOptions.length; k++) {

                if (languagePOptions[k].value == '33') {

                    languagePOptions[k].parentElement.classList.add('ok')
                    languageP.selectedIndex = k
                    break
                }
            }
        }
}

window.inputGroupCategories = function(){
    let app_talk_categories = JSON.parse(localStorage.getItem('app_talk_categories_' + getCookie('activeLang')))

    let data = app_talk_categories.talk_categories.data

    if (app_talk_categories) {


        document.getElementById('categoryG').innerHTML = ''


        let option = document.createElement('option')
        option.className = "dn"
        document.getElementById('categoryG').appendChild(option)

        for (let i = 0; i < data.length; i++) {
            const element = data[i];
            let option = document.createElement('option')
            option.value = element.id
            option.text = element.value

            document.getElementById('categoryG').appendChild(option)
        }
    }

}

window.inputCategories = function(){
    let app_talk_categories = JSON.parse(localStorage.getItem('app_talk_categories_' + getCookie('activeLang')))

    let data = app_talk_categories.talk_categories.data

    if (app_talk_categories) {


        document.getElementById('categoryP').innerHTML = ''


        let option = document.createElement('option')
        option.className = "dn"
        document.getElementById('categoryP').appendChild(option)

        for (let i = 0; i < data.length; i++) {
            const element = data[i];
            let option = document.createElement('option')
            option.value = element.id
            option.text = element.value

            document.getElementById('categoryP').appendChild(option)
        }
    }

}

window._loadedScripts = window._loadedScripts || {};
window.loadScript = function(e, t, type) {

        var scriptKey = e.split('?')[0];
        if (window._loadedScripts[scriptKey]) {
            if (window._loadedScripts[scriptKey] === true) {
                if (t) t();
            } else {
                window._loadedScripts[scriptKey].push(t);
            }
            return;
        }
        window._loadedScripts[scriptKey] = [t];

        let a = document.createElement("script");
        (a.type = "text/javascript"),
            a.readyState ?
                (a.onreadystatechange = function () {
                    if ("loaded" === a.readyState || "complete" === a.readyState) {
                        a.onreadystatechange = null;
                        var callbacks = window._loadedScripts[scriptKey];
                        window._loadedScripts[scriptKey] = true;
                        if (Array.isArray(callbacks)) { callbacks.forEach(function(cb) { if (cb) cb(); }); }
                    }
                })
                :
                (a.onload = function () {
                    var callbacks = window._loadedScripts[scriptKey];
                    window._loadedScripts[scriptKey] = true;
                    if (Array.isArray(callbacks)) { callbacks.forEach(function(cb) { if (cb) cb(); }); }
                }),
            (a.src = e),
            type ? a.type = "module" : null,
            document.getElementsByTagName("head")[0].appendChild(a)

}

window.loadCss = function(e) {
    let t = document.getElementsByTagName("head")[0],
        a = document.createElement("link");
    (a.rel = "stylesheet"), (a.type = "text/css"), (a.href = e), (a.media = "all"), t.appendChild(a)
}

window.removeHighlightedAvailabilites = function () {
    if (document.getElementsByClassName('redFramebord')[0]) {
        let redFramebords = document.getElementsByClassName('redFramebord')
        let arre = []
        for (let i = redFramebords.length - 1; i >= 0; i--) {
            let highlightedItems = redFramebords[i].getElementsByClassName('divItemTransition')


            for (let k = highlightedItems.length - 1; k >= 0; k--) {
                arre.push(highlightedItems[k])
            }

            let reversed = arre.reverse()

            for (let j = 0; j < reversed.length; j++) {

                if (reversed[j].parentElement.classList.contains('redFramebord')) {
                    redFramebords[i].parentElement.insertBefore(reversed[j], reversed[j].parentElement)
                }

            }
            redFramebords[i].remove()
        }

    }
}

window.getCookie = function (cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

window.deleteCookie = function (name, path = false) {
    path = path ?? '/'
    document.cookie = name + '=; Path='+ path +'; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

window.setCookie = function (cname, cvalue, seconds, path) {
    var d = new Date();
    d.setTime(d.getTime() + (seconds * 1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=" + path;
}
window.showMoreThreeDots = function(){
    if (document.getElementsByClassName('showMoreDesc')[0]) {
        let showMoreDesc = document.getElementsByClassName('showMoreDesc')
        for (let i = 0; i < showMoreDesc.length; i++) {

            showMoreDesc[i].addEventListener('click', function (e) {
                e.preventDefault()
                e.stopImmediatePropagation()
                e.stopPropagation()
                let parent = this.parentElement
                if (this.dataset.opened === "0") {

                    parent.getElementsByClassName('threeDots')[0].classList.add('dn')
                    parent.getElementsByClassName('restofchars')[0].classList.remove('dn')
                    this.innerHTML = getPoTranslate('SHOW_LESS')
                    this.dataset.opened = 1
                } else if (this.dataset.opened === "1") {

                    parent.getElementsByClassName('threeDots')[0].classList.remove('dn')
                    parent.getElementsByClassName('restofchars')[0].classList.add('dn')
                    this.innerHTML = getPoTranslate('PROFILE_SHOW_MORE_BUTTON_TEXT')
                    this.dataset.opened = 0
                }

                if(document.body.className === "booking"){
                    calculatePopUpHeight(this.closest('.popupBase'))
                }

            })
        }

    }
}


window.diff_minutes = function (dt2, dt1) {

    let diff = (dt2.getTime() - dt1.getTime()) / 1000
    diff /= 60
    return Math.abs(Math.round(diff))

}

window.getDayFromObj = function (x) {
    let day
    switch (parseInt(x)) {
        case 1:
            day = "Monday";
            break;
        case 2:
            day = "Tuesday";
            break;
        case 3:
            day = "Wednesday";
            break;
        case 4:
            day = "Thursday";
            break;
        case 5:
            day = "Friday";
            break;
        case 6:
            day = "Saturday";
            break;
        case 7:
            day = "Sunday";
    }
    return day
}


window.eventFire = function (el, etype) {
    try {
        if (el.fireEvent) {

            el.fireEvent('on' + etype)

        } else {

            const evObj = new CustomEvent(etype, {
                bubbles: true,
                cancelable: false,
                detail: false
            })

            el.dispatchEvent(evObj)
        }
    } catch (error) {
        console.log('event fire function could not process', error)
    }

}
//TODO
window.showLoading = function () {
    if(document.getElementById('loadingPopup')){
        document.getElementById('loadingPopup').style.display = 'flex';
        document.getElementById('loadingPopup').style.alignItems = 'center';
        document.getElementById('loadingPopup').style.zIndex = '2147483647'
        setTimeout(
            function () {
                document.getElementById('loadingPopup').style.opacity = '1';
                document.getElementById('loadingPopup').getElementsByClassName('popuper')[0].style.transform = 'scale(1)'
            }
        )
    }



}
//TODO
window.hideLoading = function () {
    if(document.getElementById('loadingPopup')){
        if (document.body.className === 'video_conference') {
            closePopup('loadingPopup')
        } else {
            document.getElementById('loadingPopup').style.opacity = '0';
            document.getElementById('loadingPopup').getElementsByClassName('popuper')[0].style.transform = 'scale(0)'

            setTimeout(
                function () {
                    document.getElementById('loadingPopup').style.display = 'none';
                }, 310
            )
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
        escapeMarkup:false
    }).showToast();
}

window.addZero = function (i) {
    if (i < 10) {
        i = "0" + i
    }
    return i
}

window.addMinutes = function (date, minutes) {
    return new Date(date.getTime() + minutes * 60000)
}

window.clearAfterDestroyCropper = function(){
    if(document.getElementsByClassName('cropper-container')[0]){
        let croperContainers = document.getElementsByClassName('cropper-container')
        for (let i = 0; i < croperContainers.length; i++) {
            croperContainers[i].remove()

        }
    }
    if(document.getElementsByClassName('uploadButton')[0]){
        let uploadButtons = document.getElementsByClassName('uploadButton')
        for (let i = 0; i < uploadButtons.length; i++) {
            uploadButtons[i].style.display = 'block'

        }
    }
}


window.getPoTranslate = function (poTranslateStringName, poArgs = false){

    if(poArgs){
        if(typeof window.i18n !== 'undefined' && typeof window.i18n === 'object'){
            if(typeof window.i18n[poTranslateStringName] !== 'undefined' && window.i18n[poTranslateStringName].length > 0){

                let splitPoTag = window.i18n[poTranslateStringName].split(':')
                let translatedWithArgs = ''

                for (let i = 0; i < splitPoTag.length-1; i++) {
                    let seccondSplitPoTag = splitPoTag[i+1].split(' ')

                    let position = splitPoTag[i+1].indexOf(" ")

                    splitPoTag[i+1] = poArgs[seccondSplitPoTag[0]] + splitPoTag[i+1].slice(position)
                }

                for (let i = 0; i < splitPoTag.length; i++) {
                    translatedWithArgs += splitPoTag[i]
                }

                return translatedWithArgs
            }else{
                return poTranslateStringName
            }
        }else{
            return poTranslateStringName
        }
    }

    if(typeof window.i18n !== 'undefined' && typeof window.i18n === 'object'){
        if(typeof window.i18n[poTranslateStringName] !== 'undefined' && window.i18n[poTranslateStringName].length > 0){
            return window.i18n[poTranslateStringName]
        }else{
            return poTranslateStringName
        }
    }else{
        return poTranslateStringName
    }
}

window.editAvailability = function(that) {
    window.addAvailabilityPointer = 2
    document.getElementById('timeSlotValidation').innerHTML = ''
    showTimePupup()

    let userAvailabilites = JSON.parse(document.getElementById('userAvailabilites').value).availabilities

    for (let i = 0; i < userAvailabilites.length; i++) {

        if (userAvailabilites[i].id == that.dataset.timeSlotId) {
            //set day
            setAndClearDay(document.getElementById('time-slot-popup'), userAvailabilites[i].weekday)

            let sTime, eTime

            if (that.className === "bg-color-yello") {

                sTime = userAvailabilites[i].start_time.split(':')
                eTime = userAvailabilites[i].end_time.split(':')

                setDrums(document.getElementById('time-slot-popup'), sTime[0], sTime[1], eTime[0], eTime[1])
                document.getElementById('submit-btn').dataset.timeSlotId = that.dataset.timeSlotId
                document.getElementById('submit-btn').textContent = getPoTranslate('EDIT_TIME_SLOT')
                document.getElementById('time-slot-popup').getElementsByClassName('add-time-title')[0].textContent =
                    getPoTranslate('EDIT_TIME_SLOT')

            } else {

                let times = that.getElementsByTagName('small')[0].textContent.trim().split(' - ')

                sTime = times[0].split(':')
                eTime = times[1].split(':')
                setDrums(document.getElementById('time-slot-popup'), sTime[0], sTime[1], eTime[0], eTime[1])

                if (document.body.className === "logged_in") {
                    document.getElementById('submit-btn').dataset.timeSlotId = that.dataset.timeSlotId
                    document.getElementById('submit-btn').textContent = getPoTranslate('EDIT_TIME_SLOT')
                    document.getElementById('time-slot-popup').getElementsByClassName('add-time-title')[0]
                        .textContent = getPoTranslate('EDIT_TIME_SLOT')

                    window.edditingAvailability = 1
                } else {

                    if (that.className === "date-time") {
                        document.getElementById('submit-btn').dataset.timeSlotId = that.dataset.timeSlotId
                        document.getElementById('submit-btn').textContent = getPoTranslate('EDIT_TIME_SLOT')
                        document.getElementById('time-slot-popup').getElementsByClassName('add-time-title')[0]
                            .textContent = getPoTranslate('EDIT_TIME_SLOT')

                    } else {
                        document.getElementById('submit-btn').dataset.timeSlotId = ''
                        document.getElementById('submit-btn').textContent = getPoTranslate('ADD_TIME_SLOT')
                        document.getElementById('time-slot-popup').getElementsByClassName('add-time-title')[0]
                            .textContent = getPoTranslate('ADD_TIME_SLOT')
                    }

                }

            }
            if (that.dataset.jtctimeslot === "1") {
                setDrums(document.getElementById('time-slot-popup'), '10', '00', '11', '00')
            }
        }
    }

}

window.openPaymentPopuper = function(text) {
    openPopup('specialLoading')
    document.getElementById('loadingText').textContent = text
}

window.removeActivePointerFromNoDeleteCardList = function (){
    if(document.getElementById('stripeerCont').getElementsByClassName('active')[0]){

        document.getElementById('stripeerCont').getElementsByClassName('active')[0].classList.remove('active')

    }
    if(document.getElementById('stripeerCont').getElementsByClassName('pon')[0]){

        document.getElementById('stripeerCont').getElementsByClassName('pon')[0].classList.remove('pon')

    }
}

window.getBoxHeight = function(elmID) {
    var elmHeight, elmMargin, elm = document.getElementById(elmID)

        elmHeight = elm.offsetHeight
        elmMargin = parseInt(document.defaultView.getComputedStyle(elm, '').getPropertyValue('margin-top')) + parseInt(document.defaultView.getComputedStyle(elm, '').getPropertyValue('margin-bottom'))

    return (elmHeight+elmMargin)
}



//global variables

let mobileNavElement = document.getElementsByClassName('mobileNav')[0]

let version = "?v="+document.getElementById('app_version').textContent.trim()

let assetsUlr = '/frontend/assets/js/app.js'

var localizationJson = JSON.parse(document.getElementById('localizationJson').textContent.trim())
var socketServerUrl = document.getElementById('socketServerUrl').textContent.trim()
const envAppBackendUrl = document.getElementById('beurl').textContent.trim()

let isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent)

let isIE11 = !!window.MSInputMethodContext && !!document.documentMode

//main bundle load
loadScript(assetsUlr+version, function() {})
