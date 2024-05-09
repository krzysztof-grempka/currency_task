FROM nginx:1.24-alpine

ARG TIMEZONE
ENV TZ=$TIMEZONE

RUN apk add --no-cache bash tzdata
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone