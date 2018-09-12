<?php
    require_once("_header.php");
    require_once("_nav.php");
    require_once("_menu.php");

    $data = array("reportName" => "UserDevices");
    $json = CallAPI("GET", "DeviceGet.php", $data);
    $result = GetApiData($json);
?>
<div class="row mt-4">
    
<?php
    foreach($result as $row) {
        echo $row->Id;
?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-light"><?=$row->TagName;?>

                    <div class="card-actions">
                        <a href="index.php?page=device&devicekey=<?=$row->Key;?>" class="btn">
                            <i class="fa fa-cog"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    Device Detayları
                </div>
            </div>
        </div>

<?php
    }    
?>

</div>
 

<?php
    require_once("_footer.php"); 
?>
<script> 
</script>