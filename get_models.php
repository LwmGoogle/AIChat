<?php
require_once 'models/ai_models.php';

header('Content-Type: application/json');

$ai = isset($_GET['ai']) ? $_GET['ai'] : '';
$models = getModels($ai);

echo json_encode($models);
?> 