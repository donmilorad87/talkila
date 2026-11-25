/* import {removeDots} from './dotNavigation.js' */

export function scrollToTop() {

    document.body.addEventListener('scroll', function(e) {

        if (document.body.scrollTop > 400) {
            document.getElementById('scroller').style.opacity = 1
        } else {
            document.getElementById('scroller').style.opacity = 0
        }
    })

    document.getElementById('scroller').addEventListener('click',function(){


        document.getElementsByTagName('html')[0].style.scrollBehavior = 'smooth'
        setTimeout(function(){
            document.body.scrollTo(0, 0)
        })
        setTimeout(function(){
            document.getElementsByTagName('html')[0].style.scrollBehavior = 'unset'
        },310)
    })

}

