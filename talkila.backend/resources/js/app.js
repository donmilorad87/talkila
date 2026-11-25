/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 /* require('./bootstrap'); */

/* window.Vue = require('vue'); */

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/* Vue.component('example-component', require('./components/ExampleComponent.vue').default); */

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/* const app = new Vue({
    el: '#app',
}); */

import Page from './Page.js'

const page = {}
page.instance = new Page('Home')

if (document.getElementById('collapseButtonZ')) {
    /*  document.getElementById('collapseButtonZ').addEventListener('click', function() {
         if (this.dataset.opened === "0") {

             document.getElementById('collapseExample').style.maxHeight = document.getElementById('collapseExample').getElementsByTagName('h3')[0].offsetHeight + document.getElementById('collapseExample').getElementsByClassName('card')[0].offsetHeight+ 'px'
             document.getElementById('collapseExample').getElementsByTagName('button')[0].style.transform = "rotate(90deg) scale(-1, 1)"

             this.dataset.opened = 1
         } else if (this.dataset.opened === "1") {

             document.getElementById('collapseExample').style.maxHeight = '54px'
             document.getElementById('collapseExample').getElementsByTagName('button')[0].style.transform = "rotate(90deg) scale(1, 1)"

             this.dataset.opened = 0
         }
     }) */
     document.getElementById('collapseButtonZ').parentElement.parentElement.addEventListener('click', function() {
         if (document.getElementById('collapseButtonZ').dataset.opened === "0") {

             document.getElementById('collapseExample').style.maxHeight = document.getElementById('collapseExample').getElementsByTagName('h3')[0].offsetHeight + document.getElementById('collapseExample').getElementsByClassName('card')[0].offsetHeight+ 'px'
             document.getElementById('collapseExample').getElementsByTagName('button')[0].style.transform = "rotate(90deg) scale(-1, 1)"

             document.getElementById('collapseButtonZ').dataset.opened = 1
         } else if (document.getElementById('collapseButtonZ').dataset.opened === "1") {

             document.getElementById('collapseExample').style.maxHeight = '54px'
             document.getElementById('collapseExample').getElementsByTagName('button')[0].style.transform = "rotate(90deg) scale(1, 1)"

             document.getElementById('collapseButtonZ').dataset.opened = 0
         }
     })
 }

 if (document.getElementsByClassName('copyText')[0]) {

     let copyTexts = document.getElementsByClassName('copyText')
     for (let i = 0; i < copyTexts.length; i++) {
         copyTexts[i].addEventListener('click', function copyTextToClipboard() {
             let copyText = document.getElementById('profile-path-holder1')

             copyText.select()
             copyText.setSelectionRange(0, 99999)

             try {
                 navigator.clipboard.writeText(copyText.value)
                 toastNotification(getPoTranslate('COPIED_TO_CLIPBOARD'))

             } catch (error) {
                 console.log(new TryCatchCopyURLPathError(error))
             }
         })
     }

     class TryCatchCopyURLPathError extends Error {
         constructor(message) {
             super(message)
             this.name = "TryCatchCopyURLPathError"
         }
     }
 }

 function toastNotification(x) {
     let notification = document.createElement('div')
     notification.textContent = x
     notification.className = 'toastifyNot'
     notification.style.right = '-400px'

     document.getElementsByClassName('main-content')[0].appendChild(notification)

     setTimeout(() => {
         notification.style.right = '1rem'
         setTimeout(() => {
             notification.style.right = '-400px'
             setTimeout(() => {
                 notification.remove()
             }, 3110)
         }, 3000)
     })
 }
