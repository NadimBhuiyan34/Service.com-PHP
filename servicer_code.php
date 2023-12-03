<?php
// Assuming $type_text and other variables are already defined
$type_text = isset($_GET['type']) ? $_GET['type'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get the current page from the query parameter
$itemsPerPage = 8; // Number of items to display per page

$offset = ($page - 1) * $itemsPerPage; // Calculate the offset

if ($type_text == 'All') {
    // Your database query here
     $countQuery = "SELECT * FROM `users` WHERE status = 'Active' AND role = 'servicer'";
    $result = mysqli_query($connection, $countQuery);
    $totalItems = mysqli_num_rows($result); // Get the total number of items
    $totalPages = ceil($totalItems / $itemsPerPage);

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
        $servicers = mysqli_query($connection, $servicerQuery);
}
else if($type_text != 'All')
{
    $servicerQuery = "SELECT users.*, servicer_profiles.*, ROUND(COALESCE(AVG(reviews.rating_point), 0), 1) AS average_rating
    FROM users 
    JOIN servicer_profiles ON users.id = servicer_profiles.user_id 
    LEFT JOIN reviews ON servicer_profiles.user_id = reviews.servicer_id 
    WHERE servicer_profiles.category_id = $category_id 
      AND users.status = 'Active'
    GROUP BY servicer_profiles.user_id
    ORDER BY average_rating DESC
    LIMIT $itemsPerPage
    OFFSET $offset";
     
    
}
 

?>

 
