<?php
define("FONT_PATH", dirname(__FILE__).'\font\tahoma.ttf');
define("DATA_PATH",'./data');
include('./src/LotteryImage.php');
include('./src/Zip.php');

if(!file_exists(DATA_PATH)){
    mkdir(DATA_PATH, 0777, true);
}
$files = glob(DATA_PATH.'/*'); 
foreach($files as $file) {
    if(is_file($file)){
        unlink($file);
    }
}
$year = "66";
$installment = "20";
$no = "23";
$barcode = "1756";
$bg_path = "./bg/bg_test.jpg";

for($i=0;$i<=2;$i++){
    $two_number = str_pad($i,2,'0',STR_PAD_LEFT);
    $one = mb_substr($two_number,0,1);
    $two = mb_substr($two_number,1,1);
    $n = [rand(0,9),rand(0,9),rand(0,9),rand(0,9),$one,$two];
    //$file_path = createImagLottery($n);
    $LotteryImage = new LotteryImage();
    $LotteryImage->create($year,$installment,$no,$barcode,$bg_path,$n);
    $LotteryImage->createImag();
}

$Zip = new Zip();
$Zip->createZip(DATA_PATH,'./data.zip')
?>