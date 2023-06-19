<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Hackers Poulette</title>
</head>

<body>
    <?php
    $name = $firstname = $email = $description = "";
    $file_error = "";
    $response = "";

    //////////////////////////////////////////////////////////////////////
    function sanitize_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function validate_email($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validate_file($file)
    {
        $allowed_types = array('jpg', 'png', 'gif');
        $max_size = 2 * 1024 * 1024;
        $file_error = "";

        if ($file['error'] === UPLOAD_ERR_OK) {
            $file_name = $file['name'];
            $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_size = $file['size'];

            if (!in_array($file_type, $allowed_types)) {
                $file_error = "Error: only gif, jpg and png.";
            } elseif ($file_size > $max_size) {
                $file_error = "Error: max 2MB.";
            }
        }

        return $file_error;
    }

    /////////////////////////////////////////////////////////////
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = sanitize_input($_POST["name"]);
        $firstname = sanitize_input($_POST["firstname"]);
        $email = sanitize_input($_POST["email"]);
        $description = sanitize_input($_POST["description"]);
        $name_valid = strlen($name) >= 2 && strlen($name) <= 255;
        $firstname_valid = strlen($firstname) >= 2 && strlen($firstname) <= 255;
        $email_valid = validate_email($email);
        $description_valid = strlen($description) >= 2 && strlen($description) <= 1000;

        if (isset($_FILES["file"]) && $_FILES["file"]["size"] > 0) {
            $file_error = validate_file($_FILES["file"]);
        }

        if ($name_valid && $firstname_valid && $email_valid && $description_valid && empty($file_error)) {

            $host = "localhost";
            $dbname = "hackers-poulette";
            $username = "root";
            $password = "";

            try {
                $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (PDOException $e) {
                echo "Erreur de connexion à la base de données : " . $e->getMessage();
                exit();
            }
        }

        echo $response;
    }
    ?>

    <h2>Contact Support</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">

        <input type="text" name="name" placeholder="Name" required><br>
        <input type="text" name="firstname" placeholder="First Name" required><br>

        <input type="email" name="email" placeholder="Email" required><br>

        <label for="file">Image:</label>
        <input type="file" name="file"><br>

        <textarea name="description" rows="5" cols="40" placeholder="Description" required></textarea><br>

        <div class="g-recaptcha" data-sitekey="6Lcurq8mAAAAAPtjE1hMOJjuQeFEGjP3gM8n7SWZ"></div>

        <input type="submit" name="submit" value="Submit">

    </form>
</body>

</html>