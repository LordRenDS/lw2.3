<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Ren\Connect;
use Ren\Utils;

header("Content-Type: application/xml");

$pdo = Connect::connectPDO();
$prq = $pdo->prepare("SELECT p.name, SUM(DATEDIFF(w.time_end, w.time_start))"
    . " AS total_days FROM WORK w JOIN PROJECT p ON p.ID_PROJECTS = w.FID_PROJECTS WHERE p.name = :name");
$prq->bindValue(":name", Utils::clearInput($_POST["project"]));
$prq->execute();
$result = $prq->fetchAll();

echo Utils::responseXML($result);