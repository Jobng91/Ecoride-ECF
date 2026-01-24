import Route from "./route.js";

//Définir ici vos routes
export const allRoutes = [
    new Route("/", "Accueil", "/pages/home.html", "/js/home.js", "/css/home.css", []),
    new Route("/test-auth", "Test Auth", "/pages/test-auth.html", "/js/test-auth.js","/css/test-auth.css", []),


];
    
//Le titre s'affiche comme ceci : Route.titre - websitename
export const websiteName = "EcoRide";