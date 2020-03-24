FROM lamp_ubuntu19.10:ver2.0
CMD service mysql start \\
    && service apache2 start\\
    && bash