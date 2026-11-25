


function creditCardFullName() {

    let nameStatus = {}

    let nameValue

    if (document.getElementById("submitAddCreditCard")) {

        let nameInput = document.getElementById('card_holder_name')

        let nameWarn = nameInput.parentElement.getElementsByClassName("name-warn")[0]

        let nameSvg = nameInput.parentElement.getElementsByClassName("verified-name-svg")[0]

        nameInput.addEventListener("input", nameHandler)

        document.getElementById("submitAddCreditCard").addEventListener("click", handleSubmit)

        function nameHandler() {
            nameValue = nameInput.value

            let check = nameCheck(nameValue)
                nameStatus = check

            if (check.isOk) {

                nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#1d293f'

                countLabelDriver({ el: nameInput, min: 4, max: 50 })
                    nameInput.classList.remove("error")
                    nameInput.classList.add("ok")

                    nameSvg.classList.add("active")
                    nameWarn.classList.remove("active")

            } else {
                nameInput.parentElement.getElementsByClassName('input-label')[0].style.color = '#FD2A18'

                countLabelDriver({ el: nameInput, min: 4, max: 50 })


                    nameInput.classList.add("error")
                    nameInput.classList.remove("ok")

                    nameSvg.classList.remove("active")

                    nameWarn.classList.add("active")

                    nameWarn.innerHTML = "&nbsp"
                    nameWarn.innerHTML += check.hasName ? "" : translate.missingName + ","
                    nameWarn.innerHTML += check.hasSurname ? "" : " " + translate.missingSurname + ","
                    nameWarn.innerHTML += check.hasNumber ? " " + translate.noNumbers + "," : ""
                    nameWarn.innerHTML += check.hasSymbol ? " " + translate.noSpecialCharacters + "," : ""
                    nameWarn.innerHTML += check.lengthLimit ? " " + getPoTranslate('MINIMUM_AND_MAXIMUM_CHARACTERS', {'minimum_characters':'4', 'maximum_characters':'50'}) + "," : ""


            }
        }

        function handleSubmit(e) {
            e.preventDefault()
            nameHandler()

            let postData = {
                name: nameValue
            }

            let postStatus = {
                name: nameStatus
            }

            if (nameStatus.isOk) {
                //this is where ajax call should be made




            } else {
                console.log("fullName validation failed", postData)
                console.log("fullName validation errors", postStatus)
            }

        }

    }
}


(function () {
    creditCardFullName()
})()
