let translate = {
    minimum: getPoTranslate('MINIMUM'),
    maximum: deCapitalizeFirstLetter(getPoTranslate('MAXIMUM')),
    characters: deCapitalizeFirstLetter(getPoTranslate('CHARACTERS')),
    timeError: getPoTranslate('START_TIME_MUST_BE_BEFORE_END_TIME'),
    timeError2: getPoTranslate('TIME_CANT_BE_LARGER_THAN', {
        'minutes_amount': '120'
    }),
    timeError3: getPoTranslate('END_TIME_MUST_BE_GREATER'),
    timeError4: getPoTranslate('TIME_DIFFERANCE_MUST_NOT_BE_GREATER_THAN_480_MINUTES'),
    oneSymbol: getPoTranslate('ONE_SPECIAL_CHARACTER'),
    oneNumber: getPoTranslate('ONE_NUMBER'),
    oneLowercase: getPoTranslate('ONE_LOWERCASE'),
    oneUppercase: getPoTranslate('ONE_UPPERCASE'),
    missingName: getPoTranslate('MISSING_NAME'),
    missingSurname: getPoTranslate('MISSING_SURNAME'),
    noNumbers: getPoTranslate('NO_NUMBERS_ALLOWED'),
    noSpecialCharacters: getPoTranslate('NO_SPECIAL_CARACTERS_ALLOWED'),
    noSymbols: getPoTranslate('NO_SPECIAL_CARACTERS_ALLOWED'),
    noSpaces: getPoTranslate('NO_SPACES_ALLOWED'),
    newPasswordMarchOld: getPoTranslate('NEW_PASSWORD_CAN_NOT_BE_SAME_AS_OLD'),
    passwordDoNotMatch: getPoTranslate('NEW_PASSWORD_DO_NOT_MATCH'),
    uniqueUsername: getPoTranslate('THAT_USERNAME_IS_ALREADY_USED'),
    hasName: getPoTranslate('MISSING_NAME'),
    hasSurname: getPoTranslate('MISSING_SURNAME'),
    hasNumber: getPoTranslate('NO_NUMBERS_ALLOWED'),
    hasSymbol: getPoTranslate('NO_SPECIAL_CARACTERS_ALLOWED')
}

function removeCommaFromValidationWarning(validationWarningText) {
    if (validationWarningText) {
        if (validationWarningText.trim().charAt(validationWarningText.trim().length - 1) == ",") {
            return validationWarningText.trim().substring(0, validationWarningText.trim().length - 1)
        }
        return validationWarningText
    }
}

function checkLength(value, min, max) {
    let filter = {
        lengthLimit: value.length >= min && value.length <= max,
        minimumOK: value.length >= min,
        maximumOK: value.length <= max
    }
    if (filter.lengthLimit) {
        filter["isOk"] = true
        return filter
    } else {
        filter["isOk"] = false
        return filter
    }
}

function checkLength2(value, min, max) {
    let filter = {
        lengthLimit: value >= min && value <= max,
        minimumOK: value >= min,
        maximumOK: value <= max
    }
    if (filter.lengthLimit) {
        filter["isOk"] = true
        return filter
    } else {
        filter["isOk"] = false
        return filter
    }
}

function usernameCheck2(value) {

    let nameFormat = /^(?=^[^_\n][A-Za-z0-9_]+$)\w{4,50}$/;
    let symbolFormat = /(?=.*[`!@#$%^&*()\-+=\[\]{};':"\\|,.<>\/?~]).*$/
    let numberFormat = /^(?=.*[0-9]).*$/

    return {

        nameFormatOk: value.match(nameFormat) ? true : false,
        hasSymbol: value.match(symbolFormat) ? true : false,
        hasNumber: value.match(numberFormat) ? true : false,
        lengthLimit: value.length > 4 && value.length < 50 ? false : true,
        hasSpace: value.indexOf(' ') >= 0 ? true : false
    }



}

function usernameCheck(value, target) {

    let usernameInput = document.getElementsByClassName("username-input")

    let usernameWarn = document.getElementsByClassName("username-warn")

    let usernameSvg = document.getElementsByClassName("verified-username-svg")

    let usernamePreview = document.getElementsByClassName("username-preview")

    let step1username = document.getElementsByClassName("step1username")

    let nameFormat = /^(?=^[^_\n][A-Za-z0-9_]+$)\w{4,50}$/;
    let symbolFormat = /(?=.*[`!@#$%^&*()\-+=\[\]{};':"\\|,.<>\/?~]).*$/
    let numberFormat = /^(?=.*[0-9]).*$/

    if (value.match(nameFormat)) {

        for (let i = 0; i < usernamePreview.length; i++) {
            usernamePreview[i].innerHTML = value
            usernamePreview[i].style.color = '#a6acb7'
        }

        step1username[0].innerHTML = value
        step1username[0].style.color = '#a6acb7'

        let postData = {
            username: value
        }

        showLoading()

        let token = document.querySelector('meta[name="csrf-token"]').content

        let xhr = new XMLHttpRequest()
        let url = envAppBackendUrl + '/user-validate-username'

        let params = {
            'username': value
        }

        xhr.onreadystatechange = function () {

            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.response)
                if (response.success === true) {
                    window.usernameStatus = {
                        isOk: true,
                        uniqueUsername: true
                    }

                    checkUsernameHelper(window.usernameStatus, usernameInput, usernamePreview, step1username, usernameSvg, usernameWarn)


                    if (document.getElementById('suggestedUsernamesMesage')?.parentElement) {
                        document.getElementById('suggestedUsernamesMesage').parentElement.classList.add('dn')
                    }
                    return window.usernameStatu

                } else if (response.success === false) {

                    if (value === target.dataset.username) {

                        window.usernameStatus = {
                            isOk: true,
                            uniqueUsername: true
                        }


                        checkUsernameHelper(window.usernameStatus, usernameInput, usernamePreview, step1username, usernameSvg, usernameWarn)


                    } else {
                        if (document.getElementById('suggestedUsernamesMesage')?.parentElement) {
                            document.getElementById('suggestedUsernamesMesage').parentElement.classList.remove('dn')
                        }
                        if (response.hasOwnProperty('data')) {

                            window.usernameStatus = {
                                isOk: false,
                                hasSymbol: value.match(symbolFormat) ? true : false,
                                lengthLimit: value.length > 4 && value.length < 50 ? false : true,
                                hasSpace: value.indexOf(' ') >= 0 ? true : false,
                                uniqueUsername: true
                            }


                            checkUsernameHelper(window.usernameStatus, usernameInput, usernamePreview, step1username, usernameSvg, usernameWarn)
                            let usernameInputs = document.getElementsByClassName('username-input')
                            for (let i = 0; i < usernameInputs.length; i++) {

                                usernameInputs[i].parentElement.getElementsByClassName('username-warn')[0].textContent = response.data.errors.username[0]
                                usernameInputs[i].parentElement.getElementsByClassName('username-warn')[0].classList.add('active')
                            }



                        } else {

                            window.usernameStatus = {
                                isOk: true,
                                hasSymbol: value.match(symbolFormat) ? true : false,
                                lengthLimit: value.length > 4 && value.length < 50 ? false : true,
                                hasSpace: value.indexOf(' ') >= 0 ? true : false,
                                uniqueUsername: true
                            }


                            checkUsernameHelper(window.usernameStatus, usernameInput, usernamePreview, step1username, usernameSvg, usernameWarn)



                        }
                    }



                }
            } else if (this.readyState == 4 && this.status == 400) {

                let response = JSON.parse(this.response)

                if (document.getElementById('suggestedUsernamesMesage')?.parentElement) {
                    document.getElementById('suggestedUsernamesMesage').parentElement.classList.remove('dn')
                }
                if (response.success === false) {
                    if(loggedIn){
                        if (value === target.dataset.username) {

                            window.usernameStatus = {
                                isOk: true,
                                uniqueUsername: true
                            }


                            checkUsernameHelper(window.usernameStatus, usernameInput, usernamePreview, step1username, usernameSvg, usernameWarn)


                        } else {
                            inputSuggestedHelper(false, false)


                            if (response.hasOwnProperty('data')) {

                                window.usernameStatus = {
                                    isOk: false,
                                    hasSymbol: value.match(symbolFormat) ? true : false,
                                    lengthLimit: value.length > 4 && value.length < 50 ? false : true,
                                    hasSpace: value.indexOf(' ') >= 0 ? true : false,
                                    uniqueUsername: true
                                }


                                checkUsernameHelper(window.usernameStatus, usernameInput, usernamePreview, step1username, usernameSvg, usernameWarn)
                                let usernameInputs = document.getElementsByClassName('username-input')
                                for (let i = 0; i < usernameInputs.length; i++) {

                                    usernameInputs[i].parentElement.getElementsByClassName('username-warn')[0].textContent = response.data.errors.username[0]
                                    usernameInputs[i].parentElement.getElementsByClassName('username-warn')[0].classList.add('active')
                                }



                            } else {

                                window.usernameStatus = {
                                    isOk: true,
                                    hasSymbol: value.match(symbolFormat) ? true : false,
                                    lengthLimit: value.length > 4 && value.length < 50 ? false : true,
                                    hasSpace: value.indexOf(' ') >= 0 ? true : false,
                                    uniqueUsername: true
                                }


                                checkUsernameHelper(window.usernameStatus, usernameInput, usernamePreview, step1username, usernameSvg, usernameWarn)



                            }
                        }
                    }else{

                            inputSuggestedHelper(false, false)


                            if (response.hasOwnProperty('data')) {

                                window.usernameStatus = {
                                    isOk: false,
                                    hasSymbol: value.match(symbolFormat) ? true : false,
                                    lengthLimit: value.length > 4 && value.length < 50 ? false : true,
                                    hasSpace: value.indexOf(' ') >= 0 ? true : false,
                                    uniqueUsername: true
                                }


                                checkUsernameHelper(window.usernameStatus, usernameInput, usernamePreview, step1username, usernameSvg, usernameWarn)
                                let usernameInputs = document.getElementsByClassName('username-input')
                                for (let i = 0; i < usernameInputs.length; i++) {

                                    usernameInputs[i].parentElement.getElementsByClassName('username-warn')[0].textContent = response.data.errors.username[0]
                                    usernameInputs[i].parentElement.getElementsByClassName('username-warn')[0].classList.add('active')
                                }



                            } else {

                                window.usernameStatus = {
                                    isOk: true,
                                    hasSymbol: value.match(symbolFormat) ? true : false,
                                    lengthLimit: value.length > 4 && value.length < 50 ? false : true,
                                    hasSpace: value.indexOf(' ') >= 0 ? true : false,
                                    uniqueUsername: true
                                }


                                checkUsernameHelper(window.usernameStatus, usernameInput, usernamePreview, step1username, usernameSvg, usernameWarn)



                            }

                    }




                }
            }
        }

        xhr.onloadend = function () {
            hideLoading()
        }

        xhr.onerror = function (error) {
            hideLoading()
            toastify(this.statusText)
            Sentry.captureException(new CheckIfUsernameExistSubmitError(error + 'status: ' + this
                .statusText +
                '|| response: ' + this.statusText + ' || url: ' + location.href));
        }

        xhr.open('POST', url, true)

        xhr.setRequestHeader('Content-Type', 'application/json;charset=UTF-8')
        xhr.setRequestHeader('Authorization', bearerToken)
        xhr.setRequestHeader('X-CSRF-TOKEN', token)

        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

        xhr.send(JSON.stringify(params))



    } else {

        usernameWarn.textContent = removeCommaFromValidationWarning(usernameWarn.textContent)
        try {
            window.usernameStatus = {
                isOk: false,
                hasSymbol: value.match(symbolFormat) ? true : false,
                lengthLimit: value.length > 4 && value.length < 50 ? false : true,
                hasSpace: value.indexOf(' ') >= 0 ? true : false
            }
            checkUsernameHelper(window.usernameStatus, usernameInput, usernamePreview, step1username, usernameSvg, usernameWarn)
            return window.usernameStatus
        } catch (err) {
            window.usernameStatus = {
                isOk: false,
                hasSymbol: value.match(symbolFormat) ? true : false,
                lengthLimit: value.length > 4 && value.length < 50 ? false : true,
                hasSpace: value.indexOf(' ') >= 0 ? true : false
            }
            checkUsernameHelper(window.usernameStatus, usernameInput, usernamePreview, step1username, usernameSvg, usernameWarn)
        }
    }
}

function checkUsernameHelper(check, usernameInput, usernamePreview, step1username, usernameSvg, usernameWarn) {

    if (check.isOk && check.uniqueUsername) {

        usernameInput[0].parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'

        countLabelDriver({
            el: usernameInput[0],
            min: 4,
            max: 50
        })

        if (usernameInput[1]) {
            usernameInput[1].parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'
            countLabelDriver({
                el: usernameInput[1],
                min: 4,
                max: 50
            })
        }

        for (let i = 0; i < usernamePreview.length; i++) {
            usernamePreview[i].innerHTML = usernameValue
            usernamePreview[i].style.color = '#a6acb7'
        }

        step1username[0].innerHTML = usernameValue
        step1username[0].style.color = 'rgb(29, 41, 63)'


        for (let i = 0; i < usernameInput.length; i++) {
            usernameInput[i].classList.remove("error")
            usernameInput[i].classList.add("ok")
        }

        for (let i = 0; i < usernameSvg.length; i++) {
            usernameSvg[i].classList.add("active")
        }

        for (let i = 0; i < usernameWarn.length; i++) {
            usernameWarn[i].textContent = ''
            usernameWarn[i].classList.remove("active")
        }

        if (document.getElementsByClassName('username-warn')[0]) {
            document.getElementsByClassName('username-warn')[0].classList.remove("active")
        }
        let subBut = document.getElementsByClassName('submit-button')
        for (let i = 0; i < subBut.length; i++) {
            subBut[i].disabled = false

        }

    } else {

        usernameInput[0].parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'

        countLabelDriver({
            el: usernameInput[0],
            min: 4,
            max: 50
        })


        if (usernameInput[1]) {
            usernameInput[1].parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'
            countLabelDriver({
                el: usernameInput[1],
                min: 4,
                max: 50
            })
        }
        if (usernamePreview) {
            for (let i = 0; i < usernamePreview.length; i++) {
                usernamePreview[i].innerHTML = usernameValue
                usernamePreview[i].style.color = '#FD2A18'
            }
        }



        step1username[0].innerHTML = usernameValue
        step1username[0].style.color = '#FD2A18'

        for (let i = 0; i < usernameInput.length; i++) {
            usernameInput[i].classList.add("error")
            usernameInput[i].classList.remove("ok")
        }

        for (let i = 0; i < usernameSvg.length; i++) {
            usernameSvg[i].classList.remove("active")
        }

        for (let i = 0; i < usernameWarn.length; i++) {
            usernameWarn[i].classList.add("active")
            usernameWarn[i].innerHTML = "&nbsp"
            usernameWarn[i].innerHTML += check.hasSymbol ? " " + translate.noSymbols + "," : ""
            usernameWarn[i].innerHTML += check.lengthLimit ? " " + getPoTranslate('MINIMUM_AND_MAXIMUM_CHARACTERS', {
                'minimum_characters': '4',
                'maximum_characters': '50'
            }) + "," : ""
            usernameWarn[i].innerHTML += check.hasSpace ? " " + translate.noSpaces + "," : ""
            usernameWarn[i].innerHTML += check.uniqueUsername ? " " + translate.uniqueUsername + "," : ""
            usernameWarn[i].textContent = removeCommaFromValidationWarning(usernameWarn[i].textContent)
        }


    }

}

function nameCheck(value) {

    let canSplit = value.indexOf(" ") >= 0

    let filter = {
        /* hasName: value.length > 1 ? true : false,
        hasSurname: canSplit && value.split(" ")[1].length > 0 ? true : false,
        hasSymbol: value.match(/(?=.*[`!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]).*$/) ? true : false,
        hasNumber: value.match(/^(?=.*[0-9]).*$/) ? true : false, */
        lengthLimit: value.length >= 2 && value.length <= 100 ? false : true
    }

    if ( /* filter.hasName && filter.hasSurname && !filter.hasSymbol && !filter.hasNumber && */ !filter.lengthLimit) {
        filter["isOk"] = true
        return filter
    } else {
        filter["isOk"] = false
        return filter
    }
}

function youTubeURLCheck(value) {

    if (value) {
        if (value.match(/^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/)) {
            return {
                isOk: true,
                youTubeUrlLinkFormat: true
            }
        }
    }
    return {
        isOk: false,
        youTubeUrlLinkFormat: false
    }
}

function emailCheck(value) {


    function isEmailAddress(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    if (isEmailAddress(value)) {
        return {
            isOk: true
        }
    } else {
        try {
            return {
                isOk: false,
                hasBeforeAt: value.length > 0 ? true : false,
                hasAt: value.split("@") ? true : false,
                hasAfterAt: value.split("@")[1] ? true : false,
                hasDot: value.split("@")[1].includes(".") ? true : false,
                hasAfterDot: value.split("@")[1].split(".")[1] ? true : false
            }

        } catch (err) {
            return {
                isOk: false,
                hasBeforeAt: value.length > 0 ? true : false,
                hasAt: false,
                hasAfterAt: false,
                hasDot: false,
                hasAfterDot: false,
            }
        }
    }
}

function passwordCheck(value) {
    let passwordFormat = /^(?=.{8,})(?=.*[a-z])(?=.*[0-9])(?=.*[A-Z])(?=.*[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]).*$/;
    if (value.match(passwordFormat) && value.length < 50) {
        return {
            isOk: true
        }
    } else {
        let filter = {
            isOk: false,
            length: {
                isOk: value.length > 8,
                translate: getPoTranslate('MINIMUM_CHARACTERS', {
                    'minimum_characters': '8'
                })
            },
            max: {
                isOk: value.length < 50,
                translate: getPoTranslate('MAXIMUM_CHARACTERS', {
                    'maximum_characters': '50'
                }),
            },
            hasSymbol: {
                isOk: value.match(/^(?=.*[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]).*$/) ? true : false,
                translate: translate.oneSymbol
            },
            hasNumber: {
                isOk: value.match(/^(?=.*[0-9]).*$/) ? true : false,
                translate: translate.oneNumber
            },
            hasLowercase: {
                isOk: value.match(/^(?=.*[a-z]).*$/) ? true : false,
                translate: translate.oneLowercase
            },
            hasUppercase: {
                isOk: value.match(/^(?=.*[A-Z]).*$/) ? true : false,
                translate: translate.oneUppercase
            }
        }
        return filter
    }
}

function createValidationElements(passwordValidationFieldsContainer, type, object, index) {

    let validationItemDisplay = document.createElement('div')
    validationItemDisplay.className = type === 'red' ? 'df aic validationItem redValidationItem' : 'df aic validationItem greenValidationItem'
    validationItemDisplay.innerHTML = document.getElementById(type === 'red' ? 'redXIcon' : 'greenCheckmarkIcon').innerHTML

    let validationText = document.createElement('span')
    validationText.textContent = Object.values(object)[index].translate

    validationItemDisplay.append(validationText)

    passwordValidationFieldsContainer.append(validationItemDisplay)

}




function countLabelDriver(params) {
    params.el.value = params.el.value.trim() === '' ? params.el.value = '' : params.el.value = params.el.value
    let counter = params.el.parentElement.getElementsByClassName("count-label")[0]
    counter.classList.remove('dn')
    counter.innerText = "(" + params.el.value.length + "/" + params.max + ")"
    counter.style.color = params.el.value.length >= params.min && params.el.value.length <= params.max ? "#313131" : "red"
    counter.style.display = params.el.value.length >= params.min && params.el.value.length <= params.max ? "none" : "block"
}

resetInputDriver()

function resetInputDriver() {
    let clearButtons = document.getElementsByClassName("clear-button")
    if (clearButtons) {
        for (let i = 0; i < clearButtons.length; i++) {
            clearButtons[i].addEventListener("click", clearField)
        }
    }

    function clearField(e) {
        let parent = e.target.parentElement
        let input


        if(parent.getElementsByClassName('default-textarea')[0]){
            parent.getElementsByClassName('verified-svg')[0].style.right = '-55px'
         }

        if(parent.getElementsByClassName('default-input-number')[0]){
           parent.getElementsByClassName('verified-svg')[0].style.right = '-55px'
        }
        if(parent.getElementsByClassName('default-input')[0]){
            parent.getElementsByClassName('verified-svg')[0].style.right = '-55px'
         }
        if(  parent.getElementsByClassName('verified-email-svg')[0]){
            parent.getElementsByClassName('verified-email-svg')[0].classList.remove('active')
            parent.getElementsByClassName('verified-email-svg')[0].style.right = '-56px'
        }
        parent.getElementsByClassName('clear-button')[0].style.right = '-56px'
        if(  parent.getElementsByClassName('verified-email-svg')[0]){
            parent.getElementsByClassName('verified-email-svg')[0].classList.remove('active')
            parent.getElementsByClassName('verified-email-svg')[0].style.right = '-56px'
        }
        if( parent.getElementsByClassName('eye-icon-mange')[0]){

            parent.getElementsByTagName('input')[0].classList.remove('ok')
        }

        if(parent.getElementsByTagName('input')[0]){
            parent.getElementsByTagName('input')[0].classList.remove('ok')
        }
        if(parent.getElementsByTagName('select')[0]){

            parent.getElementsByClassName('verified-svg')[0].style.right = '-55px'
            if(parent.getElementsByTagName('select')[0].id === 'categoryG'){
                document.getElementById('group-talk-form').getElementsByClassName('subcat')[0].classList.add('dn')
                let ele = document.getElementById('group-talk-form').elements

                ele['subCategoryG'].selectedIndex = -1
                ele['subCategoryG'].classList.remove('ok')
                ele['subCategoryG'].classList.remove('error')
                ele['subCategoryG'].parentElement.getElementsByClassName('default-warn')[0].classList.remove('active')
                ele['subCategoryG'].parentElement.getElementsByClassName('verified-svg')[0].style.right = '-55px'
                ele['subCategoryG'].parentElement.getElementsByClassName('input-label')[0].style.color = ''
                ele['subCategoryG'].parentElement.getElementsByClassName('clear-button')[0].style.right = '-55px'

            }
        }


        parent.classList.remove('ok')

        if (parent.getElementsByTagName("input").length > 0) {
            input = parent.getElementsByTagName("input")[0]
            parent.getElementsByTagName("input")[0].blur()

        } else if (parent.getElementsByTagName("select").length > 0) {
            input = parent.getElementsByTagName("select")[0]
            parent.getElementsByTagName("select")[0].blur()

        } else if (parent.getElementsByTagName("textarea").length > 0) {
            input = parent.getElementsByTagName("textarea")[0]
            parent.getElementsByTagName("textarea")[0].blur()

        }


        parent.getElementsByClassName('input-label')[0].style.color = ''

        input.value = ""
        input.classList.remove("ok")
        input.classList.remove("error")
        if(parent.getElementsByClassName('count-label')[0]){
            parent.getElementsByClassName('count-label')[0].style.cssText = "display: none; color: rgb(49, 49, 49);"

        }
        input.focus()

        let counter = parent.getElementsByClassName("count-label")
        if (counter.length > 0) {
            let split = counter[0].innerText.split("/")[1]
            parent.getElementsByClassName("count-label")[0].innerText = "(0/" + split
        }
        let children = parent.children
        for (let i = 0; i < children.length; i++) {
            children[i].classList.remove("active")
        }


    }
}

function inputDriver(params, tr) {

    let value = ""

    if (params.type === "input") value = params.el.value
    if (params.type === "textarea") value = params.el.value
    if (params.type === "select") value = params.el.selectedIndex !== (-1) ? params.el.options[params.el.selectedIndex].value : ''
    if (params.type === "datalist") value = params.el.value
    if (params.type === "number") value = params.el.value

    let inputLabel = params.el.parentElement.getElementsByClassName("input-label")[0]
    let verifiedSvg = params.el.parentElement.getElementsByClassName("verified-svg")[0]
    let defaultWarn = params.el.parentElement.getElementsByClassName("default-warn")[0]

    let check

    if (params.type !== "number") {
        check = checkLength(value, params.min, params.max)

    } else {
        check = checkLength2(value, params.min, params.max)
    }


    if (check.isOk) {

        if (params.type === "select" || params.type === "number"){
            params.el.parentElement.getElementsByClassName('clear-button')[0].style.right = '56px'
            if( params.el.parentElement.getElementsByClassName('verified-svg')[0]){
                params.el.parentElement.getElementsByClassName('verified-svg')[0].style.right = '22px'
            }




        }else{
            params.el.parentElement.getElementsByClassName('clear-button')[0].style.right = '42px'

            if( params.el.parentElement.getElementsByClassName('verified-svg')[0]){
                params.el.parentElement.getElementsByClassName('verified-svg')[0].style.right = '8px'
                params.el.parentElement.getElementsByClassName('verified-svg')[0].classList.add('ok')
            }

            if( params.el.parentElement.getElementsByClassName('verified-email-svg')[0]){
                params.el.parentElement.getElementsByClassName('verified-email-svg')[0].style.right = '8px'
                params.el.parentElement.getElementsByClassName('verified-svg')[0].classList.add('active')
            }

        }



        inputLabel.style.color = '#1d293f'
        params.el.classList.remove("error")
        params.el.classList.add("ok")

        if (params.svg) {
            verifiedSvg.classList.add("active")
        } else {

        }

        if (defaultWarn) {
            defaultWarn.classList.remove("active")
        }

        if (params.el.parentNode.parentNode.getElementsByClassName('tooltip2')[0]) {

            if (params.el.classList.contains('default-textarea')) {
                params.el.parentNode.parentNode.getElementsByClassName('tooltip2')[0].style.bottom = '50px'
            } else {
                params.el.parentNode.parentNode.getElementsByClassName('tooltip2')[0].style.top = 'calc(((100% - (100% - 48px)) / 2) - 10px'
            }

        }

        return check

    } else {




        inputLabel.style.color = '#FD2A18'

        params.el.classList.add("error")
        params.el.focus()
        params.el.classList.remove("ok")

        if (params.svg) verifiedSvg.classList.remove("active")

        if (defaultWarn) {
            defaultWarn.classList.add("active")
        }

        if (params.msg) {
            defaultWarn.innerHTML = params.msg
        }

        if (params.warn) {
            defaultWarn.innerHTML = "&nbsp"
            if (tr) {
                defaultWarn.innerHTML += (check.lengthLimit ? "" : tr.minimum) + " " + params.min + ", " + tr.maximum + " " + params.max + " " + (params.type === "number" ? '' : tr.characters)
            } else {
                defaultWarn.innerHTML += (check.lengthLimit ? "" : translate.minimum) + " " + params.min + ", " + translate.maximum + " " + params.max + " " + (params.type === "number" ? '' : translate.characters)
            }

        }

        if (params.el.parentNode.parentNode.getElementsByClassName('tooltip2')[0]) {
            params.el.parentNode.parentNode.getElementsByClassName('tooltip2')[0].style.top = 'calc(((100% - (100% - 48px)) / 2) - 10px)'
        }

        return check
    }
}











class GetTokenCheckIfUsernameExist extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenCheckIfUsernameExist"
    }
}
class CheckIfUsernameExistSubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "CheckIfUsernameExistSubmitError"
    }
}
