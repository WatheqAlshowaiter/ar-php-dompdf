<?php

require 'vendor/autoload.php';


use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
// $options->set('defaultFont', 'DejaVu Sans');
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$arabic = new \ArPHP\I18N\Arabic();

$absoluteUrl = url() . '/assets';

$reportHtml = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>الفاتورة</title>
    <style>
        @font-face {
            font-family: 'eazycare';
            src: url({$absoluteUrl}/cocon-next-arabic.ttf);
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
        }

        @page {
            margin: 0px;
        }

        *, td, th {
            font-weight: normal;
            font-family: 'eazycare';
            /*font-family: DejaVu Sans;*/
            /*font-size: 12px;*/
            text-align: right;
            direction: rtl;
        }

        body {
            background-repeat: no-repeat;
            direction: rtl;
            /*padding: 10px 50px;*/
        }

        .body {
            /*padding: 10px 50px;*/
            text-align: right;
        }

        .body p{
            text-align: right;
            color: #096DAD;
        }

        .invoice-name p {
            font-size: 50px;
            margin: 0;
            padding: 0;
            /*font-weight: 600;*/
            color: #096DAD;
        }

        .invoice-name span {
            margin: 10px 55px;
            color: #0AAD9A;
        }

        .invoice-name {
            text-align: right;
            float: right;
            /*right: 0;*/
        }

        .logo {
            margin: 20px 60px;
            float: left;
        }

        table{
            width: 90%;
            margin: 20px 40px;
            text-align: right;
        }
        table th {
            background-color: #096DAD;
            color: #fff;
            padding: 0 5px 5px 5px;
            text-align: center;
        }
    </style>
</head>
<body dir='rtl' style='background: url({$absoluteUrl}/background.jpg) ;background-size: 100% 100%;'>
<div class='header'>
    <div class='invoice-name'>
        <p>الفاتورة </p>
        <span>رقم الطلب: 9323243</span>
    </div>
    <div class='logo'>
        <img src='{$absoluteUrl}/vertical@4x-8.png' width='140'>
    </div>
</div>
<div class='body'>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <p>اسم المركز: مختبرات الفرابي</p>
    <p style='margin: 0 30px'>
        تــاريخ الحجز
        <br>
        <span style='margin: 0 20px'> Sunday, Jan, 15, 2023</span>
    </p>

    <table>
        <tr>
            <th>المرضى</th>
            <th>الكمية</th>
            <th>اسم التحليل</th>
        </tr>
        <tr>
            <td>أمجد</td>
            <td>2</td>
            <td>تحليل الاميبياء</td>
        </tr>
    </table>

    <hr>

</div>
</body>
</html>";

$p = $arabic->arIdentify($reportHtml);

$maxLineChr = 80;
$htmlOutput = substr($reportHtml, 0, $p[0]);

for ($i = 0; $i < count($p); $i += 2) {
    $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i], $p[$i + 1] - $p[$i]), $maxLineChr, hindo: false);
    $lastEn = isset($p[$i + 2]) ? $p[$i + 2] : strlen($reportHtml);

    $htmlOutput .= str_replace("\n", "<br>\n", $utf8ar);
    $htmlOutput .= substr($reportHtml, $p[$i + 1], $lastEn - $p[$i + 1]);
}

$dompdf->loadHtml($htmlOutput);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream('example', array('Attachment' => false));


function url()
{
    return 'http://' . $_SERVER['HTTP_HOST'];
}
