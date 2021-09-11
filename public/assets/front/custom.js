const addtocart = '/add-to-cart';
const checkIfInCart = '/check-if-in-cart';
  
    $(".lx-contact-us > a").on("click",function(){
	if($(".lx-contact-us-content").css("display") !== "block"){
		$(".lx-contact-us-content").css("display","block");
		$(this).find("i").attr("class","fa fa-times");
	}
	else{
		$(".lx-contact-us-content").css("display","none");
		$(this).find("i").attr("class","fa fa-phone");
	}
});
    
    
    
    
    
    
    
    $('body #menuclose').click(function(){
      $('.side-navigation').hide();
    });
    
    $('body #menuopen').click(function(){
      $('.side-navigation').show();
    });
    
    


	var later = $('#laterDate').val();
	
	$(function () {
           setInterval(function () {
                var currentDate = new Date().getTime();
                var eventDate = new Date(later).getTime();
                var dateDifference = eventDate - currentDate;
                var seconds = parseInt(dateDifference / 1000);
                var minutes = parseInt(seconds / 60);
                var hours = parseInt(minutes / 60);
                var days = parseInt(hours / 24);
                var months = parseInt(days / 30);
                seconds = seconds - minutes * 60;
                minutes = minutes - hours * 60;
                hours = hours - days * 24;
                days = days - months * 30;
             
                $('#seconds').html(seconds);
                $('#minutes').html(minutes);
                $('#hours').html(hours);
                $('#days').html(days);
                
            })
    }, 1000)
        





function validatePhone(txtPhone) {
    var a = txtPhone;
    var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
    if (filter.test(a)) {
        return true;
    }
    else {
        return false;
    }
}






$('#savecommand').submit(function(e) {


  e.preventDefault();
  e.stopPropagation();



var tel = $('#savecommand [name="phone"]').val();
  
if( tel.length > 10  || tel.length < 9 ){
     $('#phoneAlert').show();
     return false;  
}

if( ! validatePhone (tel))  {
     $('#phoneAlert').show();
     return false;  
}




$('#phoneAlert').hide();

  var datastring = $(this).serialize();

  jQuery.ajax({
    url: '/storeApi',
    type : 'post',
    data: datastring,
    dataType: "html",
    beforeSend:function(){
        
    },
   success: function( response ) {
           window.location.href = "/thank-you";
          },
    error:function(response){
 
    }
  });

  return false;
});



$('.quantity_area #type').change(function(){
        
    var price = $('.quantity_area #type').val();
    var quantity = $('.quantity_area #type option:selected').attr('data-quantity');
    
   // alert(price);
   // alert(quantity);
    
    
    $('#savecommand [name="price"]').val(price);
    $('#savecommand [name="quantity"]').val(quantity);
});






$('body #close_cmd').click(function(){
    $('.cmd_wrapper').hide();
});

window.setInterval(function(){
          $(".single-visitors b").text(parseInt($(".single-visitors b").text()) + Math.floor((Math.random() * 5) + 1));
},3000);

  $('.thumbnail-item').click(function(){
    var img = $(this).find('img').attr('src');
    $('.product-slider.product-slider-desktop .preview img').attr('src',img);
  });




$('.quantity-handler i.fa.fa-plus').click(function(){
  var qty = parseInt($('.single-quantity').val());
    qty+=1;
    $('.single-quantity').val(qty);



  $('#savecommand [name="quantity"]').val(qty);




});

$('.quantity-handler i.fa.fa-minus').click(function(){
  var qty = parseInt($('.single-quantity').val());
  if(qty >1){
    qty-=1;
    $('.single-quantity').val(qty);
    $('#savecommand [name="quantity"]').val(qty);
  }  
});

$('#search-icon').click(function(){
  $('.search-form').toggle();
});




 var owl = $('.list-preview');
      owl.owlCarousel({
        margin: 10,
        loop: true,
        rtl: true,
           nav:true,
      navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        
        responsive: {
          0: {
            items: 3
          },
          600: {
            items: 2
          },
          1000: {
            items: 5
          }
        }
      });






 var owl = $('.categories-style-1');
      owl.owlCarousel({
        margin: 10,
        rtl: true,
              nav:true,
      navText : ['<i class="fa fa-angle-left" aria-hidden="true"></i>','<i class="fa fa-angle-right" aria-hidden="true"></i>'],
        
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 2
          },
          1000: {
            items: 4
          }
        }
      })








$('.thumbnail-item img').click(function(){
  var src = $(this).attr('src');
  $('.thumbnail .preview img').attr('src',src);
});



$('body .owl-carousel2').owlCarousel( {
    loop: true,
    center: true,
    items: 1,
    margin: 30,
    autoplay: true,
    dots:false,
    nav:false,
    autoplayTimeout: 8500,
    smartSpeed: 450,
    responsive: {
      0: {
        items: 1
      },
      768: {
        items: 2
      },
      1170: {
        items: 1
      }
    }
  });

$(document).on('click', 'body #order-now', function (e) {
  const product = $(this).data('product');
  const type = $('select#type').find(":selected");
  const quantity = type.data('quantity');
  const price = type.val();

  e.preventDefault();
  var formData = new FormData();
  formData.append('product', product);
  formData.append('quantity', quantity);
  formData.append('price', price);

  $.ajax({
    url: checkIfInCart,
    type: 'POST',
    processData: false, // important
    contentType: false, // important
    data: formData,
    cache: false,
    dataType: "JSON",
    success: function (data) {
      if(! data.exist){
        $.ajax({
          url: addtocart,
          type: 'POST',
          processData: false, // important
          contentType: false, // important
          data: formData,
          cache: false,
          dataType: "JSON",
          success: function (data) {
            let cartCounter = $('#cart-counter').html().replace('(', '').replace(')', '');
            const newCount = parseInt(cartCounter) + 1;
            $('#cart-counter').html('(' + newCount + ')');
          }
        });
      }
    }
  });
  return false;
});
