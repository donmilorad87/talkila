function talksAndAvailabilityValidation() {
    let privateStatus = {}
    let groupStatus = {}
    let postPrivateData = {}
    let postGroupData = {}




    if (document.getElementById("private-talk-form")) {

        let privateForm = document.getElementById("private-talk-form").elements
        let groupForm
        if (document.getElementById("group-talk-form")) {
            groupForm = document.getElementById("group-talk-form").elements
        }



        let nameP = privateForm["nameP"]
        let categoryP = privateForm["categoryP"]
        let subCategoryP = privateForm["subCategoryP"]
        let descriptionP = privateForm["descriptionP"]

        let priceP = privateForm["priceP"]
        let languageP = privateForm["languageP"]
        let allowVideoTalkP = privateForm["allowVideoTalkP"]
        let allowAnonimousTalkP = privateForm["allowAnonimousTalkP"]
        let pauseThisTalk = privateForm["pauseThisTalk"]


        let privateSubmit = document.getElementsByClassName("saveButtonPrivateTalk")
        for (let i = 0; i < privateSubmit.length; i++) {
            privateSubmit[i].addEventListener("click", function () {
                handleSubmit("private")
            })

        }


        nameP.addEventListener("input", namePHandler)
        categoryP.addEventListener("change", categoryPHandler)
        categoryP.addEventListener("input", inputSubcategory)
        subCategoryP.addEventListener("change", subCategoryPHandler)
        descriptionP.addEventListener("input", descriptionPHandler)

        priceP.addEventListener("change", pricePHandler)
        priceP.addEventListener("input", pricePHandler)
        languageP.addEventListener("change", languagePHandler)
        allowVideoTalkP.addEventListener("change", allowVideoTalkPHandler)
        allowAnonimousTalkP.addEventListener("change", allowAnonimousTalkPHandler)
        pauseThisTalk.addEventListener("change", pauseTalkHandlerP)



        function namePHandler() {
            let params = {
                el: nameP,
                type: "input",
                min: 4,
                max: 100,
                svg: true,
                warn: true,
                msg: false
            }
            privateStatus["namePStatus"] = inputDriver(params)
            postPrivateData["name"] = nameP.value
            countLabelDriver({
                el: nameP,
                min: params.min,
                max: params.max
            })

            chekToShowButton()
            calculatePopUpHeight(document.getElementById('addPrivateTalk'), 94)
        }

        function categoryPHandler() {
            let params = {
                el: categoryP,
                type: "select",
                min: 1,
                max: 50,
                svg: false,
                warn: false,
                msg: false
            }
            privateStatus["categoryPStatus"] = inputDriver(params)
            postPrivateData["category"] = categoryP.selectedIndex !== (-1) ? categoryP.options[categoryP.selectedIndex].value : ''

            chekToShowButton()
            calculatePopUpHeight(document.getElementById('addPrivateTalk'), 94)
        }

        function inputSubcategory(e) {



            var category = e.currentTarget.options[e.currentTarget.selectedIndex].value


            document.getElementById('subCategoryP').innerHTML = ''

            let app_talk_categories = JSON.parse(localStorage.getItem('app_talk_categories_' + getCookie('activeLang')))

            let data = app_talk_categories.talk_categories.data

            for (let i = 0; i < data.length; i++) {
                if (data[i].id == category) {
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



                }

            }

            document.getElementsByClassName('subcatP')[0].classList.remove('dn')
        }

        function subCategoryPHandler() {
            let params = {
                el: subCategoryP,
                type: "select",
                min: 1,
                max: 50,
                svg: false,
                warn: false,
                msg: false
            }
            privateStatus["subCategoryPStatus"] = inputDriver(params)
            postPrivateData["subCategory"] = subCategoryP.selectedIndex !== (-1) ? subCategoryP.options[subCategoryP.selectedIndex].value : ''

            chekToShowButton()
            calculatePopUpHeight(document.getElementById('addPrivateTalk'), 94)

        }



        function descriptionPHandler() {
            let params = {
                el: descriptionP,
                type: "input",
                min: 50,
                max: 5000,
                svg: true,
                warn: true,
                msg: false
            }
            privateStatus["descriptionPStatus"] = inputDriver(params)
            postPrivateData["description"] = document.getElementById('private-talk-form').elements['descriptionP'].value.trim()
            countLabelDriver({
                el: descriptionP,
                min: params.min,
                max: params.max
            })


        }

        function durationPHandler() {
            let params = {
                el: durationP,
                type: "select",
                min: 0,
                max: 1150,
                svg: false,
                warn: false,
                msg: false
            }
            privateStatus["durationPStatus"] = inputDriver(params)
            postPrivateData["duration"] = durationP.selectedIndex != (-1) ? durationP.options[durationP.selectedIndex].value : '';
        }

        function pricePHandler() {

            let params = {
                el: priceP,
                type: "number",
                min: 10,
                max: 10000,
                svg: false,
                warn: true,
                msg: false
            }
            privateStatus["pricePStatus"] = inputDriver(params)
            postPrivateData["price"] = priceP.value

        }

        function languagePHandler() {
            let params = {
                el: languageP,
                type: "select",
                min: 1,
                max: 50,
                svg: false,
                warn: false,
                msg: false
            }
            privateStatus["languagePStatus"] = inputDriver(params)
            postPrivateData["language"] = languageP.selectedIndex != -1 ? languageP.options[languageP.selectedIndex].value : '';
        }

        function allowVideoTalkPHandler() {
            postPrivateData["allowVideoTalk"] = allowVideoTalkP.checked
        }

        function allowAnonimousTalkPHandler() {
            postPrivateData["allowAnonimousTalk"] = allowAnonimousTalkP.checked
        }

        function pauseTalkHandlerP() {
            postPrivateData["pauseThisTalk"] = pauseThisTalk.checked
        }

        if (document.getElementById("group-talk-form")) {
            let participantsG = groupForm["participantsG"]
            let nameG = groupForm["nameG"]
            let categoryG = groupForm["categoryG"]
            let subCategoryG = groupForm["subCategoryG"]
            let descriptionG = groupForm["descriptionG"]

            let priceG = groupForm["priceG"]
            let languageG = groupForm["languageG"]
            let allowVideoTalkG = groupForm["allowVideoTalkG"]
            let allowAnonimousTalkG = groupForm["allowAnonimousTalkG"]
            let startGTime = document.getElementById('addGroupTalk').getElementsByClassName("startTime")[0].children
            let endGTime = document.getElementById('addGroupTalk').getElementsByClassName("endTime")[0].children
            let groupSubmit = document.getElementsByClassName("saveButtonGroupTalk")

            let talkInteractionTypeG = document.getElementById('talkInteractionTypeG')

            participantsG.addEventListener("change", participantsGHandler)
            nameG.addEventListener("input", nameGHandler)
            nameG.addEventListener("input", showHideSubmitButton)
            categoryG.addEventListener("change", categoryGHandler)
            categoryG.addEventListener("change", showHideSubmitButton)
            categoryG.addEventListener("change", inputGroupSubcategory)
            subCategoryG.addEventListener("change", subCategoryGHandler)
            subCategoryG.addEventListener("change", showHideSubmitButton)
            descriptionG.addEventListener("input", descriptionGHandler)
            descriptionG.addEventListener("input", showHideSubmitButton)

            priceG.addEventListener("input", priceGHandler)
            priceG.addEventListener("change", priceGHandler)
            languageG.addEventListener("change", languageGHandler)
            allowVideoTalkG.addEventListener("change", allowVideoTalkGHandler)
            allowAnonimousTalkG.addEventListener("change", allowAnonimousTalkGHandler)

            talkInteractionTypeG.addEventListener("change", talkInteractionTypeHandlerG)

            for (let i = 0; i < groupSubmit.length; i++) {
                groupSubmit[i].addEventListener("click", function () {

                    handleSubmit("group")
                })


            }

            if (document.getElementsByClassName('cleanerEx')[0]) {
                let cleanerExS = document.getElementsByClassName('cleanerEx')
                for (let i = 0; i < cleanerExS.length; i++) {
                    cleanerExS[i].addEventListener("click", showHideSubmitButton)

                }
            }

            function inputGroupSubcategory(e) {



                var category = e.currentTarget.options[e.currentTarget.selectedIndex].value


                document.getElementById('subCategoryG').innerHTML = ''

                let app_talk_categories = JSON.parse(localStorage.getItem('app_talk_categories_' + getCookie('activeLang')))

                let data = app_talk_categories.talk_categories.data

                for (let i = 0; i < data.length; i++) {
                    if (data[i].id == category) {
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



                    }

                }

                document.getElementById('group-talk-form').getElementsByClassName('subcat')[0].classList.remove('dn')
            }

            function showHideSubmitButton() {

                let form = document.getElementById('group-talk-form').elements

                let nameG = form['nameG']
                let categoryG = form['categoryG']
                let subCategoryG = form['subCategoryG']
                let descriptionG = form['descriptionG']

                if (
                    nameG.classList.contains('ok') &&
                    categoryG.classList.contains('ok') &&
                    subCategoryG.classList.contains('ok') &&
                    descriptionG.classList.contains('ok')
                ) {

                    document.getElementById('groupSubmit').parentElement.parentElement.classList.remove('dn')

                    calculatePopUpHeight(document.getElementById('addGroupTalk'), 94)
                } else {
                    document.getElementById('groupSubmit').parentElement.parentElement.classList.add('dn')

                    calculatePopUpHeight(document.getElementById('addGroupTalk'), 94)
                }

            }


            function talkInteractionTypeHandlerG() {
                let params = { el: talkInteractionTypeG, type: "select", min: 1, max: 2, svg: true, warn: false, msg: false }
                postGroupData["talk_interaction_type"] = talkInteractionTypeG.selectedIndex !== (-1) ? talkInteractionTypeG.options[talkInteractionTypeG.selectedIndex].value : ''
                groupStatus["talk_interaction_typeGStatus"] = inputDriver(params)


            }


            function participantsGHandler() {
                let params = { el: participantsG, type: "select", min: 1, max: 2, svg: true, warn: false, msg: false }
                postGroupData["participants"] = participantsG.selectedIndex !== (-1) ? participantsG.options[participantsG.selectedIndex].value : ''
                groupStatus["participantsGStatus"] = inputDriver(params)
                /* countLabelDriver({ el: participantsG, min: params.min, max: params.max }) */

            }
            function nameGHandler() {
                let params = { el: nameG, type: "input", min: 4, max: 100, svg: true, warn: true, msg: false }
                groupStatus["nameGStatus"] = inputDriver(params)
                postGroupData["name"] = nameG.value
                countLabelDriver({ el: nameG, min: params.min, max: params.max })

            }

            function categoryGHandler() {
                let params = { el: categoryG, type: "select", min: 1, max: 50, svg: false, warn: false, msg: false }
                groupStatus["categoryGStatus"] = inputDriver(params)
                postGroupData["category"] = categoryG.selectedIndex !== (-1) ? categoryG.options[categoryG.selectedIndex].value : ''

            }



            function subCategoryGHandler() {
                let params = { el: subCategoryG, type: "select", min: 1, max: 50, svg: false, warn: false, msg: false }
                groupStatus["subCategoryGStatus"] = inputDriver(params)
                postGroupData["subCategory"] = subCategoryG.selectedIndex !== (-1) ? subCategoryG.options[subCategoryG.selectedIndex].value : ''

            }

            function descriptionGHandler() {

                let params = { el: descriptionG, type: "input", min: 50, max: 5000, svg: true, warn: true, msg: false }
                groupStatus["descriptionGStatus"] = inputDriver(params)
                postGroupData["description"] = document.getElementById('group-talk-form').elements['descriptionG'].value.trim()
                countLabelDriver({ el: descriptionG, min: params.min, max: params.max })

            }



            function priceGHandler() {
                // let params = { el: priceG, type: "select", min: 2, max: 50, svg: false, warn: false, msg: false }
                // groupStatus["priceGStatus"] = inputDriver(params)
                // postGroupData["price"] = priceG.options[priceG.selectedIndex].value;

                let params = { el: priceG, type: "number", min: 10, max: 9999.99, svg: false, warn: true, msg: false }
                postGroupData["price"] = priceG.value
                groupStatus["priceGStatus"] = inputDriver(params)
                //countLabelDriver({ el: priceG, min: params.min, max: params.max })
            }

            function languageGHandler() {
                let params = { el: languageG, type: "select", min: 1, max: 50, svg: false, warn: false, msg: false }
                groupStatus["languageGStatus"] = inputDriver(params)
                postGroupData["language"] = languageG.selectedIndex != -1 ? languageG.options[languageG.selectedIndex].value : '';
            }

            function allowVideoTalkGHandler() {
                postGroupData["allowVideoTalk"] = allowVideoTalkG.checked
            }

            function allowAnonimousTalkGHandler() {
                postGroupData["allowAnonimousTalk"] = allowAnonimousTalkG.checked
            }

            function startGTimeHandler() {
                postGroupData["startTime"] = startGTime[0].innerText + ":" + startGTime[1].innerText
            }

            function endGTimeHandler() {
                let element = document.getElementById('group-talk-form').getElementsByClassName("endTime")[0]
                let params = { element: element, startTime: Number(startGTime[0].innerText + startGTime[1].innerText), endTime: Number(endGTime[0].innerText + endGTime[1].innerText) }
                groupStatus["timeStatus"] = timeCheck(params)
                postGroupData["endTime"] = endGTime[0].innerText + ":" + endGTime[1].innerText
            }
        }


        function timeCheck(params) {


            let startTime = document.getElementById('addGroupTalk').getElementsByClassName('startTime')[0].textContent
            let endTime = document.getElementById('addGroupTalk').getElementsByClassName('endTime')[0].textContent

            if (params.startTime >= params.endTime) {
                params.element.style.border = "1px solid red"
                document.getElementById('timeRangeMessage').textContent = translate.timeError3
                document.getElementById('timeRangeMessage').classList.remove('dn')
                return { isOk: false, reason: translate.timeError3 }

            } else {

                if( diff_minutes(new Date('99 ' + endTime), new Date('99 ' + startTime)) <= 480){
                    params.element.style.border = "none"
                    document.getElementById('timeRangeMessage').classList.add('dn')
                    return { isOk: true, reason: false }
                }

                params.element.style.border = "1px solid red"
                document.getElementById('timeRangeMessage').textContent = translate.timeError4
                document.getElementById('timeRangeMessage').classList.remove('dn')
                return { isOk: false, reason: translate.timeError4 }
            }
        }

        function observeTimeDrumsChange() {
            // Select the node that will be observed for mutations
            const startTime = document.getElementById("group-talk-form").getElementsByClassName('startTime')[0];
            const endTime = document.getElementById("group-talk-form").getElementsByClassName('endTime')[0];
            // Options for the observer (which mutations to observe)
            const config = { attributes: true, childList: true, subtree: true };

            // Callback function to execute when mutations are observed
            const callback = (mutationList, observer) => {
                for (const mutation of mutationList) {
                    if (mutation.type === "childList") {


                        endGTimeHandler()

                    } else if (mutation.type === "attributes") {

                    }
                }
            };

            // Create an observer instance linked to the callback function
            const observerStart = new MutationObserver(callback);

            const observerEnd = new MutationObserver(callback);

            // Start observing the target node for configured mutations
            observerStart.observe(startTime, config);
            observerEnd.observe(endTime, config);
        }

        observeTimeDrumsChange()

        function handleSubmit(type) {

            if (type === "private") {
                namePHandler()
                categoryPHandler()
                subCategoryPHandler()
                descriptionPHandler()
                durationPHandler()
                pricePHandler()
                languagePHandler()
                allowVideoTalkPHandler()
                allowAnonimousTalkPHandler()
                pauseTalkHandlerP()


                if (privateForm["talkIdP"]) {
                    postPrivateData["talkId"] = privateForm["talkIdP"].value
                    postPrivateData["talkType"] = 1
                    postPrivateData["state"] = pauseThisTalk.checked ? 1 : 2
                }

                let isDataPrivateIsOK = Object.keys(privateStatus).filter(function (el) {
                    return !privateStatus[el].isOk
                }).length > 0 ? false : true

                if (isDataPrivateIsOK) {

                    showLoading()

                    postPrivateData["languages_id"] = languageP.value
                    postPrivateData["call_type"] = allowVideoTalkP.checked ? 2 : 1
                    postPrivateData["headline"] = postPrivateData["name"]
                    postPrivateData["max_participiants"] = 1
                    postPrivateData["talk_categories_id"] = postPrivateData["category"]
                    postPrivateData["talk_type"] = postPrivateData["talkType"]

                    postPrivateData["talks_id"] = privateForm["talkIdP"].value
                    postPrivateData["anonym_call"] = allowAnonimousTalkP.checked ? 1 : 0
                    postPrivateData["finance_currencies_id"] = 1
                    postPrivateData["talk_subcategories_id"] = postPrivateData["category"]

                    document.getElementById('privateSubmit').classList.add('disabledButton')
                    postPrivateData['_token'] = document.querySelector('meta[name="csrf-token"]').content
                    submitValidationForm(postPrivateData, consts.ONE_TO_ONE)


                } else {
                    console.log("Private Post Failed", postPrivateData)
                    console.log("Private Post errors", privateStatus)
                }

            } else if (type === "group") {
                participantsGHandler()
                nameGHandler()
                categoryGHandler()
                subCategoryGHandler()
                descriptionGHandler()

                priceGHandler()
                languageGHandler()
                allowVideoTalkGHandler()
                allowAnonimousTalkGHandler()
                startGTimeHandler()
                endGTimeHandler()

                talkInteractionTypeHandlerG()

                postGroupData["talkDay"] = document.getElementById('addGroupTalk').getElementsByClassName('date-scheduler-wrap')[0].getElementsByClassName('active')[0].dataset.index

                if (groupForm["talkIdG"]) {
                    postGroupData["talkId"] = groupForm["talkIdG"].value
                    postGroupData["talkType"] = 2
                }

                let isDataGroupIsOK = Object.keys(groupStatus).filter(function (el) { return !groupStatus[el].isOk }).length > 0 ? false : true
                if (isDataGroupIsOK) {

                    showLoading()
                    document.getElementById('privateSubmit').classList.add('disabledButton')


                    postGroupData["languages_id"] = languageG.value
                    postGroupData["call_type"] = groupForm["allowVideoTalkG"].checked ? 2 : 1
                    postGroupData["headline"] = postGroupData["name"]
                    postGroupData["max_participiants"] = 1
                    postGroupData["talk_categories_id"] = postGroupData["category"]
                    postGroupData["talk_type"] = postGroupData["talkType"]

                    postGroupData["talks_id"] = groupForm["talkIdG"].value
                    postGroupData["anonym_call"] = groupForm["allowAnonimousTalkG"].checked ? 1 : 0
                    postGroupData["finance_currencies_id"] = 1
                    postGroupData["talk_subcategories_id"] = postGroupData["category"]

                    submitValidationForm(postGroupData, consts.GROUP)


                } else {
                    console.log("Group Post Failed", postGroupData)
                    console.log("Group Post errors", groupStatus)


                }
            }

            function submitValidationForm(formData, talkType) {
                let token = document.querySelector('meta[name="csrf-token"]').content
                if (typeof formData.talkId === 'undefined' || formData.talkId === "") {

                    jQuery.ajax({
                        type: 'POST',
                        url: '/frontend/api/add-talk',
                        data: {
                            'headline': formData.name ?? null,
                            'talk_categories_id': formData.category ?? null,
                            'talk_subcategories_id': formData.subCategory ?? null,
                            'duration': formData.talkType === 1 ? document.getElementById('durationP').value : diff_minutes(new Date('99 ' + formData.endTime), new Date('99 ' + formData.startTime)) ?? null,
                            'description': formData.description ?? null,
                            'end_time_call': formData.endTime ? formData.endTime + ':00' : null,
                            'start_time_call': formData.startTime ? formData.startTime + ':00' : null,
                            'finance_currencies_id': 1,
                            'weekday': formData.talkDay ?? 1,
                            'price': formData.price ?? null,
                            'max_participiants': formData.participants ?? 1,
                            'languages_id': formData.language ?? null,
                            'anonym_call': formData.allowAnonimousTalk ? 1 : 0,
                            'state': 1,
                            'call_type': talkType,
                            'talk_type': formData.allowVideoTalk ? consts.VIDEO_CALL : consts.VOICE_CALL,
                            'interactive_mode': formData.talkType === 2 ? talkInteractionTypeG[talkInteractionTypeG.selectedIndex].value : 2,
                            'repeat': formData.talkType === 2 ? (allowRepeatG.checked ? 1 : 0) : 0,
                            '_token': token
                        },
                        beforeSend: function () {
                            // Handle the beforeSend event

                            showLoading()


                        },

                        success: function (response) {

                            if (response.success) {

                                if (document.body.className !== "logged_in") {
                                    showLoading()
                                    location.reload()
                                } else {
                                    // return response.message;
                                    closePopup('addPrivateTalk')
                                    window.addCompletedTalkToAvailability = 1
                                    window.addCompletedTalkToAvailabilityId = response.data.talk_id


                                    document.getElementById('addedTalkPrice').textContent = formData.price
                                    document.getElementById('addedTalkDuration').textContent = document.getElementById('durationP').value
                                    let k1ffss = document.getElementById('addCompleteTalk').getElementsByClassName('k1ff')
                                    for (let i = 0; i < k1ffss.length; i++) {
                                        k1ffss[i].classList.remove('dn')

                                    }

                                    let sharingTalks = document.getElementsByClassName('sharingTalks')
                                    for (let i = 0; i < sharingTalks.length; i++) {
                                        sharingTalks[i].href += response.data.talk_id

                                    }
                                    document.getElementById('addCompleteTalk').getElementsByClassName('nativeShare')[0].dataset.link += response.data.talk_id


                                    openPopup('addCompleteTalk')
                                    hideLoading()

                                }

                            } else {
                                document.getElementById('privateSubmit').classList.remove('disabledButton')
                                toastify(response.message)
                                return response.message
                            }
                        },
                        error: function (errorMessage) {
                            document.getElementById('privateSubmit').classList.remove('disabledButton')
                            Sentry.captureException(new TalksAndAvailabilitySubmitError(errorMessage + ' url: ' + location.href + ' method : add talks'));
                        }
                    });
                } else {

                    jQuery.ajax({
                        type: 'PUT',
                        url: '/frontend/api/update-talk',
                        data: {
                            'talkId': formData.talkId ?? null,
                            'headline': formData.name ?? null,
                            'talk_categories_id': formData.category ?? null,
                            'talk_subcategories_id': formData.subCategory ?? null,
                            'duration': parseInt(formData.duration) ?? null,
                            'duration': formData.talkType === 1 ? document.getElementById('durationP').value : diff_minutes(new Date('99 ' + formData.endTime), new Date('99 ' + formData.startTime)) ?? null,
                            'finance_currencies_id': 1,
                            'price': formData.price ?? null,
                            'max_participiants': formData.participants ? formData.participants : 1,
                            'languages_id': formData.language ?? null,
                            'anonym_call': formData.allowAnonimousTalk ? 1 : 0,
                            'end_time_call': formData.endTime ? formData.endTime + ':00' : null,
                            'start_time_call': formData.startTime ? formData.startTime + ':00' : null,
                            'weekday': formData.talkDay ?? 1,
                            'state': document.getElementById('private-talk-form').elements['pauseThisTalk'].checked ? 0 : 1,
                            'call_type': talkType,
                            'talk_type': formData.allowVideoTalk ? consts.VIDEO_CALL : consts.VOICE_CALL,
                            'interactive_mode': formData.talkType === 2 ? talkInteractionTypeG[talkInteractionTypeG.selectedIndex].value : 2,
                            'repeat': formData.talkType === 2 ? (allowRepeatG.checked ? 1 : 0) : 0,
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

                                toastify(response.message)

                                let x = document.getElementById('private-talk-form')

                                clearForm(x)

                                if (document.getElementById("group-talk-form")) {
                                    let y = document.getElementById('group-talk-form')
                                    clearForm(y)
                                }

                                updateTalkFieldFrontend(formData)

                                document.getElementById('privateSubmit').classList.remove('disabledButton')

                            } else {
                                document.getElementById('privateSubmit').classList.remove('disabledButton')
                                toastify(response.message)
                                return response.message

                            }

                        },
                        error: function (errorMessage) {
                            document.getElementById('privateSubmit').classList.remove('disabledButton')
                            Sentry.captureException(new TalksAndAvailabilitySubmitError(errorMessage + ' url: ' + location.href + ' method : update talks'));
                        }
                    });
                }


            }

        }
    }
}




class GetTokenErrorTalksAndAvailability extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenErrorTalksAndAvailability"
    }
}
class TalksAndAvailabilitySubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "TalksAndAvailabilitySubmitError"
    }
}
class GetSubactegoriesTalksAndAvailabilityError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetSubactegoriesTalksAndAvailabilityError"
    }
}


function updateTalkFieldFrontend(talkData) {

    let dataTalkId = document.getElementsByClassName('dataTalkId')

    let cameraSVGIcon = '<svg width="13" height="8" viewBox="0 0 13 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.14286 0H8C8.63118 0 9.14286 0.511675 9.14286 1.14286V1.93262L12.5714 0.218332V7.7818L9.14286 6.0675V6.85714C9.14286 7.48833 8.63118 8 8 8H1.14286C0.511675 8 0 7.48833 0 6.85714V1.14286C0 0.511675 0.511675 0 1.14286 0ZM9.14286 4.78975L11.4286 5.93262V2.06751L9.14286 3.21038V4.78975ZM1.14286 1.14286V6.85714H8V1.14286H1.14286Z" fill="#172B4D"></path></svg>'
    let cameraCrossedSVGIcon = '<svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.1431 2H8.00024C8.63143 2 9.1431 2.51167 9.1431 3.14286V3.93262L12.5717 2.21833V9.7818L9.1431 8.0675V8.85714C9.1431 9.48833 8.63143 10 8.00024 10H1.1431C0.511919 10 0.000244141 9.48833 0.000244141 8.85714V3.14286C0.000244141 2.51167 0.511919 2 1.1431 2ZM9.1431 6.78975L11.4288 7.93262V4.06751L9.1431 5.21038V6.78975ZM1.1431 3.14286V8.85714H8.00025V3.14286H1.1431Z" fill="#D1D5DB"></path><line x1="9.11957" y1="0.696923" x2="1.69694" y2="11.1941" stroke="#172B4D" stroke-linecap="round"></line></svg>'



    for (let i = 0; i < dataTalkId.length; i++) {

        if (dataTalkId[i].dataset.talkId == talkData.talkId) {
            if (talkData.talkType === 2) {
                if (document.body.className === 'jtc2_add_your_first_talk') {
                    if (dataTalkId[i].parentElement.getElementsByClassName('talkDurationMinutes')[0]) {
                        let duration = diff_minutes(new Date('99 ' + talkData.endTime), new Date('99 ' + talkData.startTime))
                        dataTalkId[i].parentElement.getElementsByClassName('talkDurationMinutes')[0].textContent = duration
                    }

                    if (dataTalkId[i].getElementsByClassName('lefter')[0]) {
                        dataTalkId[i].getElementsByClassName('lefter')[0].textContent = talkData.name
                    }

                    if (dataTalkId[i].parentElement.getElementsByClassName('iconsSearchItem')[0]) {
                        talkData.anonym_call == 1 ? dataTalkId[i].parentElement.getElementsByClassName('annonContainer')[0].classList.remove('dn') : dataTalkId[i].parentElement.getElementsByClassName('annonContainer')[0].classList.add('dn')

                        if (talkData.call_type == 1) {
                            dataTalkId[i].parentElement.getElementsByClassName('phoneIcon')[0].classList.remove('dn')
                            dataTalkId[i].parentElement.getElementsByClassName('cameraIcon')[0].classList.add('dn')

                        } else if (talkData.call_type == 2) {
                            dataTalkId[i].parentElement.getElementsByClassName('phoneIcon')[0].classList.add('dn')
                            dataTalkId[i].parentElement.getElementsByClassName('cameraIcon')[0].classList.remove('dn')
                        }
                    }

                    dataTalkId[i].getElementsByClassName('righter')[0].textContent = new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format(parseFloat(talkData.price)).replace("€", "") + ' €'

                } else {

                    if (dataTalkId[i].parentElement.getElementsByClassName('talkDurationMinutes')[0]) {
                        let duration = diff_minutes(new Date('99 ' + talkData.endTime), new Date('99 ' + talkData.startTime))
                        dataTalkId[i].parentElement.getElementsByClassName('talkDurationMinutes')[0].textContent = duration
                    }

                    if (dataTalkId[i].getElementsByClassName('lefter')[0]) {
                        dataTalkId[i].getElementsByClassName('lefter')[0].textContent = talkData.name
                    }

                    if (dataTalkId[i].parentElement.getElementsByClassName('iconsSearchItem')[0]) {
                        talkData.anonym_call == 1 ? dataTalkId[i].parentElement.getElementsByClassName('annonContainer')[0].classList.remove('dn') : dataTalkId[i].parentElement.getElementsByClassName('annonContainer')[0].classList.add('dn')

                        if (talkData.call_type == 1) {
                            if(dataTalkId[i].tagName !== 'TD'){
                                dataTalkId[i].parentElement.getElementsByClassName('phoneIcon')[0]?.classList.remove('dn')
                                dataTalkId[i].parentElement.getElementsByClassName('cameraIcon')[0].classList.add('dn')
                            }
                            if(dataTalkId[i].tagName == 'TD'){
                                dataTalkId[i].parentElement.getElementsByClassName('cameraIcon')[0].innerHTML = cameraCrossedSVGIcon
                            }

                        } else if (talkData.call_type == 2) {
                            if(dataTalkId[i].tagName !== 'TD'){
                                dataTalkId[i].parentElement.getElementsByClassName('phoneIcon')[0]?.classList.add('dn')
                                dataTalkId[i].parentElement.getElementsByClassName('cameraIcon')[0].classList.remove('dn')
                            }
                            if(dataTalkId[i].tagName == 'TD'){
                                dataTalkId[i].parentElement.getElementsByClassName('cameraIcon')[0].innerHTML = cameraSVGIcon
                            }

                        }
                    }
                    if(dataTalkId[i].getElementsByClassName('righter')[0]){

                        dataTalkId[i].getElementsByClassName('righter')[0].textContent = new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format(parseFloat(talkData.price)).replace("€", "") + ' €'

                    }

                }

                closePopup('addGroupTalk')


            } else {
                closePopup('addPrivateTalk')
                if (document.body.className === 'jtc2_add_your_first_talk') {

                    if (dataTalkId[i].parentElement.getElementsByClassName('talkDurationMinutes')[0]) {
                        dataTalkId[i].parentElement.getElementsByClassName('talkDurationMinutes')[0].textContent = talkData.duration
                    }

                    if (dataTalkId[i].getElementsByClassName('lefter')[0]) {
                        dataTalkId[i].getElementsByClassName('lefter')[0].textContent = talkData.name
                    }

                    if (dataTalkId[i].parentElement.getElementsByClassName('iconsSearchItem')[0]) {
                        talkData.anonym_call == 1 ? dataTalkId[i].parentElement.getElementsByClassName('annonContainer')[0].classList.remove('dn') : dataTalkId[i].parentElement.getElementsByClassName('annonContainer')[0].classList.add('dn')

                        if (talkData.call_type == 1) {
                            dataTalkId[i].parentElement.getElementsByClassName('phoneIcon')[0].classList.remove('dn')
                            dataTalkId[i].parentElement.getElementsByClassName('cameraIcon')[0].classList.add('dn')

                        } else if (talkData.call_type == 2) {
                            dataTalkId[i].parentElement.getElementsByClassName('phoneIcon')[0].classList.add('dn')
                            dataTalkId[i].parentElement.getElementsByClassName('cameraIcon')[0].classList.remove('dn')
                        }
                    }

                    dataTalkId[i].getElementsByClassName('righter')[0].textContent = new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format(parseFloat(talkData.price)).replace("€", "") + ' €'

                } else {

                    if (dataTalkId[i].getElementsByClassName('pricing')[0]) {
                        dataTalkId[i].getElementsByClassName('pricing')[0].innerHTML = new Intl.NumberFormat(getCookie('activeLang'), {
                            style: 'currency',
                            currency: 'EUR'
                        }).format(talkData.price).replace(/[^0-9.,]/g, '') + ' €'

                    }

                    if (dataTalkId[i].getElementsByClassName('boldTalkTalksTAble')[0]) {

                        let boldTalkTalksTAbles = dataTalkId[i].getElementsByClassName('boldTalkTalksTAble')

                        for (let i = 0; i < boldTalkTalksTAbles.length; i++) {
                            boldTalkTalksTAbles[i].textContent = talkData.name

                        }
                    }

                    dataTalkId[i].getElementsByClassName('book-sn-icon')[0].getElementsByTagName('h6')[0].textContent = talkData.duration

                    if (dataTalkId[i].parentElement.getElementsByClassName('iconsSearchItem')[0]) {

                        let iconContainer = dataTalkId[i].parentElement.getElementsByClassName('iconsSearchItem')[0]
                        iconContainer.getElementsByClassName('cameraIcon')[0].innerHTML = talkData.call_type == 1 ? cameraCrossedSVGIcon : cameraSVGIcon

                        talkData.anonym_call === 1 ? dataTalkId[i].parentElement.getElementsByClassName('annonContainer')[0].classList.remove('dn') : dataTalkId[i].parentElement.getElementsByClassName('annonContainer')[0].classList.add('dn')
                    }

                    if (dataTalkId[i].parentElement.getElementsByClassName('switch-input')[0]) {

                        talkData.state == 1 ? dataTalkId[i].parentElement.getElementsByClassName('switch-input')[0].checked = false : dataTalkId[i].parentElement.getElementsByClassName('switch-input')[0].checked = true
                        talkData.state == 1 ? dataTalkId[i].parentElement.getElementsByClassName('shareTalk')[0].classList.add('dn') : dataTalkId[i].parentElement.getElementsByClassName('shareTalk')[0].classList.remove('dn')
                    }


                    if(dataTalkId[i].getElementsByClassName('righter')[0]){
                        dataTalkId[i].getElementsByClassName('righter')[0].textContent = new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format(parseFloat(talkData.price)).replace("€", "") + ' €'
                    }
                }


            }



        }
    }
}




(function () {
    talksAndAvailabilityValidation()
})();
