<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use Ren\Connect;

$pdo = Connect::connectPDO();
$projects = $pdo->query("SELECT name FROM project")->fetchAll();
$ceos = $pdo->query("SELECT chief FROM department")->fetchAll();
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queries</title>
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            align-items: flex-start;
        }

        .flex-content {
            display: flex;
            flex-direction: column;
            width: 16em;
            margin: 1em;
        }

        .flex-row {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .flex-row * {
            margin: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form id="projects-f">
            <fieldset class="flex-content">
                <legend>Інформація про виконані завдання за обраним проєктом на зазначену дату</legend>
                <div class="flex-row">
                    <label for="project">Project:</label>
                    <select name="project" id="project">
                        <?php foreach ($projects as $project) : ?>
                            <option value="<?php echo htmlspecialchars($project->name); ?>"><?php echo htmlspecialchars($project->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex-row">
                    <label for="date">Date:</label>
                    <input type="date" name="date" id="date" min="2000-01-01" value="2019-04-15">
                </div>
                <input type="button" value="Submit" onclick="createScript()">
            </fieldset>
        </form>
        <form id="project-time-f">
            <fieldset class="flex-content">
                <legend>Загальний час роботи над обраним проєктом</legend>
                <div class="flex-row">
                    <label for="project">Project:</label>
                    <select name="project" id="project">
                        <?php foreach ($projects as $project) : ?>
                            <option value="<?php echo htmlspecialchars($project->name); ?>"><?php echo htmlspecialchars($project->name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- <input type="button" value="Submit" onclick="XHR(document.getElementById('project-time-f'),
                'http://localhost:8080/query/project_time.php', xml)"> -->
                <input type="button" value="Submit" onclick="createScript()">
            </fieldset>
        </form>
        <form id="worker-cnt-f">
            <fieldset class="flex-content">
                <legend>Кількість співробітників відділу обраного керівника</legend>
                <div class="flex-row">
                    <label for="ceo">CEO:</label>
                    <select name="ceo" id="ceo">
                        <?php foreach ($ceos as $ceo) : ?>
                            <option value="<?php echo htmlspecialchars($ceo->chief); ?>"><?php echo htmlspecialchars($ceo->chief); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="button" value="Submit" onclick="json(document.getElementById('worker-cnt-f'),
                'http://localhost:8080/query/worker_cnt.php')">
            </fieldset>
        </form>
    </div>
    <div style="margin-left: 1em;" id="output">
        <!-- <p id="output"></p> -->
    </div>
    <script src="/js/formhandler.js"></script>
</body>

</html>