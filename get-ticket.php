<?php

$user = $_SERVER['REMOTE_USER'];

$base_dir = 'tickets';

$ticket_name = "$base_dir/$user.pdf";

if (!file_exists($ticket_name)) {
    # run the generation script

    exec("cd tickets ; python generate.py $user -o $ticket_name", $output, $rv);
    if (!file_exists($ticket_name)) {
        header('HTTP/1.1 403 Forbidden');
        header('Content-type: text/plain');
        echo "You have not signed a media consent form.";
        exit();
    }
}

header('Content-type: application/pdf');
header('Content-length: ' . filesize($ticket_name));
header('Content-Disposition: attachment; filename="ticket.pdf"');
readfile($ticket_name);

