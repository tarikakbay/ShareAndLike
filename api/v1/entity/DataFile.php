<?php 
include_once '../common/CommonEntity.php';

    class DataFile extends Common
    {
        // database connection
        private $db;
        
        // object properties
        public $Id;
        public $DataFullName; 
        public $DataOrjFullName;
        public $DataFileType;
        public $FileSize;
        public $DataType; //image, videos, document
        public $FilePriority; //Dosya gösterim önceliği 1:en yüksek...999:En Düşük
        public $IntendedUse; // S:Share, P:profil
        public $StartViewDate;
        public $FinishViewDate;
        public $FileFolderNode;
        public $FileFastFolderNode;
        public $ExplanationText;

        // constructor with $db as database connection
        public function __construct($db){
            $this->db = $db;
        }

        //Functions

        //Create Device
        function Create()
        {
            $deviceKey = uniqid();

            "INSERT INTO `DataFiles` (
             `Id`,
             `DataFullName`,
             `DataOrjFullName`, 
             `DataFileType`, 
             `FileSize`, 
             `DataType`, 
             `FilePriority, 
             `IntendedUse`, 
             `StartViewDate`, 
             `FinishViewDate`, 
             `FileFolderNode`, 
             `FileFastFolderNode`, 
             `ExplanationText`, 
             `RecordUserId`, 
             `RecordDate`, 
             `RecordState`) VALUES (
             '', 
             '', 
             '', 
             '', 
             '', 
             '', 
             '', 
             'S', 
             '', 
             '', 
             '', 
             '', 
             '', 
             '', 
             CURRENT_TIMESTAMP, 
             'A')";





            $result = $this->db->executePK("INSERT INTO Devices (`Key`,`Port`,`DeviceType`,`ApiVersion`,`RecordUserId`) VALUES (
                    '".$deviceKey."',
                    ".$this->Port.",
                    ".$this->DeviceType.",
                    ".$this->AppVersion.",
                    ".$this->RecordUserId."
                )"); 


            return ($result>0);
        }

        //GET
        function Get($filter)
        {
            try 
            {
                $result = array();
                $reportName = $filter["reportName"];
                
                if($reportName== "UserDevices")
                {
                    $query  ="SELECT * FROM UserDevices u, Devices d WHERE u.DeviceId=d.Id"; 
                    $query .=" AND u.UserId=".$filter["userId"];
                    $query .=" AND d.RecordState='A' AND u.RecordState='A' ORDER by u.Id";

                    $dbResult = $this->db->getData($query);
                    
                    foreach ($dbResult as $key => $res) {
                        $rowItem = array(
                            "Id"=> $res['Id'],
                            "Key"=> $res['Key'],
                            "Port"=> $res['Port'],
                            "TagName"=> $res['TagName'],
                            "DeviceType"=> $res['DeviceType'],
                            "ApiVersion"=> $res['ApiVersion']
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
    }
?>