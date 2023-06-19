<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hackers POulette</title>
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

        if ($file['error'] === UPLOAD_ERR_OK) {
            $file_name = $file['name'];
            $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
            $file_size = $file['size'];

            if (!in_array($file_type, $allowed_types)) {
                $file_error = "Error: only giff, jpg and png.";
            } elseif ($file_size > $max_size) {
                $file_error = "Error: max 2MB.";
            } else {
            }
        }

        return $file_error;
    }


    ?>

    <h2>Contact Support</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">

        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="firstname">First Name:</label>
        <input type="text" name="firstname" required><br>

        <label for="email">Email Address:</label>
        <input type="email" name="email" required><br>

        <label for="file">File:</label>
        <input type="file" name="file"><br>

        <label for="description">Description:</label>
        <textarea name="description" rows="5" cols="40" required></textarea><br>

        <input type="submit" name="submit" value="Submit">

    </form>
</body>

</html>