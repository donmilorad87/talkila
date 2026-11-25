class TopHeader {

    constructor() {

        this.closeTopHeader()
    }

    closeTopHeader() {
        if( document.getElementsByClassName('ptbo')[0]){

            document.body.addEventListener('scroll', this.onScrollEvent)

            document.getElementsByClassName('xSingHT')[0].addEventListener('click', () => {

                document.removeEventListener('scroll', this.onScrollEvent)

                if (document.getElementsByClassName('menuIcon')[0]) {

                    if (document.getElementsByClassName('menuIcon')[0].dataset.isOpen === "0") {W

                        this.setMobileNav('-100%')
                    }
                    document.getElementsByClassName('menuIcon')[0].style.top = "1rem"
                } else {
                    this.setMobileNav('0rem')
                    document.getElementsByClassName('ptbo')[0].style.top = '0'
                }

                document.getElementsByClassName('ptbo')[0].style.top = "-184px"
                document.getElementsByTagName('header')[0].style.top = "0px"

                setTimeout(function () {
                    document.getElementsByClassName('ptbo')[0].parentNode.removeChild(document.getElementsByClassName('ptbo')[0]);

                }, 310)

                if (document.body.className === 'jtc2_create_profile') {
                    window.closedTopHeader = 1
                    document.getElementById('firstHeader').style.top = '0px'
                }


            })
        }





    }

    onScrollEvent() {
        if( document.getElementsByClassName('ptbo')[0]){

            if (document.body.scrollTop > 150) {

                document.getElementsByClassName('ptbo')[0].style.top = '0'
            } else {

                document.getElementsByClassName('ptbo')[0].style.top = '-200px'


            }
        }


    }

    setMobileNav(value) {
        if( document.getElementsByClassName('ptbo')[0]){

        }  if (document.getElementsByClassName('mobileNav')[0]) {
            document.getElementsByClassName('mobileNav')[0].style.right = value
        }

    }

}



(function () {
    let topHeader = new TopHeader()
})()
