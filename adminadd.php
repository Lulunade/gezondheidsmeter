<?php 
require ('classes/db.php');
require ('classes/sql.php');
$database = new Dbconfig();
$db = $database->getConnection();
$sqlQuery = new Sql($db);

$data = $sqlQuery->GetAdminQUestions();
foreach($_POST as $k => $v) {
        if(strpos($k, 'Vraag') !== false) {
            $QuestionID = str_replace("Vraag", "", preg_replace('/^[0-9 ]+(?=[^\d]+)/i', '', $k));
            if($QuestionID <= $_POST['Amount']){
                $data = $sqlQuery->AdminUpdateQuestions($v, $QuestionID);
                // $admin->update($k, $v, $QuestionID);
            }else {
                preg_match_all("/([\d\.]+)(?:Vraag|\")/", $k,$matches);
                $cat  = $matches[1][0];
                $data = $sqlQuery->AdminInsertQuestions($cat, $v, $QuestionID);

                // $admin->insert($k, $v, $QuestionID);
            }
        }
    }
    foreach($_POST as $k => $v) {
        if(strpos($k, 'Weging') !== false) {
            $QuestionID = str_replace("Weging", "", preg_replace('/^[0-9 ]+(?=[^\d]+)/i', '', $k));
            if($QuestionID <= $_POST['Amount']){
                // echo $QuestionID;
                $data = $sqlQuery->AdminUpdateWeging($v, $QuestionID);
                // $admin->update($k, $v, $QuestionID);
            }else {
                preg_match_all("/([\d\.]+)(?:Weging|\")/", $k,$matches);
                $cat  = $matches[1][0];
                $data = $sqlQuery->AdminInsertWeging($cat, $v, $QuestionID);

                // $admin->insert($k, $v, $QuestionID);
            }
        }
    }