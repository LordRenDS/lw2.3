<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use Ren\Connect;
use Ren\Utils;

header("Content-Type: text/html");

$pdo = Connect::connectPDO();
$prq = $pdo->prepare("SELECT w.* FROM WORK w JOIN PROJECT p ON p.ID_PROJECTS=w.FID_PROJECTS"
    . " WHERE w.date = :date AND p.name = :name");
// $prq->bindValue(":date", Utils::clearInput($_POST["date"]));
// $prq->bindValue(":name", Utils::clearInput($_POST["project"]));
$prq->bindValue(":date", Utils::clearInput($_GET["date"]));
$prq->bindValue(":name", Utils::clearInput($_GET["project"]));
$prq->execute();
$result = $prq->fetchAll();

echo $_GET["callback"] . "(" . json_encode($result) . ")";
// echo Utils::resposnePlainText($result);