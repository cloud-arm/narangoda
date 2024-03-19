<?php
session_start();
include('connect.php');
date_default_timezone_set("Asia/Colombo");

$name = $_POST['name'];
$phone_no = $_POST['phone_no'];
$address = $_POST['address'];
$nic = $_POST['nic'];
$etf_no = $_POST['epf_no'];
$etf_amount = $_POST['epf_amount'];
$des_id = $_POST['des'];
$rate = $_POST['rate'];
$well = $_POST['well'];
$ot = $_POST['ot'];
$id = $_POST['id'];


$user_name = explode(' ', trim($name))[0];
$password = '';

if ($des_id == 1) {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
}

$user_name = lcfirst($user_name);

$attend_date = date('Y-m-d');
$type = '1';

$result = $db->prepare("SELECT * FROM employees_des WHERE id=:id ");
$result->bindParam(':id', $des_id);
$result->execute();
for ($i = 0; $row = $result->fetch(); $i++) {
    $des_id = $row['id'];
    $des = $row['name'];
    $type = $row['type'];
}

echo $_POST['image'];

$imageUploadPath = '';
if (isset($_POST["image"])) {
    function compressImage($source, $destination, $quality)
    {
        // Get image info 
        $imgInfo = getimagesize($source);
        $mime = $imgInfo['mime'];

        // Create a new image from file 
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                imagejpeg($image, $destination, $quality);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                imagepng($image, $destination, $quality);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($source);
                imagegif($image, $destination, $quality);
                break;
            default:
                $image = imagecreatefromjpeg($source);
                imagejpeg($image, $destination, $quality);
        }

        // Return compressed image 
        return $destination;
    }

    // File upload path 
    $uploadPath = "user_pic/";

    // Check if the directory exists, if not, create it
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0777, true); // Create the directory with full permissions (0777)
    }


    // If file upload form is submitted 
    $status = $statusMsg = '';
    if (!empty($_FILES["image"]["name"])) {
        $status = 'error';

        // File info 
        $fileName = $user_name . '.' . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $imageUploadPath = $uploadPath . $fileName;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

        // Allow certain file formats 
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            // Image temp source 
            $imageTemp = $_FILES["image"]["tmp_name"];

            // Compress size and upload image 
            $compressedImage = compressImage($imageTemp, $imageUploadPath, 60);

            if ($compressedImage) {
                $status = 'success';
                $statusMsg = "Image compressed successfully.";
            } else {
                $statusMsg = "Image compress failed!";
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
        }
    } else {
        $statusMsg = 'Please select an image file to upload.';
    }
    echo $statusMsg;
}


if ($id == 0) {

    $sql = "INSERT INTO employee (name,type,phone_no,nic,address,attend_date,hour_rate,des,des_id,epf_no,epf_amount,ot,well,action,user_name,password,pic) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $q = $db->prepare($sql);
    $q->execute(array($name, $type, $phone_no, $nic, $address, $attend_date, $rate, $des, $des_id, $etf_no, $etf_amount, $ot, $well, 1, $user_name, $password, $imageUploadPath));
} else {

    $sql = "UPDATE employee SET name = ?, address = ?, nic = ?, phone_no = ?, hour_rate = ?, des = ?, des_id = ?, epf_amount = ?, epf_no = ?, ot = ?, well = ?, user_name = ?, password = ?, type = ? WHERE id = ? ";
    $q = $db->prepare($sql);
    $q->execute(array($name, $address, $nic, $phone_no, $rate, $des, $des_id, $etf_amount, $etf_no, $ot, $well, $user_name, $password, $type, $id));
}

if (isset($_POST['end'])) {

    header("location: hr_employee_profile.php?id=$id");
} else {

    // header("location: hr_employee.php");
}
