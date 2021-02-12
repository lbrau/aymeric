#!/bin/bash

/etc/init.d/rabbitmq-server start

# Set up root user
echo "Setting up root user"
RABBITMQ_USER=root
RABBITMQ_PASS=root

rabbitmqctl add_user $RABBITMQ_USER $RABBITMQ_PASS
rabbitmqctl set_user_tags $RABBITMQ_USER administrator
rabbitmqctl set_permissions -p / $RABBITMQ_USER '.*' '.*' '.*'
echo "[default] hostname = 127.0.0.1 port = 15672 username = $RABBITMQ_USER password = $RABBITMQ_PASS" >> ~/.rabbitmqadmin.conf
rabbitmqctl delete_user guest

# Install rabbitmqadmin management plugin
echo "Enabling RabbitMQ Management plugin"
rabbitmq-plugins enable rabbitmq_management
/etc/init.d/rabbitmq-server restart

# Install rabbitmqadmin command line tool
echo "Installing rabbitmqadmin command line tool"
wget -nc http://127.0.0.1:15672/cli/rabbitmqadmin
cp rabbitmqadmin /usr/local/bin/
rm -f rabbitmqadmin
chmod u+x /usr/local/bin/rabbitmqadmin
mkdir /etc/bash_completion.d
echo 'rabbitmqadmin --bash-completion' > /etc/bash_completion.d/rabbitmqadmin

echo "Declaring exchange"
rabbitmqadmin -u $RABBITMQ_USER -p $RABBITMQ_PASS declare exchange name=gallery type=topic durable=true auto_delete=false

echo "Declaring queues and bindings"

echo "GALLERY"
rabbitmqadmin -u $RABBITMQ_USER -p $RABBITMQ_PASS declare queue name=gallery-gallery-email durable=true auto_delete=false
rabbitmqadmin -u $RABBITMQ_USER -p $RABBITMQ_PASS declare binding source=gallery destination=gallery-gallery-email routing_key=gallery.confirm_order_email.sent
rabbitmqadmin -u $RABBITMQ_USER -p $RABBITMQ_PASS declare binding source=gallery destination=gallery-gallery-email routing_key=gallery.new_account_created_email.sent
rabbitmqadmin -u $RABBITMQ_USER -p $RABBITMQ_PASS declare binding source=gallery destination=gallery-gallery-email routing_key=gallery.request_password_email.sent
rabbitmqadmin -u $RABBITMQ_USER -p $RABBITMQ_PASS declare binding source=gallery destination=gallery-gallery-email routing_key=gallery.out_of_stock_product_email.sent
rabbitmqadmin -u $RABBITMQ_USER -p $RABBITMQ_PASS declare binding source=gallery destination=gallery-gallery-email routing_key=gallery.account_created_to_validate_email.sent

/etc/init.d/rabbitmq-server stop

rabbitmq-server
