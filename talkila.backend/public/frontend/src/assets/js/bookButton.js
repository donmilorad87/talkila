export function bookSwitch(){
    let buttons = document.getElementsByClassName('bMySlotsButtonsCont')

    for(let i =0; i< buttons.length; i++){
        buttons[i].addEventListener('click',function(){
            if(this.getElementsByTagName('p')[0].textContent.trim() === "Group Courses"){
                this.parentNode.getElementsByClassName('buttonLine')[0].style.left = "50%"
                this.style.pointerEvents = "none;"
                this.getElementsByTagName('p')[0].style.color = "#1d293f"
                this.parentNode.getElementsByClassName('bMySlotsButtonsCont')[0].style.cssText = " pointer-events:all;"
                this.parentNode.getElementsByClassName('bMySlotsButtonsCont')[0].getElementsByTagName('p')[0].style.color = "#7c8087"
                document.getElementsByClassName('groupC')[0].style.left = "0"
                document.getElementsByClassName('privateC')[0].style.left = "200%"
            }else{
                this.parentNode.getElementsByClassName('buttonLine')[0].style.left = "0%"
                this.style.pointerEvents = "none;"
                this.getElementsByTagName('p')[0].style.color = "#1d293f"
                this.parentNode.getElementsByClassName('bMySlotsButtonsCont')[1].style.cssText = " pointer-events:all;"
                this.parentNode.getElementsByClassName('bMySlotsButtonsCont')[1].getElementsByTagName('p')[0].style.color = "#7c8087"
                document.getElementsByClassName('groupC')[0].style.left = "-200%"
                document.getElementsByClassName('privateC')[0].style.left = "0%"
            }
        })
    }
}