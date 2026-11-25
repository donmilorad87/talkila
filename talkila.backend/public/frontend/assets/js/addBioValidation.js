function initAddBioForm() {

    let formData = {}
    let formStatus = {}

    if (document.getElementById("add-bio-form")) {

        let addBioForm = document.getElementById("add-bio-form").elements

        document.getElementById("bioSubmit").addEventListener("click", handleSubmit)

        let addBio = addBioForm["addBio"]

        addBio.addEventListener("input", descriptionPHandler)

        function descriptionPHandler() {

            // postPrivateData["description"] = descriptionP.value
            // descriptionP.parentNode.getElementsByClassName("default-warn")[0].style.height = 13 + "px"
            // countLabelDriver({ el: descriptionP, min: 0, max: 500 })

            /* let params = { el: descriptionP, type: "textarea", min: 0, max: 500, svg: true, warn: false, msg: false }
            postPrivateData["description"] = inputDriver(params)
            descriptionP.parentNode.getElementsByClassName("default-warn")[0].style.height = 13 + "px"
            countLabelDriver({ el: descriptionP, min: params.min, max: params.max }) */

            /* let params = { el: addBio, type: "textarea", min: 0, max: 1000, svg: true, warn: false, msg: false }
            addBio.classList.add('ok')
            formData["addBio"] = document.getElementById('add-bio-form').elements['addBio'].value
            countLabelDriver({ el: params.el, min: params.min, max: params.max }) */

            let params = { el: addBio, type: "input", min: 1, max: 1000, svg: true, warn: true, msg: false }
            formStatus["addBio"] = inputDriver(params)
            formData["addBio"] = addBio.value.trim()
            countLabelDriver({ el: addBio, min: params.min, max: params.max })

        }

        function handleSubmit() {

            descriptionPHandler()

            let check = Object.keys(formStatus).filter(function (el) { return !formStatus[el].isOk }).length > 0 ? false : true
            if (check) {
                console.log("Private Post Success", formData)
                submitValidationForm(formData)


            }
            else{
                console.log("Private Post Failed", formData)
                console.log("Errors", formStatus)
            }

        }

        function submitValidationForm(formData) {
            showLoading()
            jQuery.ajax({
                type: 'POST',
                url: '/frontend/api/edit-profile-biography',
                data: {
                    'biography': formData.addBio ?? null,
                    '_token': document.querySelector('meta[name="csrf-token"]').content
                },

                complete: function () {
                    hideLoading()
                },
                success: function (response) {

                    if (response.success) {
                        closePopup('addShortDescription')
                        if(document.body.className === 'settings_profile'){
                            if(document.getElementsByClassName('textareaMobileCorrection')[0]){
                                document.getElementsByClassName('textareaMobileCorrection')[0].value = formData.addBio.length > 39 ? formData.addBio.substring(0,40) + '...' : formData.addBio
                            }
                        }else if(document.body.className === 'logged_in' ){
                            //class profileBio

                            if(document.getElementsByClassName('profileBio')[0]){
                                let profileBiosSpan = document.getElementsByClassName('profileBio')
                                for (let i = 0; i < profileBiosSpan.length; i++) {
                                    if( profileBiosSpan[i].getElementsByTagName('span')[0]){
                                        profileBiosSpan[i].getElementsByTagName('span')[0].textContent = formData.addBio.length > 19 ? formData.addBio.substring(0,20) + '...' : formData.addBio

                                    }

                                }
                                if(document.getElementsByClassName('teacherDescOpenBios')[0]){
                                    document.getElementsByClassName('teacherDescOpenBios')[0].textContent = formData.addBio.length > 19 ? formData.addBio.substring(0,20) + '...' : formData.addBio
                                }
                            }
                        }else{

                        }
                        toastify(response.message)

                    } else {
                        toastify(response.message)
                    }
                    hideLoading()
                },
                error: function (errorMessage) {
                    Sentry.captureException(new AddBioValidationSubmitError(errorMessage + ' url: ' + location.href ))
                }
            })
        }
    }
}

class GetTokenAddBioValidation extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenAddBioValidation"
    }
}

class AddBioValidationSubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "AddBioValidationSubmitError"
    }
}

(function () {
    initAddBioForm()
})()
