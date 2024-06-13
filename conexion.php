<?php
    class conexion{
        public function conectar(){
            $servername="localhost";
            $username="root";
            $password="";
            $dbname="sistema_asistencia";
            $conn=mysqli_connect($servername, $username, $password, $dbname);
            if(!$conn){
                echo ("Connection failed: " . mysqli_connect_error());
            }else{
                return $conn;
                echo ("Conexion OK");
            }
        }
    }
?>
