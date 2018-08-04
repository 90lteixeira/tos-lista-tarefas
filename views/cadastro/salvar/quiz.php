<?php
include_once filter_input(INPUT_SERVER, 'DOCUMENT_ROOT') . '/config.php';
include_once SERVIDOR . '/controllers/quiz.php';

$quiz = new Quiz();
$params = anti_injection($_POST);
$quiz->save($params);
