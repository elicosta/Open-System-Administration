<?php
$arquivo = fopen('/etc/named.sql.zones','w');
fwrite($arquivo, "oi");
fclose($arquivo);
?>