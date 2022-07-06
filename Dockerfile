FROM mariadb:10.8.3

# there is already `#bind-address=0.0.0.0` in /etc/mysql/my.cnf
# we use sed and replace it with `bind-address=0.0.0.0`)
RUN sed -i "s/#bind-address=0.0.0.0/bind-address=0.0.0.0/g" /etc/mysql/my.cnf && \
    # and, for example, lets change `max_allowed_packet` too.
    sed -i "s/max_allowed_packet.*/max_allowed_packet=512M/g" /etc/mysql/my.cnf;
