<?php 
$servername = "kovic.com"; // Change this to the actual hostname of your database server
$username = "Victor"; // Change this to your database username
$password = "Acit3420@com"; // Change this to your database password
$database = "Webproject"; // Change this to the name of your database

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
} else {
   //echo "Connected successfully to the database.";
}

// Fetch product information from the database
$sql = "SELECT * FROM product";
$result = $connection->query($sql);

// Display products dynamically
$imageCount = 1; // Initialize the image count
if ($result) {
    while($row = $result->fetch_assoc()) {
        // Start dynamic product item
        echo '<div class="col-lg-3 col-md-6 col-sm-12 pb-1">';
        echo '<div class="card product-item border-0 mb-4">';
        echo '<div class="card-header product-img position-relative overflow-hidden bg-transparent border">';
        echo '<img class="img-fluid w-100" src="img/product-' . $imageCount . '.jpg" alt="">';
        echo '</div>';
        echo '<div class="card-body border-left border-right text-center p-0 pt-4 pb-3">';
        echo '<h6 class="text-truncate mb-3">' . $row["product_name"] . '</h6>';
        echo '<div class="d-flex justify-content-center">';
        echo '<h6>$' . $row["product_price"] . '</h6>';
        echo '</div>';
        // Adjust the below line according to how you retrieve quantity from the database
        echo '<div class="d-flex justify-content-center"><h6>Quantity:</h6><h6 class="text-muted ml-2">' . $row["product_quantity"] . '</h6>'; 
        echo '</div>';
        echo '</div>';
        echo '<div class="card-footer d-flex justify-content-between bg-light border">';
        echo '<a href="#" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View</a>';
        echo '<a href="#" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add to Cart</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        // End dynamic product item

        $imageCount++; // Increment the image count for the next product
    }
} else {
    echo "Error fetching products: " . $connection->error;
}

// Close the connection
$connection->close();
?>
