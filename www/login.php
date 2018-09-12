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
                        Giriş
                    </div>

                    <div class="card-body py-5">
                        <form action="UserLoginPost.php" id="formLogin" method="post"  role="form">
                            <div class="form-group">
                                <label class="form-control-label">E-Posta</label>
                                <input type="email" class="form-control"  name="email" autofocus>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Parola</label>
                                <input type="password" class="form-control"  name="password">
                            </div>

                            <div class="custom-control custom-checkbox mt-4">
                                <input type="checkbox" class="custom-control-input" id="login" checked>
                                <label class="custom-control-label" for="login">Beni Hatırla</label>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6">
                                <button type="submit" class="btn btn-primary px-5" onclick="btnLogin_Click();">Giriş</button>
                            </div>

                            <div class="col-6">
                                <a href="#" class="btn btn-link">Parolamı Unuttum</a>
                            </div>
                        </div>
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
<script src="./vendor/chart.js/chart.min.js"></script>
<script src="./js/carbon.js"></script>
<script src="./js/dashboard.js"></script>

<script>
    $(document).ready(function () {
        if($.cookie("access_token"))
        {   
            window.location.href = "index.php?p=dashboard";
        }
    });
    
    function btnLogin_Click() {
        $.removeCookie("access_token");
        submitForm($('#formLogin'), false, OnLogin);
    }

    function OnLogin(selector, result)
    {
        if(result.Success) { 
            $.cookie("access_token", result.Data.access_token, { expires : result.Data.expires_in });
            $.cookie("userName", result.Data.userName, { expires : result.Data.expires_in });
            window.location.href = "index.php?p=dashboard";
        } else {
            alert("E-Posta veya Parola Yanlış");
        }
    }
</script>

</body>
</html>
