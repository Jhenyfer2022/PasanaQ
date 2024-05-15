FROM nginx:1.25

WORKDIR /workspace

ENV TZ=America/La_Paz

# Copia el archivo default a mi conf.d que es configuraciones de dns y otros
COPY ./infra/docker/nginx/default.conf /etc/nginx/conf.d/
# Copia tu archivo de configuración personalizado a la ubicación correcta
COPY ./infra/docker/nginx/nginx.conf /etc/nginx/nginx.conf