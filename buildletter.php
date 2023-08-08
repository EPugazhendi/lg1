<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Automatic Letter Generator</title>
    </head>
    <body>
        <?php
            ob_start();
// add built-in library
            require('fpdf.php');
            $result="letter.pdf";
// getting HTML inputs
            $lettertype=$_POST["head"];
            $loc=$_POST["f1"];
            $cdate=$_POST["f2"];
            $sender=$_POST["f3"];
            $toaddr=$_POST["f4"];
            $sub=$_POST["f5"];
            $body=$_POST["f6"];
            $encl=$_POST["f7"];
// Instantiate and use the FPDF class 
            $pdf = new FPDF();
//Add a new page
            $pdf->AddPage();
  
// Set the font for the text
            $pdf->SetFont('Arial', '', 14);
  
// Prints a cell with given text 
        //    $pdf->Cell(60,20,"God Ganesh is a God");
        //    
            $pdf->Ln(5);
// print letter name
            $pdf->Cell(0,15,$lettertype,0,0,'C');
// print location details (w,h) to (0,0)
            $pdf->Cell(0,30,$loc, 0,0,'R');
// print date details (w,h) to (0,0)
            $pdf->Cell(0,45,$cdate, 0,0,'R');
        //    $pdf->MultiCell(0, 0, $loc.chr(10).$cdate,0,0,'R');
// Print Sender Address
        // Line break
            $pdf->Ln(27);
            $pdf->Cell(0,0,"From",0,0,'L');
            $pdf->Ln(6);
        // This function is used for alloting 1-tab space after to address. Here width and height is 0.
            $frmarray= explode("\n", $sender);
            foreach ($frmarray as $line)
            {
                $pdf->Cell(0, 0,"\t\t\t\t\t\t".$line,0,0,'L');
                $pdf->Ln(6);
            }
        //  Worked Well: $pdf->MultiCell(0,6,"From"."\n".$sender);     
            $pdf->Cell(40,0,"To",0,0,'L');
        // Line break
            $pdf->Ln(4);
        // split to address into new line using explode() function
            $arr= explode("\n", $toaddr);
        // This function is used for alloting 1-tab space after to address. Here width and height is 0.
            foreach ($arr as $line)
            {
                $pdf->Cell(0, 0,"\t\t\t\t\t\t".$line,0,0,'L');
                $pdf->Ln(6);
            }
        //    $pdf->MultiCell(0,6,"    ".$toaddr);
        // Line Break
            $pdf->Ln(8);
            if(str_ends_with($sub, "reg") || str_ends_with($sub, "reg."))
            {
                $msg="Dear Sir/Madam,"."\n"."\t\t    Sub: ".$sub;
            }
            else
            {
                $msg="Dear Sir/Madam,"."\n"."\t\t    Sub: ".$sub."-reg.";
            }
            
            $pdf->MultiCell(0,6,$msg);
            // Line Break
            $pdf->Ln(5);
            $pdf->MultiCell(0,6, "     ".$body);
            
    // Thanks Message
            // Line Break
            $pdf->Ln(5);
        // find the width of the text and position
            $w=$pdf->GetStringWidth("Thank You");
            $pdf->SetX((210-$w)/2);
            $pdf->Cell($w, 9, "Thank You",0,0,'C');
            
        // Line Break
            $pdf->Ln(5);
        //    $pdf->Cell(0,30,"Yours Faithfully", 0,0,'R');
            $pdf->Cell(0,30,"Yours Faithfully", 0,0,'R');
            $pdf->Ln(9);
        //    $arr=str_word_count($sender, 1);
        //    $extractname=$arr[0].".".$arr[1];
            $name= strtok($sender, "\n");
        //    $str_sender= implode(" ", $arr[0]);
            $pdf->Cell(0,45,"(".$name.")",0,0,'R');
        // Line Break
            $pdf->Ln(30);
        // add enclose details
            $pdf->Cell(0, 0,"Encl:",0,0,'L');
            $pdf->Ln(6);
            if($encl!="")
            {
                $dot=explode(".", $encl);
            //    echo "<script>alert($dot)</script>";
            // checking array is empty or not
            // if numbering is not added by user, add it
                if(str_contains($encl, "."))
                {
                    $enclarr= explode("\n", $encl);
                    for($i=0;$i<count($enclarr);$i++)
                    {
                        $pdf->Cell(0, 0,$enclarr[$i],0,0,'L');
                        $pdf->Ln(6);
                    } 
                }
                else
                {
                    $k=1;
                    $enclarr= explode("\n", $encl);                  
                    for($i=0;$i<count($enclarr);$i++)
                    {
                        $pdf->Cell(0, 0,strval($k++).".$enclarr[$i]",0,0,'L');
                        $pdf->Ln(6);
                    }
                }
            /*
                if((count($dot))>1)
                {
                    $c=count($dot);
                    echo "Count:".$c."<br>";
                //    echo $c."<br><script>alert('welcome')</script>";
                    
                    $enclarr= explode("\n", $encl);
                    echo "Data Count: ".count($enclarr);
                    for($i=0;$i<count($enclarr);$i++)
                    {
                        $pdf->Cell(0, 0,$enclarr[$i],0,0,'L');
                        $pdf->Ln(6);
                    }
                }
            // if numbering is added, display them
                else
                {
                    $enclarr= explode("\n", $encl);
                    for($i=0;$i<count($enclarr);$i++)
                    {
                        $pdf->Cell(0, 0,$enclarr[$i],0,0,'L');
                        $pdf->Ln(6);
                    }
                }
             */
            }
            $pdf->Output($result,"D");
            ob_end_flush();
// return the generated output
       //     $pdf->Output("test.pdf");
        ?>
    </body>
</html>
