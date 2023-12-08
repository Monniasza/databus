FROM dockette/nodejs:v16

# Install node.js, Caddy as proxy server, and java.
RUN apk update --no-cache && apk upgrade --no-cache && \
    apk add openjdk17-jre && \
    apk add caddy && \
    node -v && \
    npm -v && \
    caddy help start && \
    java -version

# Disable the proxy server by default:
ENV DATABUS_PROXY_SERVER_ENABLE=false

# When using the proxy, use ACME by default:
ENV DATABUS_PROXY_SERVER_USE_ACME=true

# When not using ACME, what is the name of the own certificate file?
ENV DATABUS_PROXY_SERVER_OWN_CERT="cert.pem"

# When not using ACME, what is the name of the own certificate's key file?
ENV DATABUS_PROXY_SERVER_OWN_CERT_KEY="key.pem"

# What is the hostname of this machine, when using the proxy server?
# It is necessary to know this, in order to set up ACME etc.
# Note: the host name should be identical to DATABUS_RESOURCE_BASE_URL,
# but without specifying a port, protocol i.e. HTTP(S) etc.
ENV DATABUS_PROXY_SERVER_HOSTNAME="my-databus.org"

# Define the volume for the TLS certificate:
VOLUME /tls

COPY ./server /databus/server
COPY ./public /databus/public
COPY ./search /databus/search
COPY ./model/generated /databus/model/generated

COPY ./setup.sh /databus/setup.sh

# Set up the NPM projects:
RUN cd /databus/server && \
    npm install && \
    cd ../public && \
    npm install

WORKDIR /databus
ENTRYPOINT [ "/bin/sh", "./setup.sh" ]
