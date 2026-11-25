export function pauseTalks() {
    if (document.getElementById('categorySubcategoryTalksTable')) {

        if (document.getElementById('categorySubcategoryTalksTable').getElementsByClassName('switcher')[0]) {

            let switches = document.getElementById('categorySubcategoryTalksTable').getElementsByClassName('switcher')
            for (let i = 0; i < switches.length; i++) {

                switches[i].getElementsByTagName('input')[0].addEventListener('change', function () {

                    showLoading()

                    if (this.checked === false) {

                        try {

                            pauseTalk(this.parentElement.parentElement.parentElement.parentElement.getElementsByClassName('dataTalkId')[0].dataset.talkId, this.parentElement.parentElement.parentElement.parentElement, !this.checked)
                        } catch (err) {
                            Sentry.captureException(new TryCatchPauseTalk(err));
                        }

                    } else if (this.checked === true) {

                        try {

                            unPauseTalk(this.parentElement.parentElement.parentElement.parentElement.getElementsByClassName('dataTalkId')[0].dataset.talkId, this.parentElement.parentElement.parentElement.parentElement, !this.checked)
                        } catch (err) {
                            Sentry.captureException(new TryCatchUnPauseTalk(err));
                        }

                    }

                })
            }
        }
    }

    function pauseTalk(talkId, parent = false, pauseStateBefore) {
        let url = '/frontend/api/pause-talk/' + talkId
        let params = {
            _token: document.querySelector("meta[name='csrf-token']").getAttribute("content")
        }
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.responseText)

                if (response.success == true) {
                    toastify(response.message)
                    if (document.body.className === 'logged_in') {
                        if (parent) {
                            parent.getElementsByClassName('shareTalk')[0].classList.add('pen')
                            parent.getElementsByClassName('shareTalk')[0].getElementsByTagName('div')[0].classList.add('dn')
                        }
                    }



                } else {
                    toastify(response.message)
                    if (document.body.className === 'logged_in') {

                        if (parent) {
                            parent.getElementsByClassName('switch-input')[0].checked = pauseStateBefore
                        }
                    }
                }
                hideLoading()
            }
        };

        xhr.open("POST", url, true)

        xhr.onerror = function () {
            Sentry.captureException(new pauseTalkError('status: ' + this.statusText + '|| response: ' +
                this.statusText + ' || url: ' + location.href))
        }
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.send(JSON.stringify(params))
    }

    function unPauseTalk(talkId, parent = false, pauseStateBefore) {
        let url = '/frontend/api/unpause-talk/' + talkId
        let params = {
            _token: document.querySelector("meta[name='csrf-token']").getAttribute("content")
        }
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {

                let response = JSON.parse(this.responseText)

                if (response.success == true) {

                    toastify(response.message)
                    if (document.body.className === 'logged_in') {
                        if (parent) {
                            parent.getElementsByClassName('shareTalk')[0].classList.remove('pen')
                            parent.getElementsByClassName('shareTalk')[0].getElementsByTagName('div')[0].classList.remove('dn')
                        }
                    }
                } else {
                    toastify(response.message)
                    if (document.body.className === 'logged_in') {

                        if (parent) {
                            parent.getElementsByClassName('switch-input')[0].checked = pauseStateBefore
                        }
                    }
                }
                hideLoading()
            }
        };

        xhr.open("POST", url, true)

        xhr.onerror = function () {
            Sentry.captureException(new unPauseTalkError('status: ' + this.statusText + '|| response: ' +
                this.statusText + ' || url: ' + location.href))
        }
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.send(JSON.stringify(params))
    }

    class TryCatchPauseTalk extends Error {
        constructor(message) {
            super(message)
            this.name = "TryCatchPauseTalk"
        }
    }

    class TryCatchUnPauseTalk extends Error {
        constructor(message) {
            super(message)
            this.name = "TryCatchUnPauseTalk"
        }
    }

    class pauseTalkError extends Error {
        constructor(message) {
            super(message)
            this.name = "pauseTalkError"
        }
    }

    class unPauseTalkError extends Error {
        constructor(message) {
            super(message)
            this.name = "unPauseTalkError"
        }
    }
}

export function deleteTalk() {
    if (document.getElementById('acceptRemovingCourse')) {
        document.getElementById('acceptRemovingCourse').addEventListener('click', function () {
            showLoading()
            try {

                removeCourse()
            } catch (err) {
                hideLoading()
                Sentry.captureException(new TryCatchRemoveCourseFunction(err));
            }

            function removeCourse() {

                try {
                    let courseId = document.getElementById('acceptRemovingCourse').dataset.talkId

                    let cancelFutureBookingState = ''
                    if (document.getElementById('cancel_bookings').checked) {
                        cancelFutureBookingState = '?cancel_bookings=true'
                    }

                    let xhr = new XMLHttpRequest()

                    xhr.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {

                            let response = JSON.parse(this.responseText)

                            if (response.success == true) {

                                toastify(response.message)
                                location.reload()
                            } else {
                                toastify(response.message)
                                hideLoading()
                            }
                        }
                    }

                    xhr.open("DELETE", "/frontend/api/delete-talks/" + courseId + cancelFutureBookingState, true)

                    xhr.onerror = function () {
                        Sentry.captureException(new deleteTalkError('status: ' + this.statusText + '|| response: ' +
                            this.statusText + ' || url: ' + location.href))
                    }

                    xhr.setRequestHeader('X-CSRF-TOKEN', token);

                    xhr.send()

                } catch (err) {
                    Sentry.captureException(new TryDeleteTalkError(err))
                }
            }

            class deleteTalkError extends Error {
                constructor(message) {
                    super(message)
                    this.name = "deleteTalkError"
                }
            }

            class TryDeleteTalkError extends Error {
                constructor(message) {
                    super(message)
                    this.name = "TryDeleteTalkError"
                }
            }


        })
    }
}
