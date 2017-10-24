FROM nginx:latest
COPY nginx.conf /etc/nginx/
COPY site.conf /etc/nginx/conf.d/default.conf

RUN usermod -u 1000 www-data

CMD ["nginx"]

EXPOSE 80
EXPOSE 443
