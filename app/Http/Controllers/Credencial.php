<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TCPDF;
use App\Models\Registrar;

class Credencial extends Controller
{
    public function generarCredencial($id)
    {
        // Obtener los datos del modelo Registrar usando el ID
        $registrar = Registrar::findOrFail($id);

        $pdf = new TCPDF('L', 'mm', array(86, 54), true, 'UTF-8', false);
        $pdf->SetMargins(0, 0, 0);
        $pdf->SetAutoPageBreak(false, 0);
        $pdf->SetSubject('Credencial de Identificación');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Agregar una página
        $pdf->AddPage();

        // Establecer el contenido de la credencial
        $pdf->SetFont('helvetica', '', 5.5);

        // Add background image
        $backgroundImagePath = storage_path('app/public/cre_A.jpg'); // Path to your background image file
        $pdf->Image($backgroundImagePath, 0, 0, 86, 54, 'JPG', '', '', true, 300, '', false, false, 0, false, false, false);
        // $backgroundImagePath = storage_path('app/public/cred_A.jpeg'); // Path to your background image file
        // $pdf->Image($backgroundImagePath, 0, 0, 100, 70, 'JPG', '', '', true, 300, '', false, false, 0, false, false, false);

        // Agregar la fotografía del registrar
        if ($registrar->fotografia) {
            $fotografiaPath = storage_path('app/public/' . $registrar->fotografia);
            if (file_exists($fotografiaPath)) {
                // Ajusta estas coordenadas según necesites
                $pdf->Image($fotografiaPath, 4.5, 18, 32, 29.5, '', '', '', false, 300, '', false, false, 0);
            }
        }
        // Agregar texto sobre la imagen de fondo
        $pdf->SetXY(40, 14.5); // Posición inicial del texto
        // $pdf->Cell(0, 10, 'Apellido: ' . htmlspecialchars($registrar['apellido']));
        $pdf->Cell(0, 9, htmlspecialchars($registrar['apellidos']));

        $pdf->SetXY(40, 20); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 9, htmlspecialchars($registrar['nombres']));


        $pdf->SetXY(39.5, 26); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 9, htmlspecialchars($registrar['centro_infantil']));

        $datos = "INFORMACIÓN DE CONTACTO\n"
        . "------------------------\n"
        . "Padre: " . $registrar['nombre_padre'] . "\n"
        . "📱Celular: " . $registrar['celular_p'] . "\n"
        . "------------------------\n"
        . "Madre: " . $registrar['nombre_madre'] . "\n"
        . "📱Celular: " . $registrar['celular_m'] . "\n"
        . "------------------------\n"
        . "📍Dirección: " . $registrar['direccion'] . "\n"
        . "🏫Centro Infantil: " . $registrar['centro_infantil'];


    // $datos = $registrar['nombres']. $registrar['apellidos']. $registrar['celular1'];
    $pdf->write2DBarcode($datos , 'QRCODE,H', 40, 33, 15.5, 14.5, array(), 'N');
        // $pdf->SetXY(70, 34.5); // Nueva posición para el siguiente elemento
        // $pdf->Cell(0, 10, htmlspecialchars($registrar['celular1']));
        
        $pdf->AddPage();
        
        // // Imagen del reverso
        $backgroundImagePath1 = storage_path('app/public/cre_R1.jpg');
        $pdf->Image($backgroundImagePath1, 0, 0, 86, 54, 'JPG', '', '', true, 300, '', false, false, 0, false, false, false);
        // $backgroundImagePath1 = storage_path('app/public/cre_R1.jpg');
        // $pdf->Image($backgroundImagePath1, 0, 0, 100, 70, 'JPG', '', '', true, 300, '', false, false, 0, false, false, false);
        
        // Si hay personas autorizadas, las mostramos en el reverso
        $pdf->SetXY(9, 8); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 10, htmlspecialchars($registrar['persona_autorizada1']));
        $pdf->SetXY(9, 13); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 10, htmlspecialchars($registrar['persona_autorizada2']));
        $pdf->SetXY(9, 18); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 10, htmlspecialchars($registrar['persona_autorizada3']));

        $pdf->SetXY(55, 8); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 10, htmlspecialchars($registrar['parentesco1']));
        $pdf->SetXY(55, 13.5); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 10, htmlspecialchars($registrar['parentesco2']));
        $pdf->SetXY(55, 18); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 10, htmlspecialchars($registrar['parentesco3']));
        
        $pdf->SetXY(67, 8); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 10, htmlspecialchars($registrar['celular1']));
        $pdf->SetXY(67, 13); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 10, htmlspecialchars($registrar['celular2']));
        $pdf->SetXY(67, 18); // Nueva posición para el siguiente elemento
        $pdf->Cell(0, 10, htmlspecialchars($registrar['celular3']));


        // Escribir el contenido HTML en el PDF
        // $pdf->writeHTML($html, true, false, true, false, '');

        // Salida del archivo PDF
        // $pdf->Output('credencial_' . $registrar->CI . '.pdf', 'I');
        $pdf->Output('Cred_'. $registrar->nombres .'_'.  $registrar->apellidos .'.pdf', 'I');
    }
}
