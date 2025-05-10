<?php
// Include config file
require_once __DIR__ . '/../secure/config.php';
 
// Define variables and initialize with empty values
$wine_id = $producer = $supplier = $category = $year = $region = $cost = $price = $quantity = "";
$name_err = $producer_err = $supplier_err = $category_err = $year_err = $region_err = $cost_err = $price_err = $quantity_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate wine_id
    $input_wine_id = trim($_POST["wine_id"]);
    if(empty($input_wine_id)){
        $wine_id_err = "Please enter the value.";     
    } elseif(!ctype_digit($input_wine_id)){
        $wine_id_err = "Please enter a positive integer value.";
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
        $supplier= $input_supplier;
    }
    
    // Validate category
    $input_category = trim($_POST["category"]);
    if(empty($input_category)){
        } elseif(!filter_var($input_category, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $category_err = "Please enter a valid name.";
    } else{
        $category= $input_category;
    }
     // Validate year
    $input_year = trim($_POST["year"]);
    if(empty($input_year)){
        $year_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_year)){
        $year_err = "Please enter a positive integer value.";
    } else{
        $year = $input_year;
    }
       // Validate region
       $input_region = trim($_POST["region"]);
       if(empty($input_region)){
           } elseif(!filter_var($input_region, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
           $region_err = "Please enter a valid name.";
       } else{
           $region= $input_region;
       }
           // Validate cost
    $input_cost = trim($_POST["cost"]);
    if(empty($input_cost)){
        $cost_err = "Please enter the cost amount.";     
    } elseif(!is_numeric($input_cost)){
        $cost_err = "Please enter a positive integer value.";
    } else{
        $cost = $input_cost;
    }
    // Validate price
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter the price amount.";     
    } elseif(!is_numeric($input_price)){
        $price_err = "Please enter a positive integer value.";
    } else{
        $price = $input_price;
    }

 // Validate quantity
 $input_quantity = trim($_POST["quantity"]);
 if(empty($input_quantity)){
     $quantity_err = "Please enter the quantity amount.";     
 } elseif(!ctype_digit($input_quantity)){
     $quantity_err = "Please enter a positive integer value.";
 } else{
     $quantity = $input_quantity;
 }
    // Check input errors before inserting in database
    if(empty($wine_id_err) && empty($producer_err) && empty($supplier_err) && empty($category_err) 
    && empty($year_err) && empty($region_err) && empty($cost_err) 
&& empty($price_err) && empty($quantity_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO wines (wine_id, producer, supplier, category, year, region, cost, price, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";         
        if($stmt = mysqli_prepare($db_connect, $sql)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssisdii", $param_wine_id, $param_producer, 
            $param_supplier, $param_category, $param_year, $param_region, 
            $param_cost, $param_price, $param_quantity);
            
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
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="layout.css">
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
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

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
                        
                        <input type="submit" class="btn btn-primary y-2" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>