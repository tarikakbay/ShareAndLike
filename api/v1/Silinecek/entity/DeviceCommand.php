<?php 
include_once '../libraries/Common.php'; 

    class DeviceCommand extends Common
    {
        // database connection
        private $db;
        
        // object properties
        public $Id;
        public $DeviceId;
        public $Tag; 
        public $StyleColor;
        public $StyleIcon;
        public $Visible; //1:Açık, 0:Gizli

        //Custom

        // constructor with $db as database connection
        public function __construct($db){
            $this->db = $db;
        }

        //Functions

        //Create Device
        function Create()
        {
            $result = $this->db->executePK("INSERT INTO DeviceCommand (`DeviceId`, `Tag`, `StyleColor`, `StyleIcon`, `Visible`, `RecordUserId`) VALUES (
                    '".$this->DeviceId."',
                    ".$this->Tag.",
                    ".$this->StyleColor.",
                    ".$this->StyleIcon.",
                    ".$this->Visible.",
                    ".$this->RecordUserId."
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
                
                if($reportName== "CommandByDeviceKey")
                {
                    $query  = "SELECT c.Id, c.Tag, c.StyleColor, c.StyleIcon, c.Visible ";
                    $query .= ", (Select p.ParamValue1 FROM Parameter p WHERE p.ParamGroupName='CommandButtonColor' AND p.ParamCode=c.StyleColor AND p.RecordState='A') AS 'StyleColorClass' ";
                    $query .= "FROM DeviceCommand c, Devices d ";
                    $query .= "WHERE c.DeviceId=d.Id ";
                    $query .= "AND c.RecordState='A' AND d.RecordState='A' ";
                    $query .= "AND c.DeviceId=".$filter["deviceId"]." ";
 
                    $dbResult = $this->db->getData($query); 
                     

                    foreach ($dbResult as $key => $res) {
                        $rowItem = array(
                            "Id"=> $res['Id'],
                            "Tag"=> $res['Tag'],
                            "StyleColor"=> $res['StyleColor'],
                            "StyleColorClass"=> $res['StyleColorClass'],
                            "StyleIcon"=> $res['StyleIcon'],
                            "Visible"=> $res['Visible']
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