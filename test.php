<?php
if (isset($_GET['download'])) {
    ob_end_clean();
    require('fpdf/fpdf.php');

    // Instantiate and use the FPDF class
    $pdf = new FPDF();

    // Add a new page
    $pdf->AddPage();

    // Set the font for the text
    $pdf->SetFont('Arial', 'B', 18);

    // Prints a cell with given text
    $pdf->Cell(60, 20, 'Hello GeeksforGeeks!');

    // Output the generated PDF
    $pdf->Output();

} else {
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Download PDF using PHP from HTML Link</title>
    </head>

    <body>
        <center>
            <h2 style="color:green;">Welcome To GFG</h2>
            <p><b>Click below to download PDF</b>
            </p>
            <a href="?download=true">Download PDF Now</a>
        </center>
    </body>

    </html>
<?php
}
?>
