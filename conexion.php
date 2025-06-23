<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Conexión a Azure SQL
$serverName = "tcp:memo96.database.windows.net,1433";
$connectionOptions = array(
    "Database" => "SafePass",
    "Uid" => "memo96",
    "PWD" => "Hmcrgl09",
    "Encrypt" => true
);

// Leer datos enviados por POST
$data = json_decode(file_get_contents("php://input"));

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    echo json_encode(["success" => false, "message" => "Conexión fallida"]);
    exit;
}

$usuario = $data->usuario;
$contrasena = $data->password;

$sql = "SELECT * FROM inicio_sesion WHERE usuario = ? AND password = ?";
$params = array($usuario, $contrasena);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo json_encode(["success" => true, "usuario" => $usuario]);
} else {
    echo json_encode(["success" => false, "message" => "Credenciales incorrectas"]);
}

sqlsrv_close($conn);
?>
