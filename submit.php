<?php
//Include Database file
include 'db.php';
//Initialize error array
$errors = array();
//check if form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $fullname = validate_input($_POST['fullname']);
    $phone = validate_input($_POST['phone']);
    $email = validate_input($_POST['email']);
    $subject = validate_input($_POST['subject']);
    $message = validate_input($_POST['message']);

    if(empty($fullname)){
        $errors['fullname'] = "Full name is required";
    }
    if(empty($phone)){
        $errors['phone'] = "Phone number is required";
    }elseif(!is_numeric($phone)){
        $errors['phone'] = "Phone number must be numeric";
    }
    if(empty($email)){
        $errors['email'] = "Email is required";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Email Format must be maintain";
    }
    if(empty($subject)){
        $errors['subject'] = "Subject is required";
    }
    if(empty($message)){
        $errors['message'] = "Message is required";
    }
    //inserting to the DB
    if(empty($errors)){
        //Prevent Duplication
        $token = md5(uniqid(rand(),true));
        $sql="INSERT INTO contact_form (fullname, phone, email, subject, message, token) VALUES ('$fullname', '$phone', '$email', '$subject', '$message', '$token')";
        if($conn->query($sql) === TRUE) {
            //Send Mail
            $to ="dummy11@gmail.com";
            $subject = "Submit Contact Form";
            $message = "A new contact form submission:\n\n Full name: $fullname\nPhone: $phone\nEmail: $email\nSubject: $subject\nMessage: $message";
            $header = 'From: vivekkumar34@gmail.com' . "\r\n" .
                'Reply-To: vivekkumar34@gmail.com' . "\r\n" . 
                'X-Mailer: PHP/' . phpversion();
            mail($to, $subject, $message, $header);
            echo "Form Submitted successfully";
        }else{
            echo 'Error: ' . $sql . '<br>' . $conn->error;
        }
    }
    else{
            foreach($errors as $error){
                echo $error . '<br>';
            }
        }
    }
    function validate_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>