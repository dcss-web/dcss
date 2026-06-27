<?php
// send.php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  http_response_code(405);
  exit("Método no permitido");
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$message = trim($_POST["message"] ?? "");

/*if ($name === "" || $email === "" || $message === "") {
  http_response_code(400);
  exit("Faltan campos");
}*/

/*if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  exit("Email no válido");
}*/

// IMPORTANTE: pon aquí el email que recibirá los mensajes
$to = "comercial@dcss";
$subject = "Nuevo mensaje desde la web (DCSS)";
$body =
  "Nombre: {$name}\n" .
  "Email: {$email}\n\n" .
  "Mensaje:\n{$message}\n";

$headers = [];
$headers[] = "From: DCSS Web <no-reply@dcss.es>";
$headers[] = "Reply-To: {$name} <{$email}>";
$headers[] = "Content-Type: text/plain; charset=UTF-8";

$ok = mail($to, $subject, $body, implode("\r\n", $headers));

if ($ok) {
  header("Location: gracias.html"); // o muestra un OK
  exit();
} else {
  http_response_code(500);
  exit("No se pudo enviar el correo (configura SMTP)");
}
