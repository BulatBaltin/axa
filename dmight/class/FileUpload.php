<?php
class FileUpload {
    public $target_file;
    public $target_dir;
    public $form_input_name;
    public $source_file;
    public $imageFileType;
    public $overwrite;
    public $maxsize;
    public $uploadOk;
    
    function __construct($form_input_name, $options = [])
    {
        $_file = $_FILES[$form_input_name];
        $this->source_file = basename($_file["name"]);
        $this->form_input_name = $form_input_name;
        
        $this->overwrite    = $options['overwrite'] ?? true;
        $this->maxsize      = $options['maxsize'] ?? 0;
        $this->target_dir   = $options['target_dir'] ?? "uploads/";
        $this->target_file  = $this->target_dir . $this->getNewFileName($options); 
        $this->uploadOk     = 1;
        $this->imageFileType = strtolower(pathinfo($this->target_file,PATHINFO_EXTENSION));
    }
    private function getNewFileName($options) {
        if(isset($options['target_file']))  {
            if($options['target_file'] instanceof Closure) { // is_callable
                return $options['target_file']($this->source_file);
            } else {
                return $options['target_file'];
            }
        }
        return $this->source_file;
    }

    function CheckData() {
        $check = getimagesize($_FILES[$this->form_input_name]["tmp_name"]);
        if($check !== false) {
          $mssg = "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
        } else {
          $mssg =  "File is not an image.";
          $uploadOk = 0;
        }
        // Check file exists
        if ($uploadOk and file_exists($this->target_file) and !$this->overwrite) {
            $mssg = "File {$this->target_file} already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($uploadOk and $this->maxsize and $_FILES[$this->form_input_name]["size"] > $this->maxsize) {
            $mssg = "File is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($uploadOk and 
        $this->imageFileType != "jpg" && 
        $this->imageFileType != "png" && 
        $this->imageFileType != "jpeg" && 
        $this->imageFileType != "gif" ) {
            $mssg = "Only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        return [$uploadOk, $mssg];
    }

    function Action() {
        [ $Ok, $mssg ] = $this->CheckData();

        if($Ok) {
            $Ok = move_uploaded_file($_FILES[$this->form_input_name]["tmp_name"], $this->target_file);

            if($Ok) {
                $mssg = "The file ". htmlspecialchars( basename( $_FILES[$this->form_input_name]["name"])). " has been uploaded.";
            } else {
                $mssg = "There was an error uploading your file.";
            }
        }
        return [$Ok, $this->target_file, $mssg];
    }
}

// Check if image file is a actual image or fake image
// if(isset($_POST["submit"])) {
//   $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
//   if($check !== false) {
//     echo "File is an image - " . $check["mime"] . ".";
//     $uploadOk = 1;
//   } else {
//     echo "File is not an image.";
//     $uploadOk = 0;
//   }
// }

// // Check if file already exists
// if (file_exists($target_file)) {
//   echo "Sorry, file already exists.";
//   $uploadOk = 0;
// }

// // Check file size
// if ($_FILES["fileToUpload"]["size"] > 500000) {
//   echo "Sorry, your file is too large.";
//   $uploadOk = 0;
// }

// // Allow certain file formats
// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
// && $imageFileType != "gif" ) {
//   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
//   $uploadOk = 0;
// }

// Check if $uploadOk is set to 0 by an error
// if ($uploadOk == 0) {
//   echo "Sorry, your file was not uploaded.";
// // if everything is ok, try to upload file
// } else {
//   if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
//     echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
//   } else {
//     echo "Sorry, there was an error uploading your file.";
//   }
// }