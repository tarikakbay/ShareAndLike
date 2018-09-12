<?php 
include_once '../libraries/Common.php';

    class DeviceCommandDetail extends Common
    {
        // database connection
        private $db;
        
        // object properties
        public $Id;
        public $DeviceCommandId;
        public $DataKey; 
        public $DataValue;

        //Custom

        // constructor with $db as database connection
        public function __construct($db){
            $this->db = $db;
        }

        //Functions

        //Create Device
        function Create()
        {
            $result = $this->db->executePK("INSERT INTO DeviceCommandDetails (`DeviceCommandId`, `DataKey`, `DataValue`) VALUES (
                    '".$this->DeviceCommandId."',
                    ".$this->DataKey.",
                    ".$this->DataValue." 
                )"); 

            $this->Id = $result;  
            
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
                    $query="SELECT * FROM DeviceCommand c, Devices d WHERE d.Id = c.DeviceId AND c.RecordState='A' AND d.RecordState='A'";
                    $query = $query."AND d.Key='".$filter["key"]."' ";

                    $dbResult = $this->db->getData($query);
                    
                    foreach ($dbResult as $key => $res) {
                        $rowItem = array(
                            "Tag"=> $res['Tag'],
                            "StyleColor"=> $res['StyleColor'],
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