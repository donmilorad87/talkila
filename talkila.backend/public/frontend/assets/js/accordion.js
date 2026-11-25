let accordions
let myObserver
document.getElementsByClassName("ac")[0] ? accordions = document.getElementsByClassName("ac") : false

function openAcc(accordionElement) {


    accordionElement.dataset.acOpen = '1'
    accordionElement.classList.add('openedAccordion')
    accordionElement.getElementsByTagName('svg')[0].style.transform = 'rotate(90deg)'


    accordionElement.getElementsByClassName("acceptedAnswer")[0].style.height  = accordionElement.getElementsByTagName('p')[0].offsetHeight+16 + 'px'


    accordionElement.getElementsByTagName('p')[0].addEventListener('click', openAccHelper)
    accordionElement.getElementsByTagName('p')[0].addEventListener('mouseup', openAccHelper2)
    accordionElement.getElementsByTagName('p')[0].addEventListener('dblclick', openAccHelper3)

    let accordionElementP = accordionElement.getElementsByTagName('p')[0]

    function throttle(f, delay) {
        let timer = 0;
        return function(...args) {
            clearTimeout(timer);
            timer = setTimeout(() => f.apply(this, args), delay);
        }
    }


     myObserver = new ResizeObserver(entries => {
        entries.forEach(throttle(entry => {

          accordionElement.getElementsByClassName("acceptedAnswer")[0].style.height  = entry.contentRect.height+16+ 'px'
        }),100)
      })


    myObserver.observe(accordionElementP)

}

function openAccHelper(e) {
    e.preventDefault();
    e.stopPropagation();

}

function openAccHelper2(e) {

    e.preventDefault();
    e.stopPropagation();

}

function openAccHelper3(e) {

    closeAccordion(e.target.parentNode.parentNode, 1)

}

function accordion_faq() {


    for (let i = 0; i < accordions.length; i++) {
        accordions[i].addEventListener("click", function () {


            if (this.dataset.acOpen === '1') {

                closeAccordion(this)

            } else if (this.dataset.acOpen === '0'){
                if (document.getElementsByClassName('openedAccordion')[0]) {
                    closeAccordion(accordions[document.getElementsByClassName('openedAccordion')[0].dataset.number])
                    openAcc(this)


                } else {
                    openAcc(this)

                }


            }

        })
    }



}





function closeAccordion(accordionElement) {
    myObserver.disconnect()
    accordionElement.dataset.acOpen = '0'
    accordionElement.classList.remove('openedAccordion')
    accordionElement.getElementsByTagName('svg')[0].style.transform = 'rotate(0deg)'


    accordionElement.getElementsByClassName("acceptedAnswer")[0].style.height  = '0px'

    accordionElement.getElementsByTagName('p')[0].removeEventListener('click', openAccHelper)

    accordionElement.getElementsByTagName('p')[0].removeEventListener('mouseup', openAccHelper)
    accordionElement.getElementsByTagName('p')[0].removeEventListener('dblclick', openAccHelper2)
}


(function () {
    if (document.getElementsByClassName("ac")[0]) {
        accordion_faq()
    }

})()
