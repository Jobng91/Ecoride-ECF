import Route from "./route.js";
import { allRoutes, websiteName } from "./allRoutes.js";

// --- ROUTE PAR DÉFAUT 404 ---
const route404 = new Route("404", "Page introuvable", "/pages/404.html");

// --- Récupère une route correspondant à l’URL ---
const getRouteByUrl = (url) => {
  let currentRoute = null;
  allRoutes.forEach((element) => {
    if (element.url == url) currentRoute = element;
  });
  return currentRoute || route404;
};

// ----------------------------------------------------------------------
// 🟦 1. Middleware Auth SPA — synchronise front ↔ backend
// ----------------------------------------------------------------------
// ----------------------------------------------------------------------
// 🟦 1. Middleware Auth SPA — synchronise front ↔ backend
// ----------------------------------------------------------------------
async function refreshCurrentUser() {
  try {
    const response = await fetch("/api/me.php", {
      method: "GET",
      credentials: "include" // indispensable pour cookie HttpOnly
    });

    const data = await response.json();

    if (data.success) {
      window.currentUser = data.user;  // injecte l’utilisateur dans le front
    } else {
      window.currentUser = null;
    }
  } catch (error) {
    window.currentUser = null;
  }
}

// 👉 IMPORTANT : rendre la fonction globale
window.refreshCurrentUser = refreshCurrentUser;

// ----------------------------------------------------------------------
// 🟩 2. Chargement d’une page
// ----------------------------------------------------------------------
const LoadContentPage = async () => {

  // 👉 Synchronisation AUTH avant toute logique
  await refreshCurrentUser();

  const path = window.location.pathname;
  const actualRoute = getRouteByUrl(path);

  // --- Vérification des droits ---
  const allRolesArray = actualRoute.authorize;

  if (allRolesArray.length > 0) {

    // Page réservée aux utilisateurs déconnectés
    if (allRolesArray.includes("disconnected")) {
      if (window.currentUser) {
        window.location.replace("/");
        return;
      }
    } 

    // Page réservée à certains rôles
    else {
      const roleUser = window.currentUser ? window.currentUser.role : null;

      if (!roleUser || !allRolesArray.includes(roleUser)) {
        window.location.replace("/");
        return;
      }
    }
  }

  // --- Récupération du HTML ---
  const html = await fetch(actualRoute.pathHtml).then((data) => data.text());
  document.getElementById("main-page").innerHTML = html;

  // --- Chargement du JS de la page ---
  if (actualRoute.pathJS != "") {
    var scriptTag = document.createElement("script");
    scriptTag.setAttribute("type", "text/javascript");
    scriptTag.setAttribute("src", actualRoute.pathJS);
    document.querySelector("body").appendChild(scriptTag);
  }

  // --- Titre de la page ---
  document.title = actualRoute.title + " - " + websiteName;

  // --- Affichage selon rôle ---
  if (typeof showAndHideElementsForRoles === "function") {
    showAndHideElementsForRoles();
  }
};

// ----------------------------------------------------------------------
// 🔵 3. Gestion évènementielle
// ----------------------------------------------------------------------
const routeEvent = (event) => {
  event = event || window.event;
  event.preventDefault();
  window.history.pushState({}, "", event.target.href);
  LoadContentPage();
};

window.onpopstate = LoadContentPage;
window.route = routeEvent;

// ----------------------------------------------------------------------
// 🟣 4. Chargement initial
// ----------------------------------------------------------------------
LoadContentPage();
