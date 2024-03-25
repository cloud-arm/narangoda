<?php
session_start();
include('connect.php');
// include('connection.php');
date_default_timezone_set("Asia/Colombo");


$re = $db->prepare("SELECT * FROM vat_record ");
$re->bindParam(':id', $id);
$re->execute();
for ($k = 0; $r = $re->fetch(); $k++) {

    $id = $r['id'];

    $sql = "UPDATE vat_record SET acc_id=?, acc_no=? WHERE id=?";
    $ql = $db->prepare($sql);
    $ql->execute(array(1, '00000', $id));
}

// $data = array(
//     "name" => "Test3",
//     "amount" => "150000"
// );

// $init = new Database();
// $init->insert("cash", $data);

// $updateData = array(
//     "amount" => "155000",
//     // Add more columns and values as needed
// );

// $where = "id = 6"; // Modify this according to your condition
// $db = new Database();
// $db->updateData("cash", $updateData, $where);

// // Select all data from a table
// $db = new Database();
// $data = $db->select('cash');
// foreach ($data as $list) {
//     echo $list['id'] . '/' . $list['name'] . '/' . $list['amount'] . '<br>';
// }
// // Select specific columns from a table
// $data = $db->select('cash', 'name');
// foreach ($data as $list) {
//     echo $list['name'] . '<br>';
// }
// // Select data from a table with conditions
// $data = $db->select('cash', '*', 'id = 1');
// foreach ($data as $list) {
//     echo $list['id'] . '/' . $list['name'] . '/' . $list['amount'] . '<br>';
// }

// File name and content
// $file_name = 'log/sales.txt';
// $new_content = 'This is the content of the text file. new 1111.';

// file_put_contents($file_name, $new_content . PHP_EOL, FILE_APPEND | LOCK_EX);

// if (file_put_contents($file_name, $new_content . PHP_EOL, FILE_APPEND | LOCK_EX) !== false) {
//     echo "Content has been added to '$file_name' successfully.";
// } else {
//     echo "Error: Unable to add content to file.";
// }
?>
<?php

// $imageUploadPath='';
// if (isset($_POST["img"])) {
//     function compressImage($source, $destination, $quality)
//     {
//         // Get image info 
//         $imgInfo = getimagesize($source);
//         $mime = $imgInfo['mime'];

//         // Create a new image from file 
//         switch ($mime) {
//             case 'image/jpeg':
//                 $image = imagecreatefromjpeg($source);
//                 imagejpeg($image, $destination, $quality);
//                 break;
//             case 'image/png':
//                 $image = imagecreatefrompng($source);
//                 imagepng($image, $destination, $quality);
//                 break;
//             case 'image/gif':
//                 $image = imagecreatefromgif($source);
//                 imagegif($image, $destination, $quality);
//                 break;
//             default:
//                 $image = imagecreatefromjpeg($source);
//                 imagejpeg($image, $destination, $quality);
//         }

//         // Return compressed image 
//         return $destination;
//     }

//     // File upload path 
//     $uploadPath = "user_pic/";

//     // Check if the directory exists, if not, create it
//     if (!file_exists($uploadPath)) {
//         mkdir($uploadPath, 0777, true); // Create the directory with full permissions (0777)
//     }


//     // If file upload form is submitted 
//     $status = $statusMsg = '';
//     if (!empty($_FILES["image"]["name"])) {
//         $status = 'error';

//         // File info 
//         $fileName = $_POST['name'] . '.' . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
//         $imageUploadPath = $uploadPath . $fileName;
//         $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);

//         // Allow certain file formats 
//         $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
//         if (in_array($fileType, $allowTypes)) {
//             // Image temp source 
//             $imageTemp = $_FILES["image"]["tmp_name"];

//             // Compress size and upload image 
//             $compressedImage = compressImage($imageTemp, $imageUploadPath, 60);

//             if ($compressedImage) {
//                 $status = 'success';
//                 $statusMsg = "Image compressed successfully.";
//             } else {
//                 $statusMsg = "Image compress failed!";
//             }
//         } else {
//             $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.';
//         }
//     } else {
//         $statusMsg = 'Please select an image file to upload.';
//     }

// }
?>

<!-- 
<img id="image-preview" src="<?php echo $imageUploadPath; ?>" alt="Image Preview" />

<form action="update_data.php" method="post" enctype="multipart/form-data">
    <input type="text" name="name">
    <input type="file" name="image">
    <button type="submit" name="submit">Upload Image</button>
</form> -->

<?php
// // Sample string containing a paragraph
// $paragraph = "This is a sample paragraph. It contains multiple words.";

// // Extract the first word from the paragraph
// $words = explode(' ', $paragraph);
// $firstWord = $words[0];

// // Create a simple letter using the first word
// $letter = "Dear " . lcfirst($firstWord);

// // Output the letter
// echo $letter;
?>
<?php

// $file_path = 'log/sales_list.txt';

// // Read the contents of the file into an array
// $lines = file($file_path);

// // Get the number of lines in the file
// $num_lines = count($lines);

// // Determine where to start reading the last 10 records
// $start_index = $num_lines - 10;
// if ($start_index < 0) {
//     $start_index = 0;
// }

// // Get the last 10 records
// $last_10_records = array_slice($lines, $start_index);

// // Truncate the file
// $file_handle = fopen($file_path, 'w');
// fclose($file_handle);

// // Write the last 10 records back to the file
// $file_handle = fopen($file_path, 'a');
// foreach ($last_10_records as $line) {
//     fwrite($file_handle, $line);
// }
// fclose($file_handle);

// echo "Last 10 records cleared and saved successfully.";
?>