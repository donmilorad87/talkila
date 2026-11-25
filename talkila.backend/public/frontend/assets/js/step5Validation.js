

function initStep5Validation() {

    let formStatus = {};
    let postData = {};

    if (document.getElementById('billing-information-form')) {

        let form = document.getElementById('billing-information-form').elements;

        if (form['accountingId']) {
            postData['accountingId'] = form['accountingId'].value;
        }

        let name, address, city, zipCode, vatId, vatCheckbox,country,taxPercentage

        if(document.getElementById('clientForma').value === 'kormorana'){

            name = form['name']
            address = form['address']
            city = form['city']
            zipCode = form['zipCode']
            vatId = form['vatId']
            vatCheckbox = form['vat_cb'] ?? null
            country = form['country']


            name.addEventListener('input', nameHandler2)
            address.addEventListener('input', addressHandler2)
            city.addEventListener('input', cityHandler2)

            zipCode.addEventListener('input', zipCodeHandler2)
            vatId.addEventListener("input", vatIdHandler2)
            country.addEventListener('change', countryHandler)

        }else{

            name = form['name']
            address = form['address']
            city = form['city']
            zipCode = form['zipCode']
            vatId = form['vatId']
            vatCheckbox = form['vat_cb'] ?? null
            country = form['country']

            name.addEventListener('input', nameHandler)
            address.addEventListener('input', addressHandler)
            city.addEventListener('input', cityHandler)

            zipCode.addEventListener('input', zipCodeHandler)
            vatId.addEventListener("input", vatIdHandler)
            country.addEventListener('change', countryHandler)

        }



        let submitBtn = document.getElementsByClassName('submit-button')

        for (let i = 0; i < submitBtn.length; i++) {
            submitBtn[i].addEventListener('click', handleSubmit)

        }

        function nameHandler2() {
            let params = {
                el: name,
                type: 'input',
                min: 0,
                max: 50,
                svg: true,
                warn: true,
                msg: false
            }

            formStatus['nameStatus'] = inputDriver(params)
            postData['name'] = name.value

            countLabelDriver({
                el: name,
                min: params.min,
                max: params.max
            })
        }

        function addressHandler2() {
            let params = {
                el: address,
                type: 'input',
                min: 0,
                max: 200,
                svg: true,
                warn: false,
                msg: false
            };
            formStatus['addressStatus'] = inputDriver(params);
            postData['address'] = address.value

            countLabelDriver({
                el: address,
                min: params.min,
                max: params.max
            })
        }

        function cityHandler2() {

            let params = {
                el: city,
                type: 'input',
                min: 0,
                max: 50,
                svg: true,
                warn: false,
                msg: false
            }

            formStatus['cityStatus'] = inputDriver(params)
            postData['city'] = city.value
            countLabelDriver({
                el: city,
                min: params.min,
                max: params.max
            })
        }

        function zipCodeHandler2() {
            let params = {
                el: zipCode,
                type: 'datalist',
                min: 0,
                max: 50,
                svg: true,
                warn: false,
                msg: false
            }

            formStatus['zipCodeStatus'] = inputDriver(params)
            postData['zipCode'] = zipCode.value
            countLabelDriver({
                el: zipCode,
                min: params.min,
                max: params.max
            })
        }

        function vatIdHandler2() {
             let params = { el: vatId, type: "input", min: 0, max: 20, svg: true, warn: false, msg: false }
             formStatus["vatIdStatus"] = inputDriver(params)
             postData["vatId"] = vatId.value
             countLabelDriver({ el: vatId, min: params.min, max: params.max })
        }

        function vatCBHandler2() {
            postData['vatCb'] = vatCheckbox ? (vatCheckbox.checked ?? null) : null
        }

        function nameHandler() {
            let params = {
                el: name,
                type: 'input',
                min: 4,
                max: 50,
                svg: true,
                warn: true,
                msg: false
            };
            formStatus['nameStatus'] = inputDriver(params);
            postData['name'] = name.value;
            countLabelDriver({
                el: name,
                min: params.min,
                max: params.max
            });
        }

        function addressHandler() {
            let params = {
                el: address,
                type: 'input',
                min: 4,
                max: 200,
                svg: true,
                warn: false,
                msg: false,
            };
            formStatus['addressStatus'] = inputDriver(params);
            postData['address'] = address.value;
            countLabelDriver({
                el: address,
                min: params.min,
                max: params.max
            });
        }

        function cityHandler() {

            let params = {
                el: city,
                type: 'input',
                min: 1,
                max: 50,
                svg: true,
                warn: false,
                msg: false,
            };
            formStatus['cityStatus'] = inputDriver(params);
            postData['city'] = city.value;
            countLabelDriver({
                el: city,
                min: params.min,
                max: params.max
            });
        }

        function zipCodeHandler() {
            let params = {
                el: zipCode,
                type: 'datalist',
                min: 1,
                max: 50,
                svg: true,
                warn: false,
                msg: false,
            };
            formStatus['zipCodeStatus'] = inputDriver(params);
            postData['zipCode'] = zipCode.value;
            countLabelDriver({
                el: zipCode,
                min: params.min,
                max: params.max
            });
        }

        function vatIdHandler() {
             let params = { el: vatId, type: "input", min: 0, max: 20, svg: true, warn: false, msg: false }
             formStatus["vatIdStatus"] = inputDriver(params)
             postData["vatId"] = vatId.value
             countLabelDriver({ el: vatId, min: params.min, max: params.max })
        }

        function vatCBHandler() {

            postData['vatCb'] = vatCheckbox ? (vatCheckbox.checked ?? null) : null
        }

        function countryHandler() {
            let params = {
                el: country,
                type: 'select',
                min: 1,
                max: 50,
                svg: true,
                warn: false,
                msg: false,
            };
            formStatus['countryStatus'] = inputDriver(params);
            postData['country'] = country.options[country.selectedIndex].value;



        }

        function handleSubmit(e) {

            if(document.getElementById('clientForma').value === 'kormorana'){
                countryHandler()
            }else{
                nameHandler()
                addressHandler()
                cityHandler()
                zipCodeHandler()
                vatCBHandler()
                countryHandler()
                vatIdHandler()
            }




            let isDataOk = Object.keys(formStatus).filter(function (el) {
                return !formStatus[el].isOk;
            }).length > 0 ? false : true;

            if (isDataOk) {
                console.log('Post Success', postData)

                submitValidationForm(postData)


            } else {
                console.log('Post Failed', postData)
                console.log('Post errors', formStatus)
            }


            function submitValidationForm(formData) {
                let token = document.getElementById('billing-information-form').elements['_token'].value


                showLoading()

                let xhr = new XMLHttpRequest();
                let params
                if(document.getElementById('clientForma').value === 'kormorana'){

                    nameHandler2()
                    addressHandler2()
                    cityHandler2()
                    zipCodeHandler2()
                    vatCBHandler2()
                    countryHandler()
                    vatIdHandler2()

                    params = {
                        'id': formData.accountingId ?? null,
                        'city': formData.city,
                        'company_name': formData.name,
                        'countries_id': formData.country,
                        'street': formData.address,
                        'vat': formData.taxPercentage,
                        'zipcode': formData.zipCode,
                        'tax_number'  : formData.vatId ?? null,
                        'pays_vat': formData.vatCb,
                        'from_jtc': document.body.className === 'jtc_set_accounting' ? true : false,
                        '_token': token
                    }

                }else{

                    nameHandler()
                    addressHandler()
                    cityHandler()
                    zipCodeHandler()
                    vatCBHandler()
                    countryHandler()
                    vatIdHandler()

                    params = {
                        'id': formData.accountingId ?? null,
                        'city': formData.city,
                        'company_name': formData.name,
                        'countries_id': formData.country,
                        'street': formData.address,
                        'vat': formData.taxPercentage,
                        'zipcode': formData.zipCode,
                        'tax_number'  : formData.vatId ?? null,
                        'pays_vat': formData.vatCb,
                        'from_jtc': document.body.className === 'jtc_set_accounting' ? true : false,
                        '_token': token
                    };

                }



                xhr.onreadystatechange = function () {

                    if (this.readyState == 4 && this.status == 200) {

                        let response = JSON.parse(this.response);

                        if (response.success === true) {
                            if (document.body.className === 'billing_ingormations') {
                                toastify(response.message)
                            } else if (document.body.className === 'book_slot_payment' || document.body.className === 'video_conference') {
                                toastify(response.message)

                                let country = document.getElementById('country')
                                document.getElementById('countryNameBilling').textContent = country.options[country.selectedIndex].text
                                let pencilOpener = document.getElementsByClassName('pencilOpener')[0]
                                document.getElementsByClassName('hiddenForm')[0].style.maxHeight = '0px'
                                pencilOpener.dataset.opened = '0'

                                if(document.body.className === 'video_conference'){
                                    calculatePopUpHeight(document.getElementById('paymentWalletPopUp'),6)
                                }else if(document.body.className === 'book_slot_payment'){
                                    let taxValue = parseFloat(document.getElementById('bookingStringPrace').dataset.price) * (parseFloat(country.options[country.selectedIndex].dataset.value) / 100)
                                    let fullValueMinusTaxValue = parseFloat(document.getElementById('bookingStringPrace').dataset.price) - taxValue

                                    document.getElementById('bookingBase').textContent                  = new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format(fullValueMinusTaxValue).replace(/[^0-9.,]/g, '') + ' €'
                                    document.getElementById('bookingVAT').textContent                  = new Intl.NumberFormat(getCookie('activeLang'), { style: 'currency', currency: 'EUR' }).format(taxValue).replace(/[^0-9.,]/g, '') + ' €'
                                    document.getElementById('bookingVATPercentage').textContent         = document.getElementById('country').options[document.getElementById('country').selectedIndex].dataset.value
                                }
                            } else {
                                toastify(response.message)
                            }


                        } else if (response.success === false) {
                            toastify(response.message)
                            return response.message

                        }
                        hideLoading()
                    }
                };

                xhr.onerror = function (error) {
                    hideLoading()
                    toastify(this.statusText);
                    Sentry.captureException(new JTCStep5SubmitError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
                };

                xhr.open('POST', '/frontend/api/join-the-club-accounting', true);

                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('Accept', 'application/json');

                xhr.send(JSON.stringify(params));


            }
        }
    }
}

class GetTokenErrorJTCStep5 extends Error {
    constructor(message) {
        super(message);
        this.name = 'GetTokenErrorJTCStep5';
    }
}

class JTCStep5SubmitError extends Error {
    constructor(message) {
        super(message);
        this.name = 'JTCStep5SubmitError';
    }
}

(function () {
    initStep5Validation();
})();
