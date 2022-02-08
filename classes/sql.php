<?php 
class Sql {
  // set varriable connnection so it can get accesst only in this file in every function
    private $conn;

    // __construct is used on startup when the class is being called
    public function __construct($db) {
      // the variable $db is the data from db.php saved in the conn variable for global use
        $this->conn = $db;
    }

    // function login for the users with the parameters email and password
    public function UserLogin($email, $password){
        // var i is for the amount of rows selected
        $i = 0;
        // statement for getting the email password and if user is an admin where the email is the parameter email
        $stmt = $this->conn->query("SELECT `email`, `wachtwoord`, `admin`,`Naam`,`ID`,`Leeftijd`,`Geslacht` FROM gebruiker WHERE email='$email'");
        // for every row that the sql wuery got execute this
        while ($row = $stmt->fetch()) {
            // add 1 to the var i 
            $i++;
            // only if the password is correct return true else false
            if (password_verify($password, $row['wachtwoord'])) {
                $_SESSION['admin'] = $row['admin'];
                $_SESSION['name'] = $row['Naam'];
                $_SESSION['userID'] = $row['ID'];
                $_SESSION['age'] = $row['Leeftijd'];
                $_SESSION['sex'] = $row['Geslacht'];
                return true;
            }else {
                return false;
            }
        }
        // if there are no rows collected return false 
        if($i === 0){
            return false;
        }
    }

    // get all the categories for the admin page
    public function GetAdminQUestions(){
      $sql = "SELECT * FROM categorie WHERE 1";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      return $stmt;
    }

    // get all the questions where the categorie ID is ID
    public function GetAdminQuestion($ID){
      $sql = "SELECT V.ID AS VID, VA.ID AS VAID, v.Vraag, VA.Weging, VA.Antwoord
      FROM Vraag AS V
      LEFT JOIN vraag_antwoord AS VA
      ON V.ID = VA.Vraag_ID WHERE V.Categorie_ID = $ID";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      return $stmt;
    }

    // check if user exists with this email
    public function UserExists($email){
        $sql = "SELECT ID FROM gebruiker WHERE email='$email'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
  
        return $stmt;
    }

    // register a new user with the needed information
    public function UserInsert($gebruikersnaam, $leeftijd, $email, $eWachtwoord){
        $this->conn->query("INSERT INTO Gebruiker (naam, leeftijd, email, wachtwoord) VALUES ('$gebruikersnaam', $leeftijd, '$email', '$eWachtwoord')");

        $sql = $this->conn->prepare("SELECT ID FROM gebruiker ORDER BY ID DESC LIMIT 1");
        $sql->execute();

        $stmt = $this->conn->query("SELECT `ID`, `Naam` FROM gebruiker ORDER BY `ID` DESC LIMIT 1");
        // for every row that the sql wuery got execute this
        while ($row = $stmt->fetch()) {
            // only if the password is correct return true else false
            $_SESSION['userID'] = $row['ID'];
            $_SESSION['name'] = $row['Naam'];
        }

        return "INSERT INTO Gebruiker (naam, leeftijd, email, wachtwoord) VALUES ('$gebruikersnaam', $leeftijd, '$email', '$eWachtwoord')";
    }

    public function AdminInsertQuestions($catID, $v, $QuestionID){
      $sql = "INSERT INTO `vraag`(`Categorie_ID`, `Vraag`) VALUES ($catID, '$v');";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();

      return $stmt;
    }

    public function AdminUpdateQuestions($v, $QuestionID){
      $sql = "UPDATE `vraag` SET `Vraag`='$v' WHERE ID = $QuestionID";
      
      $stmt = $this->conn->prepare($sql);

      $stmt = $this->conn->prepare($sql);
      $stmt->execute();

      return $stmt;
    }

    public function AdminInsertWeging($catID, $v, $QuestionID){
      $sql = "INSERT INTO `vraag_antwoord`(`Vraag_ID`, `Weging`) VALUES ($QuestionID, '$v');";
   
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();

      return $stmt;
    }

    public function AdminUpdateWeging($v, $QuestionID){
      $sql = "UPDATE `vraag_antwoord` SET `Weging`= $v WHERE ID = $QuestionID";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      file_put_contents("sql.txt", $sql);

      return $stmt;
    }

    public function UpdateUser($UserName, $UserEmail, $UserHeight, $UserWeight, $UserAge, $Sex , $UserID){
        $sql = "UPDATE `gebruiker` SET `Naam`='$UserName', Lengte='$UserHeight' , email='$UserEmail', Gewicht='$UserWeight', Leeftijd='$UserAge', Geslacht='$Sex'  WHERE ID = $UserID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    public function getUserData($ID){
        $sql = "SELECT * FROM gebruiker WHERE ID= $ID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function GetQuestions($ID)
    {
        $sql = "SELECT * FROM vraag WHERE Categorie_ID = $ID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }
    public function GetSingleQuestion($ID) {
        $sql = "SELECT * FROM vraag WHERE ID = $ID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }

    public function InsertQuestions($QuestionID,$UserID, $Answer)
    {
        //Beetje een zooitje maar geen tijd meer. ;(
        if (is_array($Answer)) {
            $QuestionID = str_replace('_','',$QuestionID);
            $healthy = $this->GetSingleQuestion($QuestionID)->fetch()['gezond'];

            if ($healthy == 1) {
                $score = 2;
            } else {
                $score = 0;
            }

            $sql = "DELETE FROM `antwoord` WHERE `Gebruiker_ID` = $UserID AND Vraag_ID = $QuestionID AND Datum = CURRENT_DATE();";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            foreach ($Answer as $item) {
                $answer_id = 0;
                $answer_weging = 0;
                $sql = "SELECT ID, Weging from `vraag_antwoord` WHERE `Vraag_ID` = $QuestionID AND `Antwoord` = '$item'";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute();

                while ($row = $stmt->fetch())
                {
                    $answer_id = $row["ID"];
                    $answer_weging = $row['Weging'];
                }
                if ($healthy == 1) {
                    $score = $score - $answer_weging;
                    if ($score < 0) {$score = 0;}
                } else {
                    $score = $score + $answer_weging;
                    if ($score < 0) {$score = 0;}

                }

            }
            $sql2 = "INSERT INTO `antwoord` (Gebruiker_ID, Vraag_ID, Antwoord, datum,Score) VALUES ('$UserID', '$QuestionID', '0', CURRENT_DATE(),$score)";

            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute();
            return false;
        }

        $answer_id = 0;
        $answer_weging = 0;
        $sql = "SELECT ID, Weging from `vraag_antwoord` WHERE `Vraag_ID` = $QuestionID AND `Antwoord` = '$Answer'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();


        while ($row = $stmt->fetch())
        {
          $answer_id = $row["ID"];
          $answer_weging = $row['Weging'];
        }

        $sql2 = "INSERT INTO `antwoord` (Gebruiker_ID, Vraag_ID, Antwoord, datum,Score) SELECT '$UserID', '$QuestionID', $answer_id,CURRENT_DATE(),$answer_weging 
                FROM DUAL WHERE NOT EXISTS (SELECT * FROM `antwoord` WHERE `Gebruiker_ID` = $UserID AND `Vraag_ID`= $QuestionID AND Datum = CURRENT_DATE());
                 UPDATE `antwoord` SET Antwoord = $answer_id, Score = $answer_weging WHERE `Gebruiker_ID` = $UserID AND `Vraag_ID`= $QuestionID AND Datum = CURRENT_DATE();";
        $stmt2 = $this->conn->prepare($sql2);
        $stmt2->execute();

        return $stmt2;
    }

    public function getUserDashboardData($ID){
      $sql = "SELECT antwoord.Score, vraag.Vraag, vraag.Categorie_ID, categorie.naam FROM antwoord INNER JOIN vraag ON antwoord.Vraag_ID = vraag.ID AND antwoord.Gebruiker_ID = $ID AND antwoord.Datum = '" . date("Y-m-d") . "' INNER JOIN categorie on vraag.Categorie_ID = categorie.ID";
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
      return $stmt;
    }
    public function GetCategories() {
        $sql = "SELECT * FROM categorie";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }
    
    public function GetChoices($ID) {
        $sql = "SELECT * FROM vraag_antwoord WHERE Vraag_ID = $ID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt;
    }
}