var app_name=$('#app_name').val();
var gst_no=$('#gst_no').val();
var phone=$('#phone').val();
var address=$('#address').val();
var logo=$('#logo').val();
var base_url=$('#base_url').val();
function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
      let c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return null;
  }

function setPageCookie(store_name) {
    let d=new Date();
    d.setTime(d.getTime() + (1*24*3600000));
    let expires = "expires="+ d.toUTCString();
    document.cookie="store_name="+store_name+"; expires="+expires+"; path=/";      
    console.log(document.cookie);

    //store the store_name in local db
    var db = openDatabase('mydb', '1.0', 'Test DB', 2 * 1024 * 1024); 
    db.transaction(function (tx) {   
        tx.executeSql('CREATE TABLE IF NOT EXISTS STORE (store_name)'); 
        tx.executeSql('INSERT INTO CART (store_name) VALUES ("'+store_name+'")'); 
    });
}
  var total_cart_qty=total_cart_price=0; 
  function showCartValue() {
      var home_cart=getCookie('cart');
      var store_name=getCookie('store_name');      
      let c=JSON.parse(home_cart);
      let pd_id=$('#product_id').val();
      let pd_qty=0;
      if(c!=undefined && [store_name]!=undefined) {   
          $.each(c[store_name],function(index,item) {
              if(item.item_id==pd_id) pd_qty=item.quantity;
              total_cart_qty+=parseInt(item.quantity);
              total_cart_price+=(parseInt(item.quantity)*parseFloat(item.mrp));
          });
          $('#total_qty').text(total_cart_qty);
          $('#total_price').text(total_cart_price);
          $('#count').attr('value',pd_qty);
      }
  }
 
function checkStoreName() {
    var store_name='';
    var csrfTokenName=$('#csrfTokenName').val();
    var csrfTokenValue=$('#csrfTokenValue').val();
    var flag=false;
    const urlParams = new URLSearchParams(window.location.search);
    store_name = urlParams.get('ref');
    /*console.log(document.cookie);
    console.log(store_name);*/
    //return;
    if(store_name==null) 
        store_name=getCookie('store_name');
    if(store_name==null) {
        var db = openDatabase('mydb', '1.0', 'Test DB', 2 * 1024 * 1024); 
        db.transaction(function (tx) {   
            tx.executeSql('SELECT *FROM STORE',[],function(ts,data) {
                store_name=data.rows.item(0);
            });             
        });
    } 
    console.log(strre_name);
    if(store_name!=null) {
        $.ajax({
            url:base_url+'Home/check_store_name',
            data:"store_name="+store_name+'&'+csrfTokenName+'='+csrfTokenValue,
            type:'POST',
            dataType:'json',
            xhrFields: {
                withCredentials: true
             },
            success:function(res) {
                if(res.success) {
                    setPageCookie(store_name);
                    showCartValue();
                }
                else {
                    console.log('not found');
                    //window.location=base_url+'not_found';
                }
            }
        }); 
    } else { 
        console.log('store id not found');
       // window.location=base_url+'not_found';
    }    
}

checkStoreName();
var customer_banner = '<div class="homeshop-card hide" id="homeshop-card">\
<div class="container">\
    <div class="d-flex align-items-end">\
        <img src="'+logo+'" alt="" height="100" width="100">\
        <div class="ms-4">\
            <h4 class="mb-2">'+app_name+'</h4>\
            <div class="d-flex">\
                <div class="text-muted pe-3">GST NO. <b>'+gst_no+'</b></div> |\
                <div class="text-dark ps-3"><i class="bi-geo-alt-fill"></i> '+address+'</div>\
            </div>\
            <div class="input-group w-50 mt-1">\
                <span class="input-group-text" id="basic-addon1"><i class="bi-telephone"></i></span>\
                <input type="text" class="form-control form-control-sm" disabled value="'+phone+'" aria-label="Username" aria-describedby="basic-addon1">\
            </div>\
        </div>\
        <div class="destination ms-auto "></div>\
    </div>\
</div>\
</div>';

$(".customer-banner").html(customer_banner);

$(document).ready(function () {
    $(".count-input").hide();
    
    

    $('#list,#product_detail').on('click','.increamentbtn',function () {
        var count = 0;
        var item_id=0;
        var countInput = $(this).siblings('input');
        count=countInput.attr("value");
        console.log(countInput);
        console.log('incr='+count);
        count++;
        item_id=$(this).data('product_id');
        let item_detail=JSON.parse($('#product'+item_id).val());
        countInput.attr("value", count);
        let store_name=getCookie('store_name');
        var db = openDatabase('mydb', '1.0', 'Test DB', 2 * 1024 * 1024); 
        db.transaction(function (tx) {   
            tx.executeSql('CREATE TABLE IF NOT EXISTS CART (store_id,item_id,quantity,item_image)'); 
            tx.executeSql('INSERT INTO CART (store_id,item_id,quantity,item_image) VALUES ("'+store_name+'","'+item_id+'","'+count+'","'+item_detail+'")'); 
            //tx.executeSql('INSERT INTO CART (store_id,item_id) VALUES ("'+store_name+'","'+item_id+'")'); 
        });
        //updateCart(item_id,count,'incr');
    });
    
    $('#list,#product_detail').on('click','.decreamentbtn',function () {
        var count = 0;
        var item_id=0;
        var countInput = $(this).siblings('input');
        count=countInput.attr("value");
        console.log('decr='+count);
        item_id=$(this).data('product_id');
        count--;
        if(count<0) count=0;
        else {
            countInput.attr("value", count);
        }
        if (count <= 0) {
            countInput.parent().siblings().closest(".cart-btn").show();
            $(this).parent('.count-input').hide();
            $(this).parent().addClass("d-none").removeClass("d-flex");
        }
        if (count == 0) {
            count = 0;
            countInput.attr("value", count);
        }
        console.log(count); //return;
        updateCart(item_id,count,'decr');

    });

    
    
    $('#list').on('click','.cart-btn',function () {
        $(this).hide();
        $(this).prev(".count-input").addClass("d-flex").removeClass("d-none");
        $(this).prev().find('.increamentbtn').trigger('click');
    });
    $('#product_detail').on('click','.cart-btn-table',function () {
        $(this).hide();
        $(this).parent().prev().find(".count-input").css({'display':'block'});        
    });

    $(".pickup-section").hide();
    $("#delivery").click(function () {
        $(".delivery-section").show();
        $(".pickup-section").hide();
    });

    $("#pickup").click(function () {
        $(".delivery-section").hide();
        $(".pickup-section").show();
    });

});


var jsonObj = {
    "index": { "y1": 300, "y2": 2900 },
    "product-details": { "y1": 60 }
};
var y2 = jsonObj["index"]["y2"];

if (window.location.href.indexOf("index") > -1) {
    y1 = jsonObj["index"]["y1"];
}

else if (window.location.href.indexOf("product-details") > -1 ||
    window.location.href.indexOf("order-details") > -1 ||
    window.location.href.indexOf("cart") > -1 ||
    window.location.href.indexOf("place-order") > -1) {
    y1 = jsonObj["product-details"]["y1"];
}

// Scroll to see pricing
myID = document.getElementById("homeshop-card");

if(myID) {
    var myScrollFunc = function () {
        var y = window.scrollY;

        if (y <= y1) {
            myID.className = "homeshop-card hide"
            $(".cart-wrapper").appendTo(".cart-parent");
        } else if (y >= y2) {
            myID.className = "homeshop-card hide"
            $(".cart-wrapper").appendTo(".cart-parent");
        } else {
            myID.className = "homeshop-card show"
            $(".cart-wrapper").appendTo(".destination");
        }
    };
}

window.addEventListener("scroll", myScrollFunc);



// Product Image Magnifier

function imageZoom(imgID, resultID) {
    var img, lens, result, cx, cy;
    img = document.getElementById(imgID);
    result = document.getElementById(resultID);
    /*create lens:*/
    lens = document.createElement("DIV");
    lens.setAttribute("class", "img-zoom-lens");
    /*insert lens:*/
    img.parentElement.insertBefore(lens, img);
    /*calculate the ratio between result DIV and lens:*/
    cx = result.offsetWidth / lens.offsetWidth;
    cy = result.offsetHeight / lens.offsetHeight;
    /*set background properties for the result DIV:*/
    result.style.backgroundImage = "url('" + img.src + "')";
    result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
    /*execute a function when someone moves the cursor over the image, or the lens:*/
    lens.addEventListener("mousemove", moveLens);
    img.addEventListener("mousemove", moveLens);
    /*and also for touch screens:*/
    lens.addEventListener("touchmove", moveLens);
    img.addEventListener("touchmove", moveLens);
    function moveLens(e) {
        var pos, x, y;
        /*prevent any other actions that may occur when moving over the image:*/
        e.preventDefault();
        /*get the cursor's x and y positions:*/
        pos = getCursorPos(e);
        /*calculate the position of the lens:*/
        x = pos.x - (lens.offsetWidth / 2);
        y = pos.y - (lens.offsetHeight / 2);
        /*prevent the lens from being positioned outside the image:*/
        if (x > img.width - lens.offsetWidth) { x = img.width - lens.offsetWidth; }
        if (x < 0) { x = 0; }
        if (y > img.height - lens.offsetHeight) { y = img.height - lens.offsetHeight; }
        if (y < 0) { y = 0; }
        /*set the position of the lens:*/
        lens.style.left = x + "px";
        lens.style.top = y + "px";
        /*display what the lens "sees":*/
        result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
    }
    function getCursorPos(e) {
        var a, x = 0, y = 0;
        e = e || window.event;
        /*get the x and y positions of the image:*/
        a = img.getBoundingClientRect();
        /*calculate the cursor's x and y coordinates, relative to the image:*/
        x = e.pageX - a.left;
        y = e.pageY - a.top;
        /*consider any page scrolling:*/
        x = x - window.pageXOffset;
        y = y - window.pageYOffset;
        return { x: x, y: y };
    }
}
function updateCart(item_id,count,c_type) {
    var form_data={};
    const d = new Date();
    //console.log("cookie");
    //console.log(document.cookie);
    let cart=getCookie('cart');
    let store_name=getCookie('store_name');
    let item_detail=JSON.parse($('#product'+item_id).val());
    let total_qty=total_price=0;
    let store_c=JSON.parse(cart);
    //console.log('st_name='+store_name);
    if(store_name==null) {
        console.log("No store found");
        return;
    }    
    if(cart==null || Object.keys(store_c).length==0) {
        form_data[item_id]=item_detail;
        form_data[item_id]['quantity']=count;
    } else {
        if(store_c[store_name]!=undefined) {
            form_data=store_c[store_name];
            //console.log(form_data);
            if(count==0) 
                delete store_c[store_name][item_id];
            else {
                let qty=count;
                if(form_data[item_id]!=undefined) {                    
                    if(c_type=='incr')
                        qty=form_data[item_id]['quantity']+1;
                    else qty=form_data[item_id]['quantity']-1;
                }
                else form_data[item_id]=item_detail;
                form_data[item_id]['quantity']=qty;
            }
        } else {
            form_data[item_id]=item_detail;
            form_data[item_id]['quantity']=count;
        }
    }    
    $.each(form_data,function(index,item) {
        total_qty+=parseInt(item.quantity);
        total_price+=(parseInt(item.quantity)*parseFloat(item.mrp));
    });
    //console.log(store_name);
    //console.log(form_data);
   // return;
    d.setTime(d.getTime() + (1*24*3600000));
    let expires = "expires="+ d.toUTCString();  
    let store_cart={};
    store_cart[store_name]=form_data;  
    //console.log(store_cart);
    document.cookie="cart="+JSON.stringify(store_cart)+"; expires="+expires+"; path=/";
    //console.log(document.cookie);
    $('#total_qty').text(total_qty);
    $('#total_price').text(total_price);
    /*var csrfTokenName=$('#csrfTokenName').val();
    var csrfTokenValue=$('#csrfTokenValue').val();
    form_data['item_id']=item_id;
    form_data['quantity']=count;
    form_data[csrfTokenName]=csrfTokenValue;
    $.ajax({
        url:base_url+'Home/update_cart',
        data:form_data,
        type:'POST',
        dataType:'json',
        success:function(res) {
            if(res.success) {                   
            }
        }
    });*/
}