<?php include 'config.php';
$name = $address = $salary = $id= '';
$name_err = $address_err = $salary_err = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $db_select_query = "SELECT * FROM employees where id='$id'";
    $record = $link->query($db_select_query);
    if (mysqli_num_rows($record) > 0 ) {
        $n = mysqli_fetch_array($record);
        $name = $n['name'];
        $address = $n['address'];
        $salary = $n['salary'];
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['name'])) {
        $name_err = 'Name should not be empty';
    } else {
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    }

    if (empty($_POST['address'])) {
        $address_err = 'Address should not be empty';
    } else {
        $address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
    }

    if (empty($_POST['salary'])) {
        $salary_err = 'Salary should not be empty';
    } elseif (ctype_digit($salary)) {
        $salary_err = 'Please enter salary positive value';
    } else {
        $salary = $_POST['salary'];
    }

    if (empty($name_err) && empty($address_err) && empty($salary_err)) {
        $id = $_POST['id'];
       if ($id) {
           $db_update_query = "UPDATE employees SET name='$name', address='$address', salary='$salary' WHERE id=$id";
           if ($link->query($db_update_query) === true) {
               header('location: LandingPage.php');
               exit();
           } else {
               echo 'issue with updationg '. $link->error;
           }
       } else {
           $db_insert_query = "INSERT INTO employees (name, address, salary) VALUES ('$name', '$address', '$salary')";
           if ($link->query($db_insert_query) === true) {
               header('location: LandingPage.php');
               exit();
           } else {
               echo 'issue with insertion '. $link->error;
           }
       }

    }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Create Record</h2>
                </div>
                <p>Please fill this form and submit to add employee record to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                        <span class="help-block"><?php echo $name_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                        <label>Address</label>
                        <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                        <span class="help-block"><?php echo $address_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($salary_err)) ? 'has-error' : ''; ?>">
                        <label>Salary</label>
                        <input type="text" name="salary" class="form-control" value="<?php echo $salary; ?>">
                        <span class="help-block"><?php echo $salary_err; ?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="LandingPage.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
