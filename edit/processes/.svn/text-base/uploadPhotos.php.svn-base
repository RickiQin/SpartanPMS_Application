<?php
require_once("../../inc/SiteBuilderClass.php");
require_once("../../inc/classes/User.php");
require_once("../../inc/classes/Property.php");
require_once("../../inc/classes/PropertyImage.php");
require_once("../../inc/classes/PropertyDetails.php");
require_once("../../inc/classes/ImageResizer.php");

if(!isset($_POST)) {
    echo "An error occurred.";
     die();
} 
   
$user = new User();   
   
if(!($user -> isLoggedIn && $user -> department < 4)) { ?>
    <center>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE</center>
<?php die(); 
} 


if(isset($_POST['property_id'])) {
    $propertyID = $_POST['property_id'];

} else {
    echo "An error occurred.";
    die();
}

// CHECK IF DIRECTORY EXISTS FOR PROPERTY, IF NOT, CREATE IT
$rootDir = "../../image/properties/" . $propertyID;
$rootURI = "/image/properties/" . $propertyID;

if (!file_exists($rootDir) && !is_dir($rootDir)) {
    mkdir($rootDir, 0755);
} 

if(!is_dir($rootDir)) {
    echo "ERROR CREATING IMAGE DIRECTORY";
    die();
}

$image = new PropertyImage();
$imageResizer = new ImageResizer();
if(isset($_FILES)) {
    $file = $_FILES['propertyimage'];
    // Loops through each uploaded image
    for($i = 0; $i < count($file['name']); $i++) {
        if(strlen($file['name'][$i]) > 0) {
            $imageResizer -> load($file['tmp_name'][$i]);
            
            $imagePath = pathinfo($file['name'][$i]);
            $imageName = $imagePath['filename'];
            $imageExt = "." . $imagePath['extension'];
            
            $j=2;
            $tempImageName = $imageName;
            while(true) {
                $paths = array(
                    "full" => $rootDir . "/" . $tempImageName . "_FULL" . $imageExt,
                    "mid" => $rootDir . "/" . $tempImageName . "_MID" . $imageExt,
                    "small" => $rootDir . "/" . $tempImageName . "_SMALL" . $imageExt
                );
                if(file_exists($paths['full']) || file_exists($paths['mid']) || file_exists($paths['small'])) {
                    $tempImageName = $imageName . $j;
                    $j++;
                } else {
                    break;
                }
            }
            $imageName = $tempImageName;
            
            $uris = array(
                "full" => $rootURI . "/" . $imageName . "_FULL" . $imageExt,
                "mid" => $rootURI . "/" . $imageName . "_MID" . $imageExt,
                "small" => $rootURI . "/" . $imageName . "_SMALL" . $imageExt
            );
            
            $width = $imageResizer -> getWidth();
            
            if($width > 700) {
                $imageResizer -> resizeToWidth(700);
            }
           
            $height = $imageResizer -> getHeight();
            
            if($height > 600) {
                $imageResizer -> resizeToHeight(600);
            }
            
            $imageResizer -> save($paths['full']);
            
            $width = $imageResizer -> getWidth();
            
            if($width > 300) {
                $imageResizer -> resizeToWidth(300);
            }
            $height = $imageResizer -> getHeight();
            if($height > 300) {
                $imageResizer -> resizeToHeight(300);
            }
            
            $imageResizer -> save($paths['mid']);
            
            $width = $imageResizer -> getWidth();
            $height = $imageResizer -> getHeight();
            
            $imageResizer -> resizeToWidth(131);
            
            
            $imageResizer -> save($paths['small']);
            
            $data = array(
                "property_id" => $propertyID,
                "full_size_img" => $uris['full'],
                "med_thumbnail" => $uris['mid'],
                "thumbnail" => $uris['small'],
                "is_default" => 0,
                "place" => 0,
           );
           $image -> insert($data);
        }
    }
   
}

header("Location: /property_details.php?property=" . $propertyID);
?> 

