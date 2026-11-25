function addOrderByFilterEvents() {

    window.orderByFilter = [false, false]
    if (document.getElementById('ratingSort')) {
        window.lastClickedRating = 1
        document.getElementById('ratingSort').addEventListener('click', function () {

            if (window.lastClickedRating === 1) {
                orderByRateDESC(false, document.getElementsByClassName('orderByRateDESC')[0])
            } else if (window.lastClickedRating === 0) {
                orderByRateASC(false, document.getElementsByClassName('orderByRateASC')[0])
            }

        })
    }
    if (document.getElementsByClassName('orderByRateASC')[0]) {
        document.getElementsByClassName('orderByRateASC')[0].addEventListener('click', orderByRateASC)
    }

    function orderByRateASC(e, element) {
        window.lastClickedRating = 1
        resetColorOfSvgs()

        let clicker
        element ? clicker = element : clicker = e.currentTarget

        clicker.getElementsByTagName('path')[0].style.fill = '#ffb805'
        clicker.style.filter = 'drop-shadow(0px 0px 0px #5D6B82)'
        clicker.style.pointerEvents = 'none'
        document.getElementsByClassName('orderByRateDESC')[0].style.pointerEvents = 'all'

        window.filterObj.order_by = 'rating'
        window.filterObj.order_by_type = 'ASC'

        window.offset = 0
        window.sortingTalksFilter = 1
        showLoading()
        //document.getElementById('categorySubcategoryTalksTable').style.opacity = '0'
        document.getElementsByClassName('talksShowMore')[0].style.opacity = '0'
        setTimeout(function () {


            getTalksToShow(0)
        }, 310)
    }
    if (document.getElementsByClassName('orderByRateDESC')[0]) {
        document.getElementsByClassName('orderByRateDESC')[0].addEventListener('click', orderByRateDESC)
    }

    function orderByRateDESC(e, element) {

        let clicker
        element ? clicker = element : clicker = e.currentTarget

        window.lastClickedRating = 0
        resetColorOfSvgs()

        clicker.getElementsByTagName('path')[0].style.fill = '#ffb805'
        clicker.style.filter = 'drop-shadow(0px 0px 0px #5D6B82)'
        clicker.style.pointerEvents = 'none'
        document.getElementsByClassName('orderByRateASC')[0].style.pointerEvents = 'all'

        window.filterObj.order_by = 'rating'
        window.filterObj.order_by_type = 'DESC'

        window.offset = 0
        window.sortingTalksFilter = 1
        showLoading()
        //document.getElementById('categorySubcategoryTalksTable').style.opacity = '0'
        document.getElementsByClassName('talksShowMore')[0].style.opacity = '0'
        setTimeout(function () {


            getTalksToShow(0)
        }, 310)
    }

    if (document.getElementById('durationSort')) {
        window.lastClickedDuration = 1
        document.getElementById('durationSort').addEventListener('click', function () {

            if (window.lastClickedDuration === 1) {
                orderByDurationDESC(false, document.getElementsByClassName('orderByDurationDESC')[0])
            } else if (window.lastClickedDuration === 0) {
                orderByDurationASC(false, document.getElementsByClassName('orderByDurationASC')[0])
            }

        })
    }

    if (document.getElementsByClassName('orderByDurationASC')[0]) {
        document.getElementsByClassName('orderByDurationASC')[0].addEventListener('click', orderByDurationASC)
    }

    function orderByDurationASC(e, element) {
        let clicker
        element ? clicker = element : clicker = e.currentTarget

        window.lastClickedDuration = 1
        resetColorOfSvgs()

        clicker.getElementsByTagName('path')[0].style.fill = '#ffb805'
        clicker.style.filter = 'drop-shadow(0px 0px 0px #5D6B82)'
        clicker.style.pointerEvents = 'none'
        document.getElementsByClassName('orderByDurationASC')[0].style.pointerEvents = 'all'

        window.filterObj.order_by = 'duration'
        window.filterObj.order_by_type = 'ASC'

        window.offset = 0
        window.sortingTalksFilter = 1
        showLoading()
        //document.getElementById('categorySubcategoryTalksTable').style.opacity = '0'
        document.getElementsByClassName('talksShowMore')[0].style.opacity = '0'
        setTimeout(function () {

            getTalksToShow(0)
        }, 310)
    }

    if (document.getElementsByClassName('orderByDurationDESC')[0]) {
        document.getElementsByClassName('orderByDurationDESC')[0].addEventListener('click', orderByDurationDESC)
    }

    function orderByDurationDESC(e, element) {
        let clicker
        element ? clicker = element : clicker = e.currentTarget

        window.lastClickedDuration = 0
        resetColorOfSvgs()

        clicker.getElementsByTagName('path')[0].style.fill = '#ffb805'
        clicker.style.filter = 'drop-shadow(0px 0px 0px #5D6B82)'
        clicker.style.pointerEvents = 'none'
        document.getElementsByClassName('orderByDurationDESC')[0].style.pointerEvents = 'all'

        window.filterObj.order_by = 'duration'
        window.filterObj.order_by_type = 'DESC'

        window.offset = 0
        window.sortingTalksFilter = 1
        showLoading()
        //document.getElementById('categorySubcategoryTalksTable').style.opacity = '0'
        document.getElementsByClassName('talksShowMore')[0].style.opacity = '0'

        setTimeout(function () {

            getTalksToShow(0)

        }, 310)


    }

    if (document.getElementById('priceSort')) {
        window.lastClickedPrice = 1
        document.getElementById('priceSort').addEventListener('click', function () {

            if (window.lastClickedPrice === 1) {
                orderByPriceDESC(false, document.getElementsByClassName('orderByPriceDESC')[0])
            } else if (window.lastClickedPrice === 0) {
                orderByPriceASC(false, document.getElementsByClassName('orderByPriceASC')[0])
            }

        })
    }

    if (document.getElementsByClassName('orderByPriceASC')[0]) {
        document.getElementsByClassName('orderByPriceASC')[0].addEventListener('click', orderByPriceASC)
    }

    function orderByPriceASC(e, element) {
        let clicker
        element ? clicker = element : clicker = e.currentTarget

        window.lastClickedPrice = 1
        resetColorOfSvgs()

        clicker.getElementsByTagName('path')[0].style.fill = '#ffb805'
        clicker.style.filter = 'drop-shadow(0px 0px 0px #5D6B82)'
        clicker.style.pointerEvents = 'none'
        document.getElementsByClassName('orderByPriceDESC')[0].style.pointerEvents = 'all'

        window.filterObj.order_by = 'price'
        window.filterObj.order_by_type = 'ASC'

        window.offset = 0
        window.sortingTalksFilter = 1
        showLoading()

        document.getElementsByClassName('talksShowMore')[0].style.opacity = '0'
        setTimeout(function () {

            getTalksToShow(0)
        }, 310)
    }

    if (document.getElementsByClassName('orderByPriceDESC')[0]) {
        document.getElementsByClassName('orderByPriceDESC')[0].addEventListener('click', orderByPriceDESC)
    }

    function orderByPriceDESC(e, element) {
        let clicker
        element ? clicker = element : clicker = e.currentTarget

        window.lastClickedPrice = 0
        resetColorOfSvgs()

        clicker.getElementsByTagName('path')[0].style.fill = '#ffb805'
        clicker.style.filter = 'drop-shadow(0px 0px 0px #5D6B82)'
        clicker.style.pointerEvents = 'none'
        document.getElementsByClassName('orderByPriceASC')[0].style.pointerEvents = 'all'

        window.filterObj.order_by = 'price'
        window.filterObj.order_by_type = 'DESC'

        window.offset = 0
        window.sortingTalksFilter = 1
        showLoading()

        document.getElementsByClassName('talksShowMore')[0].style.opacity = '0'
        setTimeout(function () {


            getTalksToShow(0)
        }, 310)
    }
}

function resetColorOfSvgs() {
    let array = [
        document.getElementsByClassName('orderByRateASC')[0],
        document.getElementsByClassName('orderByRateDESC')[0],
        document.getElementsByClassName('orderByDurationASC')[0],
        document.getElementsByClassName('orderByDurationDESC')[0],
        document.getElementsByClassName('orderByPriceASC')[0],
        document.getElementsByClassName('orderByPriceDESC')[0]
    ]

    for (let i = 0; i < array.length; i++) {
        array[i].getElementsByTagName('path')[0].style.fill = '#5D6B82'
        array[i].style.filter = 'drop-shadow(0px 0px 0px transparent)'
    }

}

function getTalksToShow(offset, smallFilterPointer) {

    if(smallFilterPointer){

        let selectMultiple = document.getElementsByClassName('selectMultiple')
        for (let i = 0; i < selectMultiple.length; i++) {
            selectMultiple[i].style.height = '0px'
            selectMultiple[i].parentElement.dataset.clicked = "0"

        }

    }


    submitFiltersSearch(
        window.filterObj,
        false,
        true,
        offset
    )

}

function showMoreSearchTalks() {

    let talksShowMores = document.getElementsByClassName('talksShowMore')

    for (let i = 0; i < talksShowMores.length; i++) {
        talksShowMores[i].addEventListener('click', function () {
            let  offset = parseInt(document.getElementById('categorySubcategoryTalksTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length)
            submitFiltersSearch(

                window.filterObj,
                false,
                false,
                offset
            )
        })

    }

    let submitFilterZ = document.getElementsByClassName('submitFilterZ')

    for (let i = 0; i < submitFilterZ.length; i++) {
        submitFilterZ[i].addEventListener('click', function () {

            if (JSON.stringify(window.filterObjClone) != JSON.stringify(window.filterObj)) {

                let pointer
                if (document.body.className === "favorites_talks") {
                    pointer = true
                } else {
                    pointer = false
                }

                submitFiltersSearch(

                    window.filterObj,
                    pointer,
                    true,
                    0
                )

                window.filterObjClone = JSON.parse(JSON.stringify(window.filterObj))

                if(submitFilterZ[i].id === 'newFilterSubmit'){
                    window.newFilterSubmit = 1
                }

            } else {
                toastify('No filter change')
            }
        })

    }

}

function submitFiltersSearch(filter, pointer, pointerForAppending, offset) {

    let realAva = {
        "monday": filter.availability['monday'] ?? false,
        "tuesday": filter.availability['tuesday'] ?? false,
        "wednesday": filter.availability['wednesday'] ?? false,
        "thursday": filter.availability['thursday'] ?? false,
        "friday": filter.availability['friday'] ?? false,
        "saturday": filter.availability['saturday'] ?? false,
        "sunday": filter.availability['sunday'] ?? false

    }
    let realPriceRange = {
        "1_10": filter.priceRange['1_10'] ?? false,
        "10_50": filter.priceRange['10_50'] ?? false,
        "over50": filter.priceRange['over50'] ?? false,
        "over100": filter.priceRange['over100'] ?? false,
    }

    filter.availability = realAva
    filter.priceRange = realPriceRange

    showLoading()

    let url
    if (pointer) {
        url = location.href + '?pointer=true'
    } else {
        url = location.href
    }

    if (document.body.className === 'talkCategorySubcategory') {
        if (offset || offset === 0) {


        } else {
            offset = document.getElementById('categorySubcategoryTalksTable').getElementsByTagName('tbody')[0].getElementsByTagName('tr').length

        }

    }

    jQuery.ajax({
        type: 'GET',
        url: url,
        data: {
            'offset': offset,
            'filter': JSON.stringify(filter)
        },
        beforeSend: function () {
            // Handle the beforeSend event

        },
        complete: function () {
            hideLoading()



        },
        success: function (response) {

            if (response.success) {


                document.getElementById('serachFilterButton').classList.add('dn')

                if (response.html.length > 0) {

                    document.getElementById('categorySubcategoryTalksTable').classList.remove('dn')
                    if (document.getElementById('mobileSearchContainer')) {
                        document.getElementById('mobileSearchContainer').classList.remove('dn')
                    }

                    if(document.getElementsByClassName('no-found-heading')[0]){
                       let noFoundHeadings = document.getElementsByClassName('no-found-heading')
                       for (let i = 0; i < noFoundHeadings.length; i++) {
                        noFoundHeadings[i].classList.add('dn')

                       }
                    }



                    if (document.getElementById('noSearchMobile')) {
                        document.getElementById('noSearchMobile').classList.add('dn')
                    }

                    document.getElementById('talks_countField').textContent = response.talks_count

                    if (pointerForAppending) {
                        if (document.getElementById('mobileSearchContainer')) {
                            document.getElementById('mobileSearchContainer').innerHTML = response.htmlMobile
                        }

                        document.getElementById('categorySubcategoryTalksTable').getElementsByTagName('tbody')[0].innerHTML = response.html

                    } else {
                        if (document.getElementById('mobileSearchContainer')) {
                            document.getElementById('mobileSearchContainer').innerHTML += response.htmlMobile
                        }

                        document.getElementById('categorySubcategoryTalksTable').getElementsByTagName('tbody')[0].innerHTML += response.html
                    }



                    document.getElementById('categorySubcategoryTalksTable').style.opacity = '1'
                    document.getElementsByClassName('talksShowMore')[0].style.opacity = '1'

                    favoriteUnFavoriteTalk()

                    if (offset + parseInt(document.getElementById('show_more_talks').value) >= response.talks_count) {
                        let talksShowMore = document.getElementsByClassName('talksShowMore')
                        for (let i = 0; i < talksShowMore.length; i++) {
                            talksShowMore[i].classList.add('dn')

                        }
                    } else if (offset + parseInt(document.getElementById('show_more_talks').value) < response.talks_count) {
                        let talksShowMore = document.getElementsByClassName('talksShowMore')
                        for (let i = 0; i < talksShowMore.length; i++) {
                            talksShowMore[i].classList.remove('dn')

                        }

                    }



                    if (window.innerWidth < 1024) {
                        closeFilter()
                    }

                    if(window.newFilterSubmit === 1){
                        document.getElementsByClassName('filterOpener')[0].click()
                        window.newFilterSubmit = 0
                    }
                } else {

                    if (pointer) {

                        toastify(response.message)
                    } else {

                        document.getElementById('categorySubcategoryTalksTable').classList.add('dn')
                        document.getElementById('mobileSearchContainer')?.classList.add('dn')
                        document.getElementById('talks_countField').textContent = 0
                        if (document.getElementsByClassName('talksShowMore')[0]) {
                            document.getElementsByClassName('talksShowMore')[0].style.display = 'none'
                        }

                        if (window.innerWidth < 1024) {
                            closeFilter()


                            setTimeout(function () {
                                toastify(response.message)
                            }, 310)

                        } else {
                            /* toastify(response.message) */
                            toastify(response.message)
                        }
                        if (document.getElementsByClassName('no-found-heading')[0]) {
                            let noFoundHeadings = document.getElementsByClassName('no-found-heading')
                            for (let i = 0; i < noFoundHeadings.length; i++) {
                                noFoundHeadings[i].classList.remove('dn')

                            }
                        }


                        document.getElementById('noSearchMobile')?.classList.remove('dn')


                    }

                }


                if (document.getElementById('submitFilter')) {
                    document.getElementById('submitFilter').disabled = true
                }




            } else {
                toastify(response.message)
            }
        },
        error: function (errorMessage) {
            Sentry.captureException(new GetTalksError1(errorMessage + ' || URL: ' + location.href));
        }
    });
}

function favoriteUnFavoriteTalk() {
    if (document.getElementsByClassName('favoriteHeart2')[0]) {

        let favoriteHeart2 = document.getElementsByClassName('favoriteHeart2')

        for (let i = 0; i < favoriteHeart2.length; i++) {


            favoriteHeart2[i].addEventListener('click', function (e) {

                if (e.currentTarget.dataset.fallowing === '0') {
                    submitFavoriteUnFavoriteTalk(e.currentTarget)

                } else if (e.currentTarget.dataset.fallowing === '1') {

                    submitFavoriteUnFavoriteTalk(e.currentTarget)

                }



            })

        }

        function submitFavoriteUnFavoriteTalk(element) {

            let that = element
            let target = element


            let userId = element.dataset.talkId

            if (element.dataset.fallowing === '0') {

                fallowTalk(userId, element)
                element.dataset.fallowing = '1'

            } else if (element.dataset.fallowing === '1') {

                unfallowTalk(userId, element)
                that.dataset.fallowing = '0'

            }

            function fallowTalk(id) {

                jQuery.ajax({
                    type: 'POST',
                    url: '/frontend/api/user-bookmarked-talks',
                    data: {
                        'talks_id': id,
                        '_token': token
                    },
                    beforeSend: function () {
                        // Handle the beforeSend event

                        showLoading()
                    },
                    complete: function () {

                    },
                    success: function (response) {

                        if (response.success) {

                            target.getElementsByTagName('svg')[0].style.transform = 'scale(0)'
                            target.dataset.fallowing = '1'
                            setTimeout(function () {
                                target.innerHTML = '<svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M7 1.5L10.5 4L11.5 3.5L12.5 2.5L14 1.5H17.5C18.3 1.5 19.1667 2.83333 19.5 3.5C19.8333 4.66667 20.5 7.1 20.5 7.5C20.5 7.9 18.1667 10.6667 17 12C15 13.8333 10.9 17.6 10.5 18C10.1 18.4 6 13.8333 4 11.5L1.5 9L1 6.5L2 3.5L4.5 1.5H7Z" fill="#DF1818" stroke="black"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#DF1818"></path></svg>'

                                setTimeout(function () {
                                    target.getElementsByTagName('svg')[0].style.transform = 'scale(1)'
                                }, 210)

                            }, 330)

                            if (document.body.className === "favorites_talks" || document.body.className === 'talkCategorySubcategory') {

                                if (target.classList.contains('mobile')) {
                                    let favoriteHeart2 = document.getElementById('categorySubcategoryTalksTable').getElementsByTagName('tbody')[0].getElementsByClassName('favoriteHeart2')
                                    for (let i = 0; i < favoriteHeart2.length; i++) {
                                        if (favoriteHeart2[i].dataset.talkId === target.dataset.talkId) {
                                            let target2 = favoriteHeart2[i]
                                            target2.getElementsByTagName('svg')[0].style.transform = 'scale(0)'
                                            target2.dataset.fallowing = '1'
                                            setTimeout(function () {
                                                target2.innerHTML = '<svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M7 1.5L10.5 4L11.5 3.5L12.5 2.5L14 1.5H17.5C18.3 1.5 19.1667 2.83333 19.5 3.5C19.8333 4.66667 20.5 7.1 20.5 7.5C20.5 7.9 18.1667 10.6667 17 12C15 13.8333 10.9 17.6 10.5 18C10.1 18.4 6 13.8333 4 11.5L1.5 9L1 6.5L2 3.5L4.5 1.5H7Z" fill="#DF1818" stroke="black"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#DF1818"></path></svg>'

                                                setTimeout(function () {
                                                    target2.getElementsByTagName('svg')[0].style.transform = 'scale(1)'
                                                }, 210)

                                            }, 330)
                                        }
                                    }
                                } else {
                                    let favoriteHeart2 = document.getElementById('mobileSearchContainer').getElementsByClassName('favoriteHeart2')
                                    for (let i = 0; i < favoriteHeart2.length; i++) {
                                        if (favoriteHeart2[i].dataset.talkId === target.dataset.talkId) {
                                            let target2 = favoriteHeart2[i]
                                            target2.getElementsByTagName('svg')[0].style.transform = 'scale(0)'
                                            target2.dataset.fallowing = '1'
                                            setTimeout(function () {
                                                target2.innerHTML = '<svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M7 1.5L10.5 4L11.5 3.5L12.5 2.5L14 1.5H17.5C18.3 1.5 19.1667 2.83333 19.5 3.5C19.8333 4.66667 20.5 7.1 20.5 7.5C20.5 7.9 18.1667 10.6667 17 12C15 13.8333 10.9 17.6 10.5 18C10.1 18.4 6 13.8333 4 11.5L1.5 9L1 6.5L2 3.5L4.5 1.5H7Z" fill="#DF1818" stroke="black"></path> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#DF1818"></path></svg>'

                                                setTimeout(function () {
                                                    target2.getElementsByTagName('svg')[0].style.transform = 'scale(1)'
                                                }, 210)

                                            }, 330)
                                        }
                                    }
                                }
                            }
                        } else {
                            toastify(response.message)
                        }

                        hideLoading()
                    },
                    error: function (errorMessage) {
                        Sentry.captureException(new FallowTalkError(errorMessage + ' url: ' + location.href));
                    }
                });
            }

            function unfallowTalk(id) {

                jQuery.ajax({
                    type: 'POST',
                    url: '/frontend/api/unfollow-single-talk',
                    data: {
                        'talks_id': id,
                        '_token': token
                    },
                    beforeSend: function () {
                        showLoading()
                    },
                    complete: function () {

                    },
                    success: function (response) {

                        if (response.success) {

                            target.getElementsByTagName('svg')[0].style.transform = 'scale(0)'
                            target.dataset.fallowing = '0'

                            setTimeout(function () {

                                target.innerHTML = '<svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#172B4D"></path> </svg>'

                                setTimeout(function () {
                                    target.getElementsByTagName('svg')[0].style.transform = 'scale(1)'
                                }, 210)

                            }, 330)

                            if (document.body.className === 'talkCategorySubcategory' || document.body.className === "favorites_talks") {

                                if (target.classList.contains('mobile')) {

                                    let favoriteHeart2 = document.getElementById('categorySubcategoryTalksTable').getElementsByTagName('tbody')[0].getElementsByClassName('favoriteHeart2')
                                    for (let i = 0; i < favoriteHeart2.length; i++) {
                                        if (favoriteHeart2[i].dataset.talkId === target.dataset.talkId) {

                                            let target2 = favoriteHeart2[i]
                                            target2.getElementsByTagName('svg')[0].style.transform = 'scale(0)'
                                            target2.dataset.fallowing = '0'
                                            setTimeout(function () {
                                                target2.innerHTML = '<svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#172B4D"></path> </svg>'

                                                setTimeout(function () {
                                                    target2.getElementsByTagName('svg')[0].style.transform = 'scale(1)'
                                                }, 210)

                                            }, 330)
                                        }
                                    }

                                } else {

                                    let favoriteHeart2 = document.getElementById('mobileSearchContainer').getElementsByClassName('favoriteHeart2')
                                    for (let i = 0; i < favoriteHeart2.length; i++) {
                                        if (favoriteHeart2[i].dataset.talkId === target.dataset.talkId) {
                                            let target2 = favoriteHeart2[i]
                                            target2.getElementsByTagName('svg')[0].style.transform = 'scale(0)'
                                            target2.dataset.fallowing = '0'
                                            setTimeout(function () {
                                                target2.innerHTML = '<svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg"> <path fill-rule="evenodd" clip-rule="evenodd" d="M6.44583 2.17107C4.06979 2.17107 2.16667 4.07378 2.16667 6.39259C2.16667 7.522 2.61498 8.54793 3.35127 9.30824L10.8332 16.9082L18.1906 9.43199L18.2021 9.42092C19.0056 8.65095 19.5 7.57855 19.5 6.39259C19.5 4.07378 17.5969 2.17107 15.2208 2.17107C14.8518 2.17107 14.4317 2.31793 13.9572 2.64139C13.484 2.96407 13.0199 3.41997 12.5862 3.92814C11.67 5.00131 9.99667 5.00131 9.0805 3.92814C8.64672 3.41997 8.18269 2.96407 7.70939 2.64139C7.23499 2.31793 6.81484 2.17107 6.44583 2.17107ZM0 6.39259C0 2.84939 2.89862 0 6.44583 0C7.39449 0 8.23651 0.374791 8.92829 0.846413C9.62108 1.3188 10.2272 1.93141 10.7271 2.5169C10.749 2.54276 10.784 2.56195 10.8333 2.56195C10.8826 2.56195 10.9176 2.54276 10.9396 2.5169C11.4395 1.93141 12.0456 1.3188 12.7384 0.846413C13.4302 0.374791 14.2722 0 15.2208 0C18.768 0 21.6667 2.84939 21.6667 6.39259C21.6667 8.19351 20.9145 9.81964 19.7116 10.9784L10.8334 20L1.80025 10.8243C0.687819 9.67754 0 8.11459 0 6.39259Z" fill="#172B4D"></path> </svg>'

                                                setTimeout(function () {
                                                    target2.getElementsByTagName('svg')[0].style.transform = 'scale(1)'
                                                }, 210)

                                            }, 330)
                                        }
                                    }
                                }
                            }

                        } else {
                            toastify(response.message)
                        }

                        hideLoading()
                    },
                    error: function (errorMessage) {
                        Sentry.captureException(new UnfallowTalkError(errorMessage + ' url: ' + location.href));
                    }
                });
            }

        }
    }
}

function enableDisableLanguage() {
    if (document.getElementById('languageFilterEnableDisable')) {
        let languageFilterEnableDisable = document.getElementById('languageFilterEnableDisable')

        languageFilterEnableDisable.addEventListener('click', function () {

            if (this.dataset.enabled === "0") {
                this.dataset.enabled = "1"
                this.parentElement.style.maxHeight = '400px'
                this.parentElement.getElementsByTagName('svg')[0].style.transform = 'rotate(90deg) scale(-1, 1)'
            } else {
                this.dataset.enabled = "0"
                this.parentElement.style.maxHeight = '62px'
                this.parentElement.getElementsByTagName('svg')[0].style.transform = 'rotate(90deg) scale(1, 1)'
            }

        })
    }

    if (document.getElementById('checkLanguageMobile')) {
        let labelCheckbox = document.getElementById('checkLanguageMobile')
        labelCheckbox.addEventListener('click', function () {

            if (this.parentElement.dataset.clicked === "0") {

                document.getElementById('languageGg').style.left = '0px'
                document.getElementById('languageGg').style.opacity = '1'
                document.getElementById('languageGg').disabled = false
                this.parentElement.dataset.clicked = 1
            } else if (this.parentElement.dataset.clicked === "1") {

                document.getElementById('languageGg').style.left = '300px'
                document.getElementById('languageGg').style.opacity = '0.4'
                document.getElementById('languageGg').disabled = true
                this.parentElement.dataset.clicked = 0
            }
        })
    }



}

function clearFilters() {
    if (document.getElementsByClassName('clrButt')[0]) {
        let clrButts = document.getElementsByClassName('clrButt')

        for (let i = 0; i < clrButts.length; i++) {
            clrButts[i].addEventListener('click', function (e) {
                if (document.getElementById('newFilterPopup')) {
                    e.preventDefault()
                    e.stopPropagation()

                    if (document.getElementsByClassName('filterType')[0].getElementsByClassName('active')[0]) {
                        document.getElementsByClassName('filterType')[0].getElementsByClassName('active')[0].classList.remove('active')
                    }

                    document.getElementById('languageGg').style.left = '300px'
                    document.getElementById('languageGg').style.opacity = '0.4'
                    document.getElementById('languageGg').disabled = true
                    document.getElementById('labelCheckbox').dataset.clicked = "0"
                    document.getElementById('checkLanguageMobile').checked = false

                    let filterPriceBadge = document.getElementsByClassName('filterPriceBadge')
                    for (let i = 0; i < filterPriceBadge.length; i++) {
                        filterPriceBadge[i].classList.remove('active')
                        filterPriceBadge[i].dataset.checked2 = "0"
                        filterPriceBadge[i].dataset.checked = "0"
                    }

                    let filterLengthBadge = document.getElementsByClassName('filterLengthBadge')
                    for (let i = 0; i < filterLengthBadge.length; i++) {
                        filterLengthBadge[i].classList.remove('active')
                    }

                    let owl1 = jQuery("#lengthAvailability");
                    owl1.trigger('to.owl.carousel', [0, 30, true])

                    let filterAvailability = document.getElementsByClassName('filterAvailability')[0].getElementsByClassName('filterDayBadge')
                    for (let i = 0; i < filterAvailability.length; i++) {
                        filterAvailability[i].classList.remove('active')
                    }
                    let languageGg = document.getElementById("languageGg")
                    let languageGgOptions = languageGg.getElementsByTagName('option')
                    for (let i = 0; i < languageGgOptions.length; i++) {
                        if (languageGgOptions[i].value === '33') {
                            languageGg.selectedIndex = i
                        }

                    }
                    let annonTalks = document.getElementById('annonTalks')
                    annonTalks.checked = false
                }
                if (document.getElementById('filter-form')) {
                    document.getElementById('filter-form').reset()
                    document.getElementById('languageFilterEnableDisable').dataset.enabled = "0"
                    document.getElementsByClassName('svgLanguageFilterCor')[0].style.transform = 'rotate(90deg) scale(1, 1)'
                    document.getElementById('languageDeskFilters').style.maxHeight = '62px'
                    if (document.getElementById('serachFilterButton')) {
                        document.getElementById('serachFilterButton').classList.add('dn')
                    }
                    let formLabels = document.getElementById('filter-form').getElementsByTagName('label')
                    for (let i = 0; i < formLabels.length; i++) {
                        formLabels[i].style.color = 'rgb(140, 151, 172)'
                        formLabels[i].classList.remove('clicked')
                    }
                    document.getElementById('checkbox-33').parentElement.getElementsByTagName('label')[0].classList.add('clicked')
                }

            })

        }


    }
}

function checkFilterChange() {

    if (document.getElementById('filter-form')) {

        let filterFormInputs = document.getElementById('filter-form').getElementsByTagName('input')

        for (let i = 0; i < filterFormInputs.length; i++) {
            filterFormInputs[i].addEventListener('click', function () {
                if (this.type !== 'radio') {
                    if (this.dataset.clicked === "1") {
                        this.parentElement.getElementsByTagName('label')[0].style.color = '#8c97ac'
                        this.dataset.clicked = 0

                    } else {
                        this.parentElement.getElementsByTagName('label')[0].style.color = '#172B4D'

                        this.dataset.clicked = 1

                    }
                } else {
                    if (this.parentElement.parentElement.id === 'languageDeskFilters') {
                        document.getElementById('languageDeskFilters')?.getElementsByClassName('clicked')[0]?.classList.remove('clicked')
                    } else {
                        document.getElementById('typeFilters')?.getElementsByClassName('clicked')[0]?.classList.remove('clicked')
                    }

                    let that = this

                    setTimeout(function () {
                        that.parentElement.getElementsByTagName('label')[0].classList.add('clicked')
                    })


                }

                let that = this

                setTimeout(function () {

                    if (JSON.stringify(window.filterObjClone) != JSON.stringify(window.filterObj)) {

                        let serachFilterButton = document.getElementById('serachFilterButton')
                        that.parentElement.parentElement.append(serachFilterButton)
                        serachFilterButton.classList.remove('dn')

                    } else {

                        let serachFilterButton = document.getElementById('serachFilterButton')
                        serachFilterButton.classList.add('dn')

                    }

                })


            })

        }
        window.filterObjClone = JSON.parse(JSON.stringify(window.filterObj))
    }
}

function setFilterObject() {
    window.filterObj = {

        "duration": [],
        "priceRange": {
            "1_10": false,
            "10_50": false,
            "over50": false,
            "over100": false
        },
        "availability": {
            "monday": false,
            "tuesday": false,
            "wednesday": false,
            "thursday": false,
            "friday": false,
            "saturday": false,
            "sunday": false
        },
        "order_by": false,
        "order_by_type": false,
        "talks": {
            "video": false,
            "voice": false
        }
    }

    window.filterObjClone = JSON.parse(JSON.stringify(window.filterObj))
}

function checkDurationFilters() {


    let arre = Array.from(
        document.getElementById('durationFilters').getElementsByTagName('input')
    ).concat(
        Array.from(
            document.getElementById('lengthAvailability')?.getElementsByClassName('filterLengthBadge') ?? []
        )
    ).concat(
        Array.from(
            document.getElementById('filterDuration')?.getElementsByTagName('option') ?? []
        )
    )

    for (let i = 0; i < arre.length; i++) {
        arre[i].addEventListener('click', function () {
            if (this.parentElement.classList.contains('owl-item')) {

                if (this.dataset.checked2 !== "1") {
                    window.filterObj.duration.push(parseInt(this.dataset.length))
                    this.dataset.checked2 = 1

                    if (document.getElementById('durationFilters')?.getElementsByTagName('input')) {
                        let desktopInputs = document.getElementById('durationFilters').getElementsByTagName('input')
                        for (let j = 0; j < desktopInputs.length; j++) {

                            if (desktopInputs[j].parentElement.getElementsByTagName('label')[0].dataset.minutes == this.dataset.length) {

                                desktopInputs[j].dataset.checked2 = "1"
                                desktopInputs[j].dataset.clicked = "1"
                                desktopInputs[j].checked = true
                                desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(23, 43, 77)'

                            }

                        }
                    }

                    if (document.getElementById('filterDuration')) {

                        let mobileDropdown = document.getElementById('filterDuration').getElementsByTagName('option')


                        for (let j = 0; j < mobileDropdown.length; j++) {

                            if (mobileDropdown[j].value == this.dataset.length) {

                                mobileDropdown[j].selected = true
                                addRedDotForCloseDropdownFilters(document.getElementById('filterDuration').parentElement, true)
                                break
                            }

                        }
                    }

                } else if (this.dataset.checked2 === "1") {

                    window.filterObj.duration = window.filterObj.duration.filter(word => word !== parseInt(this.dataset.length));

                    this.dataset.checked2 = 0
                    if (document.getElementById('durationFilters')?.getElementsByTagName('input')) {
                        let desktopInputs = document.getElementById('durationFilters').getElementsByTagName('input')
                        for (let j = 0; j < desktopInputs.length; j++) {
                            if (desktopInputs[j].parentElement.getElementsByTagName('label')[0].dataset.minutes == this.dataset.length) {
                                desktopInputs[j].dataset.checked2 = "0"
                                desktopInputs[j].dataset.clicked = "0"
                                desktopInputs[j].checked = false
                                desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(140, 151, 172)'
                            }

                        }
                    }

                    if (document.getElementById('filterDuration')) {
                        let mobileDropdown = document.getElementById('filterDuration').getElementsByTagName('option')
                        let counterSelected = 0
                        for (let j = 0; j < mobileDropdown.length; j++) {

                            if (mobileDropdown[j].value == this.dataset.length) {
                                mobileDropdown[j].selected = false
                            }
                            if (mobileDropdown[j].selected) {
                                counterSelected++
                            }
                        }

                        if (counterSelected == 0) {
                            document.getElementById('filterDuration').parentElement.getElementsByClassName('redDot')[0].remove()
                            document.getElementById('filterDuration').parentElement.getElementsByClassName('dynamicStyle')[0].remove()
                            document.getElementById('filterDuration').parentElement.dataset.filter = '0'

                            document.getElementById('filterDuration').parentElement.getElementsByTagName('select')[0].classList.add('h0oh')
                            document.getElementById('filterDuration').parentElement.getElementsByClassName('arrowSvgz')[0].getElementsByTagName('svg')[0].style.transform = 'scale(1,1)'
                            document.getElementById('filterDuration').parentElement.dataset.clicked = '0'
                        }


                    }

                }

            } else if (this.parentElement.classList.contains('checkbox-inner')) {

                if (this.dataset.checked2 !== "1") {
                    window.filterObj.duration.push(parseInt(this.parentElement.getElementsByTagName('label')[0].dataset.minutes))
                    this.dataset.checked2 = 1
                    if (document.getElementById('lengthAvailability')?.getElementsByClassName('filterLengthBadge')) {
                        let mobileInputs = document.getElementById('lengthAvailability').getElementsByClassName('filterLengthBadge')
                        for (let j = 0; j < mobileInputs.length; j++) {

                            if (mobileInputs[j].dataset.length == this.parentElement.getElementsByTagName('label')[0].dataset.minutes) {
                                mobileInputs[j].classList.add('active')
                                mobileInputs[j].dataset.checked = "1"
                                mobileInputs[j].dataset.checked2 = "1"
                            }

                        }
                    }

                    if (document.getElementById('filterDuration')) {
                        let mobileDropdown = document.getElementById('filterDuration').getElementsByTagName('option')

                        for (let j = 0; j < mobileDropdown.length; j++) {

                            if (mobileDropdown[j].value == this.parentElement.getElementsByTagName('label')[0].dataset.minutes) {
                                mobileDropdown[j].selected = true
                                addRedDotForCloseDropdownFilters(document.getElementById('filterDuration').parentElement, true)
                                break
                            }

                        }



                    }

                } else if (this.dataset.checked2 === "1") {

                    window.filterObj.duration = window.filterObj.duration.filter(word => word !== parseInt(this.parentElement.getElementsByTagName('label')[0].dataset.minutes))

                    this.dataset.checked2 = 0

                    if (document.getElementById('lengthAvailability')?.getElementsByClassName('filterLengthBadge')) {
                        let mobileInputs = document.getElementById('lengthAvailability').getElementsByClassName('filterLengthBadge')
                        for (let j = 0; j < mobileInputs.length; j++) {
                            if (mobileInputs[j].dataset.length == this.parentElement.getElementsByTagName('label')[0].dataset.minutes) {
                                mobileInputs[j].classList.remove('active')
                                mobileInputs[j].dataset.checked = "0"
                                mobileInputs[j].dataset.checked2 = "0"

                            }

                        }
                    }

                    if (document.getElementById('filterDuration')) {

                        let mobileDropdown = document.getElementById('filterDuration').getElementsByTagName('option')

                        let counterSelected = 0

                        for (let j = 0; j < mobileDropdown.length; j++) {

                            if (mobileDropdown[j].value == this.parentElement.getElementsByTagName('label')[0].dataset.minutes) {
                                mobileDropdown[j].selected = false

                            }
                            if (mobileDropdown[j].selected) {
                                counterSelected++
                            }
                        }

                        if (counterSelected == 0) {
                            document.getElementById('filterDuration').parentElement.getElementsByClassName('redDot')[0]?.remove()
                            document.getElementById('filterDuration').parentElement.getElementsByClassName('dynamicStyle')[0]?.remove()
                            document.getElementById('filterDuration').parentElement.dataset.filter = '0'
                            document.getElementById('filterDuration').parentElement.getElementsByTagName('select')[0].classList.add('h0oh')
                            document.getElementById('filterDuration').parentElement.getElementsByClassName('arrowSvgz')[0].getElementsByTagName('svg')[0].style.transform = 'scale(1,1)'
                            document.getElementById('filterDuration').parentElement.dataset.clicked = '0'

                        }

                    }
                }
            } else if (this.parentElement.classList.contains('selectMultiple')) {

                let sele = false
                for (let option of document.getElementById('filterDuration').options) {
                    if (option.selected) {
                        sele = true
                    }
                }


                if (sele) {
                    window.filterObj.duration.push(parseInt(this.value))

                    if (!arre[i].parentElement.parentElement.getElementsByClassName('redDot')[0]) {

                        if (!arre[i].parentElement.parentElement.classList.contains('typers')) {

                            addRedDotForCloseDropdownFilters(this.parentElement)
                        } else {


                        }

                    }
                } else {

                    let parent = document.getElementById('filterDuration').parentElement
                    parent.getElementsByClassName('redDot')[0].remove()
                    parent.getElementsByClassName('dynamicStyle')[0].remove()

                    /*   document.getElementById('filterDuration').style.height = '0px'

                      parent.dataset.clicked = 0 */
                    parent.dataset.filter = 0
                    /*   parent.getElementsByClassName('arrowSvgz')[0].getElementsByTagName('svg')[0].style.transform = 'scale(1,1)' */
                    window.filterObj.duration = []
                }



                if (document.getElementById('lengthAvailability')?.getElementsByClassName('filterLengthBadge')) {
                    let mobileInputs = document.getElementById('lengthAvailability').getElementsByClassName('filterLengthBadge')

                    for (let j = 0; j < mobileInputs.length; j++) {
                        mobileInputs[j].classList.remove('active')
                        mobileInputs[j].dataset.checked = "0"
                        mobileInputs[j].dataset.checked2 = "0"
                    }

                    for (let j = 0; j < mobileInputs.length; j++) {


                        for (let option of document.getElementById('filterDuration').options) {
                            if (option.selected) {
                                if (option.value == mobileInputs[j].dataset.length) {
                                    mobileInputs[j].classList.add('active')
                                    mobileInputs[j].dataset.checked = "1"
                                    mobileInputs[j].dataset.checked2 = "1"
                                }

                            }
                        }


                    }
                }

                if (document.getElementById('durationFilters')?.getElementsByTagName('input')) {
                    let desktopInputs = document.getElementById('durationFilters').getElementsByTagName('input')

                    for (let j = 0; j < desktopInputs.length; j++) {

                        desktopInputs[j].dataset.checked2 = "0"
                        desktopInputs[j].dataset.clicked = "0"
                        desktopInputs[j].checked = false
                        desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(140, 151, 172)'
                    }


                    for (let j = 0; j < desktopInputs.length; j++) {


                        for (let option of document.getElementById('filterDuration').options) {
                            if (option.selected) {
                                if (option.value == desktopInputs[j].parentElement.getElementsByTagName('label')[0].dataset.minutes) {
                                    desktopInputs[j].dataset.checked2 = "1"
                                    desktopInputs[j].dataset.clicked = "1"
                                    desktopInputs[j].checked = true
                                    desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(23, 43, 77)'
                                }

                            }
                        }
                    }
                }

                getTalksToShow(0, true)

            }
        })

    }
}

function checkAvailabilityFilters() {

    let arre = Array.from(
        document.getElementById('availabilityFilters').getElementsByTagName('input')
    ).concat(
        Array.from(
            document.getElementsByClassName('avaSmallFilter')[0]?.getElementsByClassName('filterDayBadge') ?? []
        )
    ).concat(
        Array.from(
            document.getElementById('filterDays')?.getElementsByTagName('option') ?? []
        )
    )

    for (let i = 0; i < arre.length; i++) {
        arre[i].addEventListener('click', function () {
            if (this.parentElement.parentElement.classList.contains('avaSmallFilter')) {

                if (this.dataset.checked2 !== "1") {
                    window.filterObj.availability[this.dataset.day] = true
                    this.dataset.checked2 = 1

                    if (document.getElementById('availabilityFilters')?.getElementsByTagName('input')) {
                        let desktopInputs = document.getElementById('availabilityFilters').getElementsByTagName('input')
                        for (let j = 0; j < desktopInputs.length; j++) {

                            if (desktopInputs[j].dataset.day == this.dataset.day) {

                                desktopInputs[j].dataset.checked2 = "1"
                                desktopInputs[j].dataset.clicked = "1"
                                desktopInputs[j].checked = true
                                desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(23, 43, 77)'

                            }

                        }
                    }

                    if (document.getElementById('filterDays')) {
                        let mobileDropdown = document.getElementById('filterDays').getElementsByTagName('option')

                        for (let j = 0; j < mobileDropdown.length; j++) {

                            if (mobileDropdown[j].value == this.dataset.value) {
                                mobileDropdown[j].selected = true
                                addRedDotForCloseDropdownFilters(document.getElementById('filterDays').parentElement, true)
                                break
                            }

                        }

                    }

                } else if (this.dataset.checked2 === "1") {

                    window.filterObj.availability[this.dataset.day] = false
                    this.dataset.checked2 = 0
                    if (document.getElementById('availabilityFilters')?.getElementsByTagName('input')) {
                        let desktopInputs = document.getElementById('availabilityFilters').getElementsByTagName('input')
                        for (let j = 0; j < desktopInputs.length; j++) {
                            if (desktopInputs[j].dataset.day == this.dataset.day) {
                                desktopInputs[j].dataset.checked2 = "0"
                                desktopInputs[j].dataset.clicked = "0"
                                desktopInputs[j].checked = false
                                desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(140, 151, 172)'
                            }

                        }
                    }

                    if (document.getElementById('filterDays')) {
                        let mobileDropdown = document.getElementById('filterDays').getElementsByTagName('option')

                        for (let j = 0; j < mobileDropdown.length; j++) {

                            if (mobileDropdown[j].value == this.dataset.value) {
                                mobileDropdown[j].selected = false
                            }

                        }

                        if (this.parentElement.getElementsByClassName('active').length === 0) {
                            document.getElementById('filterDays').parentElement.getElementsByClassName('redDot')[0].remove()
                            document.getElementById('filterDays').parentElement.getElementsByClassName('dynamicStyle')[0].remove()
                            document.getElementById('filterDays').parentElement.dataset.filter = '0'
                        }


                        document.getElementById('filterDays').parentElement.getElementsByTagName('select')[0].classList.add('h0oh')
                        document.getElementById('filterDays').parentElement.getElementsByClassName('arrowSvgz')[0].getElementsByTagName('svg')[0].style.transform = 'scale(1,1)'
                        document.getElementById('filterDays').parentElement.dataset.clicked = '0'
                    }

                }

            } else if (this.parentElement.classList.contains('checkbox-inner')) {

                if (this.dataset.checked2 !== "1") {

                    window.filterObj.availability[this.dataset.day] = true
                    this.dataset.checked2 = 1
                    if (document.getElementsByClassName('avaSmallFilter')[0]?.getElementsByClassName('filterDayBadge')) {
                        let mobileInputs = document.getElementsByClassName('avaSmallFilter')[0].getElementsByClassName('filterDayBadge')
                        for (let j = 0; j < mobileInputs.length; j++) {

                            if (mobileInputs[j].dataset.day == this.dataset.day) {
                                mobileInputs[j].classList.add('active')
                                mobileInputs[j].dataset.checked = "1"
                                mobileInputs[j].dataset.checked2 = "1"
                            }

                        }
                    }

                    if (document.getElementById('filterDays')) {
                        let mobileDropdown = document.getElementById('filterDays').getElementsByTagName('option')
                        for (let j = 0; j < mobileDropdown.length; j++) {

                            if (mobileDropdown[j].value == this.dataset.value) {
                                mobileDropdown[j].selected = true
                                addRedDotForCloseDropdownFilters(document.getElementById('filterDays').parentElement, true)
                                break
                            }

                        }
                    }


                } else if (this.dataset.checked2 === "1") {

                    window.filterObj.availability[this.dataset.day] = false

                    this.dataset.checked2 = 0
                    if (document.getElementsByClassName('avaSmallFilter')[0]?.getElementsByClassName('filterDayBadge')) {
                        let mobileInputs = document.getElementsByClassName('avaSmallFilter')[0].getElementsByClassName('filterDayBadge')

                        for (let j = 0; j < mobileInputs.length; j++) {
                            if (mobileInputs[j].dataset.day == this.dataset.day) {
                                mobileInputs[j].classList.remove('active')
                                mobileInputs[j].dataset.checked = "0"
                                mobileInputs[j].dataset.checked2 = "0"

                            }

                        }
                    }

                    if (document.getElementById('filterDays')) {
                        let mobileDropdown = document.getElementById('filterDays').getElementsByTagName('option')
                        for (let j = 0; j < mobileDropdown.length; j++) {

                            if (mobileDropdown[j].value == this.dataset.value) {
                                mobileDropdown[j].selected = false
                            }

                        }

                        if (this.parentElement.parentElement.querySelectorAll('input[type="checkbox"]:checked').length === 0) {

                            document.getElementById('filterDays').parentElement.getElementsByClassName('redDot')[0]?.remove()
                            document.getElementById('filterDays').parentElement.getElementsByClassName('dynamicStyle')[0]?.remove()
                            document.getElementById('filterDays').parentElement.dataset.filter = '0'
                        }



                        document.getElementById('filterDays').parentElement.getElementsByTagName('select')[0].style.height = '0'
                        document.getElementById('filterDays').parentElement.getElementsByClassName('arrowSvgz')[0].getElementsByTagName('svg')[0].style.transform = 'scale(1,1)'
                        document.getElementById('filterDays').parentElement.dataset.clicked = '0'



                    }

                }
            } else if (this.parentElement.classList.contains('selectMultiple')) {

                let sele = false

                for (let option of document.getElementById('filterDays').options) {
                    if (option.selected) {
                        sele = true
                    }
                }


                if (sele) {
                    window.filterObj.availability[this.dataset.day] = true

                    if (!arre[i].parentElement.parentElement.getElementsByClassName('redDot')[0]) {

                        if (!arre[i].parentElement.parentElement.classList.contains('typers')) {

                            addRedDotForCloseDropdownFilters(this.parentElement)
                        } else {


                        }

                    }

                } else {



                    let parent = document.getElementById('filterDays').parentElement
                    parent.getElementsByClassName('redDot')[0].remove()
                    parent.getElementsByClassName('dynamicStyle')[0].remove()
                    parent.dataset.filter = 0
                    window.filterObj.availability = {
                        "monday": false,
                        "tuesday": false,
                        "wednesday": false,
                        "thursday": false,
                        "friday": false,
                        "saturday": false,
                        "sunday": false
                    }
                }


                window.filterObj.availability[this.dataset.day] = true


                if (document.getElementById('availabilityFilters')?.getElementsByTagName('input')) {

                    let desktopInputs = document.getElementById('availabilityFilters').getElementsByTagName('input')

                    for (let j = 0; j < desktopInputs.length; j++) {

                        desktopInputs[j].dataset.checked2 = "0"
                        desktopInputs[j].dataset.clicked = "0"
                        desktopInputs[j].checked = false
                        desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(140, 151, 172)'
                    }


                    for (let j = 0; j < desktopInputs.length; j++) {


                        for (let option of document.getElementById('filterDays').options) {

                            if (option.selected) {

                                if (option.value == desktopInputs[j].dataset.value) {
                                    desktopInputs[j].dataset.checked2 = "1"
                                    desktopInputs[j].dataset.clicked = "1"
                                    desktopInputs[j].checked = true
                                    desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(23, 43, 77)'
                                }

                            }
                        }
                    }
                }

                if (document.getElementsByClassName('avaSmallFilter')[0]?.getElementsByClassName('filterDayBadge')) {
                    let mobileInputs = document.getElementsByClassName('avaSmallFilter')[0].getElementsByClassName('filterDayBadge')
                    for (let j = 0; j < mobileInputs.length; j++) {

                        if (mobileInputs[j].dataset.day == this.dataset.day) {
                            mobileInputs[j].classList.add('active')
                            mobileInputs[j].dataset.checked = "1"
                            mobileInputs[j].dataset.checked2 = "1"
                        }

                    }
                }

                getTalksToShow(0, true)
            }
        })

    }
}

function checkTalkTypeFilters() {
    let arre = Array.from(
        document.getElementById('typeFilters').getElementsByTagName('input') ?? []
    ).concat(
        Array.from(
            document.getElementsByClassName('filterType')[0]?.getElementsByClassName('filterTypeBadge') ?? []
        )
    ).concat(
        Array.from(
            document.getElementById('filterTypes')?.getElementsByTagName('option') ?? []
        )
    )


    for (let i = 0; i < arre.length; i++) {
        arre[i].addEventListener('click', function () {

            if (this.parentElement.parentElement.classList.contains('filterType')) {

                setTalksObject(this)

                if (document.getElementById('filterTypes')) {

                    if (this.dataset.clicked === "1") {

                        if (document.getElementsByClassName('filterType')[0].getElementsByClassName('active').length === 0) {

                        } else {

                            if (!document.getElementById('filterTypes').parentElement.getElementsByClassName('redDot')[0]) {

                                addRedDotForCloseDropdownFilters(document.getElementById('filterTypes'))

                            }
                        }

                        if (document.getElementById('filterTypes')) {

                            let desktopInputs = document.getElementById('filterTypes').getElementsByTagName('option')

                            for (let j = 0; j < desktopInputs.length; j++) {

                                desktopInputs[j].dataset.checked2 = "0"
                                desktopInputs[j].dataset.clicked = "0"
                                desktopInputs[j].selected = false

                            }

                            let smallFilterItems = document.getElementsByClassName('filterType')[0].getElementsByClassName('active')

                            for (let i = 0; i < smallFilterItems.length; i++) {

                                for (let j = 0; j < desktopInputs.length; j++) {

                                    if (smallFilterItems[i].dataset.type == desktopInputs[j].dataset.type) {

                                        /*      desktopInputs[j].dataset.checked2 = "1"
                                             desktopInputs[j].dataset.clicked = "1" */
                                        desktopInputs[j].selected = true

                                    }

                                }



                            }
                        }

                    } else if (this.dataset.clicked === "0") {



                        if (document.getElementsByClassName('filterType')[0].getElementsByClassName('active').length === 0) {

                            let parent = document.getElementById('filterTypes').parentElement
                            parent.getElementsByClassName('redDot')[0].remove()
                            parent.getElementsByClassName('dynamicStyle')[0].remove()
                            parent.dataset.filter = 0
                        }

                        if (document.getElementById('filterTypes')) {

                            let desktopInputs = document.getElementById('filterTypes').getElementsByTagName('option')





                            for (let j = 0; j < desktopInputs.length; j++) {

                                if (this.dataset.type == desktopInputs[j].dataset.type) {

                                    /*      desktopInputs[j].dataset.checked2 = "1"
                                         desktopInputs[j].dataset.clicked = "1" */
                                    desktopInputs[j].selected = false

                                }

                            }




                        }

                    }
                }

                if (document.getElementById('typeFilters')?.getElementsByTagName('input')) {
                    let typeDesktopInputs = document.getElementById('typeFilters')?.getElementsByTagName('input')
                    if (this.dataset.clicked === "1") {

                        for (let i = 0; i < typeDesktopInputs.length; i++) {
                            if (typeDesktopInputs[i].dataset.type == this.dataset.type) {

                                typeDesktopInputs[i].dataset.clicked = "1"
                                typeDesktopInputs[i].dataset.checked2 = "1"
                                typeDesktopInputs[i].checked = true
                            }

                        }
                    } else if (this.dataset.clicked === "0") {

                        for (let i = 0; i < typeDesktopInputs.length; i++) {
                            if (typeDesktopInputs[i].dataset.type == this.dataset.type) {

                                typeDesktopInputs[i].dataset.clicked = "0"
                                typeDesktopInputs[i].dataset.checked2 = "0"
                                typeDesktopInputs[i].checked = false
                            }

                        }
                    }
                }


            } else if (this.parentElement.classList.contains('checkbox-inner')) {

                setTalksObject(this)

                if (document.getElementById('filterTypes')) {

                    if (this.dataset.clicked !== "1") {

                        let options = document.getElementById('filterTypes').getElementsByTagName('option')
                        let counter = 0
                        let counter2 = 0
                        for (let i = 0; i < options.length; i++) {
                            if (options[i].dataset.type === this.dataset.type) {

                                options[i].selected = true
                            }
                            counter++
                        }
                        for (let i = 0; i < options.length; i++) {
                            if (options[i].selected) {
                                counter2++
                            }
                        }

                        if (counter2 == 1) {
                            let redDot = document.createElement('div')
                            redDot.className = 'redDot'
                            redDot.innerHTML = '✕'

                            document.getElementById('filterTypes').parentElement.append(redDot)

                            redDot.addEventListener('click', clearRedDotEvent)

                            let dynamicStyle = document.createElement('style')
                            dynamicStyle.className = 'dynamicStyle'
                            dynamicStyle.innerHTML = '#filterTypes{background-image: none}'

                            document.getElementById('filterTypes').parentElement.append(dynamicStyle)

                            filterTypes.classList.remove('h0oh')

                            filterTypes.parentElement.dataset.clicked = "1"
                            filterTypes.parentElement.dataset.filter = "1"

                            counter = counter - 1
                            let height = counter * 24 + counter * (12) + 6
                            filterTypes.style.cssText = 'height: ' + height + 'px'

                            document.getElementById('filterTypes').parentElement.getElementsByClassName('arrowSvgz')[0].getElementsByTagName('svg')[0].style.transform = 'scale(1, -1)'
                        }

                    }
                    else if (this.dataset.clicked === "1") {

                        let options = document.getElementById('filterTypes').getElementsByTagName('option')
                        let counter = 0
                        let counter2 = 0

                        for (let i = 0; i < options.length; i++) {
                            if (options[i].dataset.type === this.dataset.type) {

                                options[i].selected = false
                            }
                            counter++
                        }

                        for (let i = 0; i < options.length; i++) {
                            if (options[i].selected) {
                                counter2++
                            }
                        }

                        if (counter2 == 0) {

                            document.getElementById('filterTypes').parentElement.getElementsByClassName('redDot')[0]?.removeEventListener('click', clearRedDotEvent)
                            document.getElementById('filterTypes').parentElement.getElementsByClassName('redDot')[0]?.remove()
                            document.getElementById('filterTypes').parentElement.getElementsByClassName('dynamicStyle')[0]?.remove()


                            filterTypes.classList.add('h0oh')

                            filterTypes.parentElement.dataset.clicked = "0"
                            filterTypes.parentElement.dataset.filter = "0"

                            filterTypes.style.cssText = 'height: 0px'
                            document.getElementById('filterTypes').parentElement.getElementsByClassName('arrowSvgz')[0].getElementsByTagName('svg')[0].style.transform = 'scale(1, 1)'
                        }
                    }
                }

                if (document.getElementsByClassName('filterType')[0]) {
                    if (this.dataset.clicked !== "1") {
                        let types = document.getElementsByClassName('filterType')[0].getElementsByClassName('filterTypeBadge')
                        for (let i = 0; i < types.length; i++) {
                            if (types[i].dataset.type === this.dataset.type) {
                                types[i].classList.add('active')
                                types[i].dataset.clicked = "1"
                                types[i].dataset.checked2 = "1"
                            }
                        }
                    }
                    else if (this.dataset.clicked === "1") {
                        let types = document.getElementsByClassName('filterType')[0].getElementsByClassName('filterTypeBadge')
                        for (let i = 0; i < types.length; i++) {
                            if (types[i].dataset.type === this.dataset.type) {
                                types[i].classList.remove('active')
                                types[i].dataset.clicked = "0"
                                types[i].dataset.checked2 = "0"
                            }
                        }
                    }

                }

            } else if (this.parentElement.classList.contains('selectMultiple')) {

                setTalksObject(this)


                let sele = false

                for (let option of document.getElementById('filterTypes').options) {
                    if (option.selected) {
                        sele = true
                    }
                }

                if (sele) {


                    if (!arre[i].parentElement.parentElement.getElementsByClassName('redDot')[0]) {

                        addRedDotForCloseDropdownFilters(this.parentElement)

                    }
                } else {
                    let parent = document.getElementById('filterTypes').parentElement
                    parent.getElementsByClassName('redDot')[0].remove()
                    parent.getElementsByClassName('dynamicStyle')[0].remove()
                    parent.dataset.filter = 0
                    window.filterObj.talks = {
                        "video": false,
                        "voice": false
                    }
                }


                if (document.getElementById('typeFilters')?.getElementsByTagName('input')) {

                    let desktopInputs = document.getElementById('typeFilters').getElementsByTagName('input')

                    for (let j = 0; j < desktopInputs.length; j++) {

                        desktopInputs[j].dataset.checked2 = "0"
                        desktopInputs[j].dataset.clicked = "0"
                        desktopInputs[j].checked = false
                        desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(140, 151, 172)'
                    }


                    for (let j = 0; j < desktopInputs.length; j++) {


                        for (let option of document.getElementById('filterTypes').options) {

                            if (option.selected) {

                                if (option.dataset.type == desktopInputs[j].dataset.type) {
                                    desktopInputs[j].dataset.checked2 = "1"
                                    desktopInputs[j].dataset.clicked = "1"
                                    desktopInputs[j].checked = true
                                    desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(23, 43, 77)'
                                }

                            }
                        }
                    }
                }

                if (document.getElementsByClassName('filterType')[0]?.getElementsByClassName('filterTypeBadge')) {



                    let mobileInputs = document.getElementsByClassName('filterType')[0].getElementsByClassName('filterTypeBadge')

                    for (let j = 0; j < mobileInputs.length; j++) {
                        mobileInputs[j].classList.remove('active')
                        mobileInputs[j].dataset.checked = "0"
                        mobileInputs[j].dataset.checked2 = "0"
                    }

                    for (let j = 0; j < mobileInputs.length; j++) {


                        for (let option of document.getElementById('filterTypes').options) {
                            if (option.selected) {
                                if (option.dataset.type == mobileInputs[j].dataset.type) {
                                    mobileInputs[j].classList.add('active')
                                    mobileInputs[j].dataset.checked = "1"
                                    mobileInputs[j].dataset.checked2 = "1"
                                }

                            }
                        }


                    }
                }

                getTalksToShow(0, true)

            }



        })

    }
}

function setTalksObject(that) {

    if (that.dataset.clicked === "0") {
        if (that.classList.contains('filterTypeBadge')) {
            if (that.dataset.type === "video") {
                window.filterObj.talks['video'] = false
            } else if (that.dataset.type === "voice") {
                window.filterObj.talks['voice'] = false
            }
        } else {
            if (that.dataset.type === "all") {
                window.filterObj.talks = {
                    video: true,
                    voice: true
                }
            } else if (that.dataset.type === "video") {
                window.filterObj.talks['video'] = true
            } else if (that.dataset.type === "voice") {
                window.filterObj.talks['voice'] = true
            }
        }

    } else if (that.dataset.clicked === "1") {
        if (that.classList.contains('filterTypeBadge')) {
            if (that.dataset.type === "video") {
                window.filterObj.talks['video'] = true
            } else if (that.dataset.type === "voice") {
                window.filterObj.talks['voice'] = true
            }
        } else {
            if (that.dataset.type === "all") {
                window.filterObj.talks = {
                    video: false,
                    voice: false
                }
            } else if (that.dataset.type === "video") {
                window.filterObj.talks['video'] = false
            } else if (that.dataset.type === "voice") {
                window.filterObj.talks['voice'] = false
            }
        }

    } else {

        if (that.dataset.type === 'video') {

            if (filterObj.talks.video === true) {


                filterObj.talks.video = false

            } else if (filterObj.talks.video === false) {

                filterObj.talks.video = true
            }
        } else if (that.dataset.type === 'voice') {
            if (filterObj.talks.voice === true) {
                filterObj.talks.voice = false

            } else if (filterObj.talks.voice === false) {

                filterObj.talks.voice = true
            }
        }
    }

}

function checkAnonTalkFilters() {

    let arre = Array.from(document.getElementById('anonTypeFilters')?.getElementsByTagName('input') ?? [])
        .concat(Array.from([document.getElementsByClassName('switch-re-edit')[0]?.getElementsByClassName('switch-paddle')[0]].length
            && typeof document.getElementsByClassName('switch-re-edit')[0]?.getElementsByClassName('switch-paddle')[0] !== 'undefined' ?
            [document.getElementsByClassName('switch-re-edit')[0]?.getElementsByClassName('switch-paddle')[0]] : []))

    for (let i = 0; i < arre.length; i++) {

        arre[i].addEventListener('click', function () {

            if (this.parentElement.classList.contains('switch-re-edit')) {

                if (this.dataset.checked2 !== "1") {

                    window.filterObj['anonTalks'] = true
                    this.dataset.checked2 = 1

                    let desktopInputs = document.getElementById('anonTypeFilters').getElementsByTagName('input')[0]
                    desktopInputs.dataset.checked2 = "1"
                    desktopInputs.dataset.clicked = "1"
                    desktopInputs.checked = true
                    desktopInputs.parentElement.getElementsByTagName('label')[0].style.color = 'rgb(23, 43, 77)'

                } else if (this.dataset.checked2 === "1") {

                    delete window.filterObj['anonTalks']

                    this.dataset.checked2 = 0

                    let desktopInputs = document.getElementById('anonTypeFilters').getElementsByTagName('input')[0]
                    desktopInputs.dataset.checked2 = "0"
                    desktopInputs.dataset.clicked = "0"
                    desktopInputs.checked = false
                    desktopInputs.parentElement.getElementsByTagName('label')[0].style.color = 'rgb(140, 151, 172)'

                }

            } else if (this.parentElement.classList.contains('checkbox-inner')) {

                if (this.dataset.checked2 !== "1") {
                    window.filterObj['anonTalks'] = true
                    this.dataset.checked2 = 1

                    if (document.getElementById('annonTalks')) {
                        let mobileInputs = document.getElementById('annonTalks')

                        mobileInputs.parentElement.getElementsByTagName('label')[0].dataset.clicked = "1"
                        mobileInputs.parentElement.getElementsByTagName('label')[0].dataset.checked2 = "1"
                        mobileInputs.checked = true
                    }





                } else if (this.dataset.checked2 === "1") {

                    delete window.filterObj['anonTalks']
                    this.dataset.checked2 = 0

                    if (document.getElementById('annonTalks')) {
                        let mobileInputs = document.getElementById('annonTalks')

                        mobileInputs.parentElement.getElementsByTagName('label')[0].dataset.clicked = "0"
                        mobileInputs.parentElement.getElementsByTagName('label')[0].dataset.checked2 = "0"
                        mobileInputs.checked = false
                    }


                }
            }
        })

    }
}

function checkPriceFilters() {
    let arre = Array.from(document.getElementById('priceFilters').getElementsByTagName('input')).concat(Array.from(document.getElementsByClassName('filterPrice')[0]?.getElementsByClassName('filterPriceBadge') ?? []))

    for (let i = 0; i < arre.length; i++) {
        arre[i].addEventListener('click', function () {

            if (this.parentElement.parentElement.classList.contains('filterPrice')) {



                if (this.dataset.checked2 !== "1") {
                    window.filterObj.priceRange[this.dataset.price] = true
                    this.dataset.checked2 = "1"
                    this.classList.add('active')
                    if (document.getElementById('priceFilters')?.getElementsByTagName('input')) {
                        let desktopInputs = document.getElementById('priceFilters').getElementsByTagName('input')
                        for (let j = 0; j < desktopInputs.length; j++) {

                            if (desktopInputs[j].dataset.price == this.dataset.price) {

                                desktopInputs[j].dataset.checked2 = "1"
                                desktopInputs[j].checked = true
                                desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(23, 43, 77)'

                            }

                        }
                    }


                } else if (this.dataset.checked2 === "1") {


                    window.filterObj.priceRange[this.dataset.price] = false

                    this.dataset.checked2 = "0"
                    this.classList.remove('active')
                    if (document.getElementById('priceFilters')?.getElementsByTagName('input')) {
                        let desktopInputs = document.getElementById('priceFilters').getElementsByTagName('input')
                        for (let j = 0; j < desktopInputs.length; j++) {

                            if (desktopInputs[j].dataset.price == this.dataset.price) {

                                desktopInputs[j].dataset.checked2 = "0"
                                desktopInputs[j].checked = false
                                desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(140, 151, 172)'

                            }

                        }
                    }



                }
            } else if (this.parentElement.classList.contains('checkbox-inner')) {

                if (this.dataset.checked2 !== "1") {
                    window.filterObj.priceRange[this.dataset.price] = true
                    this.dataset.checked2 = "1"
                    if (document.getElementsByClassName('filterPrice')[0]?.getElementsByClassName('filterPriceBadge')) {
                        let mobileInputs = document.getElementsByClassName('filterPrice')[0].getElementsByClassName('filterPriceBadge')
                        for (let j = 0; j < mobileInputs.length; j++) {

                            if (mobileInputs[j].dataset.price == this.dataset.price) {

                                mobileInputs[j].dataset.checked2 = "1"
                                mobileInputs[j].classList.add('active')

                            }

                        }
                    }




                } else if (this.dataset.checked2 === "1") {


                    window.filterObj.priceRange[this.dataset.price] = false

                    this.dataset.checked2 = "0"
                    if (document.getElementsByClassName('filterPrice')[0]?.getElementsByClassName('filterPriceBadge')) {
                        let mobileInputs = document.getElementsByClassName('filterPrice')[0].getElementsByClassName('filterPriceBadge')
                        for (let j = 0; j < mobileInputs.length; j++) {

                            if (mobileInputs[j].dataset.price == this.dataset.price) {

                                mobileInputs[j].dataset.checked2 = "0"
                                mobileInputs[j].classList.remove('active')

                            }

                        }
                    }




                }
            }
        })
    }
}

function checkLanguageFilters() {
    let arre = Array.from([document.getElementById('languageGg')] ?? []).concat(Array.from(document.getElementById('languageDeskFilters').getElementsByTagName('input')))

    for (let i = 0; i < arre.length; i++) {
        if (arre[i] !== null) {
            arre[i].addEventListener('change', function () {

                if (this.parentElement.classList.contains('firstFooterLeft')) {

                    window.filterObj['language_id'] = [this.value]

                    let desktopInputs = document.getElementById('languageDeskFilters').getElementsByTagName('input')

                    for (let j = 0; j < desktopInputs.length; j++) {

                        desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(140, 151, 172)'

                        if (desktopInputs[j].dataset.id == this.value) {

                            desktopInputs[j].checked = true
                            desktopInputs[j].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(23, 43, 77)'

                        }

                    }



                } else if (this.parentElement.classList.contains('checkbox-inner')) {


                    window.filterObj['language_id'] = this.dataset.id

                    if (document.getElementById('languageGg')?.getElementsByTagName('option')) {
                        let mobileInputs = document.getElementById('languageGg')
                        let options = mobileInputs.getElementsByTagName('option')
                        for (let i = 0; i < options.length; i++) {

                            if (options[i].dataset.id == this.dataset.id) {

                                mobileInputs.selectedIndex = i
                            }

                        }
                    }


                }
            })
        }


    }



}

function checkLanguageFilters2() {
    let arre = Array.from([document.getElementById('languageFilterEnableDisable') ?? null]).concat(Array.from([document.getElementById('checkLanguageMobile') ?? null]))

    for (let i = 0; i < arre.length; i++) {
        if (arre[i] !== null) {
            arre[i].addEventListener('click', function () {
                if (this.parentElement.classList.contains('labelCheckbox')) {

                    if (this.parentElement.dataset.clicked !== "1") {



                        if (document.getElementById('languageFilterEnableDisable')) {
                            let languageFilterEnableDisable = document.getElementById('languageFilterEnableDisable')
                            languageFilterEnableDisable.parentElement.style.maxHeight = '400px'
                            languageFilterEnableDisable.dataset.enabled = '1'
                            languageFilterEnableDisable.dataset.checked2 = '1'
                            languageFilterEnableDisable.parentElement.getElementsByClassName('svgLanguageFilterCor')[0].style.transform = 'transform: rotate(90deg) scale(-1, 1)'


                        }




                    } else if (this.parentElement.dataset.clicked === "1") {


                        if (document.getElementById('languageFilterEnableDisable')) {
                            let languageFilterEnableDisable = document.getElementById('languageFilterEnableDisable')
                            languageFilterEnableDisable.parentElement.style.maxHeight = '62px'
                            languageFilterEnableDisable.dataset.enabled = '0'
                            languageFilterEnableDisable.dataset.checked2 = '0'
                            languageFilterEnableDisable.parentElement.getElementsByClassName('svgLanguageFilterCor')[0].style.transform = 'transform: rotate(90deg) scale(1, 1)'


                        }

                        delete window.filterObj['language_id']
                    }

                } else if (this.parentElement.classList.contains('languageFilterCor')) {

                    if (this.dataset.checked2 !== "1") {

                        this.dataset.checked2 = 1

                        if (document.getElementById('checkLanguageMobile')) {
                            let mobileInputs = document.getElementById('checkLanguageMobile')

                            mobileInputs.parentElement.dataset.clicked = "1"
                            mobileInputs.checked = true
                            mobileInputs.parentElement.parentElement.getElementsByTagName('select')[0].disabled = false
                            mobileInputs.parentElement.parentElement.getElementsByTagName('select')[0].style.cssText = 'left: 0px; opacity: 1;'

                        }






                    } else if (this.dataset.checked2 === "1") {

                        this.dataset.checked2 = 0

                        if (document.getElementById('checkLanguageMobile')) {
                            let mobileInputs = document.getElementById('checkLanguageMobile')

                            mobileInputs.parentElement.dataset.clicked = "0"
                            mobileInputs.checked = false
                            mobileInputs.parentElement.parentElement.getElementsByTagName('select')[0].disabled = true
                            mobileInputs.parentElement.parentElement.getElementsByTagName('select')[0].style.cssText = 'left: 700px; opacity: 0.4;'

                        }

                        delete window.filterObj['language_id']

                    }
                }
            })
        }
    }
}

function showDropdown() {
    let subFilterItems = document.getElementsByClassName('subFilterItems')
    for (let i = 0; i < subFilterItems.length; i++) {
        subFilterItems[i].addEventListener('click', function (e) {

            if (e.target.tagName !== 'OPTION') {
                if (this.dataset.clicked !== "1") {



                    this.getElementsByTagName('select')[0].style.height = (32 * (this.getElementsByTagName('option').length - 1)) + 'px'
                    this.getElementsByClassName('arrowSvgz')[0].getElementsByTagName('svg')[0].style.transform = 'scale(1,-1)'
                    this.dataset.clicked = 1

                } else if (this.dataset.clicked === "1") {

                    this.getElementsByTagName('select')[0].style.height = '0px'
                    this.getElementsByClassName('arrowSvgz')[0].getElementsByTagName('svg')[0].style.transform = 'scale(1,1)'

                    this.dataset.clicked = 0
                }
            }



        })

    }
}

function initFilters() {
    if (document.getElementById('filterTalks')) {
        setFilterObject()

        checkDurationFilters()
        checkAvailabilityFilters()
        checkTalkTypeFilters()
        checkAnonTalkFilters()

        checkPriceFilters()
        checkLanguageFilters()
        checkLanguageFilters2()

        showDropdown()

        enableDisableLanguage()
        clearFilters()
        checkFilterChange()


    }
    favoriteUnFavoriteTalk()
    showMoreSearchTalks()
    addOrderByFilterEvents()
}

if (document.getElementsByClassName('smallFilter33')[0]) {
    let array = [
        document.getElementById('filterTypes'),
        document.getElementById('filterDuration'),
        document.getElementById('filterDays'),
        document.getElementById('filterLanguage'),
    ]
    for (let i = 0; i < array.length; i++) {
        array[i].addEventListener('change', function (e) {

            let that = this

            switch (that.id) {
                case 'filterDuration':

                    let selected = []
                    for (var option of document.getElementById('filterDuration').options) {
                        if (option.selected) {
                            selected.push(option.value)
                        }
                    }

                    window.filterObj.duration = selected

                    break
                case 'filterTypes':
                    //type treba handlovati na ruti
                    break
                case 'filterDays':
                    //dane treba handlovati na ruti

                    switch (that.value) {

                        case '1':
                            window.filterObj.availability['monday'] = true
                            break;
                        case '2':
                            window.filterObj.availability['tuesday'] = true
                        case '3':
                            window.filterObj.availability['wednesday'] = true
                            break;
                        case '4':
                            window.filterObj.availability['thursday'] = true
                            break
                        case '5':
                            window.filterObj.availability['friday'] = true
                        case '6':
                            window.filterObj.availability['saturday'] = true
                            break;
                        case '7':
                            window.filterObj.availability['sunday'] = true
                            break;
                        default:

                            document.getElementById('filterDays').selectedIndex = -1
                            document.getElementById('filterDays').parentElement.dataset.filter = '0'

                            if (document.getElementById('filterDays').parentElement.getElementsByClassName('redDot')[0]) {
                                eventFire(document.getElementById('filterDays').parentElement.getElementsByClassName('redDot')[0], 'click')
                            }

                            delete window.filterObj.availability

                    }

                    break;
                case 'filterLanguage':

                    window.filterObj['language_id'] = [that.value]

                    break
            }

            if (!this.parentElement.getElementsByClassName('redDot')[0]) {
                if (!this.parentElement.classList.contains('typers')) {
                    addRedDotForCloseDropdownFilters(this)
                } else {


                }

            }








            if (document.body.className === "talkCategorySubcategory") {
                /* displayTalksSmallFilter(0, 3) */
            } else {
                /* displayTalksSmallFilter(0, 3, document.body.className) */
            }

        })

    }
}

function addRedDotForCloseDropdownFilters(that, pointer) {
    if (that.getElementsByClassName('redDot')[0]) {

    } else {
        let redDot = document.createElement('div')
        redDot.textContent = '✕'
        redDot.className = 'redDot'
        pointer ? that.appendChild(redDot) : that.parentElement.appendChild(redDot)
        pointer ? that.dataset.filter = '1' : that.parentElement.dataset.filter = '1'
        let style = document.createElement('style')
        style.className = "dynamicStyle"
        style.innerHTML = '#' + that.id + '{background-image: none;}'
        pointer ? that.appendChild(style) : that.parentElement.appendChild(style)

        redDot.addEventListener('click', clearRedDotEvent)
    }

}

function clearRedDotEvent(e) {
    e.stopPropagation()
    let that = e.currentTarget

    if (that.parentElement.getElementsByTagName('style')[0]) {
        that.parentElement.getElementsByTagName('style')[0].remove()
    }

    that.parentElement.dataset.filter = '0'

    that.parentElement.getElementsByTagName('select')[0].setAttribute('style', 'height:0px')
    that.parentElement.getElementsByClassName('arrowSvgz')[0].getElementsByTagName('svg')[0].style.transform = 'scale(1,1)'
    that.parentElement.dataset.clicked = '0'

    that.parentElement.getElementsByTagName('select')[0].selectedIndex = -1

    switch (that.parentElement.getElementsByTagName('select')[0].id) {
        case 'filterDuration':

            window.filterObj.duration = []

            let durationFilters = document.getElementById('durationFilters').getElementsByTagName('input')

            for (let i = 0; i < durationFilters.length; i++) {
                durationFilters[i].checked = false
                durationFilters[i].dataset.checked2 = 0
                durationFilters[i].dataset.clicked = 0
                durationFilters[i].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(140, 151, 172)'

            }

            let lengthAvailability = document.getElementById('lengthAvailability')?.getElementsByClassName('filterLengthBadge')
            if (lengthAvailability) {
                for (let i = 0; i < lengthAvailability.length; i++) {
                    lengthAvailability[i].dataset.checked2 = 0
                    lengthAvailability[i].dataset.checked = 0
                    lengthAvailability[i].classList.remove('active')
                }
            }


            break;
        case 'filterTypes':
            window.filterObj.talks = { video: false, voice: false }

            let typeFilters = document.getElementById('typeFilters').getElementsByTagName('input')

            for (let i = 0; i < typeFilters.length; i++) {
                typeFilters[i].checked = false
                typeFilters[i].dataset.checked2 = 0
                typeFilters[i].dataset.clicked = 0
                typeFilters[i].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(140, 151, 172)'

            }

            let filterType = document.getElementsByClassName('filterType')[0].getElementsByClassName('filterTypeBadge')

            for (let i = 0; i < filterType.length; i++) {
                filterType[i].dataset.checked2 = 0
                filterType[i].dataset.checked = 0
                filterType[i].dataset.clicked = 0
                filterType[i].classList.remove('active')
            }

            break;
        case 'filterDays':
            window.filterObj.availability = {
                "monday": false,
                "tuesday": false,
                "wednesday": false,
                "thursday": false,
                "friday": false,
                "saturday": false,
                "sunday": false
            }

            let availabilityFilters = document.getElementById('availabilityFilters').getElementsByTagName('input')

            for (let i = 0; i < availabilityFilters.length; i++) {
                availabilityFilters[i].checked = false
                availabilityFilters[i].dataset.checked2 = 0
                availabilityFilters[i].dataset.clicked = 0
                availabilityFilters[i].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(140, 151, 172)'

            }

            let avaSmallFilter = document.getElementsByClassName('avaSmallFilter')[0]?.getElementsByClassName('filterDayBadge')
            if (avaSmallFilter) {
                for (let i = 0; i < avaSmallFilter.length; i++) {
                    avaSmallFilter[i].dataset.checked2 = 0
                    avaSmallFilter[i].dataset.checked = 0
                    avaSmallFilter[i].classList.remove('active')
                }
            }


            break
        case 'filterLanguage':
            delete window.filterObj.language_id

            if (document.getElementById('checkLanguageMobile')) {
                let checkLanguageMobile = document.getElementById('checkLanguageMobile')
                checkLanguageMobile.checked = false
                checkLanguageMobile.parentElement.dataset.clicked = "0"
                if (document.getElementById('languageGg')) {
                    document.getElementById('languageGg').style.cssText = 'left:300px; opacity:0.4;'

                }

            }

            if (document.getElementById('languageDeskFilters')?.getElementsByTagName('input')) {
                let languageDeskFilters = document.getElementById('languageDeskFilters').getElementsByTagName('input')

                for (let i = 0; i < languageDeskFilters.length; i++) {

                    languageDeskFilters[i].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(140, 151, 172)'

                    languageDeskFilters[i].parentElement.getElementsByTagName('label')[0].classList.remove('clicked')

                    if (languageDeskFilters[i].dataset.id === "33") {
                        languageDeskFilters[i].checked = true
                        languageDeskFilters[i].parentElement.getElementsByTagName('label')[0].style.color = 'rgb(23, 43, 77)'
                    }

                }

                if (document.getElementById('languageDeskFilters')) {
                    document.getElementById('languageDeskFilters').style.maxHeight = '62px'
                }

                if (document.getElementById('languageFilterEnableDisable')) {
                    document.getElementById('languageFilterEnableDisable').dataset.enabled = '0'
                }

                if (document.getElementsByClassName('svgLanguageFilterCor')[0]) {
                    document.getElementsByClassName('svgLanguageFilterCor')[0].style.transform = 'rotate(90deg) scale(1, 1)'
                }


            }

    }


    that.remove()
    document.getElementsByClassName('dynamicStyle')[0]?.remove()
    //set other filters



    if (document.body.className === "talkCategorySubcategory") {
        /*  displayTalksSmallFilter(0, 3) */
    } else {
        /* displayTalksSmallFilter(0, 3, document.body.className) */
    }



}
(function () {
    initFilters()
})()
