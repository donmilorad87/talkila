export function getTalkData(id) {

    let xhttp = new XMLHttpRequest()

    xhttp.onreadystatechange = function () {

        if (this.readyState == 1) {
            showLoading()
        }

        if (this.readyState == 4 && this.status == 200) {

            let response = JSON.parse(this.response)

            document.getElementById('acceptRemovingCourse').dataset.talkId = response.data.id
            if (response.data.call_type === consts.ONE_TO_ONE) {
                //input languages
                let app_languages = JSON.parse(localStorage.getItem('app_languages_' + getCookie('activeLang')))
                let languages = app_languages.data.languages

                inputLanguages()


                select_language(parseInt(response.data.languages_id))

                //input categories
                let app_talk_categories = JSON.parse(localStorage.getItem('app_talk_categories_' + getCookie('activeLang')))
                let data = app_talk_categories.talk_categories.data
                inputCategories()

                //select and input sub category
                select_category_input_and_select_subcategory(data, parseInt(response.data.talk_category_id), parseInt(response.data.talk_subcategory_id))
                //select sub category


                hideLoading()





                talkInputP.focus()

                let talk_data = response.data
                let form = document.getElementById('private-talk-form').elements

                form['talkIdP'].value = talk_data.id
                form['nameP'].classList.add('ok')
                form['nameP'].value = talk_data.headline
                form['descriptionP'].value = talk_data.description
                form['descriptionP'].classList.add('ok')


                //set duration
                let durationPOptions = durationP.options
                for (let i = 0; i < durationPOptions.length; i++) {
                    if (durationPOptions[i].value == talk_data.duration) {
                        durationP.selectedIndex = i
                        durationP.classList.add('ok')
                        break
                    }

                }

                form['priceP'].value = parseFloat(talk_data.price)
                form['priceP'].classList.add('ok')
                form['allowVideoTalkP'].checked = talk_data.is_anonymous_allowed === 0 ? false : true
                form['allowVideoTalkP'].checked = talk_data.talk_type === 1 ? false : true
                form['pauseThisTalk'].checked = talk_data.state === 1 ? false : true

                form['allowAnonimousTalkP'].checked = talk_data.is_anonymous_allowed == 1 ? true : false
                document.getElementById('addPrivateTalk').getElementsByClassName('deleteTalkButtoner')[0].classList.remove('dn')

                document.getElementsByClassName('pauseWrap')[0].classList.remove('dn')
                document.getElementsByClassName('deleteTalkButtoner')[0].classList.remove('dn')
                document.getElementById('privateSubmit').classList.remove('dn')
                document.getElementById('privateSubmit').textContent = getPoTranslate('EDIT_PRIVATE_TALK')
                document.getElementById('mobilePrivateTalkTitle').textContent = getPoTranslate('EDIT_PRIVATE_TALK')


                openPopup('addPrivateTalk')
            } else if (response.data.call_type === consts.GROUP) {

                let form = document.getElementById('group-talk-form').elements

                //input languages
                let app_languages = JSON.parse(localStorage.getItem('app_languages_' + getCookie('activeLang')))
                let languages = app_languages.data.languages

                inputGroupLanguages()

                select_group_language(getLanguageId())

                //input categories
                let app_talk_categories = JSON.parse(localStorage.getItem('app_talk_categories_' + getCookie('activeLang')))
                let data = app_talk_categories.talk_categories.data
                inputGroupCategories()

                //select and input sub category
                select_group_category_input_and_select_subcategory(data, parseInt(response.data.talk_category_id), parseInt(response.data.talk_subcategory_id))
                //select sub category


                hideLoading()

                let maxParticipantsOptions = participantsG.options
                let talk_data = response.data

                for (let k = 0; k < maxParticipantsOptions.length; k++) {

                    if (maxParticipantsOptions[k].value == talk_data.max_participiants) {

                        participantsG.classList.add('ok')
                        participantsG.selectedIndex = k

                        break
                    }
                }

                form['talkIdG'].value = talk_data.id

                form['nameG'].classList.add('ok')
                form['nameG'].value = talk_data.headline

                form['descriptionG'].value = talk_data.description
                form['descriptionG'].classList.add('ok')

                form['priceG'].value = parseFloat(talk_data.price)
                form['priceG'].classList.add('ok')

                let options = talkInteractionTypeG.options
                if(talk_data.interactive_mode){
                    for (let k = 0; k < options.length; k++) {

                        if (options[k].value == talk_data.interactive_mode) {

                            options[k].parentElement.classList.add('ok')
                            talkInteractionTypeG.selectedIndex = k
                            break
                        }
                    }
                }

                form['allowVideoTalkG'].checked = talk_data.is_anonymous_allowed === 0 ? false : true
                form['allowVideoTalkG'].checked = talk_data.talk_type === 1 ? false : true

                form['allowAnonimousTalkG'].checked = talk_data.is_anonymous_allowed == 1 ? true : false

                document.getElementById('group-talk-form').getElementsByClassName('pauseWrap')[0].classList.remove('dn')

                document.getElementById('group-talk-form').getElementsByClassName('date-scheduler-wrap')[0].getElementsByClassName('active')[0].classList.remove('active')
                let daysDivs = document.getElementById('group-talk-form').getElementsByClassName('date-scheduler-wrap')[0].getElementsByTagName('div')
                for (let i = 0; i < daysDivs.length; i++) {
                    if (daysDivs[i].dataset.index == talk_data.weekday) {
                        daysDivs[i].classList.add('active')
                    }

                }


                let start_time_call = new Date('1987.07.25. ' + talk_data.start_time_call)
                let end_time_call = new Date('1987.07.25. ' + talk_data.end_time_call)


                setDrums(
                    document.getElementById('group-talk-form'),
                    addZero(start_time_call.getHours()).toString(),
                    addZero(start_time_call.getMinutes()).toString(),
                    addZero(end_time_call.getHours()).toString(),
                    addZero(end_time_call.getMinutes()).toString()
                )

                document.getElementById('groupSubmit').parentElement.parentElement.classList.remove('dn')

                document.getElementById('groupSubmit').textContent = getPoTranslate('EDIT_GALLERY_TALK')
                document.getElementById('addGroupTalk').getElementsByClassName('pageTitlePoperAva')[0].textContent = getPoTranslate('EDIT_GALLERY_TALK')

                document.getElementById('group-talk-form').getElementsByClassName('deleteTalkButtoner')[0].classList.remove('dn')


                let pageTitlePoperAva = document.getElementById('addGroupTalk').getElementsByClassName('pageTitlePoperAva')

                for (let i = 0; i < pageTitlePoperAva.length; i++) {
                    pageTitlePoperAva[i].textContent = getPoTranslate('EDIT_GALLERY_TALK')
                }

                document.getElementById('jtc_add_gallery_talk_description').classList.add('dn')
                document.getElementById('jtc_edit_gallery_talk_description').classList.remove('dn')

                openPopup('addGroupTalk')
            }

        }
    }


    xhttp.onerror = function () {
        Sentry.captureException(new GetTalkDataError('status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
    }


    xhttp.open("GET", envAppBackendUrl + '/get-talk/' + id, true)


    xhttp.setRequestHeader('Accept', 'application/json')
    xhttp.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
    xhttp.setRequestHeader('Authorization', bearerToken)
    xhttp.send();
}


export function uploadFile(file) {


    var url = envAppBackendUrl + '/edit-profile-photo'

    var xhr = new XMLHttpRequest()

    var formData = new FormData()
    formData.append('_token', token)
    xhr.open('POST', url, true)

    xhr.setRequestHeader('Accept', 'application/json')

    xhr.addEventListener('loadstart', function () {
        /* document.getElementsByClassName('uplcnt')[0].style.display = 'block' */
    })

    // Update progress (can be used to show progress indicator)
    xhr.upload.addEventListener("progress", function (e) {

        /* updateProgress(i, (e.loaded * 100.0 / e.total) || 100) */
    })

    xhr.addEventListener('loadend', function () {
        /*  document.getElementsByClassName('uplcnt')[0].style.display = 'none'
            document.getElementsByClassName('icon-deletes')[0].style.display = 'none'
            dropArea.className = 'uploadedS' */
        window.fileUpl = true

    })

    xhr.addEventListener('readystatechange', function (e) {
        if (xhr.readyState == 4 && xhr.status == 200) {

            let obj = JSON.parse(this.responseText)

            if (obj.success == false) {
                toastify(obj.message)
                takePictureAgainHelper()
            } else {
                uploadCamPictureHelper(1, file)
                takePictureAgainHelper()
                /* window.location.reload(false) */
            }

            /* updateProgress(i, 100) */ // <- Add this
        } else if (xhr.readyState == 4 && xhr.status != 200) {
            // Error. Inform the user
            uploadCamPictureHelper(0)

        }
    })
    xhr.onerror = function () {
        Sentry.captureException(new editProfilePhotoError('status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
    }

    xhr.setRequestHeader('Accept', 'application/json')
    xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
    xhr.setRequestHeader('Authorization', bearerToken)

    formData.append('file', file)

    xhr.send(formData)
}



function uploadCamPictureHelper(x, f) {



    if (x === 1) {

        var reader = new FileReader();
        reader.readAsDataURL(f);
        reader.onloadend = function () {
            var base64data = reader.result;

            let img = document.createElement('img')
            let img2 = document.createElement('img')

            img.src = base64data
            img2.src = base64data

            document.getElementsByClassName('loggedPic')[0].getElementsByTagName('img')[0].src = base64data

            if (document.getElementById('profile-img')) {
                document.getElementById('profile-img').src = base64data
            }

            if (document.getElementsByClassName('account-Vtion-group')[0]) {
                document.getElementsByClassName('account-Vtion-group')[0].getElementsByTagName('img')[0].src = base64data
            }



        }

        closePopup('takePictureWithWebCam')
        setTimeout(function () {
            closePopup('uploadDropArea')
            toastify(getPoTranslate('IMG_SUCCESS_UPLOADED'))

        }, 250)


    } else if (x === 0) {
        toastify(getPoTranslate('PLEASE_UPLOAD_IMG_AGAIN'))
    }
    hideLoading()
}

class UploadFileGetTokenError extends Error {
    constructor(message) {
        super(message)
        this.name = "UploadFileGetTokenError"
    }
}
class editProfilePhotoError extends Error {
    constructor(message) {
        super(message)
        this.name = "editProfilePhotoError"
    }
}
class GetDataError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetDataError"
    }
}
class PostDataError extends Error {
    constructor(message) {
        super(message)
        this.name = "PostDataError"
    }
}
class GetTalkDataError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTalkDataError"
    }
}

class GetCategorySubcategoriesError extends Error {
    constructor(message) {
        super(message)
        this.name = "GetCategorySubcategoriesError"
    }
}
