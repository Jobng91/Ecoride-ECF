export default class Route {
  constructor(url, title, pathHtml, pathJS = "", pathCSS = "", authorize = []) {
    this.url = url;
    this.title = title;
    this.pathHtml = pathHtml;
    this.pathJS = pathJS;
    this.pathCSS = pathCSS;
    this.authorize = authorize;
  }
}

/*
[] -> tout le monde
["disconnected"] -> uniquement déconnectés
["ROLE_PASSAGER"] -> uniquement passagers
["ROLE_ADMIN"] -> uniquement admins
["ROLE_ADMIN", "ROLE_EMPLOYE"] -> admin OU employé
*/
