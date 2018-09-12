<?php 
    class User
    {
        // database connection
        private $db;
        
        // object properties
        public $Id;
        public $Name;
        public $Surname;
        public $UserName;
        public $Email;
        public $Password; //md5'li
        public $UserState; //0:Pasif,1:Aktif, 2:PasifeAlınmış,3:ŞifreYenileme
        public $RecordState;
        public $RecordDate;
        public $LastLoginDate;
        public $UserType;

        //Custom

        // constructor with $db as database connection
        public function __construct($db){
            $this->db = $db;
        }

        //Functions

        //Create Device
        function Create()
        {
            $result = $this->db->executePK("INSERT INTO `Users` ( 
                `Name`, 
                `Surname`, 
                `UserName`, 
                `Email`, 
                `Password`, 
                `UserState`, 
                `UserType`
                ) VALUES ( 
                    '".$this->Name."',
                    '".$this->Surname."',
                    '".$this->UserName."',
                    '".$this->Email."',
                    '".$this->Password."',
                    '".$this->UserState."',
                    '".$this->UserType."'
                )"); 

            $this->Id = $result;
            $this->RecordState='A'; 
            
            return ($result>0);
        }

        //GET
        function Get($filter)
        {
            try 
            {
                $result = array();
                $reportName = $filter["reportName"];
                
                if($reportName== "DeviceByDeviceKey")
                {
                    $query="SELECT * FROM Devices d WHERE d.RecordState='A' ";
                    $query = $query."AND d.Key='".$filter["key"]."' ";
                    $query = $query. "LIMIT 1";

                    $dbResult = $this->db->getData($query);
                    
                    foreach ($dbResult as $key => $res) {
                        $rowItem = array(
                            "Id"=> $res['Id'],
                            "Key"=> $res['Key']
                        ); 

                        array_push($result, $rowItem); 
                    }
                }
                return $result;
            }
            catch(Exception $e)
            {
              echo $e->getMessage();
            }
        }

        function CheckUser($Email, $PasswordMD5)
        {
            $query ="SELECT * FROM Users u WHERE u.RecordState='A' ";
            $query .= "AND u.UserState=1 ";
            $query .= "AND u.Email='".$Email."' ";
            $query .= "AND u.Password='".$PasswordMD5."' ";
            $query .= "LIMIT 1";

            $dbResult = $this->db->getDataSingleRow($query);

            if(!$dbResult || $dbResult["Id"]<=0)
            {
                return false;
            }
            else
            {
                $this->Id=$dbResult["Id"];
                $this->Name=$dbResult["Name"];
                $this->Surname=$dbResult["Surname"];
                $this->UserName=$dbResult["UserName"];
                $this->Email=$dbResult["Email"];
                $this->Password=$dbResult["Password"]; //md5'li
                $this->UserState=$dbResult["UserState"]; //0:YeniKayit,1:Aktif, 2:PasifeAlınmış,3:ŞifreYenileme
                $this->RecordState=$dbResult["RecordState"];
                $this->RecordDate=$dbResult["RecordDate"];
                $this->LastLoginDate=$dbResult["LastLoginDate"];
                $this->UserType=$dbResult["UserType"];

                //LastLoginDate Güncelleniyor
                $result = $this->db->execute("UPDATE `Users` SET
                `LastLoginDate`='".date("Y-m-d H:i:s")."'
                WHERE Id='".$this->Id."'");

                return true;
            }
        }

        function CheckIsEmail($Email)
        {
            $query ="SELECT * FROM Users u WHERE u.RecordState='A' ";
            $query .= "AND u.Email='".$Email."'";

            $dbResult = $this->db->getDataSingleRow($query);

            if(!$dbResult || $dbResult["Id"]<=0)
            {
                return false;
            }
            else
            {
                return true;
            }
        }

        function CheckIsUserName($UserName)
        {
            $query ="SELECT * FROM Users u WHERE u.RecordState='A' ";
            $query .= "AND u.UserName='".$UserName."'";

            $dbResult = $this->db->getDataSingleRow($query);

            if(!$dbResult || $dbResult["Id"]<=0)
            {
                return false;
            }
            else
            {
                return true;
            }
        }
        
        function GetUserId($Email)
        {
            $query ="SELECT Id FROM Users u WHERE u.RecordState='A' ";
            $query .= "AND u.Email='".$Email."'";

            $dbResult = $this->db->getDataSingleRow($query);

            return $dbResult["Id"];
        }
        
    }
?>