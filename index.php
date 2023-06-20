<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="stylesheet" href="./assets/scss/css/style.css" />
    <script type="module" defer src="./assets/js/validate.js"></script>
    <title>Hackers Poulette</title>
</head>

<body>
    <?php
    $name = $firstname = $email = $description = "";
    $file_error = "";
    $response = "";
    //////////////////////validation/////////////
    include 'assets/php/validate.php';
    ////////////////////////////////////////////
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = sanitize_input($_POST["name"]);
        $firstname = sanitize_input($_POST["firstname"]);
        $email = sanitize_input($_POST["email"]);
        $description = sanitize_input($_POST["description"]);
        $name_valid = strlen($name) >= 2 && strlen($name) <= 255;
        $firstname_valid = strlen($firstname) >= 2 && strlen($firstname) <= 255;
        $email_valid = validate_email($email);
        $description_valid = strlen($description) >= 2 && strlen($description) <= 1000;

        $file_error = validate_file($_FILES["file"]);

        ///////////////////////reCaptcha//////////////////////
        include 'assets/php/verify.php';
        //////////////////////////////////////////////////////
        if ($captcha_valid && $name_valid && $firstname_valid && $email_valid && $description_valid) {

            $host = "localhost";
            $dbname = "id20939391_hackerp";
            $username = "root";
            $password = "";

            try {
                $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                echo "Error (connexion to the db) : " . $e->getMessage();
                exit();
            }

            ///////////////////////////////////////////////////
            $sql = "INSERT INTO support (name, firstname, email, description, file) VALUES (:name, :firstname, :email, :description, :file)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':firstname', $firstname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':description', $description);

            if ($_FILES["file"]["size"] > 0) {
                $file_content = file_get_contents($_FILES['file']['tmp_name']);
            } else {
                $file_content = null;
            }
            $stmt->bindParam(':file', $file_content, PDO::PARAM_LOB);

            if ($stmt->execute()) {
                $response .= "Insertion to the db ok.<br>";
            } else {
                $response .= "Error (insertion db).<br>";
            }

            $response = "<div class='response__ok'>Thank you for contacting us</div>";

            $name = $firstname = $file = $email = $description = "";
        } else {
            $response = "<div class='response__fail'>Please fill in all the required fields correctly.</div>";
        }

        echo $response;
    }
    ?>

    <div class="container">
        <div class="container__info">
            <h1>Welcome to our contact and support page!</h1>
            <p>To contact us, you can use the form below by filling in the necessary fields. We encourage you to provide as much detail as possible so that we can better understand your request and provide you with appropriate assistance.</p>
            <span class="container__info__mail">✉</span>
        </div>
        <div class="container__support">
            <h2>Contact support</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data" onsubmit="return validateForm()">


                <input type="text" name="name" placeholder="Name">
                <input type="text" name="firstname" placeholder="First Name">
                <input type="email" name="email" placeholder="Email">
                <input type="file" name="file">

                <textarea name="description" rows="5" cols="40" placeholder="Description"></textarea>
                <span id="error" class="error"></span>
                <div class="g-recaptcha" data-sitekey="6Lcurq8mAAAAAPtjE1hMOJjuQeFEGjP3gM8n7SWZ"></div>

                <input class="btn__submit" type="submit" name="submit" value="Submit">

            </form>
        </div>
    </div>
</body>

</html>