

function getRole() {
    return window.currentUser ? window.currentUser.role : null;
}

async function signout() {
    try {
        
        await fetch("/api/logout.php", {
            method: "POST",
            credentials: "include" 
        });
    } catch (e) {
        console.error("Erreur logout:", e);
    }

    // Mettre à jour l’état du front
    window.currentUser = null;

    // Recharge la page pour refléter l’état déconnecté
    window.location.reload();
}


function isConnected() {
    return window.currentUser !== null;
}

function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {   
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function showAndHideElementsForRoles() {
    const userConnected = isConnected();
    const role = getRole();

    let allElementsToEdit = document.querySelectorAll('[data-show]');

    allElementsToEdit.forEach(element => {
        switch(element.dataset.show) {
            case 'disconnected': 
                if (userConnected) element.classList.add("d-none");
                break;
            case 'connected': 
                if (!userConnected) element.classList.add("d-none");
                break;
            case 'ROLE_ADMIN': 
            case 'ROLE_EMPLOYE':
            case 'ROLE_CHAUFFEUR':
            case 'ROLE_PASSAGER':
                if (!userConnected || role !== element.dataset.show) {
                    element.classList.add("d-none");
                }
                break;
        }
    });
}

console.log(isConnected() ? "Utilisateur connecté" : "Utilisateur non connecté");
