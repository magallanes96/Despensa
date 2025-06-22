<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

// Conexión a Azure SQL
$serverName = "tcp:TU-SERVIDOR.database.windows.net,1433";
$connectionOptions = array(
    "Database" => "TU_BD",
    "Uid" => "TU_USUARIO",
    "PWD" => "TU_CONTRASEÑA",
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
$contrasena = $data->contrasena;

$sql = "SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ?";
$params = array($usuario, $contrasena);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo json_encode(["success" => true, "usuario" => $usuario]);
} else {
    echo json_encode(["success" => false, "message" => "Credenciales incorrectas"]);
}

sqlsrv_close($conn);
?>
