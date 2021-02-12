FROM rabbitmq:3.6

RUN apt-get update -y && apt-get install -y netcat vim wget python

ADD scripts /scripts
RUN chmod +x /scripts/*.sh
CMD /scripts/init.sh
