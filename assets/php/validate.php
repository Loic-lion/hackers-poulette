<?php 
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