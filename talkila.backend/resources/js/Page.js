export default class Page {

    constructor(pageName) {
      this.pageName = pageName
      this.constructPage()
    }

    constructPage() {
      console.log(this.pageName)
    }

  }
