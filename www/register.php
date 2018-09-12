<?php
    require_once("_header.php");
?>
<body>
<div class="page-wrapper flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4">
                    <div class="card-header text-center text-uppercase h4 font-weight-light">
                        Kayıt Ol
                    </div>

                    <div class="card-body py-5">
                        <form action="UserCreatePost.php" id="formCreate" method="post"  role="form">
                            <div class="form-group">
                                <label class="form-control-label">Ad</label>
                                <input type="name" name="name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Soyad</label>
                                <input type="surname" name="surname" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Kullanici Ad</label>
                                <input type="username" name="username" class="form-control">
                            </div>
    
                            <div class="form-group">
                                <label class="form-control-label">E-Posta</label>
                                <input type="email" name="email" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Şifre</label>
                                <input type="password" name="password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Şifre Onay</label>
                                <input type="password" name="passwordConfirm" class="form-control">
                            </div>
                        </form>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-block"onclick="btnCreate_Click();">Kayıt Ol</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="./vendor/jquery/jquery.min.js"></script>
<script src="./vendor/jqueryCookie/jquery.cookie.min.js"></script>
<script src="./vendor/popper.js/popper.min.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="./vendor/sweetAlert/sweetalert.min.js"></script>
<script src="./js/carbon.js"></script>
<script src="./js/dashboard.js"></script>

<script>
    $(document).ready(function () { 
    });
    
    function btnCreate_Click() { 
        submitForm($('#formCreate'), false, OnCreate);
    }

    function OnCreate(selector, result)
    {
        if(result.Success) { 
            swal("Başarılı!", result.MessageText, "success"); 
        } else {
            swal("Dikkat!", result.MessageText, "warning"); 
        }
    }
</script>

</body>
</html>
