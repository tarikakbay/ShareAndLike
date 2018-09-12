<?php 
include_once '../libraries/Common.php';

    class DeviceData2Send extends Common
    {
        // database connection
        private $db;
        
        // object properties
        public $Id;
        public $DeviceId;
        public $DeviceKey;
        public $DeviceCommandId;
        public $StartDatetime;
        public $FinishDatetime;
        public $SendDatetime;
        public $RequestCount;
        public $DataState;

        //Custom

        // constructor with $db as database connection
        public function __construct($db){
            $this->db = $db;
        }

        //Functions

        //Create Device
        function Create()
        {
            $result = $this->db->executePK("INSERT INTO DeviceData2Send (
                `DeviceId`, 
                `DeviceKey`, 
                `StartDatetime`, 
                `FinishDatetime`,   
                `RequestCount`, 
                `DataState`, 
                `DeviceCommandId`, 
                `RecordUserId`)
                VALUES (
                    '".$this->DeviceId."',
                    '".$this->DeviceKey."',
                    '".$this->StartDatetime."',
                    '".$this->FinishDatetime."', 
                    ".$this->RequestCount.",
                    ".$this->DataState.",
                    ".$this->DeviceCommandId.",
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
                
                if($reportName== "NotSendDataByDeviceKey")
                {
                    $query  = "SELECT d.Id 'SendId', cd.DataKey 'DataKey', cd.DataValue 'DataValue' ";  
                    $query .= "FROM DeviceData2Send d, DeviceCommand c, DeviceCommandDetails cd ";
                    $query .= "WHERE d.DeviceCommandId = c.Id AND c.Id = cd.DeviceCommandId AND c.RecordState='A' AND d.RecordState='A' ";
                    $query .= "AND d.DataState=0 AND d.StartDatetime<=NOW() AND d.FinishDatetime>=NOW() ";
                    $query .= "AND d.DeviceKey='".$filter["deviceKey"]."' "; 

                    $dbResult = $this->db->getData($query);

                    foreach ($dbResult as $key => $res) {

                        $this->db->execute("UPDATE `DeviceData2Send` SET `SendDatetime`='".date("Y-m-d H:i:s")."', RequestCount = RequestCount + 1 WHERE Id=".$res['SendId']);

                        $rowItem = array(
                            "SendId"=> $res['SendId'],
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

        

        //GET PAGING
        function GetRowCount($filter)
        {
            try 
            {
                $result = 0;
                $reportName = $filter["reportName"];
                
                if($reportName== "DataSendByDeviceKey")
                {
                    $query  = "SELECT * FROM DeviceLogs l ";
                    $query .= "WHERE l.DeviceKey='".$filter["deviceKey"]."' ";
                    $query .= "AND l.RecordState='A'"; 

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
                
                if($reportName== "DataSendByDeviceKey")
                { 
                    $query ="SELECT d.Id, d.StartDatetime, IFNULL(d.SendDatetime, ''), d.RequestCount, u.Name, u.Surname, c.Tag, ";
                    $query .="(SELECT p.ParamName FROM Parameter p  WHERE p.RecordState = 'A' AND p.ParamGroupName = 'SendDataState' AND p.ParamCode=d.DataState) 'SendStateText' ";
                    $query .="FROM DeviceData2Send d, Users u, DeviceCommand c ";
                    $query .="WHERE d.DeviceCommandId=c.Id ";
                    $query .="AND d.RecordUserId = u.Id AND d.RecordState = 'A' ";
                    $query .= "AND d.DeviceKey='".$filter["deviceKey"]."' ";
                    $query .= "ORDER BY d.StartDatetime DESC ";
                    $query .= "LIMIT ".$startIndex.", ".$pageCount;                    

                    $dbResult = $this->db->getData($query);     
                    
                    foreach ($dbResult as $key => $res) {
                        $rowItem = array(
                             "Id"            => $res['Id'],
                             "StartDatetime" => date('d.m.Y H:i:s', strtotime($res['StartDatetime'])),
                             "SendDatetime"  => $res['SendDatetime'], 
                             "RequestCount"  => $res['RequestCount'],
                             "Name"          => $res['Name'],
                             "Surname"       => $res['Surname'],
                             "Tag"           => $res['Tag'],
                             "SendStateText" => $res['SendStateText'] 
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