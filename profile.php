// profile image
        // if($profileImage = $_FILES['profileImage'])
        // {
        //     $profileImage = $_FILES['profileImage']['name'];
        //     $profileImageTmp = $_FILES['profileImage']['tmp_name']; 
        //     $profileImageDestination = "admin/public/profile/" . $profileImage;
        //     move_uploaded_file($profileImageTmp, $profileImageDestination);
        // }
        //  work image
        // if($_FILES['workImage'])
        // {
        //     $workImages = $_FILES['workImage'];
        //     $workImageNames = array();

        //     foreach ($workImages['tmp_name'] as $key => $tmp_name) {
        //         $workImage = $workImages['name'][$key];
        //         $workImageTmp = $tmp_name;
        //         $workImageNames[] = $workImage;
        //         $workImageDestination = "admin/public/workimage/" . $workImage;
        //         // $workImageDestinations[] = $workImageDestination;
                
        //         move_uploaded_file($workImageTmp, $workImageDestination);
        //     }
            
        // }

                // Convert array of image paths to comma-separated string
                // $workImageNamesJson = json_encode($workImageNames);
