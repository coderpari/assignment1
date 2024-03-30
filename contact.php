<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpasswd = "";
$dbname = "niral_assignment";
$downloadLink = "assets/download.zip";
$success = 0 ;
$message = "";

$conn = new mysqli( $dbhost, $dbuser, $dbpasswd, $dbname);

if($conn->connect_error){
    die("connection field".$con->connect_error);
}

function validate_number($phone)
{
    return preg_match('/^[0-9]{10}+$/', $phone);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $contactNumber = $_POST['contactNumber'];
    $companyName = $_POST['companyName'];
    // Perform validation (you can add more validation as needed)
    if (empty($firstName)) {
        $message = "First Name is required.";
    }else if(empty($lastName)){
        $message = "Last name is required.";
    }else if( empty($city) ){
        $message = "City is required.";
    }
    else if( empty($country) ){
        $message = "Country is required.";
    }
    else if( empty($contactNumber) ){
        $message = "ContactNumber is required.";
    }
    else if( !validate_number($contactNumber) || !intval($contactNumber) ){
        $message = "The phone number must consist of 10 digits.";
    }
    else if( empty($companyName) ){
        $message = "Company Name is required.";
    } else {
            $query = "INSERT INTO `users` ( `fname` , `lname` , `city` , `country` ,`contact_number` , `company_name` ) 
                VALUES ('$firstName','$lastName',' $city','$country','$contactNumber', '$companyName')";

            if (mysqli_query($conn, $query)) {
                // Provide the download link (replace "path/to/your/download/file" with the actual download link)                 
                 $success = 1;
                 $message = "Thank you, $firstName $lastName! Your download link: <a href='$downloadLink'>Download</a>";
            }else{
                $message = "Something went wrong. Please Try later after sometime" ;
            }
        }
    }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <?php if(!$success){ ?>
            <h2>Fill in your details to download</h2>
            <p class="error message" ><?php echo $message; ?></p>
        <form action="contact.php" method="post" novalidate>
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required value="<?php if(isset($firstName)){ echo $firstName; } ?>"><br><br>
            
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required value="<?php  if(isset($lastName)){  echo $lastName; } ?>"><br><br>
            
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required value="<?php  if(isset($city)){  echo $city; } ?>"><br><br>
            
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" required value="<?php  if(isset($country)){  echo $country; } ?>"><br><br>
            
            <label for="contactNumber">Contact Number:</label>
            <input type="text" id="contactNumber"  name="contactNumber" required value="<?php  if(isset($contactNumber)){  echo $contactNumber; } ?>" maxlength="10" size="10"><br><br>
            
            <label for="companyName">Company Name:</label>
            <input type="text" id="companyName" name="companyName" required value="<?php  if(isset($companyName)){  echo $companyName; } ?>"><br><br>
            
            <input type="submit" value="Submit" class="btn-submit">
        </form>
        <?php }else{ ?>
            
            <p class="success message" ><?php echo $message; ?></p>

        <?php } ?>
    </div>
</body>
</html>


