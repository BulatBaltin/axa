<?

// require VENDOR . 'fpdf/fpdf.php';
// ------------------------------------------------
// class PDF_print extends FPDF { 
class PDF_print { 
    function __construct ($orientation = 'P', $unit = 'pt', $format = 'A4', $margin = 0) { 
        // $this->FPDF($orientation, $unit, $format); 
        // parent::__construct($orientation, $unit, $format);
        // $this->SetTopMargin($margin); 
        // $this->SetLeftMargin($margin); 
        // $this->SetRightMargin($margin); 
        // $this->SetAutoPageBreak(true, $margin); 

        $this->base = (new Factory('dmight/vendor/Fpdf'))->Create('Fpdf');

        $this->base->SetTopMargin($margin); 
        $this->base->SetLeftMargin($margin); 
        $this->base->SetRightMargin($margin); 
        $this->base->SetAutoPageBreak(true, $margin); 
    } 
}

$data = [
    'image' => IMAGES."pdf/Certificaat_Hairstylist_basis.png",
    'name_student' => "Anett Kontaveit",
    'name_teacher' => "Marcella Heinen",
    'date_1' => "12-09-2022 te Stad",
    'date_2' => "15-09-2022",
    'student_date' => "17-09-2022",
    'teacher_date' => "18-09-2022",
    'copy_right_year' => date('Y'),
    'certificate_number' => "22-OHB-12345"
];
// $course = 'A'; // 1
// $course = 'B'; // 2
// $course = 'C'; // 3
// $course = 'D'; // 4
// $course = 'E'; // 5
// $course = 'F'; // 6
// $course = 'J'; // 7
// $course = 'H'; // 8
// $course = 'I'; // 9
// $course = 'G'; // 10
$course = 'K'; // 11
switch ($course) {
    case 'A':
        $data['image'] = IMAGES."pdf/Certificaat_Barbier_basis.png";
        $data['name_teacher'] = 'Alaa Hallak';
        $xy['name_student'] = 396;
        $xy['date_2_x'] = 248;
        $xy['date_2_y'] = 499;
        $xy['name_axis_y'] = 685;
        $xy['date_axis_y'] = 719;
        // $file_name = BarbierBasis($course);
        break;
    case 'B':
        $data['image'] = IMAGES."pdf/Certificaat_Hairstylist_basis.png";
        $data['name_teacher'] = 'Marcella Heinen';
        $xy['name_student'] = 389;
        $xy['date_2_x'] = 248;
        $xy['date_2_y'] = 499;
        $xy['name_axis_y'] = 695;
        $xy['date_axis_y'] = 728;
        // $file_name = HairstylistBasis($course, $data);
        break;
    case 'C':
        $data['image'] = IMAGES."pdf/Certificaat_Visagie_LashLifting.png";
        $data['name_teacher'] = 'Ilana Goetjes';
        $xy['name_student'] = 395;
        $xy['date_2_x'] = 241;
        $xy['date_2_y'] = 505;
        $xy['name_axis_y'] = 695;
        $xy['date_axis_y'] = 730;
        // $file_name = VisagieLashLifting($course, $data);
        break;
    case 'D':
        $data['image'] = IMAGES."pdf/Certificaat_Visagie_basis.png";
        $data['name_teacher'] = 'Ilana Goetjes';
        $xy['name_student'] = 402;
        $xy['date_2_x'] = 241;
        $xy['date_2_y'] = 509;
        $xy['name_axis_y'] = 685;
        $xy['date_axis_y'] = 720;
        break;
    case 'E':
        $data['image'] = IMAGES."pdf/Certificaat_Kleuren.png";
        $data['name_teacher'] = 'Marcella Heinen';
        $xy['name_student'] = 395;
        $xy['date_2_x'] = 250;
        $xy['date_2_y'] = 501;
        $xy['name_axis_y'] = 675;
        $xy['date_axis_y'] = 706;
        break;
    case 'F':
        $data['image'] = IMAGES."pdf/Certificaat_Opsteken.png";
        $data['name_teacher'] = 'Mandy van Hattem';
        $xy['name_student'] = 372;
        $xy['date_2_x'] = 245;
        $xy['date_2_y'] = 479;
        $xy['name_axis_y'] = 658;
        $xy['date_axis_y'] = 700;
        break;
    
    case 'J':
        $data['image'] = IMAGES."pdf/Diploma_Visagie_Allround.png";
        $data['name_teacher'] = 'Ilana Goetjes';
        $xy['name_student'] = 400;
        $xy['date_2_x'] = 244;
        $xy['date_2_y'] = 509;
        $xy['name_axis_y'] = 688;
        $xy['date_axis_y'] = 722;
        break;
    case 'H':
        $data['image'] = IMAGES."pdf/Diploma_Barbier_Masterclass.png";
        $data['name_teacher'] = 'Alaa Hallak';
        
        $xy['name_student'] = 385;
        $xy['date_2_x'] = 239;
        $xy['date_2_y'] = 517;
        $xy['name_axis_y'] = 698;
        $xy['date_axis_y'] = 728;
        break;
    case 'I':
        $data['image'] = IMAGES."pdf/Diploma_Barbier_Allround.png";
        $data['name_teacher'] = 'Alaa Hallak';
        
        $xy['name_student'] = 398;
        $xy['date_2_x'] = 242;
        $xy['date_2_y'] = 503;
        $xy['name_axis_y'] = 703;
        $xy['date_axis_y'] = 737;

        break;
    
    case 'G':
        $data['image'] = IMAGES."pdf/Diploma_Hairstylist_Allround.png";
        $data['name_teacher'] = 'Alaa Hallak';
        
        $xy['name_student'] = 375;
        $xy['date_2_x'] = 244;
        $xy['date_2_y'] = 481;
        $xy['name_axis_y'] = 670;
        $xy['date_axis_y'] = 705;

        break;

    case 'K':
        $data['image'] = IMAGES."pdf/Diploma_Hairstylist_basis.png";
        $data['name_teacher'] = 'Melanie Blijenberg';
        
        $xy['name_student'] = 375;
        $xy['date_2_x'] = 248;
        $xy['date_2_y'] = 486;
        $xy['name_axis_y'] = 670;
        $xy['date_axis_y'] = 703;

        break;
    
    default:
        # code...
        break;

}
$file_name = RenderPDF($course, $data, $xy);
echo $file_name;
exit();

function RenderPDF($course, $data, $xy) {
    [$image,
    $name_student,
    $name_teacher,
    $date_1,
    $date_2,
    $student_date,
    $teacher_date,
    $copy_right_year,
    $certificate_number
    ] = array_values($data);

    $pdf = new PDF_print(); 
    $pdf->AddPage();
    $pdf->Image($image,0,0,600,850); 
    
    $pdf->SetXY(0, $xy['name_student']);
    $pdf->SetFont('Times', 'B', 22);
    $pdf->Cell(0, 22, $name_student, 0, 1, "C" ); //$_POST['name']);

    $pdf->SetXY(0, $xy['name_student']+34);
    $pdf->SetFont('Times', 'B', 18);
    $pdf->Cell(0, 18, $date_1, 0, 1, "C" ); //$_POST['name']);

    $pdf->SetXY($xy['date_2_x'], $xy['date_2_y']);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(50, 16, $date_2, 0, 1, "C" ); //$_POST['name']);
// =================
    $pdf->SetXY(0, $xy['name_axis_y']);
    $pdf->SetFont('Times', '', 18);
    $pdf->Cell(207, 20, $name_student, 0, 1, "R" );
    
    $pdf->SetXY(0, $xy['date_axis_y']);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(207, 16, $student_date.' , Utrecht', 0, 1, "R" );
    
    $pdf->SetXY(320, $xy['name_axis_y']);
    $pdf->SetFont('Times', '', 18);
    $pdf->Cell(207, 20, $name_teacher, 0, 1, "R" );
    
    $pdf->SetXY(320, $xy['date_axis_y']);
    $pdf->SetFont('Times', 'B', 12);
    $pdf->Cell(207, 16, $teacher_date.' , Utrecht', 0, 1, "R" );
    
    $pdf->SetXY(70, -60);
    $pdf->SetFont('Times', 'B', 8);
    $footer = chr(169)."Hair Kappersopleiding $copy_right_year  Certificate number: $certificate_number";
    $pdf->Cell(40, 12, $footer ); //, 0, 0, "B" ); //$_POST['name']);
    
    $file_name = "pdf/certificate_{$course}.pdf";
    $pdf->Output($file_name, 'F');
    return $file_name;
}
