
    # Installation Node.js
    FROM node:20

    # Définition du dossier de travail
    WORKDIR /app-frontend

    # Copie des fichiers nécessaires pour installer les dépendances
    COPY package*.json ./

    # Installation des dépendances NPM
    RUN npm install


    # 5️⃣ Copier le reste du code du projet
    COPY . .

    # 6️⃣ Exposer le port du serveur de dev (souvent 5173 pour Vite, 3000 pour React)
    EXPOSE 3000

    # 7️⃣ Lancer le serveur de développement
    CMD ["npm", "run", "dev"]
