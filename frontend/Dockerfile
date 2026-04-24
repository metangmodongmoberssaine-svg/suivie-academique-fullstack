# ── Étape 1 : Build Angular ──
FROM node:20-alpine AS builder

WORKDIR /app
COPY package*.json ./
RUN npm ci

COPY . .
# Build en mode production
RUN npm run build -- --configuration production

# ── Étape 2 : Servir avec Nginx ──
FROM nginx:alpine AS production

# Supprimer la config Nginx par défaut
RUN rm /etc/nginx/conf.d/default.conf

# Copier la config custom
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf

# Copier les fichiers buildés par Angular
COPY --from=builder /app/dist/*/browser /usr/share/nginx/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
