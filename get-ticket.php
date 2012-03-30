<?php

$user = $_SERVER['REMOTE_USER'];

$base_dir = dirname(__FILE__) . '/bees';

$ticket_name = "$base_dir/$user.pdf";

if (!file_exists($ticket_name)) {
    # run the generation script

    exec("cd tickets ; python generate.py $user -y 2012 -d 'April 14th-15th (Doors open 9:30)' -l 'https://www.studentrobotics.org/comp' -o $ticket_name 2>&1", $output, $rv);
    if (!file_exists($ticket_name)) {
        header('HTTP/1.1 403 Forbidden');
        header('Content-type: text/html');
        header('Content-length: ' . filesize('nope.html'));
        readfile('nope.html');
        exit();
    }
}

header('Content-type: application/pdf');
header('Content-length: ' . filesize($ticket_name));
header('Content-Disposition: attachment; filename="ticket.pdf"');
readfile($ticket_name);

