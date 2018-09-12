<?php
    class DeviceLog {
        // database connection
        private $db;

        // object properties
        public $Id;
        public $DeviceId;
        public $DeviceKey;
        public $CheckDate;
        public $RequestIpAddress;
        public $RequestData;
        public $ResponseData;

        // constructor with $db as database connection
        public function __construct($db){
            $this->db = $db;
        }

        //Create Device
        function Create()
        {
            try 
            {
                $result = $this->db->executePK("INSERT INTO `DeviceLogs`(  
                    `DeviceKey`,
                    `DeviceId`,  
                    `RequestIpAddress`, 
                    `RequestData`,  
                    `ResponseData`
                    ) VALUES ( 
                        '".$this->DeviceKey."', 
                        ".$this->DeviceId.",
                        '".$this->RequestIpAddress."',
                        '".$this->RequestData."',
                        '".$this->ResponseData."'
                    )"); 
                
                $this->Id = $result;

                return ($result>0);
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
            }
        }

        //PUT
        function Update()
        {
            try
            {
                $result = $this->db->execute("UPDATE `DeviceLogs` SET `ResponseData`='".$this->ResponseData."' WHERE Id=".$this->Id);
            }
            catch(Exception $e)
            {
                echo $e->getMessage();
            }
        }

        //GET
        function Get($filter)
        {
            try 
            {

            }
            catch(Exception $e)
            {
              echo $e->getMessage();
            }
        }

        //GET PAGING
        function GetRowCount($filter)
        {
            try 
            {
                $result = 0;
                $reportName = $filter["reportName"];
                
                if($reportName== "LogByDeviceKey")
                {
                    $query="SELECT * FROM DeviceLogs l ";
                    $query .= "WHERE l.DeviceKey='".$filter["deviceKey"]."' ";

                    $result = $this->db->getRowCount($query); 
                }
                
                return $result;
            }
            catch(Exception $e)
            {
              echo $e->getMessage();
            }
        }

        function GetPaged($filter, $startIndex, $pageCount)
        {
            try 
            {
                $result = array();
                $reportName = $filter["reportName"];
                
                if($reportName== "LogByDeviceKey")
                {
                    $query="SELECT * FROM DeviceLogs l ";
                    $query .= "WHERE l.DeviceKey='".$filter["deviceKey"]."' ";
                    $query .= "ORDER BY l.CheckDate DESC ";
                    $query .= "LIMIT ".$startIndex.", ".$pageCount;

                    $dbResult = $this->db->getData($query);     
                    
                    foreach ($dbResult as $key => $res) {
                        $rowItem = array(
                             "Id"=> $res['Id'],
                             "DeviceId"=> $res['DeviceId'],
                             "DeviceKey"=> $res['DeviceKey'],
                             "CheckDate"=> date('d.m.Y H:i:s', strtotime($res['CheckDate'])),
                             "RequestIpAddress"=> $res['RequestIpAddress'],
                            "IncomingValue1"=> $res['IncomingValue1'],
                            "IncomingValue2"=> $res['IncomingValue2'],
                            "IncomingValue3"=> $res['IncomingValue3']
                            ,"ResponseData"=> $res['ResponseData']
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