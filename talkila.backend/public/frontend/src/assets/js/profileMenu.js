export function openProfileMenu() {


    if (document.getElementById('profile-menu')) {
        document.getElementById('profile-menu').addEventListener('click', function (e) {
            e.preventDefault()
            e.stopImmediatePropagation()
            e.stopPropagation()
        })
    }

    if (document.getElementsByClassName('linkTopProfileDropdown')[0]) {
        document.getElementsByClassName('linkTopProfileDropdown')[0].addEventListener('click', function () {
            closeMainDropdownMenu()
            location.href = this.href
        })
    }

    if (document.getElementById('profile-menuParent')) {
        if (document.getElementById('profile-menuParent').getElementsByClassName('menu-bar')[0]) {
            let allDropdownMenuBars = document.getElementById('profile-menuParent').getElementsByClassName('menu-bar')
            for (let i = 0; i < allDropdownMenuBars.length; i++) {
                let liItemsWithATag = allDropdownMenuBars[i].getElementsByTagName('li')
                for (let i = 0; i < liItemsWithATag.length; i++) {
                    liItemsWithATag[i].addEventListener('click', function () {
                        if (this.getElementsByTagName('a')[0]) {

                            closeMainDropdownMenu()
                            location.href = this.getElementsByTagName('a')[0].href

                        } else {

                            closeMainDropdownMenu()
                        }
                    })
                }
            }
        }
    }


    if (document.getElementsByClassName('closeDropDownMenu')[0]) {
        let closeDropDownMenu = document.getElementsByClassName('closeDropDownMenu')[0]
        closeDropDownMenu.addEventListener('click', function (e) {
            closeMainDropdownMenu()
        })
    }


    if (document.getElementsByClassName('profile-area2')[0] && document.getElementById('profile-img')) {

        document.getElementsByClassName('profile-area2')[0].addEventListener('click', function () {

            let profileMenu = document.getElementById('profile-menuParent')
            let profileMenuChild = document.getElementById('profile-menu')

            if (this.dataset.opened === "0") {


                profileMenu.style.display = "block"

                setTimeout(function () {
                    profileMenu.style.opacity = '1'

                    profileMenuChild.style.top =    "0px"

                })

                this.dataset.opened = 1

                document.addEventListener('keydown', pressEscape, false)
                document.addEventListener('click', checkIfIsInOptionButton, false)

            } else {

                closeMainDropdownMenu()
            }

        })
    }
}

function closeMainDropdownMenu() {

    let languageCell = document.getElementsByClassName('languageCell')
    let languageList = document.getElementsByClassName('languageList')[0]

    if (languageCell[0].dataset.opened === "1") {
        languageList.style.height = '0px'
        languageList.style.border = '1px solid transparent'
        languageList.style.boxShadow = 'inset 0 0 0 0px rgba(6, 4, 3, 0.1)'
        languageCell[0].dataset.opened = 0
    }

    document.getElementById('profile-menu').style.top = "-1000px"


    setTimeout(function () {
        document.getElementsByClassName('profile-area2')[0].dataset.opened = "0"
        document.getElementById('profile-menuParent').style.opacity = '0'
        setTimeout(function () {
            document.getElementById('profile-menuParent').style.display = 'none'
        }, 310)
    }, 10)
    document.removeEventListener('click', checkIfIsInOptionButton, false)
    document.removeEventListener('keydown', pressEscape, false)

    if(document.getElementById('mainLanguageCell')){
        if(document.getElementById('mainLanguageCell').getElementsByClassName('rotate90')[0]){
            document.getElementById('mainLanguageCell').getElementsByClassName('rotate90')[0].style.transform = 'rotate(90deg) scale(1, 1)'
        }
    }
}

function checkIfIsInOptionButton(event) {

    if (event.currentTarget.id === "profile-menuParent" || event.currentTarget.className === "closeDropDownMenu") {
        closeMainDropdownMenu()
    }


}

function pressEscape(e) {

    if (e.key === "Escape") {
        closeMainDropdownMenu()
    }
}
