//Wizard Init
var currentStep = 0;
var orderInfoString = "";
var orderSoloDuoString = "";
var orderTypeString = "";
var orderExtrasString="";
var orderPPString="";
var orderIdUnique="";
var orderMessage="";
var orderFormObj = {type:'', region:'', username:'', password:'', email:'', summoner_name:'', discord:'', message:'', lpg:'', starting_lp:'', extras:[]};
var resultt = false;
let checked=false;
var endInfoCheck=false;
let order = {order_id:'', order_type:'', order_price:'', order_message:null, order_status:'unclaimed', payout_status:'in-progress', client_id: '', booster_id:null, created_at:null, updated_at:null};

let accountExists = false;

var clientIDReturn=[];

var username="";
var password="";
var email="";
var discord="";
var message="";
var summonerName="";
var orderExtras=[];
var validOrder=true;
var orderPrice = 43.00;
var discountedPrice = -1.00;
var paginate = true;
let ranks = ['I4', 'I3', 'I2', 'I1', 'B4', 'B3', 'B2', 'B1', 'S4', 'S3', 'S2', 'S1', 'G4', 'G3', 'G2', 'G1', 'P4', 'P3', 'P2', 'P1', 'D4', 'D3', 'D2', 'D1', "M", 'GM', 'C'];
let ranks2 = ['Iron 4', 'Iron 3', 'Iron 2', 'Iron 1', 'Bronze 4', 'Bronze 3', 'Bronze 2', 'Bronze 1', 'Silver 4', 'Silver 3', 'Silver 2', 'Silver 1', 'Gold 4', 'Gold 3', 'Gold 2', 'Gold 1', 'Platinum 4', 'Platinum 3', 'Platinum 2', 'Platinum 1', 'Diamond 4', 'Diamond 3', 'Diamond 2', 'Diamond 1', "Master", 'GM', 'C'];
let ranks3 = ['I', 'B', 'S', 'G', 'P', 'D', 'M', 'GM', 'C'];
let ranks4 = ['Iron', 'Bronze', 'Silver', 'Gold', 'Platinum', 'Diamond', 'Master', 'Grandmaster', 'Challenger'];

$("#wizard").steps({
    headerTag: "h3",
    bodyTag: "section",
    stepsOrientation: "vertical",
    titleTemplate: '<span class="number">#index#</span>',
    transitionEffect: 1,
    transitionEffectSpeed: 200,
    enablePagination: paginate,
    onStepChanging: function(event, currentIndex, newIndex)
    {

      // For First Step
      if($("input[name='solo-duo']:checked").val()==='Solo'){
        $('#duo-orders').hide();
        $('#solo-orders').show();
        $('#solo-info').show();
        $('#duo-info').hide();

      }else{
        $('#solo-orders').hide();
        $('#duo-orders').show();
        $('#duo-info').show();
        $('#solo-info').hide();

      }

      // For Third Step
      if($("input[name='solo-type']:checked").val()==='Solo Division'){
        $('#division-duo').hide();
        $('#division-solo').show();
        $('#netwin-solo').hide();
        $('#netwin-duo').hide();
        $('#placement-solo').hide();
        $('#placement-duo').hide();


      }else if($("input[name='duo-type']:checked").val()==='Duo Division'){
        $('#division-solo').hide();
        $('#division-duo').show();
        $('#netwin-solo').hide();
        $('#netwin-duo').hide();
        $('#placement-solo').hide();
        $('#placement-duo').hide();


      }
      else if($("input[name='solo-type']:checked").val()==='Solo Net Wins'){
        $('#division-solo').hide();
        $('#division-duo').hide();
        $('#netwin-solo').show();
        $('#netwin-duo').hide();
        $('#placement-solo').hide();
        $('#placement-duo').hide();

      }
      else if($("input[name='duo-type']:checked").val()==='Duo Net Wins'){
        $('#division-solo').hide();
        $('#division-duo').hide();
        $('#netwin-solo').hide();
        $('#netwin-duo').show();
        $('#placement-solo').hide();
        $('#placement-duo').hide();

      }
      else if($("input[name='solo-type']:checked").val()==='Solo Placement'){
        $('#division-solo').hide();
        $('#division-duo').hide();
        $('#netwin-solo').hide();
        $('#netwin-duo').hide();
        $('#placement-solo').show();
        $('#placement-duo').hide();
      }
      else if($("input[name='duo-type']:checked").val()==='Duo Placement'){
        $('#division-solo').hide();
        $('#division-duo').hide();
        $('#netwin-solo').hide();
        $('#netwin-duo').hide();
        $('#placement-solo').hide();
        $('#placement-duo').show();
      }

      rankImageCheckOne();
      rankImageCheckTwo();
      rankImageCheckThree();
      rankImageCheckFour();
      rankImageCheckFive();
      rankImageCheckSix();

      rankImageCheckDuoDivOne();
      rankImageCheckDuoDivTwo();
      if(newIndex===5){
        buildOrderInfo();
      }
      /*if(currentIndex === 4 && newIndex === 5){
        if(!checked){
          checkAccount();
        }
        if(resultt){
          checked=false;
          resultt=false;
          return true;
        }
        else{
          return false;
        }
      }
      else{
      return true;
    }*/
      $('.preUserSoloError').hide();
      $('.prePassSoloError').hide();
      $('.preSummSoloError').hide();
      $('.preEmailSoloError').hide();
      $('.preSummDuoError').hide();
      $('.preEmailDuoError').hide();
      let check = 0;
      if(currentIndex === 4 && newIndex === 5){
        if($("input[name='solo-duo']:checked").val()==='Solo'){
          if(($('#username').val()==='')){
            $('.preUserSoloError').show();
            check++;

          }else{
            $('.preUserSoloError').hide();

          }
          if($('#password').val()===''){
            $('.prePassSoloError').show();
            check++;
          }else{
            $('.prePassSoloError').hide();

          }
          if($('#summonerName').val()===''){
            $('.preSummSoloError').show();
            check++;
          }else{
            $('.preSummSoloError').hide();

          }
          if(!validateEmail($('#emailAddress').val()) ){
            $('.preEmailSoloError').show();
            check++;
          }else{
            $('.preEmailSoloError').hide();

          }
        }else{

          if($('#summonerName2').val()===''){
            $('.preSummDuoError').show();
            check++;
          }else{
            $('.preSummDuoError').hide();

          }
          if(!validateEmail($('#emailAddress2').val()) ){
            $('.preEmailDuoError').show();
            check++;
          }else{
            $('.preEmailDuoError').hide();

          }
        }
        if(check!=0){
          return false;
        }else{
          return true;
        }
      }else{
        return true;
      }
    },
    onStepChanged: function(event, currentIndex, newIndex){
      currentStep = currentIndex;
      if(currentIndex===2 || currentIndex===3 || currentIndex===4){
        $('.actions').show();
      }
      else{
        $('.actions').hide();
      }
      if(currentIndex===2 || currentIndex===3){
        calculatePrice();
        $('#price-preview').show();
      }
      else{
        $('#price-preview').hide();

      }

    }
});

//$(document).ready(function($){
  //$(document).on('submit', '#newUserForm', function(event){
    //event.preventDefault();
  //});
//});

$('#price-preview').hide();
$('#discount_error').hide();
$('.endformSubmit').hide();
$('.endEmailError').hide();
$('.endPassError1').hide();
$('.endPassError2').hide();
$('.preUserSoloError').hide();
$('.prePassSoloError').hide();
$('.preSummSoloError').hide();
$('.preEmailSoloError').hide();
$('.preSummDuoError').hide();
$('.preEmailDuoError').hide();


$('.registerFormEmail').on('change', function(e){
  //console.log(Date.now());
});
$('.registerFormClientID').attr('value', Date.now());
//console.log($('.registerFormClientID').val());

function changeStep(){
  $("#wizard").steps("next", {});

}
//Server requests

//make one that takes order info and returns price
//paypal

$('.navbar-nav li a').on('click', function(){
    if(!$( this ).hasClass('dropdown-toggle')){
        $('.navbar-collapse').collapse('hide');
    }
});

//Form control
//below runs when started
$('.actions').hide();
$("a[href$='previous']").hide();

$('#solo-duo-input').on('change', function(e) {
    orderExtrasVisibility();
    if(e.target.value==='Solo'){
      $('#duo-orders').hide();
      $('#solo-orders').show();

    }else{
      $('#solo-orders').hide();
      $('#duo-orders').show();


    }
});
$('#applyDiscount').on('click', function(e){
  if($('#discount_code').val()!==''){
    $('#discount_error').hide();
    $.ajax({
    type:"GET",
    url:"https://app.bmsboosting.com/api/prices/"+$('#discount_code').val(),

    success: function success(data){
      //console.log(data);
      if(data!==' '){
        $(".scBuiltDisc").each(function(){
          $(this).remove();

        });
        $(".scBuiltPrice").each(function(){
          $(this).remove();

        });
        let info = data.split(" ");
        //console.log('info');
        if(info[0]==='percentage'){
          let discValue = orderPrice * (parseInt(info[1])/100);
          discountedPrice = orderPrice - discValue;
          order.order_price = discountedPrice;
          $('#table-order-info').append("<tr class='scBuiltDisc'><td colspan='2'>Discount ("+$('#discount_code').val()+")</td><td> -$"+discValue.toFixed(2)+"</td></tr>");
          $('#table-order-info').append("<tr class='scBuiltPrice'><td colspan='2'>Total Price</td><td> $"+discountedPrice.toFixed(2)+"</td></tr>");


        }
        else if(info[0]==='flat'){
          let discValue = parseInt(info[1]);
          discountedPrice = orderPrice - discValue;
          $('#table-order-info').append("<tr class='scBuiltDisc'><td colspan='2'>Discount ("+$('#discount_code').val()+")</td><td> -$"+discValue.toFixed(2)+"</td></tr>");
          $('#table-order-info').append("<tr class='scBuiltPrice'><td colspan='2'>Total Price</td><td> $"+discountedPrice.toFixed(2)+"</td></tr>");
          order.order_price = discountedPrice;
        }
      }
      else{
        $('#discount_error').show();
        //discountedPrice = -1.00;
      }


    }
  })
  }
  else{
    $('#discount_error').show();
    //discountedPrice = -1.00;

  }
})
$('#express-order-2').click(function(e){
  //console.log('click');
  calculatePrice();

});


$('#express-order-1').click(function(e){
  //console.log('click');
  calculatePrice();
});



$('#offline-mode-1').click(function(e){
  //console.log('click');
  calculatePrice();
});


$('#rank-1').on('change', function(e){
  rankImageCheckOne();
  verifyOrder();
  calculatePrice();
});
$('#division-1').on('change', function(e){
  calculatePrice();
  verifyOrder();
});
$('#division-10').on('change', function(e){
  calculatePrice();
  verifyOrder();
});
$('#division-11').on('change', function(e){
  calculatePrice();
  verifyOrder();
});
$('#division-2').on('change', function(e){
  calculatePrice();
  verifyOrder();
})

$('#rank-10').on('change', function(e){
  rankImageCheckDuoDivOne();
  calculatePrice();
  verifyOrder();

});

$('#rank-11').on('change', function(e){
  rankImageCheckDuoDivTwo();
  calculatePrice();
  verifyOrder();

});

$('#rank-2').on('change', function(e){
  rankImageCheckTwo();
  calculatePrice();
  verifyOrder();
});

$('#rank-3').on('change', function(e){
  rankImageCheckThree();
  calculatePrice();

});
$('#division-3').on('change', function(e){
  calculatePrice();

})
$('#division-4').on('change', function(e){
  calculatePrice();

})
$('#rank-4').on('change', function(e){
  rankImageCheckFour();
  calculatePrice();

});

$('#rank-5').on('change', function(e){
  rankImageCheckFive();
  calculatePrice();

});

$('#rank-6').on('change', function(e){
  rankImageCheckSix();
  calculatePrice();

});

$('#startinglp_1').on('change', function(e){
    calculatePrice();
});

$('#startinglp_10').on('change', function(e){
    calculatePrice();
});


$('#lpg_1').on('change', function(e){
    calculatePrice();
});

$('#lpg_10').on('change', function(e){
    calculatePrice();
});

$("input[name='solo-duo']").on('change', function(e){
  resetVisibility();
  $("#wizard").steps("next", {});
});

$("input[name='solo-type']").on('change', function(e){
  visibilityCheck();
  $("#wizard").steps("next", {});
});

$("input[name='duo-type']").on('change', function(e){
  visibilityCheck();
  $("#wizard").steps("next", {});
});



$('#net-selector').on('change', function(e){
  $('#net-number-solo').text($('#net-selector').val());
  calculatePrice();

});

$('#net-selector-duo').on('change', function(e){
  $('#net-number-duo').text($('#net-selector-duo').val());
  calculatePrice();

});

$('#placement-selector-solo').on('change', function(e){
  $('#placement-number-solo').text($('#placement-selector-solo').val());
  calculatePrice();

});

$('#placement-selector-duo').on('change', function(e){
  $('#placement-number-duo').text($('#placement-selector-duo').val());
  calculatePrice();

});

$(function(){
  $('#net-number-solo').text($('#net-selector').val());

});

$('#username').on('change', function(e) {
    username = e.target.value;
    orderFormObj.username = e.target.value;
    orderFormObj.type = 'solo';
});
$('#regionSel').on('change', function(e){
  orderFormObj.region = $('#regionSel').val();
  //console.log(e.target.value);
});
$('#password').on('change', function(e) {
    password = e.target.value;
    orderFormObj.password = e.target.value;
});
$('#emailAddress').on('change', function(e) {
    email = e.target.value;
    orderFormObj.email = e.target.value;
    orderFormObj.region = $('#regionSel').val();

});
$('#emailAddress2').on('change', function(e) {
    email = e.target.value;
    orderFormObj.email = e.target.value;
    orderFormObj.region = $('#regionSel2').val();


});
$('#discord').on('change', function(e) {
    discord = e.target.value;
    orderFormObj.discord = e.target.value;
});
$('#discord2').on('change', function(e) {
    discord = e.target.value;
    orderFormObj.discord = e.target.value;
    orderFormObj.region = $('#regionSel2').val();

});
$('#summonerName').on('change', function(e) {
    summonerName = e.target.value;
    orderFormObj.summoner_name = e.target.value;
});
$('#summonerName2').on('change', function(e) {
    summonerName = e.target.value;
    orderFormObj.summoner_name = e.target.value;
    orderFormObj.type = 'duo';
    orderFormObj.region = $('#regionSel2').val();

});
$('#orderMessage').on('change', function(e) {
    message = e.target.value;
    orderFormObj.message = e.target.value;
});
$('#orderMessage2').on('change', function(e) {
    message = e.target.value;
    orderFormObj.message = e.target.value;
    orderFormObj.region = $('#regionSel2').val();


});

$(".registerFormClientID").val(makeClientID());
//Functions Below
function makeClientID(){
  let tempId = Date.now();
  $('#id').val(tempId);
  return tempId;
}
function setupOrdersArr(){

  let tempArr = [order];
  let result = JSON.stringify(tempArr)
  $('#ongoing_orders_arr').val(result);

}

async function checkAccount(){
  let query = {emailAddress: email};
  console.log(query.emailAddress);
  $.ajax({
    type:"GET",
    url:"https://app.bmsboosting.com/api/accounts",
    data: query,
    dataType: "json",
    success: function success(data){
      if(data){
        console.log('Account Exists');
        accountExists = true;
        resultt = true;
        $('.userFormClientID').val(data);
        $('.registerFormClientID').val(data);
        order.client_id = data;
        clientIDReturn.push(data);
        console.log(data);

      }
      else{
        accountExists = false;

        resultt=false;
      }

    }
  }).then(()=>{
    console.log(clientIDReturn);
    return clientIDReturn;
  })
  
}
async function checkAccountEnd(paymentIntentId){
  let query = {emailAddress: email};
  console.log(query.emailAddress);
  $.ajax({
    type:"GET",
    url:"https://app.bmsboosting.com/api/accounts",
    data: query,
    dataType: "json",
    success: function success(data){
      if(data){
        console.log('Account Exists');
        accountExists = true;
        resultt = true;
        $('.userFormClientID').val(data);
        $('.registerFormClientID').val(data);
        order.client_id = data;
        clientIDReturn.push(data);
        console.log(data);

      }
      else{
        accountExists = false;

        resultt=false;
      }

    }
  }).then(()=>{
    console.log(clientIDReturn);

    if(order.client_id==''){
      console.log('order.client_id is empty');
      let clientID = makeClientID();
      order.client_id = clientID;
    }
    setupOrdersArr();
    return fetch('https://app.bmsboosting.com/api/capture-stripe-transaction', {
          method: 'post',
          headers: {
            'content-type': 'application/json'
          },
          body: JSON.stringify({
            orderID: paymentIntentId,          //this may be diff, check stripe v
            id_invoice: orderIdUnique,
            orderType: orderPPString,
            orderOne:orderSoloDuoString,
            orderTwo:orderTypeString,
            orderThree:orderInfoString,
            clienter_id: [order.client_id],
            price: orderPrice.toFixed(2),
            client_email: email,
            message: JSON.stringify(orderFormObj),
            accountExists: accountExists,
            orderObj: JSON.stringify(order),

          })
        }).then(function(res) {
          //console.log(data);
          //console.log(res);
        }).then(function(details) {
          if(!accountExists){
            modalActivity();
          }else{
            window.location.replace('https://app.bmsboosting.com/login');
          }

        })
      

  })
  
}

function modalActivity(){
  $('#orderUserRegisterModal').modal({
    backdrop: 'static',
    keyboard: false,
  }, 'show');
  if(orderSoloDuoString === 'Solo'){
    $("#email").val($('#emailAddress').val());
  }else{
    $("#email").val($('#emailAddress2').val());
  }
}
function setOptions(){
  if($("input[name='solo-type']:checked").val()==='Solo Division'){

  }
}
function verifyOrder(){
  if(validOrder){
    $('.actions').show();
  }
  else{
    $('.actions').hide();

  }
}
function orderExtrasVisibility(){
  if($("input[name='solo-duo']:checked").val()==='Solo'){
    $('#solo-options').show();
    $('#duo-options').hide();

  }
  else{
    $('#solo-options').hide();
    $('#duo-options').show();

  }
}
function resetVisibility(){
  $("input:radio[name='solo-type']").each(function(i){
    this.checked = false;
  })
  $("input:radio[name='duo-type']").each(function(i){
    this.checked = false;
  })
  $('#division-duo').hide();
  $('#division-solo').hide();
  $('#netwin-solo').hide();
  $('#netwin-duo').hide();
  $('#placement-solo').hide();
  $('#placement-duo').hide();
}
function visibilityCheck(){
  if($("input[name='solo-type']:checked").val()==='Solo Division'){
    $('#division-duo').hide();
    $('#division-solo').show();
    $('#netwin-solo').hide();
    $('#netwin-duo').hide();
    $('#placement-solo').hide();
    $('#placement-duo').hide();


  }else if($("input[name='duo-type']:checked").val()==='Duo Division'){
    $('#division-solo').hide();
    $('#division-duo').show();
    $('#netwin-solo').hide();
    $('#netwin-duo').hide();
    $('#placement-solo').hide();
    $('#placement-duo').hide();


  }
  else if($("input[name='solo-type']:checked").val()==='Solo Net Wins'){
    $('#division-solo').hide();
    $('#division-duo').hide();
    $('#netwin-solo').show();
    $('#netwin-duo').hide();
    $('#placement-solo').hide();
    $('#placement-duo').hide();

  }
  else if($("input[name='duo-type']:checked").val()==='Duo Net Wins'){
    $('#division-solo').hide();
    $('#division-duo').hide();
    $('#netwin-solo').hide();
    $('#netwin-duo').show();
    $('#placement-solo').hide();
    $('#placement-duo').hide();

  }
  else if($("input[name='solo-type']:checked").val()==='Solo Placement'){
    $('#division-solo').hide();
    $('#division-duo').hide();
    $('#netwin-solo').hide();
    $('#netwin-duo').hide();
    $('#placement-solo').show();
    $('#placement-duo').hide();
  }
  else if($("input[name='duo-type']:checked").val()==='Duo Placement'){
    $('#division-solo').hide();
    $('#division-duo').hide();
    $('#netwin-solo').hide();
    $('#netwin-duo').hide();
    $('#placement-solo').hide();
    $('#placement-duo').show();
    //console.log('duo place');
  }
}
function makeNewInvoiceID(){
  orderIdUnique = Date.now();
  order.order_id = orderIdUnique;
}
$('.endFormValidator').click(function(){
  validateEndForm();
});
function validateEndForm(){
  var x = document.forms["endForm"];
  var endEmail = x['email'].value;

  var endP1 = x['password'].value;
  var endP2 = x['password_confirmation'].value;
  //console.log(x);
  //console.log(endP1);
  //console.log(endEmail);
  if(endP1.length < 8){
    $('.endPassError1').show()
  }else{
    $('.endPassError1').hide()
  }
  if(endP1!=endP2){
    $('.endPassError2').show()
  }else{
    $('.endPassError2').hide()
  }
  if(!validateEmail(endEmail)){
      $('.endEmailError').show();
  }else{
      $('.endEmailError').hide();
  }
  if($('.endPassError1').is(':hidden') && $('.endPassError2').is(':hidden') && $('.endEmailError').is(':hidden')){
    $('.endFormSubmittor').trigger('click');
  }
}
function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function calculatePrice(){

  let query = {order_type:'', divisions:[], placement_rank:'', netwin_rank:'', quantity:''};
  if($("#division-solo").is(':visible') || $('#solo-division').is(':checked')){
    query.order_type = 'solodiv';
    let startingDiv = $('#rank-1').val() + $('#division-1').val();
    if($('#rank-1').val()==='M' || $('#rank-1').val()==='GM' || $('#rank-1').val()==='C'){
      startingDiv = $('#rank-1').val();
    }
    let endingDiv = $('#rank-2').val() + $('#division-2').val();
    if($('#rank-2').val()==='M' || $('#rank-2').val()==='GM' || $('#rank-2').val()==='C'){
      endingDiv = $('#rank-2').val();
    }
    let startingIndex = ranks.indexOf(startingDiv);
    let endingIndex = ranks.indexOf(endingDiv);
    let divList = [];


    if(startingIndex >= endingIndex){
      //RAISE ERROR
      validOrder=false;
      $('#temp-order-price').text("Invalid Order");

    }
    else{
      validOrder=true;
      for(let i=startingIndex; i<ranks.length; i++){

        divList.push(ranks[i]);
        if(i===endingIndex){
          break;
        }
      }
      for(let i=0; i<divList.length; i++){
        query.divisions.push(divList[i] + " to " + divList[i+1]);
        if(i===endingIndex-1){
          break;
        }
      }
      $.ajax({
        type:"GET",
        url:"https://app.bmsboosting.com/api/prices",
        data: query,
        dataType: "json",
        success: function success(data){
          //console.log(data);
          orderPrice = data;
          order.order_price = data;

          if($('#startinglp_1').val()==='21'){
            let newQuery = {order_type:'', divisions:[], placement_rank:'', netwin_rank:'', quantity:''};
            newQuery.order_type = query.order_type;
            let newDivs = [query.divisions[0]];
            newQuery.divisions = newDivs;

            $.ajax({
              type:"GET",
              url:"https://app.bmsboosting.com/api/prices",
              data: newQuery,
              dataType: "json",
              success: function success(data){
                //console.log(data);

                orderPrice = orderPrice - data + (data*0.88);

                if($('#lpg_1').val()==='19'){
                  //pass
                }else if($('#lpg_1').val()==='16'){
                  orderPrice += orderPrice*0.1;
                  //console.log(orderPrice);

                }else if($('#lpg_1').val()==='15'){
                  orderPrice = orderPrice + orderPrice*0.25;

                }
                let extrasPrice=0;
                if($('#express-order-1').is(':checked')){
                  extrasPrice += orderPrice*0.25;
                }
                if($('#offline-mode-1').is(':checked')){
                  extrasPrice += orderPrice*0.1;

                }
                //console.log(extrasPrice);
                orderPrice += extrasPrice;
                order.order_price = orderPrice;

               orderPrice = Math.round(orderPrice * 100)/100;

                $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

              }
            })
          }else if($('#startinglp_1').val()==='41'){
            let newQuery = {order_type:'', divisions:[], placement_rank:'', netwin_rank:'', quantity:''};
            newQuery.order_type = query.order_type;
            let newDivs = [query.divisions[0]];
            newQuery.divisions = newDivs;

            $.ajax({
              type:"GET",
              url:"https://app.bmsboosting.com/api/prices",
              data: newQuery,
              dataType: "json",
              success: function success(data){
                //console.log(data);

                orderPrice = orderPrice - data + (data*0.79);
                if($('#lpg_1').val()==='19'){
                  //pass
                }else if($('#lpg_1').val()==='16'){
                  orderPrice = orderPrice + orderPrice*0.1;
                }else if($('#lpg_1').val()==='15'){
                  orderPrice = orderPrice + orderPrice*0.25;

                }
                let extrasPrice=0;
                if($('#express-order-1').is(':checked')){
                  extrasPrice += orderPrice*0.25;
                }
                if($('#offline-mode-1').is(':checked')){
                  extrasPrice += orderPrice*0.1;

                }
                orderPrice += extrasPrice;
                order.order_price = orderPrice;


               orderPrice = Math.round(orderPrice * 100)/100;
                $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

              }
            })
          }else if($('#startinglp_1').val()==='61'){
            let newQuery = {order_type:'', divisions:[], placement_rank:'', netwin_rank:'', quantity:''};
            newQuery.order_type = query.order_type;
            let newDivs = [query.divisions[0]];
            newQuery.divisions = newDivs;

            $.ajax({
              type:"GET",
              url:"https://app.bmsboosting.com/api/prices",
              data: newQuery,
              dataType: "json",
              success: function success(data){
                //console.log(data);

                orderPrice = orderPrice - data + (data*0.7);
                if($('#lpg_1').val()==='19'){
                  //pass
                }else if($('#lpg_1').val()==='16'){
                  orderPrice = orderPrice + orderPrice*0.1;
                }else if($('#lpg_1').val()==='15'){
                  orderPrice = orderPrice + orderPrice*0.25;

                }
                let extrasPrice=0;
                if($('#express-order-1').is(':checked')){
                  extrasPrice += orderPrice*0.25;
                }
                if($('#offline-mode-1').is(':checked')){
                  extrasPrice += orderPrice*0.1;

                }
                orderPrice += extrasPrice;
                order.order_price = orderPrice;


               orderPrice = Math.round(orderPrice * 100)/100;
                $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

              }
            })
          }else if($('#startinglp_1').val()==='81'){
            let newQuery = {order_type:'', divisions:[], placement_rank:'', netwin_rank:'', quantity:''};
            newQuery.order_type = query.order_type;
            let newDivs = [query.divisions[0]];
            newQuery.divisions = newDivs;

            $.ajax({
              type:"GET",
              url:"https://app.bmsboosting.com/api/prices",
              data: newQuery,
              dataType: "json",
              success: function success(data){
                //console.log(data);

                orderPrice = orderPrice - data + (data*0.6);
                if($('#lpg_1').val()==='19'){
                  //pass
                }else if($('#lpg_1').val()==='16'){
                  orderPrice = orderPrice + orderPrice*0.1;
                }else if($('#lpg_1').val()==='15'){
                  orderPrice = orderPrice + orderPrice*0.25;

                }
                let extrasPrice=0;
                if($('#express-order-1').is(':checked')){
                  extrasPrice += orderPrice*0.25;
                }
                if($('#offline-mode-1').is(':checked')){
                  extrasPrice += orderPrice*0.1;

                }
                orderPrice += extrasPrice;
                order.order_price = orderPrice;

               orderPrice = Math.round(orderPrice * 100)/100;

                $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

              }
            })
          }else if($('#startinglp_1').val()==='100'){
            let newQuery = {order_type:'', divisions:[], placement_rank:'', netwin_rank:'', quantity:''};
            newQuery.order_type = query.order_type;
            let newDivs = [query.divisions[0]];
            newQuery.divisions = newDivs;

            $.ajax({
              type:"GET",
              url:"https://app.bmsboosting.com/api/prices",
              data: newQuery,
              dataType: "json",
              success: function success(data){
                //console.log(data);

                orderPrice = orderPrice - data + (data*0.5);
                if($('#lpg_1').val()==='19'){
                  //pass
                }else if($('#lpg_1').val()==='16'){
                  orderPrice = orderPrice + orderPrice*0.1;
                }else if($('#lpg_1').val()==='15'){
                  orderPrice = orderPrice + orderPrice*0.25;


                }
                let extrasPrice=0;
                if($('#express-order-1').is(':checked')){
                  extrasPrice += orderPrice*0.25;
                }
                if($('#offline-mode-1').is(':checked')){
                  extrasPrice += orderPrice*0.1;

                }
                orderPrice += extrasPrice;
                order.order_price = orderPrice;


               orderPrice = Math.round(orderPrice * 100)/100;
                $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

              }
            })
          }else{

            if($('#lpg_1').val()==='19'){
              //pass
            }else if($('#lpg_1').val()==='16'){
              orderPrice += orderPrice*0.1;
              //console.log(orderPrice);

            }else if($('#lpg_1').val()==='15'){
              orderPrice = orderPrice + orderPrice*0.25;

            }
            let extrasPrice=0;
            if($('#express-order-1').is(':checked')){
              //console.log('checked in calc price');
              extrasPrice += orderPrice*0.25;
            }
            if($('#offline-mode-1').is(':checked')){
              extrasPrice += orderPrice*0.1;

            }
            //console.log(extrasPrice);
            orderPrice += extrasPrice;
           orderPrice = Math.round(orderPrice * 100)/100;
            $('#temp-order-price').text("  $"+orderPrice.toFixed(2));
          }
        }
      })
      /*axios.get('https://app.bmsboosting.com/api/prices', JSON.stringify(query)).then((data)=>{
        //console.log(data.data);
      });*/


    }


  }
  else if($("#netwin-solo").is(':visible') || $('#solo-net').is(':checked')){
    query.order_type = 'solonet';
    let netDiv = $('#rank-3').val()+$('#division-3').val();
    if($('#rank-3').val()==='M' || $('#rank-3').val()==='GM' || $('#rank-3').val()==='C'){
      netDiv = $('#rank-3').val();
    }
    let amount = $('#net-selector').val();
    query.netwin_rank = netDiv;
    query.quantity = parseInt(amount, 10);
    //console.log(query.quantity);
    $.ajax({
      type:"GET",
      url:"https://app.bmsboosting.com/api/prices",
      data: query,
      dataType: "json",
      success: function success(data){
        //console.log(data);
        orderPrice = data;
        let extrasPrice=0;
        if($('#express-order-1').is(':checked')){
          extrasPrice += orderPrice*0.25;
        }
        if($('#offline-mode-1').is(':checked')){
          extrasPrice += orderPrice*0.1;

        }
        orderPrice += extrasPrice;
        order.order_price = orderPrice;
       orderPrice = Math.round(orderPrice * 100)/100;
        $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

      }
    });
  }
  else if($("#placement-solo").is(':visible') || $('#solo-placement').is(':checked')){
    query.order_type = "soloplace";
    let netDiv = $('#rank-5').val();
    let amount = $('#placement-selector-solo').val();
    query.placement_rank = netDiv;
    query.quantity = parseInt(amount, 10);
    $.ajax({
      type:"GET",
      url:"https://app.bmsboosting.com/api/prices",
      data: query,
      dataType: "json",
      success: function success(data){
        //console.log(data);
        orderPrice = data;
        let extrasPrice=0;
        if($('#express-order-1').is(':checked')){
          extrasPrice += orderPrice*0.25;
        }
        if($('#offline-mode-1').is(':checked')){
          extrasPrice += orderPrice*0.1;

        }
        orderPrice += extrasPrice;
        order.order_price = orderPrice;
       orderPrice = Math.round(orderPrice * 100)/100;
        $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

      }
    });
  }
  else if($("#division-duo").is(':visible') || $('#duo-division').is(':checked')){
    query.order_type = 'duodiv';
    let startingDiv = $('#rank-10').val() + $('#division-10').val();
    if($('#rank-10').val()==='M' || $('#rank-10').val()==='GM' || $('#rank-10').val()==='C'){
      startingDiv = $('#rank-10').val();
    }
    let endingDiv = $('#rank-11').val() + $('#division-11').val();
    if($('#rank-11').val()==='M' || $('#rank-11').val()==='GM' || $('#rank-11').val()==='C'){
      endingDiv = $('#rank-11').val();
    }
    let startingIndex = ranks.indexOf(startingDiv);
    let endingIndex = ranks.indexOf(endingDiv);
    let divList = [];
    ////console.log(startingIndex + " " + endingIndex);
    if(startingIndex >= endingIndex){
      //RAISE ERROR
      validOrder=false;
      $('#temp-order-price').text("Invalid Order");

    }
    else{
      validOrder=true;
      for(let i=startingIndex; i<ranks.length; i++){

        divList.push(ranks[i]);
        if(i===endingIndex){
          break;
        }
      }
      for(let i=0; i<divList.length; i++){
        query.divisions.push(divList[i] + " to " + divList[i+1]);
        if(i===endingIndex-1){
          break;
        }
      }
      $.ajax({
        type:"GET",
        url:"https://app.bmsboosting.com/api/prices",
        data: query,
        dataType: "json",
        success: function success(data){
          //console.log(data);
          orderPrice = data;
          order.order_price = data;
          if($('#startinglp_10').val()==='21'){
            let newQuery = {order_type:'', divisions:[], placement_rank:'', netwin_rank:'', quantity:''};
            newQuery.order_type = query.order_type;
            let newDivs = [query.divisions[0]];
            newQuery.divisions = newDivs;

            $.ajax({
              type:"GET",
              url:"https://app.bmsboosting.com/api/prices",
              data: newQuery,
              dataType: "json",
              success: function success(data){
                //console.log(data);

                orderPrice = orderPrice - data + (data*0.88);
                if($('#lpg_10').val()==='19'){
                  //pass
                }else if($('#lpg_10').val()==='16'){
                  orderPrice = orderPrice + orderPrice*0.1;
                }else if($('#lpg_10').val()==='15'){
                  orderPrice = orderPrice + orderPrice*0.25;

                }
                let extrasPrice=0;
                if($('#express-order-2').is(':checked')){
                  extrasPrice += orderPrice*0.25;
                }

                orderPrice += extrasPrice;
                order.order_price = orderPrice;

               orderPrice = Math.round(orderPrice * 100)/100;

                $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

              }
            })
          }else if($('#startinglp_10').val()==='41'){
            let newQuery = {order_type:'', divisions:[], placement_rank:'', netwin_rank:'', quantity:''};
            newQuery.order_type = query.order_type;
            let newDivs = [query.divisions[0]];
            newQuery.divisions = newDivs;

            $.ajax({
              type:"GET",
              url:"https://app.bmsboosting.com/api/prices",
              data: newQuery,
              dataType: "json",
              success: function success(data){
                //console.log(data);

                orderPrice = orderPrice - data + (data*0.79);
                if($('#lpg_10').val()==='19'){
                  //pass
                }else if($('#lpg_10').val()==='16'){
                  orderPrice = orderPrice + orderPrice*0.1;
                }else if($('#lpg_10').val()==='15'){
                  orderPrice = orderPrice + orderPrice*0.25;

                }
                let extrasPrice=0;
                if($('#express-order-2').is(':checked')){
                  extrasPrice += orderPrice*0.25;
                }

                orderPrice += extrasPrice;
                order.order_price = orderPrice;

               orderPrice = Math.round(orderPrice * 100)/100;

                $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

              }
            })
          }else if($('#startinglp_10').val()==='61'){
            let newQuery = {order_type:'', divisions:[], placement_rank:'', netwin_rank:'', quantity:''};
            newQuery.order_type = query.order_type;
            let newDivs = [query.divisions[0]];
            newQuery.divisions = newDivs;

            $.ajax({
              type:"GET",
              url:"https://app.bmsboosting.com/api/prices",
              data: newQuery,
              dataType: "json",
              success: function success(data){
                //console.log(data);

                orderPrice = orderPrice - data + (data*0.7);
                if($('#lpg_10').val()==='19'){
                  //pass
                }else if($('#lpg_10').val()==='16'){
                  orderPrice = orderPrice + orderPrice*0.1;
                }else if($('#lpg_10').val()==='15'){
                  orderPrice = orderPrice + orderPrice*0.25;

                }
                let extrasPrice=0;
                if($('#express-order-2').is(':checked')){
                  extrasPrice += orderPrice*0.25;
                }

                orderPrice += extrasPrice;
                order.order_price = orderPrice;


               orderPrice = Math.round(orderPrice * 100)/100;
                $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

              }
            })
          }else if($('#startinglp_10').val()==='81'){
            let newQuery = {order_type:'', divisions:[], placement_rank:'', netwin_rank:'', quantity:''};
            newQuery.order_type = query.order_type;
            let newDivs = [query.divisions[0]];
            newQuery.divisions = newDivs;

            $.ajax({
              type:"GET",
              url:"https://app.bmsboosting.com/api/prices",
              data: newQuery,
              dataType: "json",
              success: function success(data){
                //console.log(data);

                orderPrice = orderPrice - data + (data*0.6);
                if($('#lpg_10').val()==='19'){
                  //pass
                }else if($('#lpg_10').val()==='16'){
                  orderPrice = orderPrice + orderPrice*0.1;
                }else if($('#lpg_10').val()==='15'){
                  orderPrice = orderPrice + orderPrice*0.25;

                }
                let extrasPrice=0;
                if($('#express-order-2').is(':checked')){
                  extrasPrice += orderPrice*0.25;
                }

                orderPrice += extrasPrice;
                order.order_price = orderPrice;


               orderPrice = Math.round(orderPrice * 100)/100;
                $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

              }
            })
          }else if($('#startinglp_10').val()==='100'){
            let newQuery = {order_type:'', divisions:[], placement_rank:'', netwin_rank:'', quantity:''};
            newQuery.order_type = query.order_type;
            let newDivs = [query.divisions[0]];
            newQuery.divisions = newDivs;

            $.ajax({
              type:"GET",
              url:"https://app.bmsboosting.com/api/prices",
              data: newQuery,
              dataType: "json",
              success: function success(data){
                //console.log(data);

                orderPrice = orderPrice - data + (data*0.5);
                if($('#lpg_10').val()==='19'){
                  //pass
                }else if($('#lpg_10').val()==='16'){
                  orderPrice = orderPrice + orderPrice*0.1;
                }else if($('#lpg_10').val()==='15'){
                  orderPrice = orderPrice + orderPrice*0.25;

                }
                let extrasPrice=0;
                if($('#express-order-2').is(':checked')){
                  extrasPrice += orderPrice*0.25;
                }

                orderPrice += extrasPrice;
                order.order_price = orderPrice;

               orderPrice = Math.round(orderPrice * 100)/100;

                $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

              }
            })
          }
          else{
            if($('#lpg_10').val()==='19'){
              //pass
            }else if($('#lpg_10').val()==='16'){
              orderPrice += orderPrice*0.1;
              //console.log(orderPrice);

            }else if($('#lpg_10').val()==='15'){
              orderPrice = orderPrice + orderPrice*0.25;

            }
            let extrasPrice=0;
            if($('#express-order-2').is(':checked')){
              extrasPrice += orderPrice*0.25;
            }

            orderPrice += extrasPrice;
           orderPrice = Math.round(orderPrice * 100)/100;
            $('#temp-order-price').text("  $"+orderPrice.toFixed(2));
          }
        }
      })
      /*axios.get('https://app.bmsboosting.com/api/prices', JSON.stringify(query)).then((data)=>{
        //console.log(data.data);
      });*/

    }
  }
  else if($("#netwin-duo").is(':visible') || $('#duo-net').is(':checked')){
    query.order_type = 'duonet';
    let netDiv = $('#rank-4').val()+$('#division-4').val();
    if($('#rank-4').val()==='M' || $('#rank-4').val()==='GM' || $('#rank-4').val()==='C'){
      netDiv = $('#rank-4').val();
    }
    let amount = $('#net-selector-duo').val();
    query.netwin_rank = netDiv;
    query.quantity = parseInt(amount, 10);
    $.ajax({
      type:"GET",
      url:"https://app.bmsboosting.com/api/prices",
      data: query,
      dataType: "json",
      success: function success(data){
        //console.log(data);
        orderPrice = data;
        let extrasPrice=0;
        if($('#express-order-2').is(':checked')){
          extrasPrice += orderPrice*0.25;
        }

        orderPrice += extrasPrice;
       orderPrice = Math.round(orderPrice * 100)/100;
        $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

      }
    });
  }
  else if($("#placement-duo").is(':visible') || $('#duo-placement').is(':checked')){
    query.order_type = 'duoplace';
    let netDiv = $('#rank-6').val();
    let amount = $('#placement-selector-duo').val();
    query.placement_rank = netDiv;
    query.quantity = parseInt(amount, 10);
    $.ajax({
      type:"GET",
      url:"https://app.bmsboosting.com/api/prices",
      data: query,
      dataType: "json",
      success: function success(data){
        //console.log(data);
        orderPrice = data;
        let extrasPrice=0;
        if($('#express-order-2').is(':checked')){
          extrasPrice += orderPrice*0.25;
        }

        orderPrice += extrasPrice;
        order.order_price = orderPrice;
       orderPrice = Math.round(orderPrice * 100)/100;
        $('#temp-order-price').text("  $"+orderPrice.toFixed(2));

      }
    });
  }
  //Math.round(orderPrice * 100)/100;
}

function buildOrderInfo(){
  orderInfoString = "";
  orderSoloDuoString = "";
  orderTypeString = "";
  orderExtrasString="";
  orderMessage="";
  orderExtras = [];
  orderSoloDuoString = $("input[name='solo-duo']:checked").val();
  $(".scBuilt").each(function(){
    $(this).remove();

  })
  $(".scBuiltPrice").each(function(){
    $(this).remove();

  })

  if(orderSoloDuoString === 'Solo'){
    orderTypeString = $("input[name='solo-type']:checked").val();
    $('#primaryRoleText').text('Primary Role: '+$('#primary_role').val());

    orderExtras.push("Secondary Role: "+$('#secondary_role').val());
    orderExtras.push($('#keyset').val());
    if($('#offline-mode-1').is(':checked')){
      orderExtras.push("Offline Mode")
    }
    if($('#express-order-1').is(':checked')){
      orderExtras.push("Express Order")
    }

  }
  else{
    orderTypeString = $("input[name='duo-type']:checked").val();
    $('#primaryRoleText').text('Primary Role: '+$('#primary_role-2').val());

    orderExtras.push("Secondary Role: "+$('#secondary_role-2').val());

    if($('#express-order-2').is(':checked')){
      orderExtras.push("Express Order")
    }

  }

  for(let i=0; i<orderExtras.length; i++){
      $('#table-order-info').append("<tr class='scBuilt'><td></td><td>"+orderExtras[i]+"</td></tr>");
  }



  ranks[ranks2.indexOf($('#rank-1').val())]
  if($("input[name='solo-type']:checked").val()==='Solo Division'){
    if($('#rank-1').val()==='M' || $('#rank-1').val()==='GM' || $('#rank-1').val()==='C'){
      if($('#rank-2').val()==='M' || $('#rank-2').val()==='GM' || $('#rank-2').val()==='C'){
        orderInfoString = orderInfoString.concat(ranks4[ranks3.indexOf($('#rank-1').val())] + " to " + ranks4[ranks3.indexOf($('#rank-2').val())]);
      }
      else{
        orderInfoString = orderInfoString.concat(ranks4[ranks3.indexOf($('#rank-1').val())] + " to " + ranks4[ranks3.indexOf($('#rank-2').val())] + " " + $('#division-2'));
      }
    }
    else{
      let lpString = " " + $('#startinglp_1').val() + " LP to ";
      if($('#startinglp_1').val()==='0'){
        lpString = " (" + $('#startinglp_1').val() + "-20)" + " LP to ";
        orderFormObj.starting_lp = "(" + $('#startinglp_1').val() + "-20)";

      }else if($('#startinglp_1').val()==='21'){
        lpString = " (" + $('#startinglp_1').val() + "-40)" + " LP to ";
        orderFormObj.starting_lp = "(" + $('#startinglp_1').val() + "-40)";

      }
    else if($('#startinglp_1').val()==='41'){
      lpString = " (" + $('#startinglp_1').val() + "-60)" + " LP to ";
      orderFormObj.starting_lp = "(" + $('#startinglp_1').val() + "-60)";


    }
    else if($('#startinglp_1').val()==='61'){
      lpString = " (" + $('#startinglp_1').val() + "-80)" + " LP to ";
      orderFormObj.starting_lp = "(" + $('#startinglp_1').val() + "-80)";

    }
    else if($('#startinglp_1').val()==='81'){
      lpString = " (" + $('#startinglp_1').val() + "-99)" + " LP to ";
      orderFormObj.starting_lp = "(" + $('#startinglp_1').val() + "-99)";

    }else if($('#startinglp_1').val()==='100'){
      lpString = " " + $('#startinglp_1').val() + " LP to ";
      orderFormObj.starting_lp = "100";

    }

      if($('#rank-2').val()==='M' || $('#rank-2').val()==='GM' || $('#rank-2').val()==='C'){
        orderInfoString = orderInfoString.concat(ranks4[ranks3.indexOf($('#rank-1').val())] + " " + $('#division-1').val() + lpString + ranks4[ranks3.indexOf($('#rank-2').val())]);
      }
      else{
        orderInfoString = orderInfoString.concat(ranks4[ranks3.indexOf($('#rank-1').val())] + " " + $('#division-1').val() + lpString + ranks4[ranks3.indexOf($('#rank-2').val())] + " " + $('#division-2').val());
      }
    }
    //orderInfoString = orderInfoString.concat($('#rank-1').val() + " " + $('#division-1').val() + " to " + $('#rank-2').val() + " " + $('#division-2').val());

    orderFormObj.lpg = $('#lpg_1').val();
  }
  else if($("input[name='duo-type']:checked").val()==='Duo Division'){
    if($('#rank-10').val()==='M' || $('#rank-10').val()==='GM' || $('#rank-10').val()==='C'){
      if($('#rank-11').val()==='M' || $('#rank-11').val()==='GM' || $('#rank-11').val()==='C'){
        orderInfoString = orderInfoString.concat(ranks4[ranks3.indexOf($('#rank-10').val())] + " to " + ranks4[ranks3.indexOf($('#rank-11').val())]);
      }
      else{
        orderInfoString = orderInfoString.concat(ranks4[ranks3.indexOf($('#rank-10').val())] + " to " + ranks4[ranks3.indexOf($('#rank-11').val())] + " " + $('#division-11'));
      }
    }
    else{
      let lpString = " " + $('#startinglp_10').val() + " LP to ";
      if($('#startinglp_10').val()==='0'){
        lpString = " (" + $('#startinglp_10').val() + "-20)" + " LP to ";
        orderFormObj.starting_lp = "(" + $('#startinglp_10').val() + "-20)";

      }else if($('#startinglp_10').val()==='21'){
        lpString = " (" + $('#startinglp_10').val() + "-40)" + " LP to ";
        orderFormObj.starting_lp = "(" + $('#startinglp_10').val() + "-40)";

      }
    else if($('#startinglp_10').val()==='41'){
      lpString = " (" + $('#startinglp_10').val() + "-60)" + " LP to ";
      orderFormObj.starting_lp = "(" + $('#startinglp_10').val() + "-60)";

    }
    else if($('#startinglp_10').val()==='61'){
      lpString = " (" + $('#startinglp_10').val() + "-80)" + " LP to ";
      orderFormObj.starting_lp = "(" + $('#startinglp_10').val() + "-80)";

    }
    else if($('#startinglp_10').val()==='81'){
      lpString = " (" + $('#startinglp_10').val() + "-99)" + " LP to ";
      orderFormObj.starting_lp = "(" + $('#startinglp_10').val() + "-99)";

    }else if($('#startinglp_10').val()==='100'){
      lpString = " " + $('#startinglp_10').val() + " LP to ";
      orderFormObj.starting_lp = "100";

    }
      if($('#rank-11').val()==='M' || $('#rank-11').val()==='GM' || $('#rank-11').val()==='C'){

        orderInfoString = orderInfoString.concat(ranks4[ranks3.indexOf($('#rank-10').val())] + " " + $('#division-10').val() + lpString + ranks4[ranks3.indexOf($('#rank-11').val())]);
      }
      else{
        orderInfoString = orderInfoString.concat(ranks4[ranks3.indexOf($('#rank-10').val())] + " " + $('#division-10').val() + lpString + ranks4[ranks3.indexOf($('#rank-11').val())] + " " + $('#division-11').val());
      }
    }
    orderFormObj.lpg = $('#lpg_10').val();

  }
  else if($("input[name='solo-type']:checked").val()==='Solo Net Wins'){
    if($('#rank-3').val()==='M' || $('#rank-3').val()==='GM' || $('#rank-3').val()==='C'){
      orderInfoString = orderInfoString.concat($('#net-selector').val() + " - " + ranks4[ranks3.indexOf($('#rank-3').val())] + " Net Wins");
    }else{
      orderInfoString = orderInfoString.concat($('#net-selector').val() + " - " + ranks4[ranks3.indexOf($('#rank-3').val())] + " " + $('#division-3').val() + " Net Wins");
    }
    orderFormObj.lpg = '';

  }
  else if($("input[name='duo-type']:checked").val()==='Duo Net Wins'){
    if($('#rank-4').val()==='M' || $('#rank-4').val()==='GM' || $('#rank-4').val()==='C'){
      orderInfoString = orderInfoString.concat($('#net-selector-duo').val() + " - " + ranks4[ranks3.indexOf($('#rank-4').val())] + " Net Wins");

    }
    else{
      orderInfoString = orderInfoString.concat($('#net-selector-duo').val() + " - " + ranks4[ranks3.indexOf($('#rank-4').val())] + " " + $('#division-4').val() + " Net Wins");
    }
    orderFormObj.lpg = '';

  }
  else if($("input[name='solo-type']:checked").val()==='Solo Placement'){
    orderInfoString = orderInfoString.concat($('#placement-selector-solo').val() + " - " + ranks4[ranks3.indexOf($('#rank-5').val())] + " Placement Games");
    orderFormObj.lpg = '';

  }
  else if($("input[name='duo-type']:checked").val()==='Duo Placement'){
      orderInfoString = orderInfoString.concat($('#placement-selector-duo').val() + " - " + ranks4[ranks3.indexOf($('#rank-6').val())] + " Placement Games");
      orderFormObj.lpg = '';

  }
  $('#finalSoloDuo').text(orderSoloDuoString);
  $('#finalOrderType').text(orderTypeString);
  $('#finalOrderInfo').text(orderInfoString);
  $('#table-order-info').append("<tr class='scBuiltPrice'><td colspan='2'>Total Price</td><td id='finalOrderPrice'>$43.00</td></tr>");

  $('#finalOrderPrice').text("$"+orderPrice.toFixed(2));

  orderPPString = orderSoloDuoString + " - " + orderTypeString + " - " + orderInfoString;
  order.order_type = orderPPString;
  orderFormObj.extras = [];
  if($('#solo-info').is(':visible')){
    order.order_message = $('#orderMessage').val();
    orderMessage = $('#orderMessage').val()


    orderFormObj.extras.push("Primary Role: " + $('#primary_role').val());
    orderFormObj.extras.push("Secondary Role: " + $('#secondary_role').val());
    orderFormObj.extras.push($('#keyset').val());
    if($('#express-order-1').is(':checked')){
      orderFormObj.extras.push("Express Order");
    }
    if($('#offline-mode-1').is(':checked')){
      orderFormObj.extras.push("Offline Mode");
    }
  }
  else{
    order.order_message = $('#orderMessage2').val();
    orderMessage = $('#orderMessage2').val()

    orderFormObj.extras.push("Client Primary Role: " + $('#primary_role-2').val());
    orderFormObj.extras.push("Client Secondary Role: " + $('#secondary_role-2').val());
    if($('#express-order-2').is(':checked')){
      orderFormObj.extras.push("Express Order");
    }
  }


}
function rankImageCheckSix(){
    if($('#rank-6').val()==='I'){
      $('#iron-icon-6').show();
      $('#bronze-icon-6').hide();
      $('#silver-icon-6').hide();
      $('#gold-icon-6').hide();
      $('#platinum-icon-6').hide();
      $('#diamond-icon-6').hide();
      $('#master-icon-6').hide();
      $('#grandmaster-icon-6').hide();
      $('#challenger-icon-6').hide();

    }
    else if($('#rank-6').val()==='B'){
      $('#iron-icon-6').hide();
      $('#bronze-icon-6').show();
      $('#silver-icon-6').hide();
      $('#gold-icon-6').hide();
      $('#platinum-icon-6').hide();
      $('#diamond-icon-6').hide();
      $('#master-icon-6').hide();
      $('#grandmaster-icon-6').hide();
      $('#challenger-icon-6').hide();

    }
    else if($('#rank-6').val()==='S'){
      $('#iron-icon-6').hide();
      $('#bronze-icon-6').hide();
      $('#silver-icon-6').show();
      $('#gold-icon-6').hide();
      $('#platinum-icon-6').hide();
      $('#diamond-icon-6').hide();
      $('#master-icon-6').hide();
      $('#grandmaster-icon-6').hide();
      $('#challenger-icon-6').hide();

    }
    else if($('#rank-6').val()==='G'){
      $('#iron-icon-6').hide();
      $('#bronze-icon-6').hide();
      $('#silver-icon-6').hide();
      $('#gold-icon-6').show();
      $('#platinum-icon-6').hide();
      $('#diamond-icon-6').hide();
      $('#master-icon-6').hide();
      $('#grandmaster-icon-6').hide();
      $('#challenger-icon-6').hide();

    }
    else if($('#rank-6').val()==='P'){
      $('#iron-icon-6').hide();
      $('#bronze-icon-6').hide();
      $('#silver-icon-6').hide();
      $('#gold-icon-6').hide();
      $('#platinum-icon-6').show();
      $('#diamond-icon-6').hide();
      $('#master-icon-6').hide();
      $('#grandmaster-icon-6').hide();
      $('#challenger-icon-6').hide();

    }
    else if($('#rank-6').val()==='D'){
      $('#iron-icon-6').hide();
      $('#bronze-icon-6').hide();
      $('#silver-icon-6').hide();
      $('#gold-icon-6').hide();
      $('#platinum-icon-6').hide();
      $('#diamond-icon-6').show();
      $('#master-icon-6').hide();
      $('#grandmaster-icon-6').hide();
      $('#challenger-icon-6').hide();

    }
    else if($('#rank-6').val()==='M'){
      $('#iron-icon-6').hide();
      $('#bronze-icon-6').hide();
      $('#silver-icon-6').hide();
      $('#gold-icon-6').hide();
      $('#platinum-icon-6').hide();
      $('#diamond-icon-6').hide();
      $('#master-icon-6').show();
      $('#grandmaster-icon-6').hide();
      $('#challenger-icon-6').hide();

    }
    else if($('#rank-6').val()==='GM'){
      $('#iron-icon-6').hide();
      $('#bronze-icon-6').hide();
      $('#silver-icon-6').hide();
      $('#gold-icon-6').hide();
      $('#platinum-icon-6').hide();
      $('#diamond-icon-6').hide();
      $('#master-icon-6').hide();
      $('#grandmaster-icon-6').show();
      $('#challenger-icon-6').hide();

    }
    else if($('#rank-6').val()==='C'){
      $('#iron-icon-6').hide();
      $('#bronze-icon-6').hide();
      $('#silver-icon-6').hide();
      $('#gold-icon-6').hide();
      $('#platinum-icon-6').hide();
      $('#diamond-icon-6').hide();
      $('#master-icon-6').hide();
      $('#grandmaster-icon-6').hide();
      $('#challenger-icon-6').show();

    }
  }
function rankImageCheckFive(){
    if($('#rank-5').val()==='I'){
      $('#iron-icon-5').show();
      $('#bronze-icon-5').hide();
      $('#silver-icon-5').hide();
      $('#gold-icon-5').hide();
      $('#platinum-icon-5').hide();
      $('#diamond-icon-5').hide();
      $('#master-icon-5').hide();
      $('#grandmaster-icon-5').hide();
      $('#challenger-icon-5').hide();

    }
    else if($('#rank-5').val()==='B'){
      $('#iron-icon-5').hide();
      $('#bronze-icon-5').show();
      $('#silver-icon-5').hide();
      $('#gold-icon-5').hide();
      $('#platinum-icon-5').hide();
      $('#diamond-icon-5').hide();
      $('#master-icon-5').hide();
      $('#grandmaster-icon-5').hide();
      $('#challenger-icon-5').hide();

    }
    else if($('#rank-5').val()==='S'){
      $('#iron-icon-5').hide();
      $('#bronze-icon-5').hide();
      $('#silver-icon-5').show();
      $('#gold-icon-5').hide();
      $('#platinum-icon-5').hide();
      $('#diamond-icon-5').hide();
      $('#master-icon-5').hide();
      $('#grandmaster-icon-5').hide();
      $('#challenger-icon-5').hide();

    }
    else if($('#rank-5').val()==='G'){
      $('#iron-icon-5').hide();
      $('#bronze-icon-5').hide();
      $('#silver-icon-5').hide();
      $('#gold-icon-5').show();
      $('#platinum-icon-5').hide();
      $('#diamond-icon-5').hide();
      $('#master-icon-5').hide();
      $('#grandmaster-icon-5').hide();
      $('#challenger-icon-5').hide();

    }
    else if($('#rank-5').val()==='P'){
      $('#iron-icon-5').hide();
      $('#bronze-icon-5').hide();
      $('#silver-icon-5').hide();
      $('#gold-icon-5').hide();
      $('#platinum-icon-5').show();
      $('#diamond-icon-5').hide();
      $('#master-icon-5').hide();
      $('#grandmaster-icon-5').hide();
      $('#challenger-icon-5').hide();

    }
    else if($('#rank-5').val()==='D'){
      $('#iron-icon-5').hide();
      $('#bronze-icon-5').hide();
      $('#silver-icon-5').hide();
      $('#gold-icon-5').hide();
      $('#platinum-icon-5').hide();
      $('#diamond-icon-5').show();
      $('#master-icon-5').hide();
      $('#grandmaster-icon-5').hide();
      $('#challenger-icon-5').hide();

    }
    else if($('#rank-5').val()==='M'){
      $('#iron-icon-5').hide();
      $('#bronze-icon-5').hide();
      $('#silver-icon-5').hide();
      $('#gold-icon-5').hide();
      $('#platinum-icon-5').hide();
      $('#diamond-icon-5').hide();
      $('#master-icon-5').show();
      $('#grandmaster-icon-5').hide();
      $('#challenger-icon-5').hide();

    }
    else if($('#rank-5').val()==='GM'){
      $('#iron-icon-5').hide();
      $('#bronze-icon-5').hide();
      $('#silver-icon-5').hide();
      $('#gold-icon-5').hide();
      $('#platinum-icon-5').hide();
      $('#diamond-icon-5').hide();
      $('#master-icon-5').hide();
      $('#grandmaster-icon-5').show();
      $('#challenger-icon-5').hide();

    }
    else if($('#rank-5').val()==='C'){
      $('#iron-icon-5').hide();
      $('#bronze-icon-5').hide();
      $('#silver-icon-5').hide();
      $('#gold-icon-5').hide();
      $('#platinum-icon-5').hide();
      $('#diamond-icon-5').hide();
      $('#master-icon-5').hide();
      $('#grandmaster-icon-5').hide();
      $('#challenger-icon-5').show();

    }
  }
function rankImageCheckFour(){
    if($('#rank-4').val()==='I'){
      $('#iron-icon-4').show();
      $('#bronze-icon-4').hide();
      $('#silver-icon-4').hide();
      $('#gold-icon-4').hide();
      $('#platinum-icon-4').hide();
      $('#diamond-icon-4').hide();
      $('#master-icon-4').hide();
      $('#grandmaster-icon-4').hide();
      $('#challenger-icon-4').hide();

      $('#division-4').show();
    }
    else if($('#rank-4').val()==='B'){
      $('#iron-icon-4').hide();
      $('#bronze-icon-4').show();
      $('#silver-icon-4').hide();
      $('#gold-icon-4').hide();
      $('#platinum-icon-4').hide();
      $('#diamond-icon-4').hide();
      $('#master-icon-4').hide();
      $('#grandmaster-icon-4').hide();
      $('#challenger-icon-4').hide();

      $('#division-4').show();
    }
    else if($('#rank-4').val()==='S'){
      $('#iron-icon-4').hide();
      $('#bronze-icon-4').hide();
      $('#silver-icon-4').show();
      $('#gold-icon-4').hide();
      $('#platinum-icon-4').hide();
      $('#diamond-icon-4').hide();
      $('#master-icon-4').hide();
      $('#grandmaster-icon-4').hide();
      $('#challenger-icon-4').hide();

      $('#division-4').show();
    }
    else if($('#rank-4').val()==='G'){
      $('#iron-icon-4').hide();
      $('#bronze-icon-4').hide();
      $('#silver-icon-4').hide();
      $('#gold-icon-4').show();
      $('#platinum-icon-4').hide();
      $('#diamond-icon-4').hide();
      $('#master-icon-4').hide();
      $('#grandmaster-icon-4').hide();
      $('#challenger-icon-4').hide();

      $('#division-4').show();
    }
    else if($('#rank-4').val()==='P'){
      $('#iron-icon-4').hide();
      $('#bronze-icon-4').hide();
      $('#silver-icon-4').hide();
      $('#gold-icon-4').hide();
      $('#platinum-icon-4').show();
      $('#diamond-icon-4').hide();
      $('#master-icon-4').hide();
      $('#grandmaster-icon-4').hide();
      $('#challenger-icon-4').hide();

      $('#division-4').show();
    }
    else if($('#rank-4').val()==='D'){
      $('#iron-icon-4').hide();
      $('#bronze-icon-4').hide();
      $('#silver-icon-4').hide();
      $('#gold-icon-4').hide();
      $('#platinum-icon-4').hide();
      $('#diamond-icon-4').show();
      $('#master-icon-4').hide();
      $('#grandmaster-icon-4').hide();
      $('#challenger-icon-4').hide();

      $('#division-4').show();
    }
    else if($('#rank-4').val()==='M'){
      $('#iron-icon-4').hide();
      $('#bronze-icon-4').hide();
      $('#silver-icon-4').hide();
      $('#gold-icon-4').hide();
      $('#platinum-icon-4').hide();
      $('#diamond-icon-4').hide();
      $('#master-icon-4').show();
      $('#grandmaster-icon-4').hide();
      $('#challenger-icon-4').hide();

      $('#division-4').hide();
    }
    else if($('#rank-4').val()==='GM'){
      $('#iron-icon-4').hide();
      $('#bronze-icon-4').hide();
      $('#silver-icon-4').hide();
      $('#gold-icon-4').hide();
      $('#platinum-icon-4').hide();
      $('#diamond-icon-4').hide();
      $('#master-icon-4').hide();
      $('#grandmaster-icon-4').show();
      $('#challenger-icon-4').hide();

      $('#division-4').hide();
    }
    else if($('#rank-4').val()==='C'){
      $('#iron-icon-4').hide();
      $('#bronze-icon-4').hide();
      $('#silver-icon-4').hide();
      $('#gold-icon-4').hide();
      $('#platinum-icon-4').hide();
      $('#diamond-icon-4').hide();
      $('#master-icon-4').hide();
      $('#grandmaster-icon-4').hide();
      $('#challenger-icon-4').show();

      $('#division-4').hide();
    }
  }
function rankImageCheckThree(){
    if($('#rank-3').val()==='I'){
      $('#iron-icon-3').show();
      $('#bronze-icon-3').hide();
      $('#silver-icon-3').hide();
      $('#gold-icon-3').hide();
      $('#platinum-icon-3').hide();
      $('#diamond-icon-3').hide();
      $('#master-icon-3').hide();
      $('#grandmaster-icon-3').hide();
      $('#challenger-icon-3').hide();

      $('#division-3').show();
    }
    else if($('#rank-3').val()==='B'){
      $('#iron-icon-3').hide();
      $('#bronze-icon-3').show();
      $('#silver-icon-3').hide();
      $('#gold-icon-3').hide();
      $('#platinum-icon-3').hide();
      $('#diamond-icon-3').hide();
      $('#master-icon-3').hide();
      $('#grandmaster-icon-3').hide();
      $('#challenger-icon-3').hide();

      $('#division-3').show();
    }
    else if($('#rank-3').val()==='S'){
      $('#iron-icon-3').hide();
      $('#bronze-icon-3').hide();
      $('#silver-icon-3').show();
      $('#gold-icon-3').hide();
      $('#platinum-icon-3').hide();
      $('#diamond-icon-3').hide();
      $('#master-icon-3').hide();
      $('#grandmaster-icon-3').hide();
      $('#challenger-icon-3').hide();

      $('#division-3').show();
    }
    else if($('#rank-3').val()==='G'){
      $('#iron-icon-3').hide();
      $('#bronze-icon-3').hide();
      $('#silver-icon-3').hide();
      $('#gold-icon-3').show();
      $('#platinum-icon-3').hide();
      $('#diamond-icon-3').hide();
      $('#master-icon-3').hide();
      $('#grandmaster-icon-3').hide();
      $('#challenger-icon-3').hide();

      $('#division-3').show();
    }
    else if($('#rank-3').val()==='P'){
      $('#iron-icon-3').hide();
      $('#bronze-icon-3').hide();
      $('#silver-icon-3').hide();
      $('#gold-icon-3').hide();
      $('#platinum-icon-3').show();
      $('#diamond-icon-3').hide();
      $('#master-icon-3').hide();
      $('#grandmaster-icon-3').hide();
      $('#challenger-icon-3').hide();

      $('#division-3').show();
    }
    else if($('#rank-3').val()==='D'){
      $('#iron-icon-3').hide();
      $('#bronze-icon-3').hide();
      $('#silver-icon-3').hide();
      $('#gold-icon-3').hide();
      $('#platinum-icon-3').hide();
      $('#diamond-icon-3').show();
      $('#master-icon-3').hide();
      $('#grandmaster-icon-3').hide();
      $('#challenger-icon-3').hide();

      $('#division-3').show();
    }
    else if($('#rank-3').val()==='M'){
      $('#iron-icon-3').hide();
      $('#bronze-icon-3').hide();
      $('#silver-icon-3').hide();
      $('#gold-icon-3').hide();
      $('#platinum-icon-3').hide();
      $('#diamond-icon-3').hide();
      $('#master-icon-3').show();
      $('#grandmaster-icon-3').hide();
      $('#challenger-icon-3').hide();

      $('#division-3').hide();
    }
    else if($('#rank-3').val()==='GM'){
      $('#iron-icon-3').hide();
      $('#bronze-icon-3').hide();
      $('#silver-icon-3').hide();
      $('#gold-icon-3').hide();
      $('#platinum-icon-3').hide();
      $('#diamond-icon-3').hide();
      $('#master-icon-3').hide();
      $('#grandmaster-icon-3').show();
      $('#challenger-icon-3').hide();

      $('#division-3').hide();
    }
    else if($('#rank-3').val()==='C'){
      $('#iron-icon-3').hide();
      $('#bronze-icon-3').hide();
      $('#silver-icon-3').hide();
      $('#gold-icon-3').hide();
      $('#platinum-icon-3').hide();
      $('#diamond-icon-3').hide();
      $('#master-icon-3').hide();
      $('#grandmaster-icon-3').hide();
      $('#challenger-icon-3').show();

      $('#division-3').hide();
    }
  }
function rankImageCheckTwo(){
  if($('#rank-2').val()==='I'){
    $('#iron-icon-2').show();
    $('#bronze-icon-2').hide();
    $('#silver-icon-2').hide();
    $('#gold-icon-2').hide();
    $('#platinum-icon-2').hide();
    $('#diamond-icon-2').hide();
    $('#master-icon-2').hide();
    $('#grandmaster-icon-2').hide();
    $('#challenger-icon-2').hide();

    $('#division-2').show();
  }
  else if($('#rank-2').val()==='B'){
    $('#iron-icon-2').hide();
    $('#bronze-icon-2').show();
    $('#silver-icon-2').hide();
    $('#gold-icon-2').hide();
    $('#platinum-icon-2').hide();
    $('#diamond-icon-2').hide();
    $('#master-icon-2').hide();
    $('#grandmaster-icon-2').hide();
    $('#challenger-icon-2').hide();

    $('#division-2').show();
  }
  else if($('#rank-2').val()==='S'){
    $('#iron-icon-2').hide();
    $('#bronze-icon-2').hide();
    $('#silver-icon-2').show();
    $('#gold-icon-2').hide();
    $('#platinum-icon-2').hide();
    $('#diamond-icon-2').hide();
    $('#master-icon-2').hide();
    $('#grandmaster-icon-2').hide();
    $('#challenger-icon-2').hide();

    $('#division-2').show();
  }
  else if($('#rank-2').val()==='G'){
    $('#iron-icon-2').hide();
    $('#bronze-icon-2').hide();
    $('#silver-icon-2').hide();
    $('#gold-icon-2').show();
    $('#platinum-icon-2').hide();
    $('#diamond-icon-2').hide();
    $('#master-icon-2').hide();
    $('#grandmaster-icon-2').hide();
    $('#challenger-icon-2').hide();

    $('#division-2').show();
  }
  else if($('#rank-2').val()==='P'){
    $('#iron-icon-2').hide();
    $('#bronze-icon-2').hide();
    $('#silver-icon-2').hide();
    $('#gold-icon-2').hide();
    $('#platinum-icon-2').show();
    $('#diamond-icon-2').hide();
    $('#master-icon-2').hide();
    $('#grandmaster-icon-2').hide();
    $('#challenger-icon-2').hide();

    $('#division-2').show();
  }
  else if($('#rank-2').val()==='D'){
    $('#iron-icon-2').hide();
    $('#bronze-icon-2').hide();
    $('#silver-icon-2').hide();
    $('#gold-icon-2').hide();
    $('#platinum-icon-2').hide();
    $('#diamond-icon-2').show();
    $('#master-icon-2').hide();
    $('#grandmaster-icon-2').hide();
    $('#challenger-icon-2').hide();

    $('#division-2').show();
  }
  else if($('#rank-2').val()==='M'){
    $('#iron-icon-2').hide();
    $('#bronze-icon-2').hide();
    $('#silver-icon-2').hide();
    $('#gold-icon-2').hide();
    $('#platinum-icon-2').hide();
    $('#diamond-icon-2').hide();
    $('#master-icon-2').show();
    $('#grandmaster-icon-2').hide();
    $('#challenger-icon-2').hide();

    $('#division-2').hide();
  }
  else if($('#rank-2').val()==='GM'){
    $('#iron-icon-2').hide();
    $('#bronze-icon-2').hide();
    $('#silver-icon-2').hide();
    $('#gold-icon-2').hide();
    $('#platinum-icon-2').hide();
    $('#diamond-icon-2').hide();
    $('#master-icon-2').hide();
    $('#grandmaster-icon-2').show();
    $('#challenger-icon-2').hide();

    $('#division-2').hide();
  }
  else if($('#rank-2').val()==='C'){
    $('#iron-icon-2').hide();
    $('#bronze-icon-2').hide();
    $('#silver-icon-2').hide();
    $('#gold-icon-2').hide();
    $('#platinum-icon-2').hide();
    $('#diamond-icon-2').hide();
    $('#master-icon-2').hide();
    $('#grandmaster-icon-2').hide();
    $('#challenger-icon-2').show();

    $('#division-2').hide();
  }
}
function rankImageCheckOne(){
  if($('#rank-1').val()==='I'){
    $('#iron-icon-1').show();
    $('#bronze-icon-1').hide();
    $('#silver-icon-1').hide();
    $('#gold-icon-1').hide();
    $('#platinum-icon-1').hide();
    $('#diamond-icon-1').hide();
    $('#master-icon-1').hide();
    $('#grandmaster-icon-1').hide();
    $('#challenger-icon-1').hide();

    $('#division-1').show();
    $('#startinglp_1').show();
  }
  else if($('#rank-1').val()==='B'){
    $('#iron-icon-1').hide();
    $('#bronze-icon-1').show();
    $('#silver-icon-1').hide();
    $('#gold-icon-1').hide();
    $('#platinum-icon-1').hide();
    $('#diamond-icon-1').hide();
    $('#master-icon-1').hide();
    $('#grandmaster-icon-1').hide();
    $('#challenger-icon-1').hide();

    $('#division-1').show();
    $('#startinglp_1').show();

  }
  else if($('#rank-1').val()==='S'){
    $('#iron-icon-1').hide();
    $('#bronze-icon-1').hide();
    $('#silver-icon-1').show();
    $('#gold-icon-1').hide();
    $('#platinum-icon-1').hide();
    $('#diamond-icon-1').hide();
    $('#master-icon-1').hide();
    $('#grandmaster-icon-1').hide();
    $('#challenger-icon-1').hide();

    $('#division-1').show();
    $('#startinglp_1').show();

  }
  else if($('#rank-1').val()==='G'){
    $('#iron-icon-1').hide();
    $('#bronze-icon-1').hide();
    $('#silver-icon-1').hide();
    $('#gold-icon-1').show();
    $('#platinum-icon-1').hide();
    $('#diamond-icon-1').hide();
    $('#master-icon-1').hide();
    $('#grandmaster-icon-1').hide();
    $('#challenger-icon-1').hide();

    $('#division-1').show();
    $('#startinglp_1').show();

  }
  else if($('#rank-1').val()==='P'){
    $('#iron-icon-1').hide();
    $('#bronze-icon-1').hide();
    $('#silver-icon-1').hide();
    $('#gold-icon-1').hide();
    $('#platinum-icon-1').show();
    $('#diamond-icon-1').hide();
    $('#master-icon-1').hide();
    $('#grandmaster-icon-1').hide();
    $('#challenger-icon-1').hide();

    $('#division-1').show();
    $('#startinglp_1').show();

  }
  else if($('#rank-1').val()==='D'){
    $('#iron-icon-1').hide();
    $('#bronze-icon-1').hide();
    $('#silver-icon-1').hide();
    $('#gold-icon-1').hide();
    $('#platinum-icon-1').hide();
    $('#diamond-icon-1').show();
    $('#master-icon-1').hide();
    $('#grandmaster-icon-1').hide();
    $('#challenger-icon-1').hide();

    $('#division-1').show();
    $('#startinglp_1').show();

  }
  else if($('#rank-1').val()==='M'){
    $('#iron-icon-1').hide();
    $('#bronze-icon-1').hide();
    $('#silver-icon-1').hide();
    $('#gold-icon-1').hide();
    $('#platinum-icon-1').hide();
    $('#diamond-icon-1').hide();
    $('#master-icon-1').show();
    $('#grandmaster-icon-1').hide();
    $('#challenger-icon-1').hide();

    $('#division-1').hide();
    $('#startinglp_1').hide();

  }
  else if($('#rank-1').val()==='GM'){
    $('#iron-icon-1').hide();
    $('#bronze-icon-1').hide();
    $('#silver-icon-1').hide();
    $('#gold-icon-1').hide();
    $('#platinum-icon-1').hide();
    $('#diamond-icon-1').hide();
    $('#master-icon-1').hide();
    $('#grandmaster-icon-1').show();
    $('#challenger-icon-1').hide();

    $('#division-1').hide();
    $('#startinglp_1').hide();

  }
  else if($('#rank-1').val()==='C'){
    $('#iron-icon-1').hide();
    $('#bronze-icon-1').hide();
    $('#silver-icon-1').hide();
    $('#gold-icon-1').hide();
    $('#platinum-icon-1').hide();
    $('#diamond-icon-1').hide();
    $('#master-icon-1').hide();
    $('#grandmaster-icon-1').hide();
    $('#challenger-icon-1').show();

    $('#division-1').hide();
    $('#startinglp_1').hide();

  }
}
function rankImageCheckDuoDivOne(){

  if($('#rank-10').val()==='I'){
    $('#iron-icon-10').show();
    $('#bronze-icon-10').hide();
    $('#silver-icon-10').hide();
    $('#gold-icon-10').hide();
    $('#platinum-icon-10').hide();
    $('#diamond-icon-10').hide();
    $('#master-icon-10').hide();
    $('#grandmaster-icon-10').hide();
    $('#challenger-icon-10').hide();

    $('#division-10').show();
    $('#startinglp-10').show();

  }
  else if($('#rank-10').val()==='B'){
    $('#iron-icon-10').hide();
    $('#bronze-icon-10').show();
    $('#silver-icon-10').hide();
    $('#gold-icon-10').hide();
    $('#platinum-icon-10').hide();
    $('#diamond-icon-10').hide();
    $('#master-icon-10').hide();
    $('#grandmaster-icon-10').hide();
    $('#challenger-icon-10').hide();

    $('#division-10').show();
    $('#startinglp-10').show();

  }
  else if($('#rank-10').val()==='S'){
    $('#iron-icon-10').hide();
    $('#bronze-icon-10').hide();
    $('#silver-icon-10').show();
    $('#gold-icon-10').hide();
    $('#platinum-icon-10').hide();
    $('#diamond-icon-10').hide();
    $('#master-icon-10').hide();
    $('#grandmaster-icon-10').hide();
    $('#challenger-icon-10').hide();

    $('#division-10').show();
    $('#startinglp-10').show();

  }
  else if($('#rank-10').val()==='G'){
    $('#iron-icon-10').hide();
    $('#bronze-icon-10').hide();
    $('#silver-icon-10').hide();
    $('#gold-icon-10').show();
    $('#platinum-icon-10').hide();
    $('#diamond-icon-10').hide();
    $('#master-icon-10').hide();
    $('#grandmaster-icon-10').hide();
    $('#challenger-icon-10').hide();

    $('#division-10').show();
    $('#startinglp-10').show();

  }
  else if($('#rank-10').val()==='P'){
    $('#iron-icon-10').hide();
    $('#bronze-icon-10').hide();
    $('#silver-icon-10').hide();
    $('#gold-icon-10').hide();
    $('#platinum-icon-10').show();
    $('#diamond-icon-10').hide();
    $('#master-icon-10').hide();
    $('#grandmaster-icon-10').hide();
    $('#challenger-icon-10').hide();

    $('#division-10').show();
    $('#startinglp-10').show();

  }
  else if($('#rank-10').val()==='D'){
    $('#iron-icon-10').hide();
    $('#bronze-icon-10').hide();
    $('#silver-icon-10').hide();
    $('#gold-icon-10').hide();
    $('#platinum-icon-10').hide();
    $('#diamond-icon-10').show();
    $('#master-icon-10').hide();
    $('#grandmaster-icon-10').hide();
    $('#challenger-icon-10').hide();

    $('#division-10').show();
    $('#startinglp-10').show();

  }
  else if($('#rank-10').val()==='M'){
    $('#iron-icon-10').hide();
    $('#bronze-icon-10').hide();
    $('#silver-icon-10').hide();
    $('#gold-icon-10').hide();
    $('#platinum-icon-10').hide();
    $('#diamond-icon-10').hide();
    $('#master-icon-10').show();
    $('#grandmaster-icon-10').hide();
    $('#challenger-icon-10').hide();

    $('#division-10').hide();
    $('#startinglp-10').hide();

  }
  else if($('#rank-10').val()==='GM'){
    $('#iron-icon-10').hide();
    $('#bronze-icon-10').hide();
    $('#silver-icon-10').hide();
    $('#gold-icon-10').hide();
    $('#platinum-icon-10').hide();
    $('#diamond-icon-10').hide();
    $('#master-icon-10').hide();
    $('#grandmaster-icon-10').show();
    $('#challenger-icon-10').hide();

    $('#division-10').hide();
    $('#startinglp-10').hide();

  }
  else if($('#rank-10').val()==='C'){
    $('#iron-icon-10').hide();
    $('#bronze-icon-10').hide();
    $('#silver-icon-10').hide();
    $('#gold-icon-10').hide();
    $('#platinum-icon-10').hide();
    $('#diamond-icon-10').hide();
    $('#master-icon-10').hide();
    $('#grandmaster-icon-10').hide();
    $('#challenger-icon-10').show();

    $('#division-10').hide();
    $('#startinglp-10').hide();

  }

}
function rankImageCheckDuoDivTwo(){

  if($('#rank-11').val()==='I'){
    $('#iron-icon-11').show();
    $('#bronze-icon-11').hide();
    $('#silver-icon-11').hide();
    $('#gold-icon-11').hide();
    $('#platinum-icon-11').hide();
    $('#diamond-icon-11').hide();
    $('#master-icon-11').hide();
    $('#grandmaster-icon-11').hide();
    $('#challenger-icon-11').hide();

    $('#division-11').show();
  }
  else if($('#rank-11').val()==='B'){
    $('#iron-icon-11').hide();
    $('#bronze-icon-11').show();
    $('#silver-icon-11').hide();
    $('#gold-icon-11').hide();
    $('#platinum-icon-11').hide();
    $('#diamond-icon-11').hide();
    $('#master-icon-11').hide();
    $('#grandmaster-icon-11').hide();
    $('#challenger-icon-11').hide();

    $('#division-11').show();
  }
  else if($('#rank-11').val()==='S'){
    $('#iron-icon-11').hide();
    $('#bronze-icon-11').hide();
    $('#silver-icon-11').show();
    $('#gold-icon-11').hide();
    $('#platinum-icon-11').hide();
    $('#diamond-icon-11').hide();
    $('#master-icon-11').hide();
    $('#grandmaster-icon-11').hide();
    $('#challenger-icon-11').hide();

    $('#division-11').show();
  }
  else if($('#rank-11').val()==='G'){
    $('#iron-icon-11').hide();
    $('#bronze-icon-11').hide();
    $('#silver-icon-11').hide();
    $('#gold-icon-11').show();
    $('#platinum-icon-11').hide();
    $('#diamond-icon-11').hide();
    $('#master-icon-11').hide();
    $('#grandmaster-icon-11').hide();
    $('#challenger-icon-11').hide();

    $('#division-11').show();
  }
  else if($('#rank-11').val()==='P'){
    $('#iron-icon-11').hide();
    $('#bronze-icon-11').hide();
    $('#silver-icon-11').hide();
    $('#gold-icon-11').hide();
    $('#platinum-icon-11').show();
    $('#diamond-icon-11').hide();
    $('#master-icon-11').hide();
    $('#grandmaster-icon-11').hide();
    $('#challenger-icon-11').hide();

    $('#division-11').show();
  }
  else if($('#rank-11').val()==='D'){
    $('#iron-icon-11').hide();
    $('#bronze-icon-11').hide();
    $('#silver-icon-11').hide();
    $('#gold-icon-11').hide();
    $('#platinum-icon-11').hide();
    $('#diamond-icon-11').show();
    $('#master-icon-11').hide();
    $('#grandmaster-icon-11').hide();
    $('#challenger-icon-11').hide();

    $('#division-11').show();
  }
  else if($('#rank-11').val()==='M'){
    $('#iron-icon-11').hide();
    $('#bronze-icon-11').hide();
    $('#silver-icon-11').hide();
    $('#gold-icon-11').hide();
    $('#platinum-icon-11').hide();
    $('#diamond-icon-11').hide();
    $('#master-icon-11').show();
    $('#grandmaster-icon-11').hide();
    $('#challenger-icon-11').hide();

    $('#division-11').hide();
  }
  else if($('#rank-11').val()==='GM'){
    $('#iron-icon-11').hide();
    $('#bronze-icon-11').hide();
    $('#silver-icon-11').hide();
    $('#gold-icon-11').hide();
    $('#platinum-icon-11').hide();
    $('#diamond-icon-11').hide();
    $('#master-icon-11').hide();
    $('#grandmaster-icon-11').show();
    $('#challenger-icon-11').hide();

    $('#division-11').hide();
  }
  else if($('#rank-11').val()==='C'){
    $('#iron-icon-11').hide();
    $('#bronze-icon-11').hide();
    $('#silver-icon-11').hide();
    $('#gold-icon-11').hide();
    $('#platinum-icon-11').hide();
    $('#diamond-icon-11').hide();
    $('#master-icon-11').hide();
    $('#grandmaster-icon-11').hide();
    $('#challenger-icon-11').show();

    $('#division-11').hide();
  }

}
