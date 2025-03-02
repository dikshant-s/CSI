<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $subject = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    $sendgrid_api_key = "YOUR_SENDGRID_API_KEY";
    $template_id = "YOUR_TEMPLATE_ID";
    $recipient = "your-email@example.com"; // Replace with your actual email

    $email_data = [
        "personalizations" => [
            [
                "to" => [["email" => $recipient]],
                "dynamic_template_data" => [
                    "name" => $name,
                    "email" => $email,
                    "subject" => $subject,
                    "message" => $message
                ]
            ]
        ],
        "from" => ["email" => "your-sendgrid-verified-email@example.com"],
        "template_id" => $template_id
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.sendgrid.com/v3/mail/send");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($email_data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $sendgrid_api_key",
        "Content-Type: application/json"
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
