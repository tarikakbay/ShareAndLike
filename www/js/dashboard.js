var apiRoot = "http://localhost/proje1/api/v1/controller/";

//#region page Events
$(document).ready(function () {
});
    
function refreshPage() {
    window.location.href = window.location.href;
}
    
    //#endregion
    
function sendData(type, serializedData, url, callback)
{
    console.log(serializedData, "sendData serializeData");

    $.ajax({
        cache: false,
        async: true, //!!!
        type: type,//"POST",
        url: apiRoot + url,
        data: serializedData,
        dataType: 'json',
        beforeSend: function (request) {
            request.setRequestHeader("access_token", $.cookie("access_token"));
            //showLoadingPanel();
        },
        success: function (data) {
            console.log(data, "dashboard -> sendData -> success");
            if (callback != undefined || callback != null)
                callback(data);
        },
        error: function (xhr, status, error) {
            console.log("Bağlantı sırasında hata oluştu!", "dashboard -> sendData -> errorMessage -> " + error);
            var errMessage = "Beklenilmeyen hata oluştu. ";
            try {
                var json = $.parseJSON(xhr.responseText);
                errMessage += json.ExceptionMessage;
            }
            catch (e) {
                errMessage += error;
            }
            alert(errMessage);
        },
        complete: function () {
            //hideLoadingPanel();
        }
    });
}
function submitForm(form, valid, callback)
{    
    if (valid != undefined && valid)
        if (!$form.valid()) return;

    var urlFull = apiRoot + form.attr('action');

    console.log("form DATA", form.serialize());

    $.ajax({
        cache: false,
        async: true, //!!!
        type: "POST",
        url: urlFull,
        data: form.serialize(),
        dataType: 'json',
        beforeSend: function (request) {
            request.setRequestHeader("access_token", $.cookie("access_token"));
            //showLoadingPanel();
        },
        success: function (data) {
            console.log(data, "dashboard -> submitForm -> success");
            if (callback != undefined)
                callback(form.selector, data);
        },
        error: function (xhr, status, error) {
            console.log("Bağlantı sırasında hata oluştu!", "dashboard -> submitForm -> errorMessage -> " + error);
            console.log("Url->"+urlFull);
            var errMessage = "Beklenilmeyen hata oluştu. ";
            try {
                var json = $.parseJSON(xhr.responseText);  
                errMessage += json.MessageText;
            }
            catch (e) {
                errMessage += error;
            }
            alert(errMessage);
        },
        complete: function () {
            //hideLoadingPanel();
        }
    });
}

function getDataForGrid(verbType, serializedData, url)
{
    console.log("getDataForGrid HttpVerb:"+verbType, apiRoot + url);

    var d = $.Deferred();
    $.ajax({
        type: verbType,
        url: apiRoot + url,
        data: serializedData, 
        dataType: "json", 
        beforeSend: function (request) {
            request.setRequestHeader("access_token", $.cookie("access_token"));
        },
    }).done(function (response) {
        console.log(response, "dashboard -> getDataForGrid");
        d.resolve(
            {
                data: response.Data,
                itemsCount: response.ItemsCount
            }
        );
    }); 

    return d.promise();
}

//#region ShowDialog
function ShowDialog(dialogType, message, callback) { 
    var mymodal = $('#ModalDialog');
    mymodal.find('.modal-body').text(message);

    if (dialogType == "Success") {
        mymodal.find('.modal-title').text('Başarılı');
        mymodal.find('.modal-header').attr("class", "modal-header bg-success border-0");
    }
    else if (dialogType == "Error") {
        mymodal.find('.modal-title').text('Hata !');
        mymodal.find('.modal-header').attr("class", "modal-header bg-danger border-0");
    }
    else if (dialogType == "Info") {
        mymodal.find('.modal-title').text('Bilgi');
        mymodal.find('.modal-header').attr("class", "modal-header bg-info border-0");
    }
    else if (dialogType == "Warning") {
        mymodal.find('.modal-title').text('Dikkat !');
        mymodal.find('.modal-header').attr("class", "modal-header bg-warning border-0");
    }  

    var btnOK = document.getElementById("ModalDialogButton");
    btnOK.onclick = function () {
        $('#ModalDialog').modal('hide');
        if (callback != undefined)
        { callback(); }
    }; 

    mymodal.modal('show');  
}

function QuestionDialog(Message, yesCallback, noCallback) {
    var btnYes = document.getElementById("btnModalQuestionDialogYes");
    btnYes.onclick = function () {
        $('#ModalQuestionDialog').modal('hide');
        if (yesCallback != undefined)
        { yesCallback(); }
    };
    var btnNo = document.getElementById("btnModalQuestionDialogNo");
    btnNo.onclick = function () {
        $('#ModalQuestionDialog').modal('hide');
        if (noCallback != undefined)
        { noCallback(); }
    };
    
    var spanMessage = document.getElementById("ModalQuestionDialogMessage");
    spanMessage.innerHTML = Message;
    //spanMessage.style.color = "#009900";

    $('#ModalQuestionDialog').modal('show');
}
//#endregion