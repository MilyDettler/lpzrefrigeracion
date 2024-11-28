<?php 
require('conexion.php');  
require_once('../fpdf/fpdf.php');

// Definir la constante PDF_CREATOR si no está definida
if (!defined('PDF_CREATOR')) {
    define('PDF_CREATOR', 'My Application');
}

// Crear una subclase de FPDF
class PDF extends FPDF {
    // Propiedades para el título y el ID
    public $titulo;

    // Método para el encabezado
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Ln(1);

        // Crear una fila con dos celdas (una para el logo y otra para los datos)
        $this->Cell(50, 30, $this->Image('../formulario/imagen/LOPEZ logo.png', $this->GetX(), $this->GetY(), 50, 30), 0, 0, 'L');
        
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, '(0343) 155244293', 0, 1, 'R');
        $this->Cell(0, 10, '3100 Parana, Entre Rios', 0, 1, 'R');
        $this->Cell(0, 10, 'lopez.mariano@live.com', 0, 1, 'R');
        $this->Cell(0, 10, 'LPZ Refrigeracion', 0, 1, 'R');
        $this->Ln(-1);
    }

    // Método para agregar un campo al formulario
    function AddField($label, $value) {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(60, 10, $label, 0, 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, htmlspecialchars($value), 0, 1, 'L');
    }

    // Método para agregar una tabla de firmas
    function AddSignatures($firmaTecnico, $firmaTienda) {
        $this->Ln(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(90, 10, 'Firma del Tecnico:', 0, 0);
        $this->Cell(90, 10, 'Firma de la Tienda:', 0, 1);
        
        $this->Image(htmlspecialchars($firmaTecnico), 10, $this->GetY(), 30, 20);
        $this->Image(htmlspecialchars($firmaTienda), 110, $this->GetY(), 30, 20);
    }

    // Método para crear una tabla de formulario con renglones
    function AddForm($order) {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Detalles de la Orden de Trabajo', 0, 1, 'C');
        $this->Ln(5);

        $this->SetAutoPageBreak(TRUE, 10);

        $this->AddField('Fecha:', htmlspecialchars($order['date']));
        $this->AddField('Servicio:', htmlspecialchars($order['servicioSolicitado']));
        $this->AddField('Razon Social:', htmlspecialchars($order['razonSocial']));
        $this->AddField('Solicitante:', htmlspecialchars($order['solicitante']));
        $this->AddField('Tienda:', htmlspecialchars($order['locacion']));
        $this->AddField('Direccion:', htmlspecialchars($order['direccion']));
        $this->AddField('Provincia:', htmlspecialchars($order['provincia']));
        $this->AddField('Localidad:', isset($order['localidad_descripcion']) ? htmlspecialchars($order['localidad_descripcion']) : '');
        $this->AddField('Inconveniente:', htmlspecialchars($order['inconveniente']));
        $this->AddField('Tareas:', htmlspecialchars($order['tareas']));
        $this->AddField('Repuestos:', htmlspecialchars($order['repuestos']));
        $this->AddField('Observaciones:', htmlspecialchars($order['observaciones']));
        $this->AddField('Estado:', htmlspecialchars($order['estado']));
        $this->AddField('Hora Entrada:', htmlspecialchars($order['horaEntrada']));
        $this->AddField('Hora Salida:', htmlspecialchars($order['horaSalida']));
        $this->AddField('Cantidad de Horas:', htmlspecialchars($order['horaTotal']));
        $this->AddField('Cantidad de Kilometros:', htmlspecialchars($order['kilometros']));
        $this->AddField('Cantidad de Operarios:', htmlspecialchars($order['operarios']));

        $this->SetFont('Arial', '', 10);
        $text = "Quien suscribe, en representacion del cliente, recibe conforme el servicio prestado por:";
        $textWidth = $this->GetStringWidth($text);
        $this->Cell($textWidth, 10, $text, 0, 0, 'L');
        $this->Image('../formulario/imagen/LOPEZ logo.png', $this->GetX(), $this->GetY() - 3, 30, 20);
        $this->Ln(5);

        $this->AddSignatures($order['firmaTecnico'], $order['firmaTienda']);
    }
} // Fin de la clase PDF

// Verificar si 'id' está presente en la URL
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = $_POST['id'];

    // Comprobar si $pdo está definido
    if (isset($pdo)) {
        $stmt = $pdo->prepare("SELECT o.*, l.descripcion AS localidad_descripcion FROM ordenes o LEFT JOIN localidades l ON o.localidad = l.id WHERE o.id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar si se encontraron resultados
        if ($order) {
            $pdf = new PDF();
            $pdf->AddPage();
            $pdf->titulo = 'Orden de Trabajo';
            $pdf->AddForm($order);
            $pdf->Output();
        } else {
            echo "No se encontró ninguna orden con el ID proporcionado.";
        }
    } else {
        echo "Error: conexión a la base de datos no establecida.";
    }
} else {
    echo "No se proporcionó un ID válido.";
}
?>
