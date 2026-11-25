function billingPaymentValidation() {

    let formStatus = {};
    let postData   = {};

    if (document.getElementById('billing-information-formclient')) {

        let form = document.getElementById('billing-information-formclient').elements;

        if (form['accountingId']) {
            postData['accountingId'] = form['accountingId'].value;
        }
        if (form['billing_type']) {
            postData['billing_type'] = form['billing_type'].value;
        }

        let name          = form['name'];
        let address       = form['address'];
        let city          = form['city'];
        let zipCode       = form['zipCode'];
        let vatCheckbox   = form['vat_cbclient'];
        let country       = form['country'];
        let taxPercentage = form['taxPercentage'];

        name.addEventListener('input', nameHandler);
        address.addEventListener('input', addressHandler);
        city.addEventListener('input', cityHandler);

        zipCode.addEventListener('input', zipCodeHandler);

        country.addEventListener('change', countryHandler);
        taxPercentage.addEventListener('change', taxPercentageHandler);

        let submitBtn = document.getElementsByClassName('submit-button-client');
        for (let i = 0; i < submitBtn.length; i++) {
            submitBtn[i].addEventListener('click', handleSubmit);

        }

        function nameHandler() {
            let params               = { el: name, type: 'input', min: 4, max: 50, svg: true, warn: true, msg: false };
            formStatus['nameStatus'] = inputDriver(params);
            postData['name']         = name.value;
            countLabelDriver({ el: name, min: params.min, max: params.max });
        }

        function addressHandler() {
            let params                  = {
                el  : address,
                type: 'input',
                min : 4,
                max : 200,
                svg : true,
                warn: false,
                msg : false,
            };
            formStatus['addressStatus'] = inputDriver(params);
            postData['address']         = address.value;
            countLabelDriver({ el: address, min: params.min, max: params.max });
        }

        function cityHandler() {

            let params               = {
                el  : city,
                type: 'input',
                min : 1,
                max : 50,
                svg : true,
                warn: false,
                msg : false,
            };
            formStatus['cityStatus'] = inputDriver(params);
            postData['city']         = city.value;
            countLabelDriver({ el: city, min: params.min, max: params.max });
        }

        function zipCodeHandler() {
            let params                  = {
                el  : zipCode,
                type: 'datalist',
                min : 1,
                max : 50,
                svg : true,
                warn: false,
                msg : false,
            };
            formStatus['zipCodeStatus'] = inputDriver(params);
            postData['zipCode']         = zipCode.value;
            countLabelDriver({ el: zipCode, min: params.min, max: params.max });
        }

        function vatCBHandler() {
            let params = {
                el  : vatCheckbox,
                type: 'checkbox',
            };

            postData['vatCb'] = vatCheckbox.checked;
        }

        function countryHandler() {
            let params                  = {
                el  : country,
                type: 'select',
                min : 1,
                max : 50,
                svg : true,
                warn: false,
                msg : false,
            };
            formStatus['countryStatus'] = inputDriver(params);
            postData['country']         = country.options[country.selectedIndex].value;

        }

        function taxPercentageHandler() {
            let params                        = {
                el  : taxPercentage,
                type: 'select',
                min : 1,
                max : 50,
                svg : true,
                warn: false,
                msg : false,
            };
            formStatus['taxPercentageStatus'] = {isOk: true}
            postData['taxPercentage']         = taxPercentage.options[taxPercentage.selectedIndex].value;
        }

        function handleSubmit(e) {

            nameHandler()
            addressHandler()
            cityHandler()
            zipCodeHandler()
            vatCBHandler()
            countryHandler()
            taxPercentageHandler()


            let isDataOk = Object.keys(formStatus).filter(function (el) { return ! formStatus[el].isOk; }).length > 0 ? false : true;

            if (isDataOk) {
                console.log('Post Success', postData)

                submitValidationForm(postData)


            } else {
                console.log('Post Failed', postData)
                console.log('Post errors', formStatus)
            }


            function submitValidationForm(formData) {
                let token = document.getElementById('billing-information-form').elements['_token'].value

                jQuery.ajax({
                    type      : 'POST',
                    headers   : {
                        'Accept': 'application/json',
                    },
                    url       : '/frontend/api/join-the-club-accounting',
                    data      : {
                        'id'          : formData.accountingId ?? null,
                        'city'        : formData.city,
                        'company_name': formData.name,
                        'countries_id': formData.country,
                        'street'      : formData.address,
                        'vat'         : formData.taxPercentage,
                        'zipcode'     : formData.zipCode,
                        'billing_type' : formData.billing_type,
                        // 'tax_number'  : formData.taxId ?? null,
                        'pays_vat'      : formData.vatCb,
                        'jtc_billing'  : document.body.className === 'jtc_set_accounting' ? 1 : 0,
                        '_token'      : token,
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

                            if (document.body.className === 'billing_ingormations') {
                                toastify(response.message)
                            }else if (document.body.className === 'book_slot_payment') {
                                toastify(response.message)
                                let billingDropdown = document.getElementsByClassName('billingDropdown')[0]
                                billingDropdown.style.transform = 'scale(0)'
                                billingDropdown.style.opacity = '0'
                                setTimeout(function(){
                                    billingDropdown.remove()
                                },310)
                            } else {
                                toastify(response.message)
                            }



                        } else {
                            toastify(response.message)
                            return response.message
                        }
                    },
                    error     : function (errorMessage) {
                        Sentry.captureException(new BillingPaymentAddressSubmitError(errorMessage))
                    },
                });
            }
        }
    }
}

class BillingPaymentAddress extends Error {
    constructor(message) {
        super(message);
        this.name = 'BillingPaymentAddress';
    }
}

class BillingPaymentAddressSubmitError extends Error {
    constructor(message) {
        super(message);
        this.name = 'BillingPaymentAddressSubmitError';
    }
}

(function () {
    billingPaymentValidation();
})();
