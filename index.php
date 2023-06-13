<?php
define("FONT_PATH", './font/tahoma.ttf');
define("DATA_PATH",'./data');
include('./src/LotteryImage.php');
include('./src/Zip.php');

$password = "admin789";
$err_msg = '';
if($_POST && $_POST['password']==$password){
    $zip = new Zip();
    $zip->cleareData(DATA_PATH);
    ////
    $year = $_POST['year'];
    $installment = $_POST['installment'];
    $no = $_POST['no'];
    $barcode = $_POST['barcode'];
    $bg_path = "./bg/bg_test.jpg";
    if($_FILES){
        $target_dir = "bg/";
        $target_file = $target_dir ."bg.jpg";
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        if($check !== false) {
            if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
                $bg_path = $target_file;
            }
        }
    }
    ////
    for($i=0;$i<=99;$i++){
        $two_number = str_pad($i,2,'0',STR_PAD_LEFT);
        $one = mb_substr($two_number,0,1);
        $two = mb_substr($two_number,1,1);
        $n = [rand(0,9),rand(0,9),rand(0,9),rand(0,9),$one,$two];
        
        $LotteryImage = new LotteryImage();
        $LotteryImage->create($year,$installment,$no,$barcode,$bg_path,$n);
        $LotteryImage->createImag();
    }

    $zip = new Zip();
    $zip->createZip(DATA_PATH,'./data.zip');
    header('refresh: 0; url=data.zip');
}else if($_POST && $_POST['password']!=$password){
    $err_msg = 'รหัสผ่านไม่ถูกต้อง';
}

?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    </head>
    <body>
        <div class="main">
            <h3 style="text-align: center;">สร้างรูปภาพ</h3>
            <div class="form_data">
            <!-- -->
                <?php 
                if($err_msg!==''){
                ?>
                <div><?php echo $err_msg; ?></div>
                <?php } ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="year">ปี :</label>
                        <input type="text" class="form-control" id="year" name="year" require>
                    </div>
                    <div class="form-group">
                        <label for="installment">งวด :</label>
                        <input type="text" class="form-control" id="year" name="installment" require>
                    </div>
                    <div class="form-group">
                        <label for="no">ชุด :</label>
                        <input type="text" class="form-control" id="year" name="no" require>
                    </div>
                    <div class="form-group">
                        <label for="barcode">รหัส 4 หลักหลังของบาร์โค้ค :</label>
                        <input type="text" class="form-control" id="barcode" name="barcode" require>
                    </div>
                    <div class="form-group">
                        <label for="password">รหัสผ่าน :</label>
                        <input type="password" class="form-control" id="password" name="password" require>
                    </div>
                    <div class="form-group">
                        <label for="password">ไฟล์พื้นหลัง :</label>
                        <div>
                            <input type="file" name="fileToUpload" id="fileToUpload"  require>
                        </div>
                    </div>
                    <div style="margin-top: 25px;">
                        <button type="submit"  class="btn btn-success">ดาวน์โหลดไฟล์</button>
                    </div>
                </form>
            <!-- -->
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
    <style>
        .main{
           margin-top:30px;
        }

        .form_data{
            width: 100%;
            max-width: 600px;
            background-color: #A5D7E8;
            padding: 50px;
            border-radius: 10px;
            margin: auto;
        }
    </style>
</html>