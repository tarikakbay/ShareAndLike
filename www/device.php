<?php
    require_once("_header.php");
    require_once("_nav.php");
    require_once("_menu.php");

    $deviceKey = htmlspecialchars($_GET["devicekey"]); 
?>

<input type="hidden" name="deviceKey" id="deviceKey" value="<?=$deviceKey;?>">

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">Aygıt Bilgileri
                <div class="card-actions">
                    <a href="#" class="btn" >
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover"> 
                    <tbody>
                    <tr>
                        <td class="text-nowrap">Cihaz Tipi</td>
                        <td>Role</td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">Son Sorgulama</td>
                        <td>01.01.2018 12:00:00</td>
                    </tr>
                    <tr>
                        <td class="text-nowrap">Bekleyen Komut</td>
                        <td>0</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">Aygıt Komutlari
                <div class="card-actions" onclick="getDeviceCommand_Refresh()">
                    <a href="#" class="btn" >
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>
            </div>
            <div class="card-body"> 
                <div id="gridDeviceCommand"></div> 
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">Gelen Degerler
                <div class="card-actions">
                    <a href="#" class="btn" onclick="getDeviceLogRequest_Refresh()" >
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="gridDeviceLogRequest"></div>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-light">Gönderilen Komutlar
                <div class="card-actions">
                    <a href="#" class="btn" onclick="getDeviceData2Send_Refresh()" >
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="gridDeviceData2Send"></div>
            </div>
        </div>
    </div> 

</div>
<?php
    require_once("_footer.php"); 
?>
<script>
    function sendCommand(commandID)
    {
        var serializedData = "commandId="+commandID+"&deviceKey="+$("#deviceKey").val();
        sendData("POST", serializedData, "DeviceData2SendPost.php", sendCommand_response)
    }

    function sendCommand_response(result)
    {
        if(result.Success)
        {
            getDeviceData2Send_Refresh();
            ShowDialog("Success","Gönderilmek istenilen komut kayıt edildi", null);
        }
    }

</script>
<script>
    function getDeviceLogRequest_Refresh() {
        $("#gridDeviceLogRequest").jsGrid("loadData"); 
    }

    $("#gridDeviceLogRequest").jsGrid({
        width: "100%",
        height : 'auto',
        pageLoading: true,

        autoload: false,
        sorting: false,
        paging: true, 
        pageSize: 5,
        noDataContent: "Kayıt Bulunamadı",

        controller: {
            loadData: function (filter) { 
                var startIndex = (filter.pageIndex - 1) * filter.pageSize; 
                var serializedData = "reportName=LogRequestByDeviceKey&startIndex="+startIndex+"&pageCount="+filter.pageSize+"&deviceKey="+$("#deviceKey").val();
                return getDataForGrid("GET",serializedData, "DeviceLogGet.php");
            }
        },

        fields: [
            { name: "CheckDate", title:"Bağlantı Zamanı", type: "text"},
            { name: "DataKey", title:"Anahtar", type: "text"},
            { name: "DataValue", title:"Değer", type: "text"}, 
            { name: "RequestIpAddress", title:"İp Adresi", type: "text"}
        ]
    });

    $("#gridDeviceLogRequest").jsGrid("loadData");
</script>

<script>
    function getDeviceData2Send_Refresh() {
        $("#gridDeviceData2Send").jsGrid("loadData"); 
    }

    $("#gridDeviceData2Send").jsGrid({
        width: "100%",
        height : 'auto',
        pageLoading: true,

        autoload: false,
        sorting: false,
        paging: true, 
        pageSize: 5,
        noDataContent: "Kayıt Bulunamadı",

        controller: {
            loadData: function (filter) { 
                var startIndex = (filter.pageIndex - 1) * filter.pageSize; 
                var serializedData = "reportName=DataSendByDeviceKey&startIndex="+startIndex+"&pageCount="+filter.pageSize+"&deviceKey="+$("#deviceKey").val();
                return getDataForGrid("GET",serializedData, "DeviceData2SendGet.php");
            }
        },

        fields: [
            { name: "Tag", title:"Komut İsmi", type: "text"}, 
            { name: "StartDatetime", title:"Kayıt Zamanı", type: "text"},
            { name: "SendStateText", title:"Gönderilme Durumu", type: "text"}, 
            { name: "SendDatetime", title:"Gönderilme Zamanı", type: "text"},
            { name: "RequestCount", title:"Gönderim Sayısı", type: "text"}, 
            { name: "Name", title:"Ekleyen", type: "text"}, 
            { name: "Surname", title:"Ekleyen", type: "text"}
        ]
    });

    $("#gridDeviceData2Send").jsGrid("loadData");
</script>

<script>
    function getDeviceCommand_Refresh() {
        $("#gridDeviceCommand").jsGrid("loadData"); 
    }

    $("#gridDeviceCommand").jsGrid({
        width: "100%",
        height : 'auto',
        pageLoading: true,

        autoload: false,
        sorting: false,
        paging: true, 
        pageSize: 5,
        noDataContent: "Kayıt Bulunamadı",

        controller: {
            loadData: function (filter) { 
                var startIndex = (filter.pageIndex - 1) * filter.pageSize; 
                var serializedData = "reportName=CommandByDeviceKey&startIndex="+startIndex+"&pageCount="+filter.pageSize+"&deviceKey="+$("#deviceKey").val();
                return getDataForGrid("GET",serializedData, "DeviceCommandGet.php");
            }
        },

        fields: [
            { name: "Tag", title:"Komut İsmi", type: "text"}, 
            {
            	itemTemplate: function(value, item) {
                    var $result = jsGrid.fields.control.prototype.itemTemplate.apply(this, arguments);
                    
                    var $customButton = $("<button>")
                        .addClass(item.StyleColorClass)
                    	.text("Gönder")
                    	.click(function(e) {
                            sendCommand(item.Id); 
                            e.stopPropagation();
                        });
                    
                    return $result.add($customButton);
                }
            } 
        ]

    });

    $("#gridDeviceCommand").jsGrid("loadData");
</script>