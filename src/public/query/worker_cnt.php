<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Ren\Connect;
use Ren\Utils;

header("Content-Type: application/json");

$pdo = Connect::connectPDO();
$prq = $pdo->prepare("SELECT chief, COUNT(name) AS workers FROM WORKER w"
    . " JOIN DEPARTMENT d ON w.FID_DEPARTMENT=d.ID_DEPARTMENT WHERE d.CHIEF=:name");
$prq->bindValue(":name", Utils::clearInput($_POST["ceo"]));
$prq->execute();
$result = $prq->fetchAll();

echo Utils::responseJSON($result);
