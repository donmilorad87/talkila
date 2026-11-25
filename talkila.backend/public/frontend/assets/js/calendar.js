let today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
let selectYear = document.getElementById("year");
let selectMonth = document.getElementById("month");
let monthHeader = document.getElementById("monthHeader");
let yearHeader = document.getElementById("yearHeader");
let nextBtn = document.getElementById("next");
let previousBtn = document.getElementById("previous");
let datePicked = document.getElementById("date-picked");
let todayReset = document.getElementById('todays')
let months = "";
let days = "";
var monthsArr = localizationJson.monthNames
let daysArr = localizationJson.weekDays
let sevenDayHelper = 0;
let bookingsList = document.getElementById("userBookingsList") ? JSON.parse(document.getElementById("userBookingsList").value) : false
let bookingArray = bookingsList.bookings;
months = monthsArr;
days = daysArr;

let tableHeaderMonth = document.getElementById("thead-month");
let dataHead = "<tr>";
let startDay = "";
let newTeacherAvailabilityDatesTime

if (document.body.className !== 'booking') {

    newTeacherAvailabilityDatesTime = JSON.parse(document.getElementById('newTeacherAvailabilityDatesTime').value.trim())
}

for (let i = 0; i < days.length; i++) {
    days[i] === "Sun" ? startDay = "red-text" : startDay = "";
    dataHead += "<th data-days='" + days[i] + "' class='" + startDay + "'>" + days[i] + "</th>";
}

dataHead += "</tr>"
tableHeaderMonth.innerHTML = dataHead

if (document.body.className !== "booking") {


    let splitter2 = newTeacherAvailabilityDatesTime.availabilities[0].date.split('-')

    showCalendar((parseInt(splitter2[1]) - 1), splitter2[0])

    let dates = document.getElementById('calendar-body').getElementsByTagName('td')

    for (let i = 0; i < dates.length; i++) {
        if (dates[i].dataset.date == splitter2[2]) {
            dates[i].classList.add('selected')
        }
    }

} else {
    let obj2 = JSON.parse(document.getElementById('userBookingsList').value.trim())

    if (obj2 && obj2.first_upcoming_booking && Object.keys(obj2.first_upcoming_booking).length > 0) {
        let daterr = Object.keys(obj2.first_upcoming_booking)[0]
        let deter = daterr.split('-')

        showCalendar((parseInt(deter[1]) - 1), deter[0])
        let dates = document.getElementById('calendar-body').getElementsByTagName('td')

        for (let i = 0; i < dates.length; i++) {
            if (dates[i].dataset.date == deter[2]) {
                dates[i].classList.add('selected')
            }
        }
    } else {
        let now = new Date()
        showCalendar(now.getMonth(), now.getFullYear())
    }
}

nextBtn.addEventListener("click", next, false)

previousBtn.addEventListener("click", previous, false)

if (document.getElementById('todays')) {
    todayReset.addEventListener("click", resetToday, false);
}

let createYear = yearRange(1970, 2050)
selectYear.innerHTML = createYear

window.overlapingSlots = {}


function findEvent(newTeacherAvailabilityDatesTime, event_id, date) {

    for (let i = 0; i < newTeacherAvailabilityDatesTime.availabilities.length; i++) {
        if (newTeacherAvailabilityDatesTime.availabilities[i].date === date) {

            for (let j = 0; j < newTeacherAvailabilityDatesTime.availabilities[i].overlapping_events.length; j++) {

                if (newTeacherAvailabilityDatesTime.availabilities[i].overlapping_events[j].id === event_id) {
                    return newTeacherAvailabilityDatesTime.availabilities[i].overlapping_events[j]
                }
            }

        }

    }
}

window.createOverlapingSlotsObject = function (newTeacherAvailabilityDatesTime, date) {


    for (let i = 0; i < newTeacherAvailabilityDatesTime.availabilities.length; i++) {
        if (newTeacherAvailabilityDatesTime.availabilities[i].date === date) {
            if (newTeacherAvailabilityDatesTime.availabilities[i].hasOwnProperty('overlapping_events')) {

                newTeacherAvailabilityDatesTime.availabilities[i].overlapping_events.forEach(function (overlapping_event) {

                    let slotObjetct = {}

                    let slotArray = []

                    for (let j = 0; j < newTeacherAvailabilityDatesTime.availabilities[i].time_slots.length; j++) {
                        let id = overlapping_event.id
                        if (newTeacherAvailabilityDatesTime.availabilities[i].time_slots[j].hasOwnProperty('event_id')) {

                            let time = new Date(newTeacherAvailabilityDatesTime.availabilities[i].time_slots[j].time)
                            if (id === newTeacherAvailabilityDatesTime.availabilities[i].time_slots[j].event_id) {
                                slotArray.push(addZero(time.getHours()) + ':' + addZero(time.getMinutes()))
                            }
                        }
                    }


                    slotObjetct.timeslots = slotArray
                    //slotObjetct.email = overlapping_event.calendars.toString()
                    //slotObjetct.info = overlapping_event.events.toString()



                    let overlapping_ev = document.createElement('div')

                    overlapping_event.items.forEach(function (item) {

                        let overlapping_ev_inner = document.createElement('div')
                        overlapping_ev_inner.innerHTML = `
                                                            <div class="df aic w-100">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.00002 4.99935H6.66669V4.16602H13.3334V4.99935H15V4.16602H16.6667V6.66602H3.33335V4.16602H5.00002V4.99935ZM3.33335 8.33268V16.666H16.6667V8.33268H3.33335ZM6.66669 2.49935H13.3334V1.66602H15V2.49935H16.6667C17.5872 2.49935 18.3334 3.24554 18.3334 4.16602V16.666C18.3334 17.5865 17.5872 18.3327 16.6667 18.3327H3.33335C2.41288 18.3327 1.66669 17.5865 1.66669 16.666V4.16602C1.66669 3.24554 2.41288 2.49935 3.33335 2.49935H5.00002V1.66602H6.66669V2.49935Z" fill="#172B4D"/></svg>
                                                            <div class="ml16 emailerInfo"></div>
                                                            </div>
                                                            <ul class="eventUlis w-100 p8 lin"></ul>
                                                        `
                        overlapping_ev_inner.className = 'df aic jcc fdc innerOverlaps'


                        overlapping_ev_inner.getElementsByClassName('emailerInfo')[0].textContent = item.calendar

                        item.events.forEach(function (event) {

                            let li = document.createElement('li')
                            li.className = 'aic'
                            li.innerHTML = `
                                                <div class="df aic">

                                                    <div class="timeDiv mr16">

                                                    </div>

                                                    <div class="eventNameDiv">

                                                    </div>

                                                </div>
                                            `

                            li.getElementsByClassName('eventNameDiv')[0].textContent = event.name

                            li.getElementsByClassName('timeDiv')[0].textContent = event.start.split(' ')[1] + ' - ' + event.end.split(' ')[1]

                            overlapping_ev_inner.getElementsByClassName('eventUlis')[0].append(li)


                        })
                        overlapping_ev.append(overlapping_ev_inner)
                    })

                    slotObjetct.info = overlapping_ev
                    //infoDivCalendarEvents.append(overlapping_ev)
                    overlapingSlots[overlapping_event.id] = slotObjetct

                })

            }
        }

    }

}

function getBookingTalkAvailability2(date) {

    if (document.body.className === 'book_slot') {

        let bookingPayment = document.getElementById('booking-payment')

        document.getElementsByClassName('tl-pt-wrap2')[0].append(bookingPayment)

        if (document.getElementById('bookingAnonCont')) {
            let bookingAnonCont = document.getElementById('bookingAnonCont')
            bookingAnonCont.classList.add('dn')
            document.getElementsByClassName('weekly-time')[0].parentElement.append(bookingAnonCont)
        }

        document.getElementsByClassName('weekly-time')[0].innerHTML = ''
        let obi = {}
        for (let i = 0; i < newTeacherAvailabilityDatesTime.availabilities.length; i++) {
            if (date === newTeacherAvailabilityDatesTime.availabilities[i].date) {

                for (let j = 0; j < newTeacherAvailabilityDatesTime.availabilities[i].time_slots.length; j++) {


                    let timez = newTeacherAvailabilityDatesTime.availabilities[i].time_slots[j]?.time

                    let button = document.createElement("button")

                    button.className = 'hollow btn'
                    button.textContent = timez.split(' ')[1].slice(0, -3)


                    if (newTeacherAvailabilityDatesTime.availabilities[i].time_slots[j].hasOwnProperty('event_id')) {



                        button.dataset.event = newTeacherAvailabilityDatesTime.availabilities[i].time_slots[j].event_id

                        let eventDetails = findEvent(newTeacherAvailabilityDatesTime, newTeacherAvailabilityDatesTime.availabilities[i].time_slots[j].event_id, newTeacherAvailabilityDatesTime.availabilities[i].date)



                    }

                    let bookingPaymentButton = document.getElementById('booking-payment')

                    button.addEventListener('click', function (e) {
                        e.stopPropagation()

                        let overlapingSlotsFrame = e.currentTarget.parentElement.parentElement

                        let openedHeight
                        let infoDivCalendarEvents = document.getElementsByClassName('infoDivCalendarEvents')[0]





                        if (bookingPaymentButton) {
                            bookingPaymentButton.style.right = '-50%'
                        }


                        if (document.getElementsByClassName('weekly-time')[0].getElementsByClassName('activee')[0]) {
                            document.getElementsByClassName('weekly-time')[0].getElementsByClassName('activee')[0].textContent =
                                document.getElementsByClassName('weekly-time')[0].getElementsByClassName('activee')[0].dataset.time

                            document.getElementsByClassName('weekly-time')[0].getElementsByClassName('activee')[0].classList.remove('activee')
                        }

                        this.classList.add('activee')

                        this.dataset.time = this.textContent

                        let isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent)

                        let dateHelper

                        isSafari ? dateHelper = new Date('2021/04/01 ' + this.textContent + ':00') : dateHelper = new Date('2021/04/01 ' + this.textContent + ':00')

                        let dateHelperToTime = addMinutes(dateHelper, document.getElementById('talkMinutes').textContent.match(/\d+/g).join(''))

                        this.textContent += ' - ' + addZero(dateHelperToTime.getHours()) + ':' + addZero(dateHelperToTime.getMinutes())
                        this.dataset.endTime = addZero(dateHelperToTime.getHours()) + ':' + addZero(dateHelperToTime.getMinutes())
                        this.innerHTML = '<span class="hideForSmalls mr8">' + document.getElementById('talkMinutes').textContent + ' |</span>' + this.textContent
                        let timeSlots = document.getElementsByClassName('weekly-time')[0].getElementsByTagName('button')

                        for (let i = 0; i < timeSlots.length; i++) {
                            timeSlots[i].style.width = "100%"
                            if (timeSlots[i].getElementsByClassName('bookingAnonCont')[0]) {
                                timeSlots[i].getElementsByClassName('bookingAnonCont')[0].style.transform = 'scale(0)'
                                timeSlots[i].getElementsByClassName('bookingAnonCont')[0].style.opacity = '0'
                            }
                            timeSlots[i].parentElement.style.height = 'auto'
                        }

                        this.style.width = '49%'


                        if (document.getElementById('bookingAnonCont')) {
                            this.parentElement.append(document.getElementById('bookingAnonCont'))
                            this.parentElement.style.height = 'auto'
                        } else {
                            this.parentElement.style.height = 'auto'
                        }

                        let that = this

                        setTimeout(function () {

                            that.parentElement.insertBefore(bookingPaymentButton, that.parentElement.getElementsByClassName('bookingAnonCont')[0])

                            setTimeout(function () {
                                bookingPaymentButton.style.right = "0%"
                            }, 10)

                            bookingPaymentButton.classList.add('activeButtoner')

                        }, 310)


                        setBookingTimeToLocalStoradge(this.dataset.time, addZero(dateHelperToTime.getHours()) + ':' + addZero(dateHelperToTime.getMinutes()))

                        if (e.currentTarget.parentElement.parentElement.className === 'redFramebord') {
                            openedHeight =
                                parseInt(document.getElementById('bookingAnonCont').offsetHeight)
                                + parseInt(overlapingSlotsFrame.getElementsByClassName('divItemTransition').length + 1) * 64
                                + (infoDivCalendarEvents ? parseInt(infoDivCalendarEvents.offsetHeight) : 0)
                                + 28
                                + 'px'

                            e.currentTarget.parentElement.parentElement.style.height = openedHeight
                        }

                    })

                    let diver = document.createElement('div')
                    diver.className = "divItemTransition"
                    diver.append(button)

                    document.getElementsByClassName('weekly-time')[0].append(diver)
                    document.getElementById('bookingAnonCont')?.classList.remove('dn')

                }
                if (newTeacherAvailabilityDatesTime.availabilities[i].time_slots.length === 1) {

                    eventFire(document.getElementsByClassName('weekly-time')[0].getElementsByTagName('button')[0], 'click')
                }
            }

        }



    } else if (document.body.className === 'booking') {
        //get bookings for clicked date

    }
}

function checkDate(date) {

    for (let i = 0; i < newTeacherAvailabilityDatesTime.availabilities.length; i++) {
        if (date === newTeacherAvailabilityDatesTime.availabilities[i].date) {
            return true
        }
    }
    return false
}

function yearRange(start, end) {
    let years = "";

    for (let year = start; year <= end; year++) {
        years += "<option value='" + year + "'>" + year + "</option>";
    }

    return years;
}

function next() {

    let d = new Date()
    let thisMont = d.getMonth()

    currentYear = currentMonth === 11 ? currentYear + 1 : currentYear;
    currentMonth = (currentMonth + 1) % 12;

    showCalendar(currentMonth, currentYear);

    document.getElementById('sevenDaysCalendarCont').dataset.startDate = new Date(currentYear, currentMonth).toISOString()
    let sevenDaysCalendar = jQuery("#sevenDaysCalendar");

    reInitSevenDaysCalendar(sevenDaysCalendar)

}

function previous() {

    let d = new Date()
    let thisMont = d.getMonth()
    currentYear = currentMonth === 0 ? currentYear - 1 : currentYear;
    currentMonth = currentMonth === 0 ? 11 : currentMonth - 1;

    showCalendar(currentMonth, currentYear);

    document.getElementById('sevenDaysCalendarCont').dataset.startDate = new Date(currentYear, currentMonth).toISOString()
    let sevenDaysCalendar = jQuery("#sevenDaysCalendar");

    reInitSevenDaysCalendar(sevenDaysCalendar)

}

function calendarJump(x, y) {

    currentYear = x
    currentMonth = y

    showCalendar(parseInt(y), parseInt(x))
}

function resetToday() {

    let t = new Date();
    let da = t.getDate();
    currentYear = t.getFullYear();
    currentMonth = t.getMonth();

    document.getElementById('sevenDaysCalendarCont').dataset.startDate = new Date(currentMonth, currentYear).toISOString()

    showCalendar(currentMonth, currentYear)
    document.getElementsByClassName('iDate' + da)[0].parentNode.className = 'date-picker selected'
}

function daysInMonth(month, year) {
    return 32 - new Date(year, month, 32).getDate();
}

function showCalendar(month, year) {

    let firstDay = new Date(year, month).getDay();

    let monthString = monthsArr[month];

    let table = document.getElementById("calendar-body");
    table.innerHTML = "";
    monthHeader.innerHTML = monthString;
    document.getElementsByClassName('date-dd')[0].getElementsByTagName('span')[0].innerHTML = monthString + ' ' + year;
    yearHeader.innerHTML = year;
    selectYear.value = year;
    selectMonth.value = month;
    firstDayHelper = firstDay
    let date = 1;

    for (let i = 0; i < 6; i++) {
        let row = document.createElement("tr");

        for (let j = 1; j < 8; j++) {

            if (firstDay === 0) {
                firstDayHelper = 7
            } else {
                firstDayHelper = firstDay
            }


            if (i === 0 && j < firstDayHelper) {
                let cell = document.createElement("td")
                let cellText = document.createTextNode("")
                cell.appendChild(cellText);
                row.appendChild(cell);
            } else if (date > daysInMonth(month, year)) {

                break
            } else {

                let cell = document.createElement("td");
                cell.setAttribute("data-date", date)
                cell.setAttribute("data-month", month + 1)
                cell.setAttribute("data-year", year)
                cell.setAttribute("data-month-name", months[month])
                cell.dataset.fullDate = year + '-' + addZero(month + 1) + '-' + addZero(date)

                let monthFormatted = addZero(month + 1)
                let dateFormatted = addZero(date);
                let fullDate = year + '-' + monthFormatted + '-' + dateFormatted

                let bookingsCount

                if (typeof bookingArray !== 'undefined') {

                    bookingsCount = bookingArray[fullDate] != undefined ? '+' + bookingArray[fullDate] : '';
                } else {
                    bookingsCount = ''
                }


                let d = new Date()
                let dateToday = d.getFullYear() + '-' + addZero(d.getMonth() + 1) + '-' + addZero(d.getDate())
                let dateText = year + '-' + addZero(month + 1) + '-' + addZero(date)

                let dt2 = new Date(d.getFullYear(), d.getMonth(), d.getDate());
                let dtext2 = new Date(year, month, date);



                if (document.body.className === "book_slot") {

                    if (checkDate(dateText)) {
                        cell.className = "date-picker"
                    } else {
                        cell.className = "date-picker smallerDate"
                    }

                    let d2 = new Date(newTeacherAvailabilityDatesTime.availabilities[0].date)

                    if (getCookie('bookingObjHelp') !== '') {
                        let obj = JSON.parse(getCookie('bookingObjHelp'))
                        let d3 = new Date(obj.bookingDate)
                        if (date === d3.getDate() && year === d3.getFullYear() && month === d3.getMonth()) {
                            cell.className = "date-picker selected";

                        }
                    } else {

                        if (date === d2.getDate() && year === d2.getFullYear() && month === d2.getMonth()) {
                            cell.className = "date-picker selected";

                        }
                    }
                    cell.innerHTML = "<p>" + date + "</p> <p class='innerDate iDate" + date + "'></p>";



                } else {

                    cell.className = "date-picker"

                    if (bookingsCount.length > 0) {
                        cell.classList.add('pea')
                    }
                    cell.innerHTML = "<p class='dateNumber'>" + date + "</p> <p class='innerDate iDate" + date + "'>" + bookingsCount + "</p>";
                    if (addZero(d.getMonth()) == addZero(month) && addZero(d.getDate()) == addZero(date)) {
                        cell.classList.add('today')
                    }
                }

                cell.onclick = function (event) {

                    if (document.getElementById('booking-submit-time')) {
                        document.getElementById('booking-submit-time').classList.add('dn')
                    }
                    if (document.getElementById('exampleSwitch1')) {
                        document.getElementById('exampleSwitch1').checked = false
                    }

                    let clickedDate = this.dataset.fullDate

                    let dates = document.querySelectorAll(".date-picker")
                    let currentTarget = event.currentTarget
                    let date = currentTarget.dataset.date
                    let month = currentTarget.dataset.month - 1
                    let year = currentTarget.dataset.year

                    let monthFormatted = addZero(currentTarget.dataset.month)
                    let dateFormatted = addZero(date)
                    let fullDate = year + '-' + monthFormatted + '-' + dateFormatted

                    if (document.getElementsByClassName('bookingDateToShow')[0]) {
                        document.getElementsByClassName('bookingDateToShow')[0].textContent = getDateWithMonthName(fullDate)
                    }

                    for (let i = 0; i < dates.length; i++) {
                        dates[i].classList.remove("selected")
                    }

                    datePicked.innerHTML = date + " " + monthsArr[month] + " " + year
                    window.dateActivated = currentTarget.dataset.fullDate

                    currentTarget.classList.add("selected")

                    if (document.body.className === "book_slot") {

                        sessionStorage.removeItem("start_call")
                        sessionStorage.removeItem("start_time")
                        sessionStorage.removeItem("end_time")

                        setBookingDateToLocalStoradge(fullDate)
                        getBookingTalkAvailability2(fullDate)

                        window.dateActivated = fullDate

                        document.getElementById('sevenDaysCalendarCont').dataset.startDate = fullDate
                        let sevenDaysCalendar = jQuery("#sevenDaysCalendar");
                        reInitSevenDaysCalendar(sevenDaysCalendar)
                        currentTarget.classList.add("selected");
                        overlapingSlots = {}
                        createOverlapingSlotsObject(JSON.parse(document.getElementById('newTeacherAvailabilityDatesTime').value.trim()), fullDate)
                        if(document.getElementById('calendarFunnelHighlightingState')){
                            if (document.getElementById('calendarFunnelHighlightingState').checked) {
                                calculateUserAvailabilites()
                            }
                        }


                        hideLoading()
                        document.getElementsByClassName('weekly-time')[0].scrollIntoView({
                            behavior: "smooth",
                            block: "start",
                            inline: "nearest"
                        })


                    } else if (document.body.className === "booking") {

                        getBookingByDate(fullDate)

                        window.dateActivated = fullDate

                        document.getElementById('sevenDaysCalendarCont').dataset.startDate = fullDate

                        let sevenDaysCalendar = jQuery("#sevenDaysCalendar");

                        reInitSevenDaysCalendar(sevenDaysCalendar)

                        showLoading()



                    }

                }

                row.appendChild(cell);

                date++;

            }
        }

        table.appendChild(row);
    }
}

function cancelationReasonsAjax() {
    let preCancelAjaxButton = document.getElementsByClassName('preCancelAjaxButton')

    for (let i = 0; i < preCancelAjaxButton.length; i++) {
        preCancelAjaxButton[i].addEventListener('click', function () {
            let bookingId = this.dataset.courseId
            showLoading()
            let openPopupin = this.dataset.popup
            closePopup(this.dataset.closePopup)

            getCancelationReasons(bookingId, openPopupin)

        })

        function getCancelationReasons(bookingId, openPopupin) {
            jQuery.ajax({
                type: 'GET',
                headers: {
                    "Accept": 'application/json',
                    "Application-Language": document.getElementById('mainLanguageCell').dataset.platform.toLocaleLowerCase()
                },
                url: '/frontend/api/calls-cancellation-reasons',
                data: {
                    'booking_id': bookingId,
                },

                success: function (response) {

                    hideLoading()

                    if (response.success) {

                        let cancelationReasons = document.getElementById('cancelAppointment-' + bookingId).getElementsByClassName('cancelationReasons')[0]
                        let items = response.data
                        document.getElementById('cancelAppointment-' + bookingId).getElementsByClassName('cancelationReasons')[0].innerHTML = ''
                        for (let i = 0; i < items.length; i++) {

                            let mainDivCancel = document.createElement('div')
                            mainDivCancel.className = 'radio-option-inner'

                            let mainInputCancel = document.createElement('input')
                            mainInputCancel.type = "radio"
                            mainInputCancel.className = "reason"
                            mainInputCancel.name = "pockets"
                            mainInputCancel.value = items[i].id
                            mainInputCancel.id = "pocketsRed-" + items[i].id

                            let mainLabelCancel = document.createElement('label')
                            mainLabelCancel.htmlFor = "pocketsRed-" + items[i].id
                            mainLabelCancel.textContent = items[i].value

                            mainDivCancel.append(mainInputCancel)
                            mainDivCancel.append(mainLabelCancel)

                            cancelationReasons.append(mainDivCancel)

                        }

                        calculatePopUpHeight(document.getElementById('cancelAppointment-' + bookingId))

                        openPopup(openPopupin)
                        /*   document.getElementById(openPopupin).addEventListener('click', function () {
                              closePopup(openPopupin)
                          })*/
                        document.getElementById(openPopupin).getElementsByClassName('closeSpanPopup')[0].addEventListener('click', function () {
                            closePopup(openPopupin)
                        })
                        toastify(response.message)

                        let cancelBooking = document.getElementsByClassName('cancelBooking')
                        for (let i = 0; i < cancelBooking.length; i++) {
                            cancelBooking[i].addEventListener('click', function (e) {

                                let reasons = document.getElementsByClassName('reason')
                                let checkedReason = 0
                                Array.prototype.forEach.call(reasons, function (element) {
                                    if (element.checked) {
                                        checkedReason = element.value
                                    }
                                });

                                let bookingId = this.getAttribute('data-booking-id');
                                let xhttp = new XMLHttpRequest();
                                let url = '/cancel-booking/?booking_id=' + bookingId + '&reason_id=' + checkedReason;

                                showLoading()
                                xhttp.onreadystatechange = function () {
                                    if (this.readyState == 1) {
                                        document.getElementsByTagName('html')[0].style.cursor = 'progress'
                                    }
                                    if (this.readyState == 4 && this.status == 200) {
                                        document.getElementsByTagName('html')[0].style.cursor = 'default';

                                        let response = JSON.parse(xhttp.responseText)

                                        if (response.success) {
                                            let closeSpanPopus = document.getElementsByClassName('closeSpanPopup')
                                            for (let i = 0; i < closeSpanPopus.length; i++) {
                                                closePopup(closeSpanPopus[i].parentNode.parentNode.id)

                                            }

                                            location.reload()
                                            toastify(response.message)
                                        } else {
                                            toastify(response.message)
                                            hideLoading()
                                        }
                                    }
                                };

                                xhttp.onerror = function (error) {
                                    Sentry.captureException(new CancelBookingError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href));
                                };

                                xhttp.open("GET", url, true);
                                xhttp.send();

                            })
                        }

                    } else {
                        toastify(response.message)
                    }
                },
                error: function (errorMessage) {
                    Sentry.captureException(new CallCancelationReasonsError(errorMessage + ' url: ' + location.href));
                }
            })

        }

    }

}

function showAndCalculateHeight(x, y) {
    if (y === 1) {
        x.style.opacity = '1'
        let counterHeight = document.getElementById('bookingContent').getElementsByClassName('bookings-inner')
        if (counterHeight.length > 0) {
            let h = 0
            for (let i = 0; i < counterHeight.length; i++) {
                if (counterHeight[i].offsetHeight != 0) {
                    h += counterHeight[i].offsetHeight + 32
                }

            }
            x.style.height = h + 'px'
        } else {
            if (window.innerWidth > 767) {
                setTimeout(function () {
                    let height = document.getElementById('bookingContent').getElementsByClassName('show-for-medium2')[0].getElementsByClassName('no-found-heading')[0].offsetHeight
                    let marginH = document.getElementById('bookingContent').getElementsByClassName('show-for-medium2')[0].getElementsByClassName('no-found-heading')[0]


                    var p = marginH
                    var style = p.currentStyle || window.getComputedStyle(p);
                    x.style.height = height + parseInt(style.marginTop.replace(/\D/g, '')) + 'px'
                })

            } else {


                let height = document.getElementById('bookingContent').getElementsByClassName('hide-for-medium2')[0].getElementsByClassName('no-found-heading')[0].offsetHeight
                let marginH = document.getElementById('bookingContent').getElementsByClassName('hide-for-medium2')[0].getElementsByClassName('no-found-heading')[0]


                var p = marginH
                var style = p.currentStyle || window.getComputedStyle(p);

                x.style.height = height + style.marginTop + 'px'
            }

        }

    } else {
        x.style.opacity = '0'
        x.style.height = '0px'
    }

}

function getBookingByDate(date) {
    showLoading()
    var xhttp = new XMLHttpRequest();
    let url = '/get-booking/' + date;

    xhttp.onreadystatechange = function () {
        if (this.readyState == 1) {
            document.getElementsByTagName('html')[0].style.cursor = 'progress'
        }
        if (this.readyState == 4 && this.status == 200) {



            document.getElementsByTagName('html')[0].style.cursor = 'default';
            document.getElementById('bookingContent').innerHTML = xhttp.responseText


            hideLoading()

            if (document.getElementById('bookingContent')) {
                showAndCalculateHeight(document.getElementById('bookingContent'), 1)
            }

            let bookingItems = document.getElementById('bookingContent').getElementsByClassName('cp')
            for (let i = 0; i < bookingItems.length; i++) {
                bookingItems[i].addEventListener('click', function () {

                    if (typeof this.dataset.postponeTime === "undefined") {
                        openPopup(bookingItems[i].dataset.popup)
                        /*  document.getElementById(bookingItems[i].dataset.popup).addEventListener('click', function () {
                             closePopup(bookingItems[i].dataset.popup)
                         })
                         document.getElementById(bookingItems[i].dataset.popup).getElementsByClassName('closeSpanPopup')[0].addEventListener('click', function () {
                             closePopup(bookingItems[i].dataset.popup)
                         }) */
                    }
                })

            }

            let createPostponeCookies = document.getElementsByClassName('createPostponeCookie')
            for (let i = 0; i < createPostponeCookies.length; i++) {
                createPostponeCookies[i].addEventListener('click', function () {
                    setCookie("postponeDateTime", this.dataset.postponeTime, 300, "/booking-summary")
                })

            }

            optionButton()

            cancelationReasonsAjax()

            if (document.body.className === "booking") {
                showMoreThreeDots()

                const queryString = window.location.search
                const urlParams = new URLSearchParams(queryString)

                const selectId = urlParams.get('select')
                if(selectId){
                    if (window.innerWidth > 767) {
                        let bookingItems = document.getElementById('deskBookings').getElementsByClassName('selectBooking')
                        for (let i = 0; i < bookingItems.length; i++) {
                            if (bookingItems[i].dataset.bookingId == selectId) {
                                bookingItems[i].style.border = '1px solid rgba(6,4,3,.6)'
                                bookingItems[i].style.boxShadow = '0px 0px 30px rgba(0, 0, 0, .16)'
                                bookingItems[i].scrollIntoView({ behavior: "smooth", block: "start", inline: "nearest" });


                                setTimeout(function () {
                                    bookingItems[i].style.boxShadow = 'none'
                                    bookingItems[i].style.border = '1px solid rgba(6,4,3,.1)'
                                }, 5000)


                                history.pushState({}, document.title, location.origin + location.pathname)


                            }

                        }
                    } else if (window.innerWidth < 768) {

                        let bookingItems = document.getElementById('mobileBookings')?.getElementsByClassName('selectBooking')
                        if(bookingItems){
                            for (let i = 0; i < bookingItems.length; i++) {
                                if (bookingItems[i].dataset.bookingId == selectId) {
                                    bookingItems[i].style.border = '1px solid rgba(6,4,3,.6)'
                                    bookingItems[i].style.boxShadow = '0px 0px 30px rgba(0, 0, 0, .16)'
                                    bookingItems[i].scrollIntoView({ behavior: "smooth", block: "start", inline: "nearest" });


                                    setTimeout(function () {
                                        bookingItems[i].style.boxShadow = 'none'
                                        bookingItems[i].style.border = '1px solid rgba(6,4,3,.1)'
                                    }, 5000)


                                    history.pushState({}, document.title, location.origin + location.pathname)


                                }

                            }
                        }

                    }
                }

            }



        }
    }

    xhttp.onerror = function (error) {
        Sentry.captureException(new GetBookingError(error + 'status: ' + this.statusText + '|| response: ' + this.statusText + ' || url: ' + location.href))
    }



    xhttp.open("GET", url, true)

    xhttp.setRequestHeader('Time-Zone-Offset-UTC', getCookie('timezone'))

    xhttp.send()

}

function getSevenDays(x, a, b) {
    let mainFrame = document.createElement('div')
    mainFrame.className = 'date-scheduler-wrap'
    let daysArr = localizationJson.weekDays


    for (let i = -1; i < x; i++) {
        let de = new Date(a)
        let realFDR = de.setDate(de.getDate() + i)
        let realFD = a.getDate() + i

        let dayFrame = document.createElement('div')
        dayFrame.style.width = 'calc((100% / ' + x + ') - (24px / 7))'

        let dayStringFrame = document.createElement('span')
        dayStringFrame.textContent = daysArr[i]

        let dayNumberFrame = document.createElement('span')
        let realFDRHelper = new Date(realFDR)
        dayNumberFrame.textContent = realFDRHelper.getDate()
        let d = new Date()
        let dateToday = d.getFullYear() + '-' + addZero(d.getMonth() + 1) + '-' + addZero(d.getDate())
        let dateText = realFDRHelper.getFullYear() + '-' + addZero(realFDRHelper.getMonth() + 1) + '-' + addZero(realFDRHelper.getDate())

        let dt2 = new Date(d.getFullYear(), d.getMonth(), d.getDate());
        let dtext2 = new Date(realFDRHelper.getFullYear(), realFDRHelper.getMonth(), realFDRHelper.getDate());

        if (document.body.className === "book_slot") {

            if (checkDate(dateText)) {
                if (typeof window.dateActivated === "undefined") {
                    if (sevenDayHelper === 0) {

                        dayFrame.className = 'dayframeSDays active'

                        sevenDayHelper = 1

                    } else {
                        dayFrame.className = 'dayframeSDays'
                    }
                } else {

                    if (dateText === window.dateActivated) {
                        dayFrame.className = 'dayframeSDays active'
                    } else {
                        dayFrame.className = 'dayframeSDays'
                    }
                }

            } else {
                dayFrame.className = 'dayframeSDays smallerDate'
            }



        } else {

            if (dateText === window.dateActivated) {
                dayFrame.className = 'dayframeSDays active'
            } else {
                dayFrame.className = 'dayframeSDays'
            }

        }


        dayFrame.dataset.date = realFDRHelper.getFullYear() + '-' + addZero(realFDRHelper.getMonth() + 1) + '-' + addZero(realFDRHelper.getDate())

        var bookingsList = document.getElementById("userBookingsList") ? JSON.parse(document.getElementById("userBookingsList").value) : false;

        var bookingArray = bookingsList.bookings;

        var bookingsCount

        if (typeof bookingArray !== 'undefined') {
            bookingsCount = bookingArray[dayFrame.dataset.date] != undefined ? '+' + bookingArray[dayFrame.dataset.date] : '';
        } else {
            bookingsCount = ''
        }

        let innerDate = document.createElement('span')

        if (bookingsCount.length > 0) {
            innerDate.textContent = bookingsCount
            dayFrame.classList.add('pea')
        }


        innerDate.className = 'innerDate iDate' + realFDRHelper.getDate()

        dayFrame.insertBefore(innerDate, dayFrame.lastChild)

        if (new Date(realFDR).getDate() === b.getDate() && new Date(realFDR).getMonth() === b.getMonth()) {
            dayFrame.classList.add('today')
        }

        if (i === -1) {
            dayFrame.style.display = 'none'
        }

        dayFrame.addEventListener('click', function () {

            let dayframeSDays = document.getElementsByClassName('dayframeSDays')

            let clickedDate = this.dataset.date
            /*  if (document.body.className !== 'booking') {
                 document.getElementsByClassName('bookingDateToShow')[0].textContent = getDateWithMonthName(this.dataset.date)
             } */

            if (document.body.className !== 'book_slot') {
                getBookingByDate(clickedDate)
            }
            for (let i = 0; i < dayframeSDays.length; i++) {
                dayframeSDays[i].classList.remove('active')
            }

            this.classList.add('active')

            /* sessionStorage.removeItem("start_call")
            sessionStorage.removeItem("start_time")
            sessionStorage.removeItem("end_time") */

            if (document.body.className === "book_slot") {

                window.dateActivated = this.dataset.date
                if (document.getElementById('booking-submit-time')) {
                    document.getElementById('booking-submit-time').classList.add('dn')
                }

                setBookingDateToLocalStoradge(this.dataset.date)

                getBookingTalkAvailability2(this.dataset.date)
                selectDateBig(this.dataset.date)
                overlapingSlots = {}
                createOverlapingSlotsObject(JSON.parse(document.getElementById('newTeacherAvailabilityDatesTime').value.trim()), this.dataset.date)
                if (document.getElementById('calendarFunnelHighlightingState')) {
                    if (document.getElementById('calendarFunnelHighlightingState').checked) {
                        calculateUserAvailabilites()
                    }
                }

                hideLoading()
                document.getElementsByClassName('weekly-time')[0].scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                    inline: "nearest"
                })

            } else if (document.body.className === "booking") {

                showLoading()
                window.dateActivated = this.dataset.date
                selectDateBig(this.dataset.date)

            }
        })

        dayFrame.insertBefore(dayStringFrame, dayFrame.lastChild)
        dayFrame.insertBefore(dayNumberFrame, dayFrame.lastChild)


        mainFrame.insertBefore(dayFrame, mainFrame.lastChild)

    }

    return mainFrame
}

window.calculateUserAvailabilites = function () {







    for (let i = 0; i < Object.keys(overlapingSlots).length; i++) {

        let groupFrame = document.createElement('div')
        groupFrame.className = 'redFramebord'

        let infoDiv = document.createElement('div')
        infoDiv.className = 'df aic jcc headerDivToper'
        infoDiv.id = 'headerDivToper'


        let infoP = document.createElement('p')
        infoP.className = 'tac'
        infoP.innerHTML = overlapingSlots[Object.keys(overlapingSlots)[i]].timeslots[0] + ' ─ ' + overlapingSlots[Object.keys(overlapingSlots)[i]].timeslots[overlapingSlots[Object.keys(overlapingSlots)[i]].timeslots.length - 1]


        infoDiv.append(infoP)

        let infoArrow = document.createElement('p')
        infoArrow.className = 'infoArrow'
        infoArrow.innerHTML = '›'
        infoArrow.style.transform = 'rotate(90deg) scale(1, 1)'

        let infoDivCalendarEvents = document.createElement('div')
        infoDivCalendarEvents.className = 'infoDivCalendarEvents'
        infoDivCalendarEvents.innerHTML = overlapingSlots[Object.keys(overlapingSlots)[i]].info.outerHTML

        infoDiv.append(infoArrow)
        groupFrame.append(infoDiv)
        groupFrame.append(infoDivCalendarEvents)

        groupFrame.addEventListener('click', function (e) {
            e.stopPropagation()
            if (groupFrame.dataset.clicked !== "1") {
                groupFrame.dataset.clicked = "1"



                groupFrame.style.height =

                    + parseInt(groupFrame.getElementsByClassName('divItemTransition').length + 1) * 64
                    + parseInt(infoDivCalendarEvents.offsetHeight)
                    + 16
                    + 'px'
                groupFrame.getElementsByClassName('infoArrow')[0].style.transform = 'rotate(90deg) scale(-1, 1)'
            } else if (groupFrame.dataset.clicked === "1") {
                groupFrame.dataset.clicked = "0"
                groupFrame.style.height = '48px'
                groupFrame.getElementsByClassName('infoArrow')[0].style.transform = 'rotate(90deg) scale(1, 1)'
            }

        })



        let buttons = document.getElementsByClassName('divItemTransition')
        let array = overlapingSlots[Object.keys(overlapingSlots)[i]].timeslots

        for (let j = 0; j < buttons.length; j++) {

            for (let k = 0; k < array.length; k++) {
                helper = true
                if (array[k] == buttons[j].textContent) {
                    if (helper) {
                        if (buttons[j].parentElement.classList.contains('weekly-time')) {
                            document.getElementsByClassName('weekly-time')[0].insertBefore(groupFrame, buttons[j])
                        }

                        helper = false
                    }
                    buttons[j].classList.add('usedGroup')
                    groupFrame.append(buttons[j])
                }

            }


        }

    }

    if (document.body.className === 'book_slot') {
        hideLoading()
    }


}

function selectDateBig(date) {
    let calendarBody = document.getElementById('calendar-body')

    if (calendarBody.getElementsByClassName('selected')[0]) {
        calendarBody.getElementsByClassName('selected')[0].classList.remove('selected')
    }

    let datePicker = calendarBody.getElementsByClassName('date-picker')
    for (let i = 0; i < datePicker.length; i++) {

        if (datePicker[i].dataset.fullDate === date) {
            datePicker[i].classList.add('selected')
        }
    }

}

function makeMainFrame(x, y) {
    let curr2 = new Date()
    return getSevenDays(x, y, curr2)
}

function getPreviousMonday(x) {
    let beforeOneWeek = new Date(new Date(x).getTime() - 60 * 60 * 24 * 7 * 1000),
        day = beforeOneWeek.getDay(),
        diffToMonday = beforeOneWeek.getDate() - day + (day === 0 ? -6 : 1),
        lastMonday = new Date(beforeOneWeek.setDate(diffToMonday))

    return lastMonday
}

function getNextMonday(x) {
    let beforeOneWeek = new Date(new Date(x).getTime() + 60 * 60 * 24 * 7 * 1000),
        day = beforeOneWeek.getDay(),
        diffToMonday = beforeOneWeek.getDate() - day + (day === 0 ? -6 : 1),
        nextMonday = new Date(beforeOneWeek.setDate(diffToMonday))

    return nextMonday
}

function renderSevenDaysCalendarHelper(x) {

    let presentMonday = new Date(getPreviousMonday(x))

    let presentDate = new Date(presentMonday.setDate(presentMonday.getDate() + 7))
    let pastDate = new Date(getPreviousMonday(x))
    let futureDate = new Date(getNextMonday(x))

    let curr1A = presentDate
    let curr1B = pastDate
    let curr1C = futureDate

    let pastFrame = makeMainFrame(7, curr1B)
    let mainFrame = makeMainFrame(7, curr1A)
    let futureFrame = makeMainFrame(7, curr1C)

    return [pastFrame, mainFrame, futureFrame]

}

function renderSevenDaysCalendar(x) {
    let curr

    if (document.getElementById('sevenDaysCalendarCont').dataset.startDate !== '') {
        curr = new Date(document.getElementById('sevenDaysCalendarCont').dataset.startDate)
    } else {
        curr = new Date(x)
        document.getElementById('sevenDaysCalendarCont').dataset.startDate = curr.toISOString()
    }

    let calendars = renderSevenDaysCalendarHelper(curr)
    document.getElementById('sevenDaysCalendar').insertBefore(calendars[2], document.getElementById('sevenDaysCalendar').lastChild)
    document.getElementById('sevenDaysCalendar').insertBefore(calendars[1], document.getElementById('sevenDaysCalendar').firstChild)
    document.getElementById('sevenDaysCalendar').insertBefore(calendars[0], document.getElementById('sevenDaysCalendar').firstChild)

}

function reInitSevenDaysCalendar(x) {

    let dd = new Date(document.getElementById('sevenDaysCalendarCont').dataset.startDate.split(" ")[0])

    document.getElementById('sevenDaysCalendar').innerHTML = ''
    x.owlCarousel('destroy')

    renderSevenDaysCalendar(dd.toISOString())
    x.owlCarousel({

        // autoplay: true,

        margin: 4,
        startPosition: 1,
        loop: false,
        nav: false,
        dots: false,
        items: 1
    });


}

function setBookingStateToDefault(obj) {

    let d = new Date()
    let todayDate = d.getFullYear() + '-' + addZero(d.getMonth() + 1) + '-' + addZero(d.getDate())

    if (document.body.className === "book_slot") {

        if (document.getElementById('exampleSwitch1')) {
            document.getElementById('exampleSwitch1').checked = false
        }
        /*  document.getElementsByClassName('bookingDateToShow')[0].textContent = getDateWithMonthName(Object.keys(obj)[0]) */
        document.getElementById('sevenDaysCalendarCont').dataset.startDate = newTeacherAvailabilityDatesTime.availabilities[0].date
        let sevenDaysCalendar = jQuery("#sevenDaysCalendar")
        reInitSevenDaysCalendar(sevenDaysCalendar)

        if (obj) {

            setBookingDateToLocalStoradge(newTeacherAvailabilityDatesTime.availabilities[0].date)
        }

    } else {

        window.dateActivated = obj
        document.getElementById('sevenDaysCalendarCont').dataset.startDate = obj
        let sevenDaysCalendar = jQuery("#sevenDaysCalendar");
        reInitSevenDaysCalendar(sevenDaysCalendar)
    }



}

function setBookingDateToLocalStoradge(date) {

    let d = new Date()
    let todayDate = d.getFullYear() + '-' + addZero(d.getMonth() + 1) + '-' + addZero(d.getDate())

    let obj = {}



    obj.bookingDate = date
    obj.bookingTime = [addZero(d.getHours()) + ':' + addZero(d.getSeconds()), addZero(d.getHours() + 1) + ':' + addZero(d.getSeconds())]

    let url = window.location.pathname.split('/')

    if (url[1] === "booking-summary") {
        obj.id = url[2]
    }

    if (document.getElementById('postponePointeringZ').textContent.trim().length > 5) {

    } else {


        setCookie("bookingObj", JSON.stringify(obj), 900, "/booking-payment")
        setCookie("bookingObj", JSON.stringify(obj), 900, "/booking-postpone")
        setCookie("bookingObjHelp", JSON.stringify(obj), 900, "/booking-summary")
    }

}

function prepareBookingObj(anonymousMeeting, bookingPrice) {

    let obj = {}


    obj.anonymousMeeting = anonymousMeeting
    obj.bookingPrice = bookingPrice

    obj.bookingDate = document.getElementById('sevenDaysCalendar').getElementsByClassName('active')[0].getElementsByClassName('active')[0]?.dataset.date

    if (document.getElementById('bookingIdForPostpone')) {
        if (document.getElementById('bookingIdForPostpone').value.trim().length > 0) {
            obj.bookingId = document.getElementById('bookingIdForPostpone').value.trim()
        }
    }

    let url = window.location.pathname.split('/')

    if (url[1] === "booking-summary") {
        obj.id = url[2]
    }
    if (document.getElementsByClassName('activeButtoner')[0]) {
        obj.bookingTime = [document.getElementsByClassName('activeButtoner')[0].parentElement.getElementsByTagName('button')[0].dataset.time, document.getElementsByClassName('activeButtoner')[0].parentElement.getElementsByTagName('button')[0].dataset.endTime]

    }

    setCookie("bookingObj", JSON.stringify(obj), 900, "/booking-payment")
    setCookie("bookingObj", JSON.stringify(obj), 900, "/booking-postpone")
    setCookie("bookingObjHelp", JSON.stringify(obj), 900, "/booking-summary")

}

function gotToBookings(button) {

    showLoading()

    if (button.dataset.popup === "addBookingLoginPopup") {

        prepareBookingObj(
            document.getElementById('anonSwitch') ? document.getElementById('anonSwitch').checked : false,
            parseFloat(document.getElementById('moneyContar').value)
        )

    } else {

        prepareBookingObj(
            document.getElementById('anonSwitch') ? document.getElementById('anonSwitch').checked : false,
            parseFloat(document.getElementById('moneyContar').value)
        )

        if (button.dataset.popup === "addBookingPostpone") {

            location.assign('/booking-postpone');
        } else {

            location.assign('/booking-payment');
        }
    }
}

(function () {

    let sevenDaysCalendar = jQuery("#sevenDaysCalendar");

    sevenDaysCalendar.owlCarousel({
        margin: 38,
        startPosition: 1,
        loop: false,
        nav: false,
        dots: false,
        items: 1
    });

    sevenDaysCalendar.on('changed.owl.carousel', function (event) {

        setTimeout(function () {
            if (event.relatedTarget['_drag']['direction'] === 'left') {
                reInitSevenDaysCalendar(sevenDaysCalendar)
            } else if (event.relatedTarget['_drag']['direction'] === 'right') {
                reInitSevenDaysCalendar(sevenDaysCalendar)
            }
        }, 300)

    })

    sevenDaysCalendar.on('change.owl.carousel', function (event) {

        setTimeout(function () {

            if (event.relatedTarget['_drag']['direction'] === 'left') {

                window.rightDrager = 0

                let dd = new Date(document.getElementById('sevenDaysCalendarCont').dataset.startDate)

                let newDd = dd.setDate(dd.getDate() + 7)

                document.getElementById('sevenDaysCalendarCont').dataset.startDate = dd.toISOString()

                let newDates = renderSevenDaysCalendarHelper(new Date(dd.toISOString()))

                calendarJump(dd.getFullYear(), dd.getMonth())

            } else if (event.relatedTarget['_drag']['direction'] === 'right') {

                window.rightDrager = 0
                let dd = new Date(document.getElementById('sevenDaysCalendarCont').dataset.startDate)


                let newDd = dd.setDate(dd.getDate() - 7)


                document.getElementById('sevenDaysCalendarCont').dataset.startDate = dd.toISOString()

                let newDates = renderSevenDaysCalendarHelper(new Date(dd.toISOString()))

                calendarJump(dd.getFullYear(), dd.getMonth())


            }
        }, 1)


    })

    setTimeout(function () {
        document.getElementById('sevenDaysCalendar').style.opacity = '1'
    }, 10)

    //dodaje se event na dugme za nastavljanej funnel procesa
    if (document.getElementById('booking-payment')) {
        let bkpm = document.getElementsByClassName('bkpm')

        for (let i = 0; i < bkpm.length; i++) {
            bkpm[i].addEventListener('click', function (e) {

                e.stopPropagation()

                if (this.parentElement.parentElement.className === 'redFramebord') {

                    openPopup('calendarSlotsOverlap')

                    if (document.getElementById('goToBookingsAnyway')) {
                        document.getElementById('goToBookingsAnyway').addEventListener('click', function () {
                            gotToBookings(bkpm[i])
                        })
                    }

                    if (document.getElementById('closePoperus')) {
                        document.getElementById('closePoperus').addEventListener('click', function () {

                            closePopup('calendarSlotsOverlap')
                        })
                    }

                } else {

                    gotToBookings(this)
                }
            })

        }

    }

    if (document.body.className === "book_slot") {
        //glavni objekat se ovde pravi
        let obj = JSON.parse(document.getElementById('newTeacherAvailabilityDatesTime').value)
        //document.getElementsByClassName('bookingDateToShow')[0].textContent = getDateWithMonthName(Object.keys(obj)[0])
        //document.getElementsByClassName('dateHolderBookingToShow')[0].style.visibility = 'visible'





        window.dateActivated = newTeacherAvailabilityDatesTime.availabilities[0].date
        setBookingStateToDefault(obj)
        overlapingSlots = {}
        createOverlapingSlotsObject(JSON.parse(document.getElementById('newTeacherAvailabilityDatesTime').value.trim()), JSON.parse(document.getElementById('newTeacherAvailabilityDatesTime').value.trim()).availabilities[0].date)
        if (document.getElementById('calendarFunnelHighlightingState')) {
            if (document.getElementById('calendarFunnelHighlightingState').checked) {
                calculateUserAvailabilites()
            }
        }

        hideLoading()
        eventFire(document.getElementById('sevenDaysCalendar').getElementsByClassName('active')[0].getElementsByClassName('active')[0], 'click')


    } else {

        let obj2 = JSON.parse(document.getElementById('userBookingsList').value.trim())

        if (obj2 && obj2.first_upcoming_booking && Object.keys(obj2.first_upcoming_booking).length > 0) {
            let firstUpcomingDate = Object.keys(obj2.first_upcoming_booking)[0]
            setBookingStateToDefault(firstUpcomingDate)
            showAndCalculateHeight(document.getElementById('bookingContent'), 0)
            showLoading()

            eventFire(document.getElementById('sevenDaysCalendar').getElementsByClassName('active')[0].getElementsByClassName('active')[0], 'click')
        } else {
            hideLoading()
        }


    }

})()


