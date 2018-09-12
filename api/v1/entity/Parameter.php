<?php 
include_once '../common/CommonEntity.php';

    class Parameter extends CommonEntity
    {
        // database connection
        private $db;
        
        // object properties
        public $Id;
        public $ParaGroupName;
        public $ParamCode; 
        public $ParamName;
        public $ParamValue1;
        public $ParamValue2;
        public $ParamValue3;
        public $ParamValue4;
        public $ParamValue5;
        public $RecordUserId;

        //Custom

        // constructor with $db as database connection
        public function __construct($db){
            $this->db = $db;
        }

        //Functions

        //Create
        function Create()
        {
            // $result = $this->db->executePK("INSERT INTO DeviceCommandDetails (`DeviceCommandId`, `DataKey`, `DataValue`) VALUES (
            //         '".$this->DeviceCommandId."',
            //         ".$this->DataKey.",
            //         ".$this->DataValue." 
            //     )"); 

            // $this->Id = $result;  
            
            // return ($result>0);
        }

        //GET
        function Get($filter)
        {
            try 
            {
                $result = array();
                $parametreGroupName = $filter["parametreGroupName"];
                 
                $query  ="SELECT * FROM Parameters p WHERE p.RecordState='A' ";
                $query .= "AND p.ParamGroupName='".$filter["parametreGroupName"]."' ";

                $dbResult = $this->db->getData($query);
                
                foreach ($dbResult as $key => $res) {
                    $rowItem = array(
                        "ParamGroupName"=> $res['ParamGroupName'],
                        "ParamCode"=> $res['ParamCode'],
                        "ParamName"=> $res['ParamName'],
                        "ParamValue1"=> $res['ParamValue1'],
                        "ParamValue2"=> $res['ParamValue2'],
                        "ParamValue3"=> $res['ParamValue3'],
                        "ParamValue4"=> $res['ParamValue4'],
                        "ParamValue5"=> $res['ParamValue5']
                    ); 

                    array_push($result, $rowItem); 
                } 

                return $result;
            }
            catch(Exception $e)
            {
              echo $e->getMessage();
            }
        }

        function GetParametreByGroupName($groupName)
        {
            try 
            {
                $result = array();
                $parametreGroupName = $filter["parametreGroupName"];
                 
                $query  ="SELECT * FROM Parameters p WHERE p.RecordState='A' ";
                $query .= "AND p.ParamGroupName='".$groupName."' ";

                $dbResult = $this->db->getData($query);
                
                foreach ($dbResult as $key => $res) {
                    $rowItem = array(
                        "ParamGroupName"=> $res['ParamGroupName'],
                        "ParamCode"=> $res['ParamCode'],
                        "ParamName"=> $res['ParamName'],
                        "ParamValue1"=> $res['ParamValue1'],
                        "ParamValue2"=> $res['ParamValue2'],
                        "ParamValue3"=> $res['ParamValue3'],
                        "ParamValue4"=> $res['ParamValue4'],
                        "ParamValue5"=> $res['ParamValue5']
                    ); 

                    array_push($result, $rowItem); 
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