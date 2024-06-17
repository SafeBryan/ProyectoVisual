<?php
require('../fpdf185/fpdf.php');
include '../modelo/conexion.php';
session_start();

if (!isset($_POST['cedula']) || empty($_POST['cedula'])) {
    $_SESSION['error'] = "Cédula no proporcionada.";
    header("Location: ../reportes.php");
    exit();
}

$cedula = $_POST['cedula'];

$conn = new conexion();
$con = $conn->conectar();

if ($con->connect_error) {
    $_SESSION['error'] = "Error de conexión: " . $con->connect_error;
    header("Location: ../reportes.php");
    exit();
}

$sqlSelect = "
    SELECT 
        e.id_empleado, e.emple_nombre, e.emple_apellido, e.emple_direccion, e.emple_telefono,
        SUM(TIMESTAMPDIFF(MINUTE, a.hora_entrada, a.hora_salida)) / 60 AS horas_trabajadas,
        SUM(a.minutos_atraso) AS minutos_atraso,
        SUM(CASE WHEN a.hora_entrada IS NULL OR a.hora_salida IS NULL THEN 8 ELSE 0 END) AS horas_no_registradas
    FROM empleados e
    LEFT JOIN asistencias a ON e.id_empleado = a.id_empleado
    WHERE e.id_empleado = '$cedula'
    GROUP BY e.id_empleado";

$respuesta = $con->query($sqlSelect);

if ($respuesta->num_rows == 0) {
    $_SESSION['error'] = "No se encontraron datos para la cédula proporcionada.";
    header("Location: ../reportes.php");
    exit();
}

class PDF extends FPDF {
    function Header() {
        $this->Image('../image.png', 10, 10, 30);
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Reporte Empleado de Asistencias', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, date('d/m/Y'), 0, 1, 'R');
        $this->Ln(20);

    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 9.5);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function DrawFrame() {
        $this->Rect(5, 5, 200, 287, 'D'); // Ajusta las dimensiones y posición del marco según sea necesario
    }

    function Watermark() {
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203); // Color rosa claro
        $this->RotatedText(35, 190, 'MARCA DE AGUA', 45);
    }

}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 9.5);

$pdf->DrawFrame();

$pdf->SetFillColor(180, 180, 180);

$header = array('ID', 'Nombre', 'Apellido', 'Horas Trab.', 'Min. Atraso', 'Descuento', 'Sueldo Total');
$w = array(30, 26, 26, 26, 26, 26, 26);
$pdf->SetFont('Arial', 'B', 10);
for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($w[$i], 10, $header[$i], 1, 0, 'C', true); // El último parámetro true establece el relleno
    }
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
$total_global = 0;

while ($row = $respuesta->fetch_array(MYSQLI_ASSOC)) {
    $descuento_atraso = $row['minutos_atraso'] * 0.25;
    $descuento_no_registradas = $row['horas_no_registradas'] * 8 * 8;
    $descuento_total = $descuento_atraso + $descuento_no_registradas;
    $sueldo = $row['horas_trabajadas'] * 8 - $descuento_total;
    $total_global += $sueldo;

    $pdf->Cell($w[0], 10, $row['id_empleado'], 1);
    $pdf->Cell($w[1], 10, $row['emple_nombre'], 1);
    $pdf->Cell($w[2], 10, $row['emple_apellido'], 1);
    $pdf->Cell($w[3], 10, number_format($row['horas_trabajadas'], 2), 1);
    $pdf->Cell($w[4], 10, $row['minutos_atraso'], 1);
    $pdf->Cell($w[5], 10, number_format($descuento_total, 2), 1);
    $pdf->Cell($w[6], 10, number_format($sueldo, 2), 1);
    $pdf->Ln();
}

$pdf->Ln();
$pdf->Cell(array_sum($w) - $w[6], 10, 'Total Global:', 1);
$pdf->Cell($w[6], 10, number_format($total_global, 2), 1);
$pdf->Ln();

$pdf->Output();
$con->close();
?>

