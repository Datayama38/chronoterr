FROM node:lts-alpine as builder

WORKDIR /app

COPY ./front .

ARG VITE_BACK_URL
ARG VITE_MAPBOX_KEY

RUN npm install --progress=false && npm run build

FROM nginx:alpine
# Set working directory to nginx asset directory
WORKDIR /usr/share/nginx/html
# Remove default nginx static assets
RUN rm -rf ./*
# Copy static assets from builder stage
COPY --from=builder /app/dist .
COPY ./docker/prod/front/nginx.conf /etc/nginx/nginx.conf
# Containers run nginx with global directives and daemon off
ENTRYPOINT ["nginx", "-g", "daemon off;"]