var html5QrCode;
var lastCode='';
var submitOk=false;

function onScanSuccess(decodedText, decodedResult) {
  if(decodedText!=lastCode){
    lastCode=decodedText;
    checkMaterialCode(decodedText);
    if($('#quantity').val()!='' || $('#received').val()!='') {
    //    submitForm();
    }
  }
}

function checkMaterialCode(code) {
    if(code.length<2) return;
    $.ajax({
    url: '/api/inventory/checkMaterialCode',
    type: 'POST',
    data: {code: code, api_token: '{{ Auth::user()->api_token }}'},
    success: function(data) {
      if (data.success) {
        $('#msg').html(`Found Chemical ${data.material.VendorCode} - ${data.material.ChemcoName}`);
        $('#code').val(`${data.material.VendorCode}`);
        $('#chemid').val(`${data.material.id}`);
        submitOk=1;
        $('#code').focus();
        $('#quantity').focus();
        $('#msgcolor').css('background-color', '#3cb043');

        //html5QrCode.stop();
      } else {
        submitOk=0;
        $('#msg').html(`Chemical ${code} not found`);
        $('#msgcolor').css('background-color', '#D0312d');
      }
    }
  });
}

var pause=false;
function submitForm() {
    if(!submitOk) {
        $('#msg').html(`Invalid Chemical ID`);
        return;
    }
    if(pause)return;
    pause=true;
    var quantity = $('#quantity').val();
    var received = $('#received').val();
    var chemid = $('#chemid').val();
    var plant = $('#plant').val();
    $.ajax({
        url: '/inventory/postInventory',
        type: 'POST',
        data: {quantity: quantity, received: received, chemid: chemid, plant: plant, api_token: '{{ Auth::user()->api_token }}'},
        success: function(data) {
            pause=false;
            if (data.success) {
                $('#msg').html(`Inventory Submitted`);
                $('#code').val('');
                $('#quantity').val('');
                $('#received').val('');
                $('#quantity').focus();
            } else {
                //$('#code').val(`${code} not found`);
            }
        }
    });
}


$(function() {
    setupAjaxToken();
//https://github.com/mebjas/html5-qrcode

    $('#sbmit').click(submitForm);
    $('#code').keyup(function () {
        console.log('keyup');
        checkMaterialCode($('#code').val());
    });

    


const formatsToSupport = [
      Html5QrcodeSupportedFormats.QR_CODE,
      Html5QrcodeSupportedFormats.UPC_A,
      Html5QrcodeSupportedFormats.UPC_E,
      Html5QrcodeSupportedFormats.UPC_EAN_EXTENSION,
      Html5QrcodeSupportedFormats.CODE_39,
      Html5QrcodeSupportedFormats.CODE_128,
  ];

  let config = { fps: 10 }; //, formatsToSupport: formatsToSupport
/*
  let msg='Cameras Found<br>';
  Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            devices.forEach(device => {
                msg+=`${device.label}<br>`;
            });
            $('#msg').html(msg);
        };
  });
*/



//  if(isMobile) {
    html5QrCode = new Html5Qrcode("reader",{
    // Use this flag to turn on the feature.
    experimentalFeatures: {
        useBarCodeDetectorIfSupported: true
    }
}
    
    
    );
    html5QrCode.start({ facingMode: "environment" }, config, onScanSuccess);
    //$('#msg').html(`Camera Started`);
//  } else {
//    $('#cameraRow').hide();
//    $('#msg').html(`Ready`);
//  }

  

});
