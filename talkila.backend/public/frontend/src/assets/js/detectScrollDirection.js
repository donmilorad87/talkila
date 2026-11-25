let sliders = [document.getElementById('sliderDesktop-One'), document.getElementById('sliderDesktop-Two')/* , document.getElementById('sliderDesktop-Three') */]

window.scrollPos = 0;
window.scrolPositionHelperDirection = '';
window.scrolPositionHelper = 0;

export function scrollDirection() {

    for (let i = 0; i < sliders.length; i++) {

        sliders[i].getElementsByClassName('owl-carousel')[0].addEventListener('mouseenter', scrollDirectionDetect, { passive: false });

    }
}

function scrollDirectionDetect(e) {

    this.addEventListener("wheel", detetctScrollUpDown, { passive: false });
    this.addEventListener('mouseleave', mouseLeaveEvent, { passive: false });

}



function detetctScrollUpDown(e) {

    e.preventDefault()
    e.stopPropagation()

    if (e.deltaY < 0) {


        if (window.scrolPositionHelperDirection === "down") {
            window.setOne = 0
            window.scrolPositionHelper = 0
            window.scrolPositionHelper++
            window.scrolPositionHelperDirection = "up"
        }

        if (window.scrolPositionHelper > 2) {

            window.scrolPositionHelper = 0
            selectCarousel(this)
        }
        window.scrolPositionHelper++
        window.scrolPositionHelperDirection = "up"
    }
    else if (e.deltaY > 0) {

        if (window.scrolPositionHelperDirection === "up") {
            window.setThree = 0
            window.scrolPositionHelper = 0
            window.scrolPositionHelper++
            window.scrolPositionHelperDirection = "down"
        }

        if (window.scrolPositionHelper > 2) {

            selectCarousel(this)
            window.scrolPositionHelper = 0
        }
        window.scrolPositionHelper++
        window.scrolPositionHelperDirection = "down"
    }

}
window.setOne = 0
window.setThree = 0

function selectCarousel(x) {

    switch (x.id) {
        case 'slider-one':
            if (window.scrolPositionHelperDirection === "up") {

                jQuery('#slider-one').trigger('prev.owl');
                if (document.getElementById('carousel-one').getElementsByClassName('one')[0].className.indexOf('active') !== -1) {

                    window.setOne++
                    if (window.setOne > 2) {
                        document.getElementById('slider-one').removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
                        document.getElementById('slider-one').removeEventListener("wheel", detetctScrollUpDown, { passive: false });
                        window.setOne = 0
                    }

                }

            } else if (window.scrolPositionHelperDirection === "down") {

                jQuery('#slider-one').trigger('next.owl');
                if (document.getElementById('carousel-one').getElementsByClassName('three')[0].className.indexOf('active') !== -1) {

                    window.setThree++

                    if (window.setThree > 2) {
                        document.getElementById('slider-one').removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
                        document.getElementById('slider-one').removeEventListener("wheel", detetctScrollUpDown, { passive: false });
                        window.setThree = 0
                    }
                }
            }
            break
        case 'slider-two':
            if (window.scrolPositionHelperDirection === "up") {

                jQuery('#slider-two').trigger('prev.owl');
                if (document.getElementById('carousel-two').getElementsByClassName('one')[0].className.indexOf('active') !== -1) {

                    window.setOne++
                    if (window.setOne > 2) {
                        document.getElementById('slider-two').removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
                        document.getElementById('slider-two').removeEventListener("wheel", detetctScrollUpDown, { passive: false });
                        window.setOne = 0
                    }

                }
            } else if (window.scrolPositionHelperDirection === "down") {

                jQuery('#slider-two').trigger('next.owl');
                if (document.getElementById('carousel-two').getElementsByClassName('three')[0].className.indexOf('active') !== -1) {

                    window.setThree++

                    if (window.setThree > 2) {
                        document.getElementById('slider-two').removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
                        document.getElementById('slider-two').removeEventListener("wheel", detetctScrollUpDown, { passive: false });
                        window.setThree = 0
                    }
                }
            }
            break
        case 'testimonial':
            if (window.scrolPositionHelperDirection === "up") {

                jQuery('#testimonial').trigger('prev.owl');
                if (document.getElementsByClassName('firster')[0].parentNode.className.indexOf('active') !== -1) {

                    window.setThree++

                    if (window.setThree > 2) {
                        document.getElementById('testimonial').removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
                        document.getElementById('testimonial').removeEventListener("wheel", detetctScrollUpDown, { passive: false });
                        window.setThree = 0
                    }
                }
            } else if (window.scrolPositionHelperDirection === "down") {

                jQuery('#testimonial').trigger('next.owl');
                if (document.getElementsByClassName('laster')[0].parentNode.className.indexOf('active') !== -1) {

                    window.setThree++

                    if (window.setThree > 2) {
                        document.getElementById('testimonial').removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
                        document.getElementById('testimonial').removeEventListener("wheel", detetctScrollUpDown, { passive: false });
                        window.setThree = 0
                    }
                }

            }
    }

}

function mouseLeaveEvent(e) {
    e.target.removeEventListener('mouseleave', mouseLeaveEvent, { passive: false })
    e.target.removeEventListener("wheel", detetctScrollUpDown, { passive: false });
}

