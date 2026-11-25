function initSetPrivateProfile() {



    if (document.getElementById("edit_private_profile_form")) {

        let setPrivateProfileForm = document.getElementById("edit_private_profile_form").elements

        document.getElementById("setPrivateProfileSubmit").addEventListener("click", handleSubmit)

        let privateProfileOnOff = setPrivateProfileForm["privateProfileOnOff"]



        function handleSubmit() {
            submitValidationForm()
        }

        function submitValidationForm() {

            let token = document.getElementById("_token").getElementsByTagName("input")[0].value;

            jQuery.ajax({
                type: 'POST',
                url: '/frontend/api/edit-profile-private-status',
                data: {
                    'private_status': privateProfileOnOff.checked ? consts.private_status_OFF :  consts.private_status_ON,
                    '_token'        : token
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
                        let privatePublicPlaceholder
                        if(privateProfileOnOff.checked){
                            privatePublicPlaceholder = getPoTranslate('PUBLIC_INFO') + ' ' + getPoTranslate('PROFILE')
                        }else{
                            privatePublicPlaceholder = getPoTranslate('PRIVATE') + ' ' + getPoTranslate('PROFILE')
                        }

                        document.getElementById('setPrivateProfileInput').placeholder = privatePublicPlaceholder

                        closePopup('setPrivateProfile')
                        toastify(response.message)

                    } else {
                        toastify(response.message)
                    }
                },
                error: function (errorMessage) {
                    Sentry.captureException(new SetPrivateProfileSubmitError(errorMessage + ' url: ' + location.href ));
                }
            });
        }
    }
}

class GetTokenSetPrivateProfile extends Error {
    constructor(message) {
        super(message)
        this.name = "GetTokenSetPrivateProfile"
    }
}
class SetPrivateProfileSubmitError extends Error {
    constructor(message) {
        super(message)
        this.name = "SetPrivateProfileSubmitError"
    }
}


(function () {
    initSetPrivateProfile()
})();
