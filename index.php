<?php 
$conn = new PDO('mysql:host=localhost:3306; dbname=add_more', 'root', 'root');
$sql = 'SELECT * FROM items';
$stmt = $conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$gt = 0;
$i = 1;
//AddPage(orientacion [ PORTRAIT, LANDSCAPEJ, tamaño[A3, A4, A5, LETTER, LEGAL], rotacion),
//SetFont(tipo [COURIER, HELVETICA, ARIAL, TIMES, SYMBOL, ZAPDINGBATS], estilo [normal, B, I, U], tamaño),
//Cell(ancho, alto, texto, bordes, ?, alineacion, rellenar, link)
//Write (alto, texto, link)
//Out Put (destino |I, D, F, S], nombre archivo, utf8)
//Image (Ruta, posicion, posiciony, alto, ancho, tipo, link)
    
    
    // // Agregando Encabezado
    // $fpdf->SetFont('Arial', 'B', 14);
    // $fpdf->Write(5, 'Empleados Registrados en el Portal');
    // $fpdf->Ln(10);

    // // Agregando Fila con Columnas
    // $fpdf->SetFont('Arial', 'B', 10);
    // // Cololear una celda  Cell(25, 7, 'DUI', 1, 0, 'C', **true**);
    // $fpdf->SetFillColor(153, 163, 164);

    // $fpdf->Cell(25, 7, 'DUI', 1, 0, 'C', true);
    // $fpdf->Cell(50, 7, 'Nombre Completo', 1, 0, 'C',false);
    // $fpdf->Cell(100, 7, utf8_decode('Direccion'), 1, 1, 'C', false);
    
    // // Agregando Fila con Columnas
    // $fpdf->SetFont('Arial', '', 10);
    // $fpdf->Ln(0); // Parametros que puede recibir (Separacion)
    // $fpdf->Cell(25, 7, '041321321-54', 1, 0, False);
    // $fpdf->Cell(50, 7, 'Emanuel Rios Roque', 1, 0, False);
    // $fpdf->Cell(100, 7, utf8_decode('Antonio Vilchis Barbosa'), 1, 1, False);


    // // Mostrando PDF
    // $fpdf->Output('I', 'Empleados.pdf');

    require('fpdf/fpdf.php');
    $fpdf = new FPDF();
    $fpdf->AddPage('PORTRAIT', 'letter');

    class pdf extends FPDF 
    {
        public function header()
        {
            $this->SetFont('Arial', 'B', 12);
            $this->SetTextColor(66, 73, 73);
            $this->Cell(0, 10, 'Centro Educativo Colonia la Paz', 0, 0 , 'C');
            // Colocar texto como encabezado 
            // $this->SetX(-40);
            // $this->Write(5, 'DevErr');

            // Colocar Imagen Como Encabezado
            $this->Image('logo.png', 180, 5, 20, 20,'png');
        }

        public function footer ()
        {
            $this->SetFont('Arial', 'B', 12);
            $this->SetY(-15);
            $this->SetTextColor(66, 73, 73);

            $this->Write(5, 'Centro Educativo, El Salvador');
            $this->SetX(-25);
            
            // Clocar Numero de Paginas
            $this->AliasNbPages();
            $this->Write(5, $this->PageNo() . '/{nb}');
        }
    }

    $fpdf = new pdf('P', 'mm', 'letter', true);
    $fpdf->AddPage('portrait', 'letter');  
    $fpdf->SetFont('Arial', 'B', 14);
    $fpdf->SetY(30);
    $fpdf->Cell(0, 5, 'Listado de Items.', 0, 0, 'C');
    // $fpdf->Image('descarga.png', 50, 80, 50,  0, 'png'); 
    $fpdf->Ln(20);


    $fpdf->SetFont('Arial', 'B', 12);
    $fpdf->SetFillColor(166, 172, 175);

    //Linea Color Azul
    $fpdf->SetDrawColor(62, 68, 68);
    $fpdf->SetLineWidth(1);
    $fpdf->Line(11,60,209,60); 


    $fpdf->Cell(40,6, 'ID:',        0, 0, 'C', true); 
    $fpdf->Cell(40,6, 'Articulo: ', 0, 0, 'C', true); 
    $fpdf->Cell(40,6, 'Precio: ',   0, 0, 'C', true); 
    $fpdf->Cell(40,6, 'Cantidad: ', 0, 0, 'C', true); 
    $fpdf->Cell(40,6, 'Total: ',    0, 1, 'C', true); 
    


    // $fpdf->Ln(5);

    // $fpdf->SetFont('Arial', '', 11);
    // $fpdf->Cell(40,6, '1',     1, 0, 'C', false); 
    // $fpdf->Cell(40,6, 'Palos', 1, 0, 'C', false); 
    // $fpdf->Cell(40,6, '100',   1, 0, 'C', false); 
    // $fpdf->Cell(40,6, '20',    1, 0, 'C', false); 
    // $fpdf->Cell(40,6, '2000',  1, 1, 'C', false); 

    foreach ($rows as $row) {
        $fpdf->Cell(40,6, $row['id'], 0, 0, 'C', true); 
        $fpdf->Cell(40,6, $row['name'], 0, 0, 'C', true); 
        $fpdf->Cell(40,6, number_format($row['price'], 2),   0, 0, 'C', true); 
        $fpdf->Cell(40,6, $row['quantity'], 0, 0, 'C', true); 
        $fpdf->Cell(40,6, number_format($row['price'] * $row['quantity']),  0, 1, 'C', true); 
    }

    $fpdf->Output();  


?>