#FROM nginx:alpine
FROM php:7.4-apache

LABEL author="Laurent BRAU"

# Copy custom nginx config
COPY ./nginx.conf /etc/nginx/nginx.conf

EXPOSE 81 443

ENTRYPOINT ["nginx", "-g", "daemon off;"]