(function () {
    let gropings = document.getElementsByClassName('gropings')[0]
    let groupC = document.getElementsByClassName('groupC')[0]
    let privateC = document.getElementsByClassName('privateC')[0]
    let bMySlotsButtons = document.getElementsByClassName('bMySlotsButtons')[0]
    let buttons = document.getElementsByClassName('bMySlotsButtonsCont')
    let bottomLine = document.getElementsByClassName('buttonLine')[0]

    for (let i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener('click', function () {

            if (this.dataset.pointer === "gc") {
                if (document.body.className !== "settings_reviews") {
                    if (document.getElementsByClassName('gropings')[0]) {
                        gropings.style.height = bMySlotsButtons.offsetHeight + groupC.offsetHeight + 25 + 'px'
                    }
                }


                this.classList.add('active')
                buttons[0].classList.remove('active')

                if (document.body.className === "settings_reviews") {
                    bottomLine.style.left = "calc(50% - 2px)"
                } else {
                    bottomLine.style.left = "50%"
                }

                groupC.style.left = "0"
                privateC.style.left = "200%"

                if (document.body.className === "book_slot") {
                    gropings.style.height = '560px'
                }


                if (document.body.className !== "profile" && document.body.className !== "settings_reviews") {
                    setTimeout(function () {
                        if (document.getElementById("talkInputG")) {
                            document.getElementById("talkInputG").focus()
                        }
                        if (document.getElementById('group-talk-form')) {
                            document.getElementById('group-talk-form').getElementsByTagName('textarea')[0].style.height = '120px'
                        }

                    }, 310)
                }
                if (document.body.className === 'about_me') {
                    document.getElementById('aboutMeContaR').style.height =
                        document.getElementsByClassName('bMySlotsButtons')[0].offsetHeight + document.getElementsByClassName('groupC')[0].offsetHeight + 'px'
                }


            } else if (this.dataset.pointer === "pc") {
                if (document.body.className !== "settings_reviews") {
                    if (document.getElementsByClassName('gropings')[0]) {
                        gropings.style.height = bMySlotsButtons.offsetHeight + privateC.offsetHeight + 25 + 'px'
                    }
                }

                this.classList.add('active')
                buttons[1].classList.remove('active')

                bottomLine.style.left = "0%"

                if (document.body.className === "settings_reviews") {
                    bottomLine.style.left = "2px"
                } else {
                    bottomLine.style.left = "0%"
                }

                groupC.style.left = "-200%"
                privateC.style.left = "0%"

                if (document.body.className === "book_slot") {
                    gropings.style.height = '316px'
                }


                if (document.body.className !== "profile" && document.body.className !== "settings_reviews") {
                    setTimeout(function () {
                        if (document.getElementById("talkInputP")) {
                            document.getElementById("talkInputP").focus()
                        }
                        if (document.getElementById('private-talk-form')) {
                            document.getElementById('private-talk-form').getElementsByTagName('textarea')[0].style.height = '120px'
                        }
                    }, 310)
                }

                if (document.body.className === 'about_me') {
                    document.getElementById('aboutMeContaR').style.height =
                        document.getElementsByClassName('bMySlotsButtons')[0].offsetHeight + document.getElementsByClassName('privateC')[0].offsetHeight + 'px'
                }

            }
        })
    }
})();
