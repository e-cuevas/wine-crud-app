<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="layout.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="modal.js"></script>
</head>

<body>
        <!-- MODAL START -->
    <div class="custom-modal">
        <div class="custom-modal-content">
            <div>
                <span class="custom-close-btn">&times;</span>
            </div>
            <h2>Project Brief</h2>
            <br>
            <p>For this demo project, the goal was to create a CRUD application to practice database manipulation.
                I suggest turning your mobile device sideways to get the widest screen possible, allowing you to view the entire table more clearly.
               For the frontend, Bootstrap—a popular open-source front-end framework—was used to simplify the design of a responsive, mobile-first interface.
            </p>
        </div>
    </div>
    <!-- MODAL finish -->
 <div class="wrapper">

       <header>
         <img src="images/logo.jpg"  alt="Logo" class="header-logo">
        </header>
</div>

<main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="float-left">Wines Details</h2>
                        <a href="create.php" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add New Wine</a>
                    </div>

                    <?php
                    // Include config file
                      // filepath: public/index.php
require __DIR__ . '/../config/config.php';
                             
 // Attempt select query execution
$sql = "SELECT * FROM wines";
if($result = mysqli_query($db_connect, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo '<div class="table-responsive">'; // Add this line
        echo '<table class="table table-bordered table-striped text-center table-sm">'; // Add table-sm class
            echo "<thead>";
                echo "<tr>";
                    echo "<th>#</th>";
                    echo "<th>Producer</th>";
                    echo "<th class='d-none d-md-table-cell'>Supplier</th>"; // Hide on small screens
                    echo "<th>Category</th>";
                    echo "<th class='d-none d-md-table-cell'>Year</th>"; // Hide on small screens
                    echo "<th class='d-none d-lg-table-cell'>Region</th>"; // Hide on small and medium screens
                    echo "<th class='d-none d-lg-table-cell'>Cost</th>"; // Hide on small and medium screens
                    echo "<th>Price</th>";
                    echo "<th class='d-none d-md-table-cell'>Quantity</th>";
                    echo "<th>Actions</th>";  
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($row = mysqli_fetch_array($result)){
                echo "<tr>";
                    echo "<td>" . $row['wine_id'] . "</td>";
                    echo "<td>" . $row['producer'] . "</td>";
                    echo "<td class='d-none d-md-table-cell'>" . $row['supplier'] . "</td>"; // Hide on small screens
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td class='d-none d-md-table-cell'>" . $row['year'] . "</td>"; // Hide on small screens
                    echo "<td class='d-none d-lg-table-cell'>" . $row['region'] . "</td>"; // Hide on small and medium screens
                    echo "<td class='d-none d-lg-table-cell'>" . $row['cost'] . "</td>"; // Hide on small and medium screens
                    echo "<td>" . $row['price'] . "</td>";
                    echo "<td class='d-none d-md-table-cell'>" . $row['quantity'] . "</td>";
                    echo "<td>";
                        echo '<a href="read.php?id='. $row['wine_id'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                        echo '<a href="update.php?id='. $row['wine_id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                        echo '<a href="delete.php?id='. $row['wine_id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                    echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";                            
        echo "</table>";
        echo '</div>'; // Add this line
        // Free result set
        mysqli_free_result($result);
    } else{
        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
    }
} else{
    echo "Oops! Something went wrong. Please try again later.";
}

// Close connection
mysqli_close($db_connect);
?>

          </div>
        </div>        
     </div>
    
</main>

    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>

</body>
</html>

