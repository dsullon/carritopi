<?php

$db = @mysqli_connect('localhost', 'iestpffaa', '@125$FFAA', 'dep_tienda');


if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
