<?php
// Assuming $type_text and other variables are already defined

if(isset($_GET['type']))
{
    $type_text = isset($_GET['type']) ? $_GET['type'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page from the query parameter
$itemsPerPage = 8; // Number of items to display per page

$offset = ($page - 1) * $itemsPerPage; // Calculate the offset
    if ($type_text == 'All') {
        // Your database query here
        // Your pagination query here, using LIMIT and OFFSET
        $servicerQuery = "
            SELECT 
                users.id AS user_id, 
                users.name, 
                users.mobile, 
                users.created_at, 
                servicer_profiles.experience,
                servicer_profiles.address, 
                servicer_profiles.biography, 
                servicer_profiles.profile_image, 
                AVG(reviews.rating_point) AS average_rating, 
                categories.title AS category_title
            FROM 
                users
            JOIN 
                servicer_profiles ON users.id = servicer_profiles.user_id
            LEFT JOIN 
                reviews ON servicer_profiles.user_id = reviews.servicer_id
            LEFT JOIN 
                categories ON servicer_profiles.category_id = categories.id
            WHERE 
                users.status = 'Active'
            GROUP BY 
                users.id, 
                users.name, 
                users.mobile, 
                users.created_at, 
                servicer_profiles.experience,
                servicer_profiles.address, 
                servicer_profiles.biography, 
                servicer_profiles.profile_image,
                categories.title
            ORDER BY 
                average_rating DESC
            LIMIT $itemsPerPage
            OFFSET $offset";
            
    }
    
    else if($type_text != 'All')
    {
        
        $servicerQuery = "
        SELECT 
            users.id AS user_id, 
            users.name, 
            users.mobile, 
            users.created_at, 
            servicer_profiles.experience,
            servicer_profiles.address, 
            servicer_profiles.biography, 
            servicer_profiles.profile_image, 
            AVG(reviews.rating_point) AS average_rating, 
            categories.title AS category_title
        FROM 
            users
        JOIN 
            servicer_profiles ON users.id = servicer_profiles.user_id
        LEFT JOIN 
            reviews ON servicer_profiles.user_id = reviews.servicer_id
        LEFT JOIN 
            categories ON servicer_profiles.category_id = categories.id
        WHERE 
            users.status = 'Active' AND
            categories.id = $type_text
        GROUP BY 
            users.id, 
            users.name, 
            users.mobile, 
            users.created_at, 
            servicer_profiles.experience,
            servicer_profiles.address, 
            servicer_profiles.biography, 
            servicer_profiles.profile_image,
            categories.title
        ORDER BY 
            average_rating DESC
        LIMIT $itemsPerPage
        OFFSET $offset";
        
        $categorySql = "SELECT `title` FROM `categories` WHERE id = $type_text";
        $categoryResult = mysqli_query($connection, $categorySql);
        $categoryRow = mysqli_fetch_assoc($categoryResult);
        $type_text = $categoryRow['title'];
           
    }
    
}

else if (isset($_POST['search']))
{
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page from the query parameter
$itemsPerPage = 8; // Number of items to display per page

$offset = ($page - 1) * $itemsPerPage; // Calculate the offset
    $area = $_POST['area'];
    $category = $_POST['category'];
    
    if(!empty($area) && empty($category))
    {
        $servicerQuery = "
        SELECT 
            users.id AS user_id, 
            users.name, 
            users.mobile, 
            users.created_at, 
            servicer_profiles.experience,
            servicer_profiles.address, 
            servicer_profiles.biography, 
            servicer_profiles.profile_image, 
            AVG(reviews.rating_point) AS average_rating, 
            categories.title AS category_title
        FROM 
            users
        JOIN 
            servicer_profiles ON users.id = servicer_profiles.user_id
        LEFT JOIN 
            reviews ON servicer_profiles.user_id = reviews.servicer_id
        LEFT JOIN 
            categories ON servicer_profiles.category_id = categories.id
        WHERE 
            users.status = 'Active' AND
            servicer_profiles.area = '$area'
        GROUP BY 
            users.id, 
            users.name, 
            users.mobile, 
            users.created_at, 
            servicer_profiles.experience,
            servicer_profiles.address, 
            servicer_profiles.biography, 
            servicer_profiles.profile_image,
            categories.title
        ORDER BY 
            average_rating DESC
        LIMIT $itemsPerPage
        OFFSET $offset";
      
    }
    else if(empty($area) && !empty($category))
    {
        $servicerQuery = "
        SELECT 
            users.id AS user_id, 
            users.name, 
            users.mobile, 
            users.created_at, 
            servicer_profiles.experience,
            servicer_profiles.address, 
            servicer_profiles.biography, 
            servicer_profiles.profile_image, 
            AVG(reviews.rating_point) AS average_rating, 
            categories.title AS category_title
        FROM 
            users
        JOIN 
            servicer_profiles ON users.id = servicer_profiles.user_id
        LEFT JOIN 
            reviews ON servicer_profiles.user_id = reviews.servicer_id
        LEFT JOIN 
            categories ON servicer_profiles.category_id = categories.id
        WHERE 
            users.status = 'Active' AND
            categories.title = '$category'
        GROUP BY 
            users.id, 
            users.name, 
            users.mobile, 
            users.created_at, 
            servicer_profiles.experience,
            servicer_profiles.address, 
            servicer_profiles.biography, 
            servicer_profiles.profile_image,
            categories.title
        ORDER BY 
            average_rating DESC
        LIMIT $itemsPerPage
        OFFSET $offset";
    }
    else if(!empty($area) && !empty($category))
    {
        $servicerQuery = "
        SELECT 
            users.id AS user_id, 
            users.name, 
            users.mobile, 
            users.created_at, 
            servicer_profiles.experience,
            servicer_profiles.address, 
            servicer_profiles.biography, 
            servicer_profiles.profile_image, 
            AVG(reviews.rating_point) AS average_rating, 
            categories.title AS category_title
        FROM 
            users
        JOIN 
            servicer_profiles ON users.id = servicer_profiles.user_id
        LEFT JOIN 
            reviews ON servicer_profiles.user_id = reviews.servicer_id
        LEFT JOIN 
            categories ON servicer_profiles.category_id = categories.id
        WHERE 
            users.status = 'Active' AND
            servicer_profiles.area = '$area' AND
            categories.title = '$category'
        GROUP BY 
            users.id, 
            users.name, 
            users.mobile, 
            users.created_at, 
            servicer_profiles.experience,
            servicer_profiles.address, 
            servicer_profiles.biography, 
            servicer_profiles.profile_image,
            categories.title
        ORDER BY 
            average_rating DESC
        LIMIT $itemsPerPage
        OFFSET $offset";
    }
    else
    {
              $message = "Input filed is required";
              header("Location: servicer.php?type=" . urlencode('All'));            
              exit; 
    }
       

}
$servicers = mysqli_query($connection, $servicerQuery);
$totalItems = mysqli_num_rows($servicers); // Get the total number of items
$totalPages = ceil($totalItems / $itemsPerPage);

?>

 
