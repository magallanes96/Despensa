<?php
$serverName = "tcp:memo96.database.windows.net,1433";
$connectionOptions = array(
    "Database" => "SafePass",
    "Uid" => "memo96",
    "PWD" => "Hmcrgl09",
    "Encrypt" => true
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn) {
    echo "✅ Conexión exitosa a la base de datos de Azure SQL Server.";
} else {
    echo "❌ Error de conexión:<br>";
    die(print_r(sqlsrv_errors(), true));
}
?>
