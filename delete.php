<?php

if (isset($_POST["id"]) && !empty($_POST["id"])){

    require_once 'config.php';


    $sql   = "DELETE FROM employees WHERE id = ?";

    if ($stmt = mysqli_prepare($tDB,$sql)){

        mysqli_stmt_bind_param($stmt,"i",$param_id);


        $param_id = trim($_POST["id"]);


        if (mysqli_stmt_execute($stmt)){

            header("location: index.php");
            exit();
        }else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    mysqli_stmt_close($stmt);

    mysqli_close($tDB);
} else {

    if(empty(trim($_GET["id"]))){

        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Delete Recort</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wapper{
            width: 750px;
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
                    <h1>Delete Recort</h1>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="alert alert-danger fade in">
                        <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                        <p>Are you sure you want to delete this record?</p> <br>
                        <p>
                            <input type="submit" value="Yes" class="btn btn-danger">
                            <a href="index.php" class="btn btn-default">No</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

