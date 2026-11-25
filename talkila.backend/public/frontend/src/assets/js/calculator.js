let elem = [document.getElementById('priceHours'), document.getElementById('hoursQuantity'), document.getElementById('calcPeopleNumber')]
export function calculator() {
  setCalc()
  let x = document.getElementsByClassName('panell')
  for (let i = 0; i < x.length; i++) {
    x[i].addEventListener('click', setCalc, {
      passive: true
    })
  }
  function writeFinalValue(a, b, c, d) {
    if (!c) c = false;
    if (!d) d = false;
    return Math.round(a * b * (c ? c : 1) * (d ? d : 1)).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + ' €'
  }
  function singleCallHelperCalc(x, y, z = false) {
    document.getElementById('result').textContent = writeFinalValue(x, y, (z ? z : false))
    document.getElementById('resultMobile').textContent = writeFinalValue(x, y, (z ? z : false))
    let newPrices = document.getElementsByClassName('newPrice')
    for (let i = 0; i < newPrices.length; i++) {
      newPrices[i].textContent = writeFinalValue(x, y, (z ? z : false), 0.8)
    }
  }
  function setCalc() {
    helper(elem)
  }
  function helper(x) {
    for (let i = 0; i < x.length; i++) {
      if (isIE11) {
        addEvent('change', x[i], function () {
          singleCallHelperCalc(parseInt(x[0].value), parseInt(x[1].value), window.groupCall === 1 ? parseInt(elem[2].value) : 1)
        })
      } else {
        x[i].addEventListener('input', function () {
          singleCallHelperCalc(parseInt(x[0].value), parseInt(x[1].value), window.groupCall === 1 ? parseInt(elem[2].value) : 1)
        })
      }
    }
  }
  let buttons = document.getElementsByClassName('panell')
  for (let i = 0; i < buttons.length; i++) {
    buttons[i].addEventListener('click', function () {
      if (this.className.indexOf('is-active') === -1) {
        if (this.dataset.pointer === "gc") {
          this.style.cssText = 'color:#1D293F; pointer-events:none'
          this.parentNode.getElementsByTagName('li')[0].style.cssText = 'color:#fff; pointer-events:auto; cursor:pointer;'
          document.getElementsByClassName('calcButton')[0].style.left = '50%'
          document.getElementsByClassName('peopleCount')[0].style.cssText = "transition:0.3s; opacity:1; transition-delay:0.1s;pointer-events:auto;"
          window.groupCall = 1
          singleCallHelperCalc(parseInt(elem[0].value), parseInt(elem[1].value), parseInt(elem[2].value))
        } else if (this.dataset.pointer === "pc") {
          this.style.cssText = 'color:#1D293F; pointer-events:none'
          this.parentNode.getElementsByTagName('li')[1].style.cssText = 'color:#fff; pointer-events:auto; cursor:pointer;'
          document.getElementsByClassName('calcButton')[0].style.left = '5px'
          document.getElementsByClassName('peopleCount')[0].style.cssText = "transition:0.3s; opacity:0; transition-delay:0.1s; pointer-events:auto;"
          window.groupCall = 0
          singleCallHelperCalc(parseInt(elem[0].value), parseInt(elem[1].value), 1)
        }
      }
    })
  }
}
function addEvent(evnt, elem, func) {
  if (elem.addEventListener)
    elem.addEventListener(evnt, func, false);
  else if (elem.attachEvent) {
    elem.attachEvent("on" + evnt, func);
  }
  else {
    elem[evnt] = func;
  }
}
