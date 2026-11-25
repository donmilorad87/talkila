
class LanguageMenu {

    constructor() {

        this.languageMenuOpen()
    }

    languageMenuOpen() {
        if (document.getElementsByClassName('languageCell')[0]) {


            let languageCell = document.getElementsByClassName('languageCell')
            let languageList = document.getElementsByClassName('languageList')[0]
            let numberOfFlags = languageList.getElementsByClassName('languageListCell')



            for (let i = 0; i < languageCell.length; i++) {
                languageCell[i].addEventListener('click',  (e) => {

                    e.preventDefault()
                    e.stopImmediatePropagation()
                    e.stopPropagation()

                    if(localStorage.getItem("app_flags")){
                        if(localStorage.getItem("app_flags_version") !== document.getElementById('app_flags_version').value){
                            this.getFlagsData('/frontend/assets/js/lang.json', this.inputFlags, 'app_flags')
                        }else{
                            this.inputFlags(JSON.parse(localStorage.getItem("app_flags")))
                        }
                    }else{
                        this.getFlagsData('/frontend/assets/js/lang.json', this.inputFlags, 'app_flags')
                    }



                    languageList.style.transition = '0.3s'
                    document.addEventListener('click', this.checkIfIsInOptionButton)

                    if (e.target.dataset.opened === "0") {
                        if(languageCell[i].getElementsByClassName('rotate90')[0]){
                            languageCell[i].getElementsByClassName('rotate90')[0].style.transform = 'rotate(90deg) scale(-1 , 1)'
                        }
                        languageList.style.height       = (numberOfFlags.length - 1) * 30 + 'px'
                        languageList.style.border       = '1px solid rgba(6,4,3,0.1)'
                        languageList.style.boxShadow    = 'inset 0 0 0 1px rgba(6, 4, 3, 0.1)'
                        e.target.dataset.opened         = 1
                        let that = e.target
                        for (let i = 0; i < numberOfFlags.length; i++) {
                            numberOfFlags[i].addEventListener('click', function () {

                                let helper =  numberOfFlags[i]
                                let cln = helper.cloneNode(true)
                                cln.getElementsByTagName('p')[0].remove()

                                document.getElementById('languageCellFlag').innerHTML = cln.innerHTML
                                //document.getElementsByClassName('languageCell')[0].removeChild(document.getElementsByClassName('languageCell')[0].getElementsByTagName('p')[0])
                                document.getElementsByClassName('languageCell')[0].dataset.platform = numberOfFlags[i].dataset.platform

                                languageList.style.height = '0px'
                                languageList.style.border = '1px solid transparent'
                                that.dataset.opened = 0

                                location.assign(numberOfFlags[i].href)

                                document.getElementById('languageListStringContainer').textContent = numberOfFlags[i].getElementsByClassName('languageP')[0].textContent.trim()

                                document.getElementsByClassName('rotate90')[0].innerHTML = '<svg width="8" height="14" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.3" d="M-6.16331e-08 10.59L4.59 6L-4.62904e-07 1.41L1.42 -6.20702e-08L7.42 6L1.42 12L-6.16331e-08 10.59Z" fill="#172B4D"></path></svg>'

                                let that2 = numberOfFlags[i]
                                setTimeout(function () {
                                    for (let i = 0; i < numberOfFlags.length; i++) {
                                        if (numberOfFlags[i].className.indexOf('dnone') !== -1) {
                                            numberOfFlags[i].className = 'languageListCell'
                                            break
                                        }

                                    }
                                    that2.className = that2.className + ' dnone'
                                }, 310)
                            })
                        }



                    } else {
                        if(languageCell[i].getElementsByClassName('rotate90')[0]){
                            languageCell[i].getElementsByClassName('rotate90')[0].style.transform = 'rotate(90deg) scale(1 , 1)'
                        }
                        languageList.style.height       = '0px'
                        languageList.style.border       = '1px solid transparent'
                        languageList.style.boxShadow    = 'inset 0 0 0 0px rgba(6, 4, 3, 0.1)'
                        e.target.dataset.opened         = 0

                    }

                })
            }






        }

    }
    checkIfIsInOptionButton(event) {
        let languageCell = document.getElementsByClassName('languageCell')
        let languageList = document.getElementsByClassName('languageList')[0]
        let parentElement = document.getElementsByClassName('lanugageMainCont')[0]
        let parentElement2 = document.getElementsByClassName('languageList')[0]

        let isClickInside = parentElement.contains(event.target);
        let isClickInside2 = parentElement2.contains(event.target);

        if (!isClickInside && !isClickInside2) {
            languageList.style.height = '0px'
            languageList.style.border = '1px solid transparent'
            for (let i = 0; i < languageCell.length; i++) {
                languageCell[i].dataset.opened = 0
            }

        }
    }
    inputFlags(flags) {

        let languageList = document.getElementsByClassName('languageList')

        for (let i = 0; i < languageList.length; i++) {

            if (languageList[i].dataset.filled === "0") {

                let languageListCell = languageList[i].getElementsByClassName('languageListCell')

                for (let i = 0; i < languageListCell.length; i++) {

                    let svgDiv = document.createElement('div')

                    svgDiv.innerHTML = flags[languageListCell[i].dataset.platform]

                    languageListCell[i].insertBefore(svgDiv.getElementsByTagName('svg')[0], languageListCell[i].getElementsByClassName('languageP')[0])

                }

                languageList[i].dataset.filled = 1
            }
        }
    }

    getFlagsData(url, callback, localStorageName) {

        var xhttp = new XMLHttpRequest()

        xhttp.onreadystatechange = function () {

            if (this.readyState == 1) {
                document.getElementsByTagName('html')[0].style.cursor = 'progress'
            }

            if (this.readyState == 4 && this.status == 200) {
                document.getElementsByTagName('html')[0].style.cursor = 'default'
                let flags = JSON.parse(this.responseText)
                localStorage.setItem(localStorageName, this.responseText)
                localStorage.setItem('appVersion', document.getElementById('app_version').textContent.trim())
                callback(flags)
            }
        }

        xhttp.open("GET", url, true)

        xhttp.onerror = function () {
            Sentry.captureException(new GetDataError('status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))
        }

        xhttp.send()

    }
}



(function () {
    let languageMenu = new LanguageMenu()
})()
