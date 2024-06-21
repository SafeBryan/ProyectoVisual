<?php
class Conexion {
    public function conectar() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "sistema_asistencia";
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());  
        }
        return $conn;
    }
}
?>
