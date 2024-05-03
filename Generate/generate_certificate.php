<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('tcpdf/tcpdf.php');

function generatePDF($id, $conn)
{
    $sql = "SELECT * FROM applications WHERE id = '$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        $pdf->SetCreator('Student Portal');
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Bonafide Certificate');
        $pdf->SetSubject('Bonafide Certificate');
        $pdf->SetKeywords('Bonafide, Certificate');

        $pdf->AddPage();
        $profileimg = __DIR__ . "/../uploads/" . $row['profile_image'];
        $signimg = __DIR__ . "/../uploads/" . $row['sign_image'];
        $geclogo = __DIR__ . "/../img/gecg-logo.png";
        $sign = __DIR__ . "/../img/sign.png";

        // Set some content
        $content = '
            <html>
            <head>
            <style>
            * {
                margin: 0;
                padding: 0;
            }
            @page {
                size: A4;
                margin: 20px;
            }
            body {
                margin: 20px;
            }
            table {
                width: 100%;
            }
            .logo {
                height: 50px;
                width: auto;
                vertical-align: middle;
            }
            .profile img {
                width: 100px;
                max-width:100px;
            }
            .line {
                margin: 20px 0px;
            }
            .date {
                text-align: right;
            }
            th, td {
                padding: 20px 0px;
            }
            .principal {
                width: 50%;
                text-align: right;
            }
            .sign {
                width: 100px;
                height: auto;
            }
        </style>
        
            </head>
            <body>
                <table>
                    <tr>
                        <th><img class="logo" src="' . $geclogo . '" /></th>
                        <th><h2>Government Engineering College Gandhinagar</h2></th>
                    </tr>
                </table>
                <hr class="line" />
        <table class="content">
            <tr>
                <th class="date" colspan="2">' . date('Y-m-d H:i:s') . '</th>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center">
                    <h2>Bonafide Certificate</h2>
                    <h3>To whomsoever it may concern</h3>
                </td>
            </tr>
            <tr style="height:150px">
                <td style="width:80%">
                    <p>
                        This is to certify that <strong>' . $row['name'] . '</strong> is a bonafide student of <strong>' . $row['branch'] . '</strong> branch, enrolled under the <strong>' . $row['semester'] . '</strong> semester of this college. The purpose of this certificate is <strong>' . $row['purpose'] . '</strong>.
                    </p>
                </td>
                <td class="profile" style="height:150px; width:20%; align-items:end; text-align:right">
                    <img style="height:100px;" src="' . $profileimg . '" />
                </td>
            </tr>
        </table>
                <table>
                    <tr>
                        <td>
                            <img class="sign" src="' . $signimg . '" />
                            <p>sign of student</p>
                        </td>
                        <td class="principal">
                            <img class="sign" src="' . $sign . '" />
                            <p>Principal GEC Gandhinagar</p>
                        </td>
                    </tr>
                </table>
            </body>
            </html>
            ';


        // Print text using WriteHTMLCell()
        $pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);

        // Save PDF to a file
        $current_date_time = date("Y-m-d_H-i-s");
        $pdfname = "bonafide_" . $id . "_" . $current_date_time . ".pdf";

        $pdf->Output(__DIR__ . "/../certificates/" . $pdfname, 'F');
    }
}
