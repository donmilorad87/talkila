export function showHidePassword(){
    let passwordEyes = document.getElementsByClassName('eye-icon-mange')
    for(let i = 0; i < passwordEyes.length; i++){
        passwordEyes[i].addEventListener('click', function(e){
            if(this.dataset.showing === "0"){
                this.parentNode.getElementsByTagName('input')[0].type = 'text'
                this.parentNode.getElementsByTagName('input')[0].focus()
                this.dataset.showing = 1
                this.getElementsByTagName('svg')[0].style.display ="none"
                this.getElementsByTagName('svg')[1].style.display ="block"
            }else{
                this.parentNode.getElementsByTagName('input')[0].type = 'password'
                this.parentNode.getElementsByTagName('input')[0].focus()
                this.dataset.showing = 0
                this.getElementsByTagName('svg')[0].style.display ="block"
                this.getElementsByTagName('svg')[1].style.display ="none"
            }

        })
    }
}

export function showHidePasswordSettings(){
    let passwordEyes = document.getElementsByClassName('eye-icon-mange')
    for(let i = 0; i < passwordEyes.length; i++){
        passwordEyes[i].addEventListener('click', function(e){
            if(this.dataset.showing === "0"){
                this.parentNode.parentNode.getElementsByTagName('label')[0].getElementsByTagName('input')[0].type = 'text'
                this.parentNode.parentNode.getElementsByTagName('label')[0].getElementsByTagName('input')[0].focus()
                this.getElementsByTagName('svg')[0].style.display ="none"
                this.getElementsByTagName('svg')[1].style.display ="block"
                this.dataset.showing = 1
            }else{
                this.parentNode.parentNode.getElementsByTagName('label')[0].getElementsByTagName('input')[0].type = 'password'
                this.parentNode.parentNode.getElementsByTagName('label')[0].getElementsByTagName('input')[0].focus()
                this.getElementsByTagName('svg')[0].style.display ="block"
                this.getElementsByTagName('svg')[1].style.display ="none"
                this.dataset.showing = 0
            }

        })
    }
}
