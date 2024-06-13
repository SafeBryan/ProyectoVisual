<?php
require('../fpdf185/fpdf.php');
include '../conexion.php';
$conn = new conexion();
$con = $conn->conectar();

$sqlSelect = "SELECT * FROM empleados"; 
$pdf->SetMargins(10, 10, 10); 
$respuesta = $con->query($sqlSelect);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);

$pdf->Cell(20, 10, 'id_empleado', 1);
$pdf->Cell(30, 10, 'emple_nombre', 1);
$pdf->Cell(30, 10, 'emple_apellido', 1);
$pdf->Cell(60, 10, 'emple_direccion', 1);
$pdf->Cell(30, 10, 'emple_telefono', 1);
$pdf->Ln();

while ($row = $respuesta->fetch_array(MYSQLI_ASSOC)) {
    $cedula = $row['id_empleado'];
    $nombre = $row['emple_nombre'];
    $apellido = $row['emple_apellido'];
    $direccion = $row['emple_direccion'];
    $telefono = $row['emple_telefono'];
    $pdf->Cell(20, 10, $cedula, 1);
    $pdf->Cell(30, 10, $nombre, 1);
    $pdf->Cell(30, 10, $apellido, 1);
    $pdf->Cell(60, 10, $direccion, 1);
    $pdf->Cell(30, 10, $telefono, 1);
    $pdf->Ln();
}

$pdf->Output();
?>
