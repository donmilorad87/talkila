

export function mobileMenu() {

    if (document.getElementsByClassName('mobileNav')[0]) {
        var mobileNavElement = document.getElementsByClassName('mobileNav')[0]
        if (document.getElementsByClassName('ptbo')[0] && window.scrollY > 150) {
            mobileNavElement.style.cssText = 'height:calc(100% - 84px);top:84px;'
        } else {
            mobileNavElement.style.cssText = 'height:100vh'
        }

        if (document.getElementsByClassName('menuIconCont')[0]) {


            document.getElementsByClassName('menuIconCont')[0].addEventListener('click', function () {
                document.getElementsByClassName('menuIconCont')[0].style.pointerEvents = 'none'
                if (document.getElementsByClassName('menuIcon')[0].dataset.isOpen === "0") {

                    document.getElementsByClassName('menuIcon')[0].style.cssText = 'position:fixed;right:32px;'

                    if (document.getElementsByClassName('langCont')[0]) {
                        document.getElementsByClassName('langCont')[0].style.right = '36px'
                    }

                    let appendStyle = document.createElement('div')
                    appendStyle.id = 'appendStyle'
                    appendStyle.innerHTML = '<style>.menuIcon:before{transform: translateY(6px) rotate(135deg)!important;}.menuIcon:after{transform: translateY(-6px) rotate(-135deg)!important;}.menuIcon div{transform: scale(0)!important;}</style>'

                    document.body.insertBefore(appendStyle, document.body.firstChild)

                    if (!document.getElementsByClassName('menuBackgroundMobile')[0]) {
                        let menuBackground = document.createElement('div')
                        menuBackground.setAttribute('class', 'menuBackgroundMobile')

                        document.getElementsByClassName('mHeader')[0].append(menuBackground)
                    } else {
                        document.getElementsByClassName('menuBackgroundMobile')[0].style.zIndex = '10'
                    }


                    setTimeout(function () {
                        document.getElementsByClassName('menuBackgroundMobile')[0].style.opacity = '1'

                        mobileNavElement.style.right = '0rem'

                        mobileNavElement.dataset.mobileOpen = 1


                    }, 10)
                    setTimeout(function () {
                        document.getElementsByClassName('menuIconCont')[0].style.pointerEvents = 'all'
                    }, 510)
                    document.getElementsByClassName('menuBackgroundMobile')[0].addEventListener('click', closeMenu)
                    document.getElementsByClassName('menuIcon')[0].dataset.isOpen = 1
                }
                else {
                    closeMenu()
                }
            })
        }

    }



}


export function menuResponsiveCheck() {
    if (document.getElementsByClassName('menuIcon')[0]) {
        if (document.getElementsByClassName('menuIcon')[0].dataset.isOpen === "1") {
            if (window.innerWidth > 639) {
                closeMenu()
            }
        }
    }
}

function closeMenu() {
    document.getElementsByClassName('menuIconCont')[0].style.pointerEvents = 'none'
    document.getElementsByClassName('menuIcon')[0].style.cssText = 'position:relative;right:0rem; transition:0s;'
    document.getElementsByClassName('langCont')[0].style.right = '0px'
    if (document.getElementById('appendStyle')) {
        document.getElementById('appendStyle').parentNode.removeChild(document.getElementById('appendStyle'))
    }
    document.getElementsByClassName('menuBackgroundMobile')[0].style.opacity = '0'
    setTimeout(function () {
        document.getElementsByClassName('menuBackgroundMobile')[0].parentElement?.removeChild(document.getElementsByClassName('menuBackgroundMobile')[0])
        document.getElementsByClassName('menuIconCont')[0].style.pointerEvents = 'all'
    }, 510)
    mobileNavElement.style.right = '-100%'

    document.getElementsByClassName('menuIcon')[0].dataset.isOpen = 0

}
