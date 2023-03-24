<?php 

$target_dir = "uploads/";

if(isset($_POST['submit'])) {
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf', 'jpeg', 'png', 'jpg');
    $file_extension = pathinfo($fileName, PATHINFO_EXTENSION);

    if (in_array($fileActualExt, $allowed)) {
        $target_file = $target_dir . basename($fileName);

        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameNew = $fileName.".".$fileActualExt;
                $fileDestination = 'uploads/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $target_file);
                // Kriptiranje datoteke koristeci OpenSSL biblioteku
                $encrypted_file = $target_dir . "encrypted_" . $fileName;
                $key = md5('jed4n j4k0 v3l1k1 kljuc');
                $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-128-CTR'));
                $encrypted_data = openssl_encrypt(file_get_contents($target_file), 'AES-128-CTR', $key, OPENSSL_RAW_DATA, $iv);

                file_put_contents($encrypted_file, $iv . $encrypted_data);
            

                header("Location: zadatak2_forma.php?uploadsucces"); 
                
                
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "There was an error uploading your file!";    
        }
    } else {
        echo "You cannot upload files of this type!";
    }

}



?>