<?php
$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
//****************************************************************/
// Secret Key ----------------------------------------------------*
$recaptcha_secret = '+++++++++++++++++++++++++++++++++++++++++++++';
// Site Key ------------------------------------------------------*
$recaptcha_public = '+++++++++++++++++++++++++++++++++++++++++++++';
//----------------------------------------------------------------*
//****************************************************************/
$SiteBrand = 'site brand';
$homeUrl = 'site url';
$siteName = 'site name';
//FORM SET-UP 
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {
    // Build POST request:
    $recaptcha_response = $_POST['recaptcha_response'];
    // Make and decode POST request:
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);
    // Take action based on the score returned:
    if ($recaptcha->score >= 0.5) {
        //contact form submission code
        $name = $_POST['name-form'];
        $email = $_POST['email-form'];
        $message = $_POST['message-form'];
        $privacy = $_POST['privacy-ceck'];
        $marketing = $_POST['marketing-ceck'];
        $telephone = $_POST['telephone-form'];
        $to = 'mail@mail.it; '; // e-mail to site admin
        $subject = "Nuovo Contatto dal form contatti: " . $siteName;
        $htmlContent = "
            <h1>Dettagli contatto:</h1>
            <p><strong>Nome / Ragione Sociale: </strong>" . $name . "</p>
            <p><strong>Email: </strong>" . $email . "</p>
			<p><strong>Telefono: </strong>" . $telephone . "</p>
			<p><strong>Messaggio: </strong>" . $message . " <hr></p>
            <p><strong>Consensi concessi dall'utente sulla privacy </strong><hr></p>
            <p>" . $privacy . "</p>
            <p>" . $marketing . "</p>
            ";
        // Set content-type HTML email to admin
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // More headers
        $headers .= 'From:' . $name . ' <' . $email . '>' . "\r\n";
        //SEND MAIL TO SITEADMIN
        mail($to, $subject, $htmlContent, $headers);
        $successo = "send-ok";
        //RESPONSE MESSAGE
        $oggetto_risposta = 'Risposta dal form contatti: ' . $siteName;
        //HTML MAIL TO SITE VISITORS
        $testo_risposta = "
                            <html>
                            <body>
                                <div style='max-width:650px; width:100%; margin: 25px auto; box-shadow: 0px 0px 20px -5px black; font-family:sans-serif;' >
                                <div style='background-color: grey; color:white;'>
                                    <h1 style='margin:0; padding:40px 20px; word-wrap: break-word;'> " . $siteName . "</h1>
                                </div>
                                <div style='padding:20px; color:black;'>
                                    <h2 style='word-wrap: break-word;'>Grazie " . $name . " per averci scritto</h2>
                                    <p style='margin-top:20px; padding-top:20px; color:grey; line-height: 1.2; word-wrap: break-word;'>
                                    Ti risponderemo prima possibile. Questo messaggio e' stato generato automaticamente, ti preghiamo pertanto di non rispondere a questa e-mail poiche' l'indirizzo non e' controllato. 
                                    </p>
                                    <p style='border-top: 1px solid lightgrey; font-size:12px; word-wrap: break-word;'>
                                    <strong>Riassunto del messaggio:</strong> <br /><br />
                                    <strong> name:</strong>  " . $name . " <br>
                                    <strong> mail:</strong>  " . $email . " <br>
                                    <strong> telefono:</strong>  " . $telephone . " <br>
                                    <strong> messaggio:</strong>  " . $message . " <br> <br>
                                    <strong> Privacy:</strong>  <br>
                                    " . $privacy . " <br>
                                    " . $marketing . " <br>
                                    </p>
                                </div>
                                <div style='background-color: lightgray; padding:10px 0; text-align: center;'>
                                    <p style='color:grey; font-size:11px; margin:0; padding: 0; word-wrap: break-word;'>
                                        <a style='color:grey; font-size:11px; text-decoration:none;' href=' " . $homeUrl . " '> © " . $SiteBrand . "</a> 
                                    </p>
                                </div>
                                </div>
                            </body>
                            </html>
                            ";

        $headers_risposta = 'From: <noreply@' . $siteName . '>' . "\r\n";
        $headers_risposta .= 'Reply-To:' . "\r\n";
        $headers_risposta .= 'MIME-Version: 1.0' . "\r\n";
        $headers_risposta .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        //SEND MAIL TO SITE VISITORS
        mail($email, $oggetto_risposta, $testo_risposta, $headers_risposta);
    } else {
        $errore = 'Error...';
    }
}
//FORM SET-UP END
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $recaptcha_public ?>"></script>
</head>

<body>
    <?php
    // if success
    if (!empty($successo)) : ?>
        <div style="position: fixed; left:0; top:0; right:0; z-index:9999999;" class="shadow alert alert-success alert-dismissible fade show m-5 p-5">
            <div class="d-flex">
                <svg style="min-width:20px;" width="20" height="20" fill="#0f5132" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm0 48c110.532 0 200 89.451 200 200 0 110.532-89.451 200-200 200-110.532 0-200-89.451-200-200 0-110.532 89.451-200 200-200m140.204 130.267l-22.536-22.718c-4.667-4.705-12.265-4.736-16.97-.068L215.346 303.697l-59.792-60.277c-4.667-4.705-12.265-4.736-16.97-.069l-22.719 22.536c-4.705 4.667-4.736 12.265-.068 16.971l90.781 91.516c4.667 4.705 12.265 4.736 16.97.068l172.589-171.204c4.704-4.668 4.734-12.266.067-16.971z" />
                </svg>
                <h3 style="padding-left: 1rem;">Grazie <?php echo $name ?>, il tuo messaggio è stato inviato correttamente.</h3>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
    endif;
    if (!empty($errore)) :
        // if error
    ?>
        <div style="position: fixed; left:0; top:0; right:0; z-index:9999999;" class="shadow alert alert-danger alert-dismissible fade show  m-5 p-5">
            <div class="d-flex">
                <svg style="min-width:20px;" fill="#842029" width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                    <path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z" />
                </svg>
                <strong style="padding-left: 1rem;">
                    Ci dispiace ma c'è qualche problema con l'invio del tuo messaggio, prova a ricompilare il form
                    e reinviare il messaggio. Se il problema dovesse persistere, ti preghiamo di riprovare più
                    tardi.
                </strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>


    <div class="container">
        <form novalidate class="needs-validation pt-4 pb-4 standard-contact-form" role="form" method="POST" action="">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label" for="InputName">
                            <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 48 48">
                                <g fill="grey">
                                    <path d="M38 4H10C7.79 4 6 5.79 6 8v28c0 2.21 1.79 4 4 4h8l6 6 6-6h8c2.21 0 4-1.79 4-4V8c0-2.21-1.79-4-4-4zm-14 6.6c2.98 0 5.4 2.42 5.4 5.4 0 2.98-2.42 5.4-5.4 5.4-2.98 0-5.4-2.42-5.4-5.4 0-2.98 2.42-5.4 5.4-5.4zM36 32H12v-1.8c0-4 8-6.2 12-6.2s12 2.2 12 6.2V32z"></path>
                                </g>
                            </svg> Nome Cognome
                        </label>
                        <input id="InputName" required type="text" class="form-control" name="name-form" placeholder="Nome e cognome / Ragione Sociale ">
                        <div id="InputName" class="invalid-feedback ">
                            <strong class="d-flex align-items-center"> <svg style="min-width:15px; margin-right:10px;" fill="#842029" width="15" height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z" />
                                </svg> Questo campo è obligatorio</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label" for="InputEmail">
                            <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 48 48">
                                <g fill="grey">
                                    <path d="M40 8H8c-2.21 0-3.98 1.79-3.98 4L4 36c0 2.21 1.79 4 4 4h32c2.21 0 4-1.79 4-4V12c0-2.21-1.79-4-4-4zm0 8L24 26 8 16v-4l16 10 16-10v4z"></path>
                                </g>
                            </svg> E-mail
                        </label>
                        <input id="InputEmail" required type="email" class="form-control" name="email-form" placeholder="Email">
                        <div id="InputEmail" class="invalid-feedback ">
                            <strong class="d-flex align-items-center"> <svg style="min-width:15px; margin-right:10px;" fill="#842029" width="15" height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z" />
                                </svg> Questo campo è obligatorio</strong>
                        </div>
                    </div>
                </div>
                <div class=" col-md-4">
                    <div class="form-group">
                        <label class="form-label" for="InputTelephone">
                            <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 48 48">
                                <g fill="grey">
                                    <path d="M13.25 21.59c2.88 5.66 7.51 10.29 13.18 13.17l4.4-4.41c.55-.55 1.34-.71 2.03-.49C35.1 30.6 37.51 31 40 31c1.11 0 2 .89 2 2v7c0 1.11-.89 2-2 2C21.22 42 6 26.78 6 8c0-1.11.9-2 2-2h7c1.11 0 2 .89 2 2 0 2.49.4 4.9 1.14 7.14.22.69.06 1.48-.49 2.03l-4.4 4.42z"></path>
                                </g>
                            </svg> Telefono
                        </label>
                        <input required type="tel" id="InputTelephone" maxlength="15" class="form-control" name="telephone-form" placeholder="Telefono">
                        <div id="InputTelephone" class="invalid-feedback ">
                            <strong class="d-flex align-items-center"> <svg style="min-width:15px; margin-right:10px;" fill="#842029" width="15" height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z" />
                                </svg> Questo campo è obligatorio</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label" for="InputMessage">
                            <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 48 48">
                                <g fill="grey">
                                    <path d="M40 4H8C5.79 4 4.02 5.79 4.02 8L4 44l8-8h28c2.21 0 4-1.79 4-4V8c0-2.21-1.79-4-4-4zM12 18h24v4H12v-4zm16 10H12v-4h16v4zm8-12H12v-4h24v4z"></path>
                                </g>
                            </svg> Messaggio
                        </label>
                        <textarea required id="InputMessage" name="message-form" class="form-control" rows="4" placeholder="Scrivi qui il tuo messaggio"></textarea>
                        <div id="InputMessage" class="invalid-feedback ">
                            <strong class="d-flex align-items-center"> <svg style="min-width:15px; margin-right:10px;" fill="#842029" width="15" height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z" />
                                </svg> Questo campo è obligatorio</strong>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="privacy-box">
                        <div class="form-check form-switch mb-4">
                            <input required name="privacy-ceck" type="checkbox" class="form-check-input" id="customSwitch1" value="Consenso per il trattamento dei dati personali e presa visione dell'informativa completa per la privacy.">
                            <label class="form-check-label" for="customSwitch1">
                                <span><strong>Prendo atto</strong> del trattamento dei dati personali <a target="_blank" href="https://eur-lex.europa.eu/legal-content/IT/TXT/?toc=OJ:L:2016:119:TOC&amp;uri=uriserv:OJ.L_.2016.119.01.0001.01.ITA">(Reg. UE 679/2016)</a>, avendo letto <a target="_blank" href="#"><strong>l'informativa completa</strong></a> sulla privacy del sito <strong><?php echo $homeUrl; ?></strong>. <strong>Dichiaro</strong> di voler ricevere e-mail o essere contattato telefonicamente dal proprietario del sito al fine di ricevere le informazioni da me richieste. Puoi richiedere in qualsiasi momento la revoca dei consensi e la cancellazione dei tuoi dati personali seguendo le istruzioni sulla <a target="_blank" href="#"><strong>pagina</strong></a> dedicata.</span>
                            </label>
                            <div id="customSwitch1" class="invalid-feedback ">
                                <strong class="d-flex align-items-center"> <svg style="min-width:15px; margin-right:10px;" fill="#842029" width="15" height="15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path d="M569.517 440.013C587.975 472.007 564.806 512 527.94 512H48.054c-36.937 0-59.999-40.055-41.577-71.987L246.423 23.985c18.467-32.009 64.72-31.951 83.154 0l239.94 416.028zM288 354c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z" />
                                    </svg> L'accettazione al trattamento dei dati è obligatoria per inviare il tuo messaggio</strong>
                            </div>
                        </div>
                        <div class="form-check form-switch mb-4">
                            <input name="marketing-ceck" type="checkbox" class="form-check-input" id="customSwitch2" value="Consenso per l'utilizzo dei dati per comunicazioni promozionali">
                            <label class="form-check-label" for="customSwitch2">
                                <span>Selezionando questa opzione accetti di ricevere email promozionali automatiche, create in base
                                    alla tua navigazione sul sito. Per maggiori informazioni leggi l' <a target="_blank" href="#"><strong>informativa
                                            completa</strong></a>. Puoi richiedere in qualsiasi momento la revoca dei consensi e la cancellazione dei tuoi dati personali seguendo le istruzioni sulla <a target="_blank" href="#"><strong>pagina</strong></a> dedicata.</a></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <button href="#messaggio" type="submit" name="submit" class="btn btn-success" value="SUBMIT">
                        INVIA ILMESSAGGIO
                    </button>
                    <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        //bootstrap validation Form
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
        //g-recaptcha 
        grecaptcha.ready(function() {
            grecaptcha.execute('<?php echo $recaptcha_public ?>', {
                action: 'contact'
            }).then(function(token) {
                var recaptchaResponse = document.getElementById('recaptchaResponse');
                recaptchaResponse.value = token;
            });
        });
    </script>
</body>

</html>
