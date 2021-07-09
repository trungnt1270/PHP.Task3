<?php

require_once 'config.php';


$name = $address = $salary = "";
$name_err = $address_err = $salary_err ="";


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    // validate name
    $input_name = trim($_POST["name"]);
    if (empty($input_name)){
        $name_err = "Please enter a name.";
    } else if (!filter_var(trim($_POST["name"]),FILTER_VALIDATE_REGEXP,
    array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = "Please enter a valid name.";
    } else {
        $name = $input_name;
    }


    $input_address = trim($_POST["address"]);
    if (empty($input_address)){
        $address_err = "Please enter an address.";
    } else {
        $address = $input_address;
    }

    $input_salary = trim($_POST["salary"]);
    if (empty($input_salary)){
        $salary_err = "Please enter the salary amount.";
    } elseif (!ctype_digit($input_salary)){
        $salary_err = "Please enter a positive integer value.";
    } else {
        $salary = $input_salary;
    }

if (empty($name_err) && empty($address_err) && empty($salary_err)){
    $sql = "INSERT INTO employees(name, address, salary) VALUES (?,?,?)";

        if ($stmt = mysqli_prepare($tDB,$sql)){
            mysqli_stmt_bind_param($stmt,"ssd",$param_name,$param_address,$param_salary);

            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;


            if (mysqli_stmt_execute($stmt)){
                header("location: index.php");
                exit();
            }else {
                echo "Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($tDB);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Create Record</h2>
                </div>
                <p>Please fill this form and subpit to add employee record to database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

                    <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                    <label>Name</label>
                     <input type="text" name="name" class="form-control" value="">
                    <span class="help-block"><?php echo $name_err; ?></span>
                    </div>

                    <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                    <label>Address</label>
                    <textarea type="text" name="address" class="form-control" value=""></textarea>
                    <span class="help-block"><?php echo $address_err; ?></span>
                    </div>

                    <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                    <label>Salary</label>
                    <input type="text" name="salary" class="form-control" value="">
                    <span class="help-block"><?php echo $salary_err; ?></span>
                    </div>

                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-default">Cancel</a>

                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
