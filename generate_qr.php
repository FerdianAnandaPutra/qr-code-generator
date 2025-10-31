<?php
require_once __DIR__ . '/phpqrcode/qrlib.php';

$csvFile = __DIR__ . '/data.csv';
$outputDir = __DIR__ . '/preview/';
$logoPath = __DIR__ . '/logo.png'; // pastikan logo PNG transparan

if (!file_exists($csvFile)) {
    die("File CSV tidak ditemukan di: $csvFile\n");
}

if (!file_exists($outputDir)) {
    mkdir($outputDir, 0777, true);
    echo "Folder 'preview' dibuat otomatis.\n";
}

$file = fopen($csvFile, 'r');
$count = 0;

while (($line = fgetcsv($file)) !== false) {
    $no_induk = trim($line[0]);
    if ($no_induk === '') continue;

    $qrTempFile = $outputDir . $no_induk . '_temp.png';
    $finalFile = $outputDir . $no_induk . '.png';

    // QR lebih tajam (matrixPointSize besar = resolusi tinggi)
    $matrixPointSize = 10; // default 6
    QRcode::png($no_induk, $qrTempFile, QR_ECLEVEL_H, $matrixPointSize, 1);

    // Konversi ke resolusi tinggi (1000x1000 px)
    $targetSize = 1000; // hasil akhir HD
    $QR = imagecreatefrompng($qrTempFile);
    $QR_resized = imagecreatetruecolor($targetSize, $targetSize);

    // latar belakang putih agar tidak transparan buram
    $white = imagecolorallocate($QR_resized, 255, 255, 255);
    imagefill($QR_resized, 0, 0, $white);

    imagecopyresampled(
        $QR_resized, $QR, 
        0, 0, 0, 0, 
        $targetSize, $targetSize, 
        imagesx($QR), imagesy($QR)
    );
    imagedestroy($QR);

    // Gabungkan logo jika ada
    if (file_exists($logoPath)) {
        $logo = imagecreatefrompng($logoPath);

        $QR_width = imagesx($QR_resized);
        $QR_height = imagesy($QR_resized);

        $logo_width = imagesx($logo);
        $logo_height = imagesy($logo);

        // Logo maksimal 1/6 lebar QR
        $logo_qr_width = $QR_width / 6;
        $scale = $logo_width / $logo_qr_width;
        $logo_qr_height = $logo_height / $scale;

        $from_width = ($QR_width - $logo_qr_width) / 2;
        $from_height = ($QR_height - $logo_qr_height) / 2;

        imagecopyresampled(
            $QR_resized, $logo,
            (int) round($from_width),       
            (int) round($from_height),     
            0, 0,                           
            (int) round($logo_qr_width),    
            (int) round($logo_qr_height),   
            (int) $logo_width,              
            (int) $logo_height              
        );

        imagedestroy($logo);
    }

    imagepng($QR_resized, $finalFile, 9); // quality max (9)
    imagedestroy($QR_resized);
    unlink($qrTempFile);
    $count++;
}

fclose($file);

echo "$count QR Code selesai dibuat di folder: $outputDir\n";
if (file_exists($logoPath)) {
    echo "Logo ditambahkan dari: $logoPath \n";
} else {
    echo "Logo tidak ditemukan, QR dibuat tanpa logo.\n";
}
?>