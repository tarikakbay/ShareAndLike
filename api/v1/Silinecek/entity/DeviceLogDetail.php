<?php
    class DeviceLogDetail {
        // database connection
        private $db;

        // object properties
        public $Id;
        public $DeviceLogId;
        public $DataType; //0:Gelen, 1:Giden
        public $DataKey;
        public $DataValue; 

        // constructor with $db as database connection
        public function __construct($db){
            $this->db = $db;
        }

        //Create Device
        function Create()
        {
            try 
            {
                $result = $this->db->executePK("INSERT INTO `DeviceLogDetails`(  
                    `DeviceLogId`,  
                    `DataType`, 
                    `DataKey`,  
                    `DataValue`
                    ) VALUES ( 
                        '".$this->DeviceLogId."', 
                        '".$this->DataType."',
                        '".$this->DataKey."',
                        '".$this->DataValue."'
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
        } 

        //GET
        function Get($filter)
        {
            try 
            {
                $result = array();
                $reportName = $filter["reportName"];
                
                if($reportName== "LogByDeviceKey")
                {

                }
                
                return $result;
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
                
                if($reportName== "LogRequestByDeviceKey")
                {   
                    $query="SELECT l.Id, l.CheckDate, l.RequestIpAddress, d.DataKey, d.DataValue FROM DeviceLogs l, DeviceLogDetails d ";
                    $query .= "WHERE l.Id=d.DeviceLogId "; 
                    $query .= "AND l.DeviceKey='".$filter["deviceKey"]."' ";
                    $query .= "AND d.DataType=0 ";//0:request, 1:Response

                    $result = $this->db->getRowCount($query); 
                }
                else if($reportName== "LogResponseByDeviceKey")
                {   
                    $query="SELECT l.Id, l.CheckDate, l.RequestIpAddress, d.DataKey, d.DataValue FROM DeviceLogs l, DeviceLogDetails d ";
                    $query .= "WHERE l.Id=d.DeviceLogId "; 
                    $query .= "AND l.DeviceKey='".$filter["deviceKey"]."' ";
                    $query .= "AND d.DataType=1 ";//0:request, 1:Response

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
                
                if($reportName== "LogRequestByDeviceKey")
                {
                    $query="SELECT l.Id, l.CheckDate, l.RequestIpAddress, d.DataKey, d.DataValue FROM DeviceLogs l, DeviceLogDetails d ";
                    $query .= "WHERE l.Id=d.DeviceLogId "; 
                    $query .= "AND l.DeviceKey='".$filter["deviceKey"]."' ";
                    $query .= "AND d.DataType=0 ";//0:request, 1:Response
                    $query .= "ORDER BY l.CheckDate DESC ";
                    $query .= "LIMIT ".$startIndex.", ".$pageCount;

                    $dbResult = $this->db->getData($query);     
                    
                    foreach ($dbResult as $key => $res) {
                        $rowItem = array(
                             "Id"=> $res['Id'],  
                             "CheckDate"=> date('d.m.Y H:i:s', strtotime($res['CheckDate'])),
                             "RequestIpAddress"=> $res['RequestIpAddress'],
                             "DataKey"=> $res['DataKey'],
                             "DataValue"=> $res['DataValue'] 
                        ); 

                        array_push($result, $rowItem); 
                    }
                }
                else if($reportName== "LogResponseByDeviceKey")
                {
                    $query="SELECT l.Id, l.CheckDate, l.RequestIpAddress, d.DataKey, d.DataValue FROM DeviceLogs l, DeviceLogDetails d ";
                    $query .= "WHERE l.Id=d.DeviceLogId "; 
                    $query .= "AND l.DeviceKey='".$filter["deviceKey"]."' ";
                    $query .= "AND d.DataType=1 ";//0:request, 1:Response
                    $query .= "ORDER BY l.CheckDate DESC ";
                    $query .= "LIMIT ".$startIndex.", ".$pageCount;

                    $dbResult = $this->db->getData($query);     
                    
                    foreach ($dbResult as $key => $res) {
                        $rowItem = array(
                             "Id"=> $res['Id'],  
                             "CheckDate"=> date('d.m.Y H:i:s', strtotime($res['CheckDate'])),
                             "RequestIpAddress"=> $res['RequestIpAddress'],
                             "DataKey"=> $res['DataKey'],
                             "DataValue"=> $res['DataValue']
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