export default class CheckCache {

    constructor(name, version, apiUrl, lang = false) {

        this.name = name
        this.version = version
        this.apiUrl = apiUrl
        this.lang = lang

        this.check_local_storadge_for_data()
    }

    check_local_storadge_for_data() {
        if (localStorage.getItem(this.name) === null) {
            this.get_data_from_json_file(this.apiUrl, `app_${this.name}`, this.version, this.lang)
        } else {
            if (localStorage.getItem(`app_${this.name}_version`) !== document.getElementById(`app_${this.name}_version`).value) {

                this.get_data_from_json_file(this.apiUrl, `app_${this.name}`, this.version, this.lang)
            } else {
                this.get_data_from_cache(JSON.parse(localStorage.getItem(`app_${this.name}`)))
            }
        }


    }

    get_data_from_json_file(url, localStorageName, version, lang) {
        var xhttp = new XMLHttpRequest()

        xhttp.onreadystatechange = function () {


            if (this.readyState == 4 && this.status == 200) {


                let response = JSON.parse(this.response)

                localStorage.setItem(`app_${localStorageName}${lang ? '_' + lang : ''}`, JSON.stringify(response))
                localStorage.setItem(`app_${localStorageName}${lang ? '_' + lang : ''}_version`, version)


            }
        }

        xhttp.open("GET", url, true)

        xhttp.onerror = function () {
            Sentry.captureException(new GetDataError('status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))
        }

        xhttp.send()
    }

    get_data_from_cache(obj) {

    }
}
