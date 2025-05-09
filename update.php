<?php
// Include config file
include "includes/config.php";
 
 
// Define variables and initialize with empty values
$wine_id = $producer = $supplier = $category = $year = $region = $cost = $price = $quantity = "";
$wine_id_err = $producer_err = $supplier_err = $category_err = $year_err = $region_err = $cost_err = $price_err = $quantity_err = "";
 
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate wine_id
    $input_wine_id = trim($_POST["wine_id"]);
    if(empty($input_wine_id)){
        $wine_id_err = "Please enter the value.";     
    } elseif(!ctype_digit($input_wine_id)){
        $wine_id_err = "Please enter a positive value.";
    } else{
        $wine_id = $input_wine_id;
    }

// Validate producer
    $input_producer = trim($_POST["producer"]);
    if(empty($input_producer)){
        $producer_err = "Please enter a producer.";
    } elseif(!filter_var($input_producer, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $producer_err = "Please enter a valid name.";
    } else{
        $producer = $input_producer;
    }
    
    // Validate supplier
    $input_supplier = trim($_POST["supplier"]);
    if(empty($input_supplier)){
        } elseif(!filter_var($input_supplier, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $supplier_err = "Please enter a valid name.";
    } else{
        $supplier = $input_supplier;
    }
    
    // Validate category
    $input_category = trim($_POST["category"]);
    if(empty($input_category)){
        } elseif(!filter_var($input_category, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $category_err = "Please enter a valid name.";
    } else{
        $category = $input_category;
    }
     // Validate year
    $input_year = trim($_POST["year"]);
    if(empty($input_year)){
        $year_err = "Please enter the year.";     
    } elseif(!ctype_digit($input_year)){
        $year_err = "Please enter a positive value.";
    } else{
        $year = $input_year;
    }
       // Validate region
       $input_region = trim($_POST["region"]);
       if(empty($input_region)){
           } elseif(!filter_var($input_region, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
           $region_err = "Please enter a valid name.";
       } else{
           $region = $input_region;
       }
           // Validate cost
    $input_cost = trim($_POST["cost"]);
    if(empty($input_cost)){
        $cost_err = "Please enter the cost amount.";     
    } elseif(!is_numeric($input_cost)){
        $cost_err = "Please enter a positive value.";
    } else{
        $cost = $input_cost;
    }
    // Validate price
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter the price amount.";     
    } elseif(!is_numeric($input_price)){
        $price_err = "Please enter a positive value.";
    } else{
        $price = $input_price;
    }

 // Validate quantity
 $input_quantity = trim($_POST["quantity"]);
 if(strlen($input_quantity) == 0){
     $quantity_err = "Please enter the quantity.";     
 } elseif(!ctype_digit($input_quantity)){
     $quantity_err = "Please enter a positive value.";
 } else{
     $quantity = $input_quantity;
 }
    
       // Check input errors before inserting in database
       if(empty($wine_id_err) && empty($producer_err) && empty($supplier_err) && empty($category_err) 
       && empty($year_err) && empty($region_err) && empty($cost_err) 
   && empty($price_err) && empty($quantity_err)){

        // Prepare an update statement
        $sql = "UPDATE wines SET wine_id=?, producer=?, supplier=?, category=?,
         year=?, region=?, cost=?, price=?, quantity=?  WHERE wine_id=?";
         
        if($stmt = mysqli_prepare($db_connect, $sql)){
             
             // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isssisidii", $param_wine_id, $param_producer, $param_supplier,
              $param_category, $param_year, $param_region, $param_cost, $param_price, $param_quantity, $param_id);

                  // Set parameters
             $param_wine_id = $wine_id;
             $param_producer = $producer;
            $param_supplier = $supplier;
             $param_category = $category;
             $param_year = $year;
             $param_region = $region;
            $param_cost = $cost;
             $param_price = $price;
             $param_quantity = $quantity;
             $param_id = $id;

                // mysqli_stmt_bind_param($stmt, "isssisidii", $wine_id, $producer,
                // $supplier, $category, $year, $region, $cost, $price, $quantity, $id);

    
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($db_connect);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM wines WHERE wine_id = ?";

        if($stmt = mysqli_prepare($db_connect, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                $wine_id = $row['wine_id'];
                $producer = $row['producer'];
                $supplier = $row['supplier'];
                $category = $row['category'];
                $year = $row['year'];
                $region = $row['region'];
                $cost = $row['cost'];
                $price = $row['price'];
                $quantity = $row['quantity'];
              
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($db_connect);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mb-5">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the wine record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

                 <div class="form-group">
                            <label>Wine ID</label>
                            <input type="text" name="wine_id" class="form-control <?php echo (!empty($wine_id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $wine_id; ?>">
                            <span class="invalid-feedback"><?php echo $wine_id_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Producer</label>
                            <textarea name="producer" class="form-control <?php echo (!empty($producer_err)) ? 'is-invalid' : ''; ?>"><?php echo $producer; ?></textarea>
                            <span class="invalid-feedback"><?php echo $producer_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Supplier</label>
                            <input type="text" name="supplier" class="form-control <?php echo (!empty($supplier_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $supplier; ?>">
                            <span class="invalid-feedback"><?php echo $supplier_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" name="category" class="form-control <?php echo (!empty($category_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $category; ?>">
                            <span class="invalid-feedback"><?php echo $category_err;?></span>
                        </div>
                        <div class="form-group">
                        <label>Year</label>
                            <input type="text" name="year" class="form-control <?php echo (!empty($year_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $year; ?>">
                            <span class="invalid-feedback"><?php echo $year_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Region</label>
                            <input type="text" name="region" class="form-control <?php echo (!empty($region_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $region; ?>">
                            <span class="invalid-feedback"><?php echo $region_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Cost</label>
                            <input type="text" name="cost" class="form-control <?php echo (!empty($cost_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cost; ?>">
                            <span class="invalid-feedback"><?php echo $cost_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" name="quantity" class="form-control <?php echo (!empty($quantity_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $quantity; ?>">
                            <span class="invalid-feedback"><?php echo $quantity_err;?></span>
                        </div>             
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>