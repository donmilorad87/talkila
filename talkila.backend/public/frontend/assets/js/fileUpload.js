window.cropper = []
var fileInput
let uploadValidationMessage = document.getElementById('uploadValidationMessage')
if (document.getElementsByClassName("drop-area")[0]) {

    if (document.getElementById('uploadDropArea')) {

        document.getElementById('uploadDropArea').addEventListener('click', function () {
            restartCropperPresetsImageUpload()

        })

        if (document.getElementById('uploadDropArea').getElementsByClassName('cz')[0]) {

            document.getElementById('uploadDropArea').getElementsByClassName('cz')[0].addEventListener('click', function () {
                restartCropperPresetsImageUpload()

            })
        }
    }



    function restartCropperPresetsImageUpload() {


        if (document.getElementsByClassName('cropper-hidden')[0]) {
            let hiddenOriginalImages = document.getElementsByClassName('cropper-hidden')
            for (let i = 0; i < hiddenOriginalImages.length; i++) {
                hiddenOriginalImages[i].remove()

            }

        }

        if (window.cropper) {
            for (let i = 0; i < window.cropper.length; i++) {
                window.cropper[i].destroy()

            }
        }
        clearAfterDestroyCropper()

        if (document.getElementsByClassName('icon-deletes')[0]) {
            let iconsDelete = document.getElementsByClassName('icon-deletes')
            for (let i = 0; i < iconsDelete.length; i++) {
                iconsDelete[i].style.display = 'none'

            }
        }

        if (document.getElementsByClassName('uploadButton')) {
            let uploadButtons = document.getElementsByClassName('uploadButton')
            for (let i = 0; i < uploadButtons.length; i++) {
                uploadButtons[i].style.display = 'block'

            }
        }

    }

    if (document.getElementById('takePictureWithWebCam')) {

        document.getElementById('takePictureWithWebCam').addEventListener('click', function () {
            restartCropperPresetsCameraImageUpload()

        })

        if (document.getElementById('takePictureWithWebCam').getElementsByClassName('cz')[0]) {

            document.getElementById('takePictureWithWebCam').getElementsByClassName('cz')[0].addEventListener('click', function () {
                restartCropperPresetsCameraImageUpload()

            })
        }

    }

    function restartCropperPresetsCameraImageUpload() {

        if (window.cropper) {
            for (let i = 0; i < window.cropper.length; i++) {
                window.cropper[i].destroy()

            }
        }

        clearAfterDestroyCropper()
        takePictureAgainFunction()
    }

    loadScript("/frontend/assets/js/lib/cropper.min.js" + version, function () {
        loadCss('/frontend/assets/css/cropper.css' + version)
    })

    // ************************ Drag and drop ***************** //

    let dropArea = document.getElementsByClassName("drop-area")


        // Prevent default drag behaviors
        ;
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        for (let i = 0; i < dropArea.length; i++) {
            dropArea[i].addEventListener(eventName, preventDefaults, false)
        }

        document.body.addEventListener(eventName, preventDefaults, false)
    })

        // Highlight drop area when item is dragged over it
        ;
    ['dragenter', 'dragover'].forEach(eventName => {
        for (let i = 0; i < dropArea.length; i++) {
            dropArea[i].addEventListener(eventName, highlight, false)
        }
    })

        ;
    ['dragleave', 'drop'].forEach(eventName => {
        for (let i = 0; i < dropArea.length; i++) {
            dropArea[i].addEventListener(eventName, unhighlight, false)
        }
    })

    // Handle dropped files
    for (let i = 0; i < dropArea.length; i++) {
        dropArea[i].addEventListener('drop', handleDrop, false)
    }


    function preventDefaults(e) {
        e.preventDefault()
        e.stopPropagation()
    }

    function highlight(e) {
        dropArea.className = 'highlight'
    }

    function unhighlight(e) {

        dropArea.className = ''
    }

    function handleDrop(e) {

        let dt = e.dataTransfer
        let files = dt.files

        handleFiles(files, e.target)
    }

    var uploadProgress = []


    function initializeProgress(numFiles) {
        document.getElementById('progress-bar').value = 0
        uploadProgress = []

        for (let i = numFiles; i > 0; i--) {
            uploadProgress.push(0)
        }
    }

    function updateProgress(fileNumber, percent) {
        uploadProgress[fileNumber] = percent
        let total = uploadProgress.reduce((tot, curr) => tot + curr, 0) / uploadProgress.length

        document.getElementById('progress-bar').value = total
    }
    function showValidationError(validationErrorText) {
        fileInput.value = ''

        uploadValidationMessage.textContent = validationErrorText

        styleUploadValidationMessage('1', 'scale(1)', '16px', '48px')

        setTimeout(function () {
            styleUploadValidationMessage('0', 'scale(0)', '0px', '0px')
        }, 5000)

        function styleUploadValidationMessage(opacity, transform, marginBottom, height) {
            uploadValidationMessage.style.opacity = opacity
            uploadValidationMessage.style.transform = transform
            uploadValidationMessage.style.marginBottom = marginBottom
            uploadValidationMessage.style.height = height


        }
    }
    function handleFiles(files, target) {

        fileInput = target;
        var filePath = fileInput.value;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.avif|\.svg|\.webp)$/i;

        if (
            (target.id === 'fileElem3' && document.body.className === 'jtc_account_verification') ||
            (target.id === 'fileElem3' && document.body.className === 'jtc2_verify_account') ||
            (target.id === 'fileElem1' && document.body.className === 'account_verification')
        ) {
            if (!allowedExtensions.exec(filePath)) {
                showValidationError(getPoTranslate('INVALID_FILE_TYPE', { 'allowed_type': 'jpg,jpeg,png,gif,avif,svg,webp' }))
                hideLoading()
            } else {

            window.files = [...files]
            initializeProgress(files.length)
            previewFile(window.files[0], target)

            let checkImageBeforeUpload = document.getElementsByClassName('checkImageBeforeUpload')

            for (let i = 0; i < checkImageBeforeUpload.length; i++) {

                checkImageBeforeUpload[i].addEventListener('click', uploadEventHelper)

            }
        }

        } else {
            showLoading()
            if (!allowedExtensions.exec(filePath)) {
                showValidationError(getPoTranslate('INVALID_FILE_TYPE', { 'allowed_type': 'jpg,jpeg,png,gif,avif,svg,webp' }))
                hideLoading()
            } else {

                //Initiate the FileReader object.
                var reader = new FileReader()
                //Read the contents of Image File.
                reader.readAsDataURL(files[0])
                reader.onload = function (e) {
                    //Initiate the JavaScript Image object.
                    var image = new Image()
                    //Set the Base64 string return from FileReader as source.
                    image.src = e.target.result
                    image.onload = function () {
                        //Determine the Height and Width.
                        var height = this.height
                        var width = this.width


                        if (height < 799 & width < 799) {
                            hideLoading()
                            showValidationError(getPoTranslate('HEIGHT_AND_WIDTH_MUST_BE_AT_LEAST', { 'min_pixels': '800px' }))
                        } else {

                            const fsize = files[0].size;
                            const file = Math.round((fsize / 1024));

                            // The size of the file.
                            if (file) {

                                hideLoading()
                                uploadFormReset()

                                if (window.fileUpl) {

                                } else {

                                    window.files = [...files]
                                    initializeProgress(files.length)
                                    previewFile(window.files[0], target)

                                    if (document.body.className === "account_verification" ||
                                        document.body.className === "verification" ||
                                        document.body.className === "jtc_account_verification") {

                                        var initialAvatarURL

                                        if (window.clickOnUploadImageOnVerificationPage) {
                                            showLoading()
                                            setTimeout(function () {
                                                const image = document.getElementsByClassName('gallery')[0].getElementsByTagName('img')[0];
                                                let croppero = new Cropper(image, {
                                                    aspectRatio: 1 / 1,
                                                    minCropBoxWidth: 300,
                                                    minCropBoxHeight: 300,
                                                    crop(event) {
                                                        hideLoading()
                                                        let kr = croppero.getCroppedCanvas()
                                                        initialAvatarURL = kr.toDataURL()

                                                        fetch(initialAvatarURL)
                                                            .then(res => res.blob())
                                                            .then(blob => {
                                                                const file = new File([blob], "File name", { type: "image/jpeg" })
                                                                window.files = [file]
                                                            })
                                                    },
                                                })

                                                window.cropper.push(croppero)

                                                let checkImageBeforeUpload = document.getElementsByClassName('checkImageBeforeUpload')

                                                for (let i = 0; i < checkImageBeforeUpload.length; i++) {

                                                    checkImageBeforeUpload[i].addEventListener('click', uploadEventHelper)

                                                }

                                            }, 300)
                                        }

                                        let checkImageBeforeUpload = document.getElementsByClassName('checkImageBeforeUpload')

                                        for (let i = 0; i < checkImageBeforeUpload.length; i++) {

                                            checkImageBeforeUpload[i].addEventListener('click', uploadEventHelper)

                                        }
                                    } else {

                                        var initialAvatarURL
                                        showLoading()

                                        setTimeout(function () {
                                            const image = document.getElementsByClassName('gallery')[0].getElementsByTagName('img')[0];
                                            let croppero = new Cropper(image, {
                                                aspectRatio: 1 / 1,
                                                minCropBoxWidth: 300,
                                                minCropBoxHeight: 300,
                                                crop(event) {
                                                    hideLoading()
                                                    let kr = croppero.getCroppedCanvas()
                                                    initialAvatarURL = kr.toDataURL()

                                                    fetch(initialAvatarURL)
                                                        .then(res => res.blob())
                                                        .then(blob => {
                                                            const file = new File([blob], "File name", { type: "image/jpeg" })
                                                            window.files = [file]
                                                        })
                                                },
                                            })

                                            window.cropper.push(croppero)

                                            let checkImageBeforeUpload = document.getElementsByClassName('checkImageBeforeUpload')

                                            for (let i = 0; i < checkImageBeforeUpload.length; i++) {

                                                checkImageBeforeUpload[i].addEventListener('click', uploadEventHelper)

                                            }

                                        }, 300)
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }


    }

    function uploadEventHelper(e) {

        if (document.body.className === "account_verification" ||

            document.body.className === "jtc2_verify_account") {

            if (e.target.dataset.verification === "verificationId") {
                setTimeout(function () {

                    if (window.verificationSuccess == 1) {
                        if( document.body.className === "jtc2_verify_account"){
                            uploadFile(window.files[0], 1, {step:4,redirect:'/jtc/account-created'})
                        }else{
                            uploadFile(window.files[0], 1)
                        }

                    } else {
                        toastify('Verification error')
                    }
                }, 100)
            } else {
                uploadFile(window.files[0])
            }
        } else {

            uploadFile(window.files[0])
        }
    }

    function previewFile(file, target) {

        let reader = new FileReader()
        reader.readAsDataURL(file)

        reader.onloadend = function () {
            if (target.parentElement.parentElement.dataset.dropdownId === "1") {
                if (document.getElementsByClassName('gallery')[0].getElementsByTagName('img')[0]) {
                    document.getElementsByClassName('gallery')[1].removeChild(document.getElementsByClassName('gallery')[1].getElementsByTagName('img')[0])
                }
                document.getElementsByClassName('uploadButton')[1].style.display = 'none'

                let img = document.createElement('img')
                img.src = reader.result

                document.getElementsByClassName('gallery')[1].appendChild(img)

                document.getElementsByClassName('checkImageBeforeUpload')[1].classList.remove('dn')

                document.getElementsByClassName('icon-deletes')[1].style.display = 'block'
                window.fileUpl = true

            } else {
                if (document.getElementsByClassName('gallery')[0].getElementsByTagName('img')[0]) {
                    document.getElementsByClassName('gallery')[0].removeChild(document.getElementsByClassName('gallery')[0].getElementsByTagName('img')[0])
                }

                document.getElementsByClassName('uploadButton')[0].style.display = 'none'

                let img = document.createElement('img')
                img.src = reader.result

                document.getElementsByClassName('gallery')[0].appendChild(img)

                document.getElementsByClassName('checkImageBeforeUpload')[0].classList.remove('dn')

                setTimeout(function () {

                    if (document.getElementById('uploadDropArea')?.getElementsByClassName('popuper')[0]) {
                        document.getElementById('uploadDropArea').getElementsByClassName('popuper')[0].style.height = 'auto'
                    }

                    document.getElementsByClassName('icon-deletes')[0].style.display = 'block'
                    window.fileUpl = true
                })
            }
        }

    }


    function uploadFile(file, pointer, jtcObj = false) {


        let fileSize = Math.round(((file.size / 1024) / 1024) / 8)



        showLoading()
        if (fileSize > 30) {
            showValidationError(getPoTranslate('FILE_IS_TO_BIG', { 'max_mb': '30MB' }))
            hideLoading()
        } else {

            showLoading()
            uploadToServer(file, pointer, jtcObj)
        }



    }


    function uploadToServer(file, pointer, jtcObj = false) {

        let i = 0
        let url

        let xhr = new XMLHttpRequest()

        let formData = new FormData()


        if (document.body.className === 'verification') {
            url = envAppBackendUrl + '/add-profile-verification'
            formData.append('name', document.getElementById('verification-form').elements['name'].value)

        } else if (document.body.className === 'jtc2_verify_account') {
            url = envAppBackendUrl + '/add-profile-verification'
            formData.append('name', document.getElementById('verification-form').elements['name'].value)

        } else {
            if (pointer) {
                url = envAppBackendUrl + '/add-profile-verification'
                formData.append('name', document.getElementById('verification-form').elements['name'].value)
            } else {

                url = envAppBackendUrl + '/edit-profile-photo'
            }

        }

        xhr.open('POST', url, true)

        xhr.setRequestHeader('Accept', 'application/json')

        xhr.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))
        xhr.setRequestHeader('Authorization', bearerToken)

        xhr.addEventListener('loadstart', function () {
            document.getElementsByClassName('uplcnt')[0].style.display = 'block'
        })

        // Update progress (can be used to show progress indicator)
        xhr.upload.addEventListener("progress", function (e) {

            updateProgress(i, (e.loaded * 100.0 / e.total) || 100)
        })

        xhr.addEventListener('loadend', function () {

            document.getElementsByClassName('uplcnt')[0].style.display = 'none'
            document.getElementsByClassName('icon-deletes')[0].style.display = 'none'
            dropArea.className = 'uploadedS'
            window.fileUpl = true

        })

        xhr.addEventListener('readystatechange', function (e) {
            if (xhr.readyState == 4 && xhr.status == 200) {


                if (JSON.parse(this.response).success === true) {

                    uploadPictureHelper(1, file)
                    updateProgress(i, 100) // <- Add this
                    uploadFormReset()
                    if (document.body.className === 'account_verification') {
                        location.reload()
                    }

                    if(jtcObj){
                        jtc2StepComplete(jtcObj.step, jtcObj.redirect)
                    }


                } else {
                    toastify(JSON.parse(this.response).message)
                    uploadFormReset()
                }
                hideLoading()
            } else if (xhr.readyState == 4 && xhr.status != 200) {
                // Error. Inform the user
                uploadPictureHelper(0)
                hideLoading()
            }
        })

        xhr.onerror = function () {
            Sentry.captureException(new AcountVerificationSubmitError(errorMessage + ' url: ' + location.href));
        }

        formData.append('file', file)
        xhr.send(formData)
    }

    function uploadPictureHelper(x, f) {

        if (document.getElementById('uploadDropArea')) {
            document.getElementById('uploadDropArea').getElementsByClassName('popuper')[0].style.transform = 'scale(0)'
            document.getElementById('uploadDropArea').style.opacity = '0'

            setTimeout(function () {
                document.getElementById('uploadDropArea').style.display = 'none'
                document.getElementById('uploadDropArea').dataset.opened = "0"

            }, 310)
        }


        if (x === 1) {

            if (document.body.className === "verification") {
                submitVerificationEndAnimation()
                toastify('Verification image successful uploaded')
                uploadFormReset()
            } else if (document.body.className === "jtc_account_verification") {
                submitVerificationEndAnimation()
                toastify('Verification image successful uploaded')
                uploadFormReset()
            } else {

                var reader = new FileReader()
                reader.readAsDataURL(f)
                reader.onloadend = function () {

                    var base64data = reader.result

                    if (document.getElementsByClassName('loggedPic')[0]) {
                        if (window.verificationSuccess == 1){

                        }else if (window.verificationSuccess == 2){
                            document.getElementsByClassName('loggedPic')[0].getElementsByTagName('img')[0].src = base64data
                        }else{
                            document.getElementsByClassName('loggedPic')[0].getElementsByTagName('img')[0].src = base64data
                        }


                    }
                    if (document.getElementsByClassName('profile-area2')[0]) {
                        if (document.getElementById('profile-img')[0]) {
                            document.getElementById('profile-img')[0].src = base64data
                        }
                    }

                }

                toastify('Image successful uploaded')

                if ( document.body.className === 'settings_profile') {
                    if (typeof document.getElementsByClassName('middleLine')[0] === 'undefined' || document.getElementsByClassName('middleLine')[0] === null) {
                        let middleLine = document.createElement('span')
                        middleLine.className = 'middleLine'
                        middleLine.textContent = ' - '

                        document.getElementsByClassName('uploadPhotoTextHolder')[0].appendChild(middleLine)
                    }


                    if (typeof document.getElementById('removePhoto') === 'undefined' || document.getElementById('removePhoto') === null) {
                        let removePhoto = document.createElement('strong')
                        removePhoto.id = 'removePhoto'
                        removePhoto.textContent = 'Remove Photo'

                        document.getElementsByClassName('uploadPhotoTextHolder')[0].appendChild(removePhoto)

                        removeProfilePhoto()
                    }
                }

                uploadFormReset()
            }

        } else if (x === 0) {
            toastify('Something went wrong with upload, please try again')
        }
    }

    let iconDeletes = document.getElementsByClassName('icon-deletes')

    for (let i = 0; i < iconDeletes.length; i++) {
        iconDeletes[i].addEventListener('click', function () {



            let fileInputs = iconDeletes[i].parentElement.parentElement.getElementsByClassName('fileInputs')[0]


            fileInputs.value = ''



            this.style.display = 'none'
            if (iconDeletes[i].dataset.pointer === '1') {
                let iconDeletes2 = document.getElementsByClassName('icon-deletes')
                for (let i = 0; i < iconDeletes2.length; i++) {
                    if (iconDeletes2[i].parentElement.getElementsByTagName('img')[0]) {
                        iconDeletes2[i].parentElement.removeChild(iconDeletes2[i].parentElement.getElementsByTagName('img')[0])
                    }
                }
            }

            uploadFormReset()

            if (document.getElementById('uploadDropArea')?.getElementsByClassName('popuper')[0]) {
                document.getElementById('uploadDropArea').getElementsByClassName('popuper')[0].style.height = 'auto'
            }

            if (document.getElementsByClassName('cropper-container')[0]) {
                document.getElementsByClassName('cropper-container')[0].remove()
            }

            if (document.getElementsByClassName('cropper-hidden')[0]) {
                document.getElementsByClassName('cropper-hidden')[0].classList.remove('cropper-hidden')
            }

        })
    }

}


function uploadFormReset() {
    window.files = []

    let uploadButton = document.getElementsByClassName('uploadButton')
    for (let i = 0; i < uploadButton.length; i++) {
        uploadButton[i].style.cssText = 'display: block;width: 100%;padding: 20px;'
    }

    if (document.getElementsByClassName('gallery')[0].getElementsByTagName('img')[0]) {

        let galleries = document.getElementsByClassName('gallery')
        for (let i = 0; i < galleries.length; i++) {

            if (galleries[i].getElementsByTagName('img')[0]) {
                galleries[i].getElementsByTagName('img')[0].remove()
            }
        }

    }

    window.fileUpl = false

    if (document.getElementById('uploadDropArea')) {


            if (document.getElementById('uploadDropArea')?.getElementsByClassName('popuper')[0]) {
                document.getElementById('uploadDropArea').getElementsByClassName('popuper')[0].style.height = 'auto'
            }


    }

    let iconDelets = document.getElementsByClassName('icon-deletes')

    for (let i = 0; i < iconDelets.length; i++) {
        iconDelets[i].style.display = 'none'
    }

    if (document.getElementById('uploadDropArea')) {
        calculatePopUpHeight(document.getElementById('uploadDropArea'), 52)
    }
    if (window.cropper) {
        for (let i = 0; i < window.cropper.length; i++) {
            window.cropper[i].destroy()

        }
    }
}


function submitVerificationEndAnimation() {

    document.getElementById('verificationForm').style.opacity = '0'

    setTimeout(function () {

        document.getElementById('verificationForm').style.display = 'none'
        document.getElementById('succesUpload').style.display = 'block'
        setTimeout(function () {


            document.getElementById('succesUpload').style.opacity = '1'

            setTimeout(function () {
                document.getElementById('uplGray').style.bottom = '0px'
                setTimeout(function () {
                    document.getElementById('uplBlue').style.top = '0px'
                    document.getElementById('uplText').style.bottom = '32px'
                    setTimeout(function () {

                        location.assign(window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/account-verification'); // '/account-verification?opensharepopup=1'
                    }, 2000)
                }, 150)

            })

        }, 10)

    }, 310)

}

class GetTokenFileUplpad extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenFileUplpad"
    }
}
class AcountVerificationSubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "AcountVerificationSubmitError"
    }
}
