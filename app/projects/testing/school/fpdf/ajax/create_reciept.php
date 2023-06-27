<?
// require VENDOR . 'fpdf/fpdf.php';
// ------------------------------------------------
class PDF_print {
    public $base; 
    function __construct ($orientation = 'P', $unit = 'pt', $format = 'Letter', $margin = 40) { 
        // $this->base->FPDF($orientation, $unit, $format); 
        // parent::__construct($orientation, $unit, $format);

        $this->base = (new Factory('dmight/vendor/Fpdf'))->Create('Fpdf');

        $this->base->SetTopMargin($margin); 
        $this->base->SetLeftMargin($margin); 
        $this->base->SetRightMargin($margin); 
        $this->base->SetAutoPageBreak(true, $margin); 
    } 

    function Header() { 
        $this->base->SetFont('Arial', 'B', 20); 
        $this->base->SetFillColor(36, 96, 84); 
        $this->base->SetTextColor(225); 
        $this->base->Cell(0, 30, "Nettuts+ Online Store", 0, 1, 'C', true); 
    }

    function Footer() { 
        $this->base->SetFont('Arial', '', 12); 
        $this->base->SetTextColor(0); 
        $this->base->SetXY(0,-60); 
        $this->base->Cell(0, 20, "Thank you for shopping at Nettuts+!", 'T', 0, 'C'); 
    }    

// We start by setting our font, text color, fill color, and line width. Next we set up our header cells. The each have a border on the left, top, and right, centered text, and a fill.
// Next, we remove the 'boldness' from the font and reset the fill color and line width. We also create a $fill variable, set to false. We'll use this to add zebra striping to our table.
    function PriceTable($products, $prices) { 
        $this->base->SetFont('Arial', 'B', 12); 
        $this->base->SetTextColor(0); 
        $this->base->SetFillColor(36, 140, 129); 
        $this->base->SetLineWidth(1); 
        $this->base->Cell(427, 25, "Item Description", 'LTR', 0, 'C', true); 
        $this->base->Cell(100, 25, "Price", 'LTR', 1, 'C', true); 
     
        $this->base->SetFont('Arial', ''); 
        $this->base->SetFillColor(238); 
        $this->base->SetLineWidth(0.2); 
        $fill = false; 
     
        for ($i = 0; $i < count($products); $i++) { 
            $this->base->Cell(427, 20, $products[$i], 1, 0, 'L', $fill); 
            $this->base->Cell(100, 20, '$' . $prices[$i], 1, 1, 'R', $fill); 
            $fill = !$fill; 
        } 
        $this->base->SetX(367); 
        $this->base->Cell(100, 20, "Total", 1); 
        $this->base->Cell(100, 20, '$' . array_sum($prices), 1, 1, 'R'); 
    }
}

$pdf = new PDF_print(); 
$pdf->base->AddPage(); 
$pdf->base->SetFont('Arial', '', 12);

// move our cursor; we can do this by using the SetY method.
// This doesn't move us down 100 points; is sets us 100 points from the top of the page. That doesn't include the margin, so we're 30pt down from the bottom of our header.
$pdf->base->SetY(100);

$pdf->base->Cell(100, 13, "Ordered By"); 
$pdf->base->SetFont('Arial', ''); 
$pdf->base->Cell(100, 13, $_POST['name']);

// Again, we set the font to bold; after writing "Date," we remove the bold and print the current date, using PHP's date function. The format we've specified will give us the month name, day number followed by a comma, and the four-digit year. We put the border as 0 (the default) so we can get to the the line parameter. We set it as 1, which will put our position to the beginning of the next line; it's the equivalent of hitting 'enter' in a word processor.

$pdf->base->SetFont('Arial', 'B', 12); 
$pdf->base->Cell(50, 13, 'Date'); 
$pdf->base->SetFont('Arial', ''); 
$pdf->base->Cell(100, 13, date('F j, Y'), 0, 1);

// The important thing to notice here is that our line parameter is 2. This means that after each cell, we will move to the next line and 'tab in' to line up with the previous cell. Finally, we call the Ln method, which adds a line break. Without a parameter, it will move our position down the heigh of the last printed cell. We've passed it a parameter, so we're moving down 100pt.
$pdf->base->SetX(140); 
$pdf->base->SetFont('Arial', 'I'); 
$pdf->base->Cell(200, 15, $_POST['address'], 0, 2); 
$pdf->base->Cell(200, 15, $_POST['city'] . ', ' . $_POST['province'], 0, 2); 
$pdf->base->Cell(200, 15, $_POST['postal_code'] . ' ' . $_POST['country']); 
$pdf->base->Ln(100);

// Now let's print out a table of the products our customer has purchased.
$pdf->PriceTable($_POST['product'], $_POST['price']);

// skip down 50pt.
$pdf->base->Ln(50);

// MultiCell... It will also break when it hits a '\n'.
// MultiCell also takes border, alignment, and fill parameters.
$message = "Thank you for ordering at the Nettuts+ online store. Our policy is to ship your materials within two business days of purchase. On all orders over $20.00, we offer free 2-3 day shipping. If you haven't received your items in 3 busines days, let us know and we'll reimburse you 5%.\n\nWe hope you enjoy the items you have purchased. If you have any questions, you can email us at the following email address:"; 
$pdf->base->MultiCell(0, 15, $message);

// The Write method take only three parameters: a height, the text, and an optional link. There's no width parameter, because it will go to the right margin before it breaks the line. Although this isn't the best use of it, we'll use it to add a link:
$pdf->base->SetFont('Arial', 'U', 12); 
$pdf->base->SetTextColor(1, 162, 232); 
$pdf->base->Write(13, "store@nettuts.com", "mailto:example@example.com");

// the second one is what we want to do with the file, in this case, save it to the server. You could also force a download with 'D', return it as a string with 'S'. The default, outputting to the browser, is 'I' (for inline).

$file_name = 'pdf/reciept.pdf';
$pdf->base->Output($file_name, 'F');

echo $file_name;
exit();

