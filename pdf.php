<?php
// Mandamos a llamar a la libreria 
use Dompdf\Dompdf;
use Dompdf\Options;
require_once 'vendor/autoload.php';


// Llamamos a nuestra conecion db
$conn = new PDO('mysql:host=localhost:33065; dbname=add_more', 'root', '');
// Llamamos a toda nuestra tabla "Items"
$sql = 'SELECT * FROM items';
$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$gt = 0;
$i = 1;

$html = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Invoice</title>
        <style>
            h2 {
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                text-align: center;
            }
            table {
                font-family: Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }
            td,th {
                border: 1px solid #444;
                padding: 8px;
                text-align: left;
            }
            .my-table {
                text-align: right;
            }
            #sign {
                padding-top: 50px;
                text-align: right;
            }
        </style>
    
    </head>
    <body>
        <img src="logo.png">
        <h2>Factura</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Articulo</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>';

foreach ($rows as $row) {
    $html .= '<tr>
                        <td>' . $i . '</td>
                        <td>' . $row['name'] . '</td>
                        <td> $' . number_format($row['price'], 2) . '</td>
                        <td>' . $row['quantity'] . '</td>
                        <td> $' . number_format($row['price'] * $row['quantity']) . '</td>
                    </tr>';
    $gt += $row['price'] * $row['quantity'];
    $i++;
}

$html .= '</tbody>
<tr>
    <th colspan="4" class="my-table">Iva (18%)</th>
    <th> $'.number_format(($gt*18)/100, 2).'</th>
</tr>
<tr>
    <th colspan="4" class="my-table">Gran Total</th>
    <th> $'.number_format($gt + ($gt * 18) /  100, 2).'</th>
</tr>
<tr>
    <th colspan="4" class="my-table">Gran Total Redondeando.</th>
    <th> $'.number_format(round($gt + ($gt * 18) /  100), 2).'</th>
</tr>
<tr>
    <td colspan="5" id="sign">Firma</td>
</tr>
</table>
</body>

</html>';




$options = new Options;
$options->set('chroot',realpath(''));
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('factura.pdf', ['Attachment' => 0]);

?>