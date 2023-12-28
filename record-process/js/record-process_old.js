//add wishlist
function addToWishList(productId, divId, url) {
  console.log(url);
  let actionUrl = "ajax/add-to-wish-list.php";
  console.log("formData");
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: { action: "add", productId: productId, divId: divId, url: url },
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);

      if (data.status == "Not LogIn") {
        window.location.href =
          "account.php?" +
          randomString(20) +
          "=" +
          randomString(20) +
          "&url=" +
          data.url +
          "&" +
          randomString(20) +
          "=" +
          randomString(20);
      } else {
        url = "'" + url + "'";

        var html =
          `<a class="wishlist active" href="javascript:void(0);"
         onclick="removeFromWishList(` +
          productId +
          ",this.id," +
          url +
          `)"
         id="` +
          divId +
          `" title="Already Added">
         <button class="btn p-0 wishlist btn-wishlist ">
                <i class="fa fa-heart filled" aria-hidden="true" style="color:red;"></i>
            </button>
        </a>
`;

        // console.log(html);
        if (data.currentPage == "product-detail.php") {
          var html1 =
            '<a class="wishlist active" onclick="removeFromWishList(' +
            productId +
            ",this.id," +
            url +
            ')" id="' +
            divId +
            '" title="Already Added" ><i class="bx bx-heart"></i> Already Added</a>';
          console.log(html1);
          $(".addWish").html(html1);
          $("." + divId).html(html);
        } else {
          // $("." + divId).html(html);
          $("#topWish_" + productId).html(html);
          $("#hotWish_" + productId).html(html);
          $("#newWish_" + productId).html(html);
          $("#bestWish_" + productId).html(html);
        }

        title = "Success";
        msg = "Item Successfully added in wishlist";
        type = "info";
        showAlert(title, msg, type);
      }
    },
  });
}

////////// Generate random String //////////
function randomString(length) {
  var result = "";
  var characters =
    "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  var charactersLength = characters.length;
  for (var i = 0; i < length; i++) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}
////////// Generate random String //////////

// remove wishlist

function removeFromWishList(productId, divId, url) {
  $("#confirmModal").addClass("show");
  console.log(divId);
  confirmDialog("Are You sure! You want to remove?", function () {
    // $("#confirmModal").modal('hide');
    actionUrl = "ajax/add-to-wish-list.php";
    $.ajax({
      url: actionUrl,
      type: "POST",
      data: { action: "remove", productId: productId },
      success: function (data) {
        data = JSON.parse(data);
        console.log(data);
        url = "'" + url + "'";
        console.log(url);

        var html =
          `<a class="wishlist" href="javascript:void(0);" 
          onclick="addToWishList(` +
          productId +
          ",this.id," +
          url +
          `)" 
          id="` +
          divId +
          `" title="Add to Wishlist ">

              <button class="btn p-0 wishlist btn-wishlist ">
                  <i class="iconly-Heart icli"></i>
              </button>
             
          </a>`;
        console.log(html);

        if (data.currentPage == "product-detail.php") {
          console.log("product");
          var html1 =
            '<a class="wishlist" onclick="addToWishList(' +
            productId +
            ",this.id," +
            url +
            ')" id="' +
            divId +
            '" title="Add Wish List" class="wishlist"><i class="bx bx-heart"></i></a>';

          // $(".addWish").html(html1);
          $("." + divId).html(html);
        } else {
          $("#hotWish_" + productId).html(html);
          $("#topWish_" + productId).html(html);
          $("#newWish_" + productId).html(html);
          $("#bestWish_" + productId).html(html);
          // $("." + divId).html(html);
        }

        $(".wishList").load("wishlist.php" + " #updateWishlist");
        // $("#snackbar").html(data.result);

        title = "Success";
        msg = "Item Successfully removed from wishlist";
        type = "info";
        showAlert(title, msg, type);
      },
    });
  });
}

function addToCart(formId, classType) {
  console.log("adding...");
  formData = $("#" + formId).serialize() + "&action=" + "add";
  let actionUrl = "ajax/addToCart.php";
  console.log(formData);

  $.ajax({
    url: actionUrl,
    type: "POST",
    data: formData,
    // dataType: 'json',
    success: function (data) {
      // console.log(classType)
      data = JSON.parse(data);
      console.log(data);
      if (data.productId == "" || data.productId == 0) {
        $("#descrip").html("Please Select " + classType);
        $("#alertBox").addClass("show").show();
      } else {
        var divId = "'" + data.divId + "'";
        var className = "'" + classType + "'";

        var html =
          ` <button onclick="removeFromCart(` +
          data.productId +
          "," +
          divId +
          "," +
          className +
          `)" type="button" class="buy-button buy-button-2 btn ">
        <i class="fa-solid fa-trash"></i>
            </button>
            <a href ="javascript:void(0);" class="added_text">
            Added
        </a>`;

        if (data.currentPage == "index.php" || data.currentPage == "") {
          $("#hot_" + data.productId).html(html);
          $("#new_" + data.productId).html(html);
          $("#top_" + data.productId).html(html);
        } else {
          $("." + data.divId).html(html);
        }
        $(".cart-total").html(
          currency +
            data.cartSubTotalAmount +
            '<i class="fa fa-angle-down"></i></span>'
        );
        $(".cart-add").html(data.totalItemInCart);
        //please insert the url of the your current page here, we are assuming the url is 'index.php'
        var url = "cart_header.php";
        console.log(url + "#cartDiv");
        $(".mini_cart").load(url + "#cartDiv");
        // $('.mini_cart').load(url + ' #cartDiv1');
        // $('.mini_cart').load(url + ' #cartDiv2');
        // $('.mini_cart').load(url + ' #cartDiv3');
        // var x = document.getElementById("snackbar");
        // x.className = "show";
        // setTimeout(function () {
        //   x.className = x.className.replace("show", "");
        // }, 3000);

        title = "Success";
        msg = "Item Successfully added in cart";
        type = "info";
        showAlert(title, msg, type);
      }
    },
  });
}

// $(".addItemToCartModel").on("submit", function (e) {

//     e.preventDefault();

//     console.log("adding...");

// var formId=this.id;
// console.log(this.id);
//     formData = $("#"+formId).serialize() + "&action=" + "add";
//     let actionUrl = 'ajax/addToCart.php';
//      console.log(formData);
//     $.ajax({
//         url: actionUrl,
//         type: 'POST',
//         data: formData,
//         // dataType: 'json',
//         success: function (data) {
//             data = JSON.parse(data);
//             console.log(data);
//             if(data.productId=="")
//             {
//                 $('#descrip').html("Please Select Size");
//                  $('#alertBox').modal('show');

//             }
//             else
//             {
//             var divId="'"+data.divId+"'";
//             var html='<button class="button add-btn"  data-toggle="tooltip" title="Already Added" style="margin-right:0;">Already Added</button><span class="sicker"><i class="fa fa-trash" onclick="removeFromCart('+data.productId+','+divId+')"></i></span>';
//             if(currentPage=='index.php' || currentPage=="")
//             {
//             $('#hot_'+data.productId).html(html);
//             $('#new_'+data.productId).html(html);
//             $('#top_'+data.productId).html(html);
//             }
//             else
//             {
//             $('.'+data.divId).html(html);
//             }
//             $(".cart-total").html('<i class="fa fa-rupee"></i>' + data.cartSubTotalAmount + '<i class="fa fa-angle-down"></i></span>');
//             $(".cart-add").html(data.totalItemInCart);
//              //please insert the url of the your current page here, we are assuming the url is 'index.php'
//              var url = 'header.php';
//             $('.mini_cart').load(url+' #cartDiv');
//             var x = document.getElementById("snackbar");
//             x.className = "show";
//             setTimeout(function () { x.className = x.className.replace("show", ""); }, 3000);
//            }

//         }

//     })

// });

/////////// Set Model Product Cart ID Value ///////////
function setModelProductId(id, div, type, classType) {
  console.log(type);
  console.log("addToCart" + div);
  console.log(id);
  $.ajax({
    url: "ajax/checkIsCart.php",
    type: "POST",
    data: { productId: id },
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);
      if (!data.isCart) {
        var formId1 = "'addCart_" + div + "'";
        var className = "'" + classType + "'";
        var html = "";
        //   if (type != "") {
        //     html += '<div id="' + type + "_" + id + '" class="mycartbtndiv">';
        //   }
        //   html +=
        //     '<a class="cart-text"  type="submit" data-toggle="tooltip" title="Add To Cart" onclick="addToCart(' +
        //     formId1 +
        //     "," +
        //     className +
        //     ')">Add To Cart</a><i class="bx bx-cart"></i>';

        //   if (type != "") {
        //     html += "</div>";
        //   }
        //   $(".addToCart" + div).html(html);
        // } else {
        //   var divId = "'addToCart" + div + "'";
        //   var className = "'" + classType + "'";

        //   var html = "";
        //   if (type != "") {
        //     html += '<div id="' + type + "_" + id + '" class="mycartbtndiv">';
        //   }
        //   html +=
        //     '<a class="cart-text"  data-toggle="tooltip" title="Already Added" style="margin-right:0;">Already Added</a><i class="bx bx-cart"></i><span class="sicker mytrash"><i class="fa fa-trash" onclick="removeFromCart(' +
        //     id +
        //     "," +
        //     divId +
        //     "," +
        //     className +
        //     ')"></i></span>';
        //   if (type != "") {
        //     html += "</div>";
        //   }
        //   $(".addToCart" + div).html(html);
      }
    },
  });
  $("#modelProductId" + div).val(id);
}
/////////// Set Model Product Cart ID Value ///////////

// Remove Cart
function removeFromCart(productId, buttonClass, classType) {
  $("#confirmModal").addClass("show");
  confirmDialog("Are You sure! You want to remove?", function () {
    actionUrl = "ajax/addToCart.php";
    $.ajax({
      url: actionUrl,
      type: "POST",
      data: { action: "remove", productId: productId },
      // dataType: 'json',
      success: function (data) {
        data = JSON.parse(data);
        console.log(data);
        $(".cart-total").html(
          currency +
            data.cartSubTotalAmount +
            '<i class="fa fa-angle-down"></i></span>'
        );
        $(".cart-add").html(data.totalItemInCart);

        var url = "cart_header.php";
        console.log(url + "#cartDiv");
        $(".mini_cart").load(url + "#cartDiv");

        var url = "cart.php";
        $(".cartPage").load(url + " #cartTable");

        // var url = "header.php"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
        // $(".mini_cart").load(url + " #cartDiv");
        // var url = "cart.php"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
        // $(".cartPage").load(url + " #resetCart");

        if (buttonClass != "") var formId = buttonClass.split("addToCart")[1];
        var formId1 = "'addCart_" + formId + "'";
        var className = "'" + classType + "'";

        console.log(formId1);
        console.log(className);

        var html =
          `
<a class="cart-text" href="javascript:void(0);">

    <button onclick="addToCart(` +
          formId1 +
          "," +
          className +
          `);" type="button" class="buy-button buy-button-2 btn ">
        <i class="iconly-Buy icli text-white m-0"></i>
    </button>

</a>
`;
        if (
          data.currentPage == "index.php" ||
          data.currentPage == "" ||
          data.currentPage == null
        ) {
          $("#new_" + data.productId).html(html);
          $("#hot_" + data.productId).html(html);
          $("#top_" + data.productId).html(html);
        } else {
          $("." + buttonClass).html(html);
        }

        title = "Success";
        msg = "Item Successfully removed from cart";
        type = "info";
        showAlert(title, msg, type);

        // }
      },
    });
  });
}

$(".closealrtthis").on("click", function () {
  $("#alertBox").removeClass("show");
});
//confirmBox

function confirmDialog(message, onConfirm) {
  var fClose = function () {
    $("#confirmModal").hide();
  };
  $("#confirmMessage").empty().append(message);
  $("#confirmModal").show();

  $("#confirmOk").unbind().one("click", onConfirm).one("click", fClose);
  $("#confirmCancel").unbind().one("click", fClose);
}
//search

/////// Product Search Functions ////////
// function searchbar(str) {
//   var xhttp = new XMLHttpRequest();
//   // document.getElementById("autocomplete").style.display = 'block';
//   xhttp.onreadystatechange = function () {
//     if (this.readyState == 4 && this.status == 200) {
//       document.getElementById("autocomplete").style.display = "block";
//       document.getElementById("autocomplete").innerHTML = this.responseText;
//     }
//   };
//   xhttp.open("GET", "ajax/search.php?sid=" + str, true);
//   xhttp.send();
// }

// jquery searchbar function
$(document).ready(function ($) {
  $("#search").keyup(function (e) {
    var key = e.keyCode;
    if (key == 40 || key == 38 || key == 13) {
      return false;
    }
    var str = $("#search").val();
    $.ajax({
      context: this,
      url: "ajax/search.php",
      type: "get",
      dataType: "html",
      data: "sid=" + str,
    }).done(function (response) {
      $("#autocomplete").html(response);
      $("#autocomplete").show();
    });
  });
});

// select suggested results using key up and down
$("#productSearch").on("keydown", "#search", function (e) {
  var listItems = $(".autocomplete a");
  var key = e.keyCode,
    selected = listItems.filter(".selected"),
    current;

  if (key != 40 && key != 38 && key != 13) return;

  if (key == 40) {
    // Down key
    listItems.removeClass("selected");
    if (!selected.length || selected.is(":last-child")) {
      current = listItems.eq(0);
    } else {
      current = selected.next();
    }
    // console.log("Current : " + current);
  } else if (key == 38) {
    // Up key
    listItems.removeClass("selected");
    if (!selected.length || selected.is(":first-child")) {
      current = listItems.last();
    } else {
      current = selected.prev();
    }
  } else if (key == 13) {
    // Enter key
    current = listItems.filter(".selected");
    current[0].click();
    return false;
  }
  current.addClass("selected");
  // console.log(current);
  //    $('a.selected').scrollIntoView();
  $(".selected")[0].scrollIntoView({
    block: "end",
  });
});

function hidesearchdiv() {
  var x = document.getElementById("autocomplete");
  // var x = document.getElementById("autocomplete1");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function hidesearchdiva() {
  var x = document.getElementById("autocomplete");
  // var x = document.getElementById("autocomplete1");

  x.style.display = "block";
}

// for mobile
function searchbar1(str) {
  var xhttp = new XMLHttpRequest();
  // document.getElementById("autocomplete11").style.display = 'block';
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("autocomplete11").style.display = "block";
      document.getElementById("autocomplete11").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "ajax/search.php?sid=" + str, true);
  xhttp.send();
}

function hidesearchdiv1() {
  var x = document.getElementById("autocomplete11");
  // var x = document.getElementById("autocomplete1");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

function hidesearchdiva1() {
  var x = document.getElementById("autocomplete11");
  // var x = document.getElementById("autocomplete1");

  x.style.display = "block";
}
/////// Product Search Functions ////////

//Fetch Price Range
/*----------------------------
    slider-range here
------------------------------ */

function getVals() {
  // Get slider values
  let parent = this.parentNode;
  let slides = parent.getElementsByTagName("input");
  let slide1 = parseFloat(slides[0].value);
  let slide2 = parseFloat(slides[1].value);
  // Neither slider will clip the other, so make sure we determine which is larger
  if (slide1 > slide2) {
    let tmp = slide2;
    slide2 = slide1;
    slide1 = tmp;
  }

  let displayElement = parent.getElementsByClassName("rangeValues")[0];
  displayElement.innerHTML = "₹" + slide1 + " - ₹" + slide2;

  var minPrice = slide1;
  var maxPrice = slide2;
  var pageNo = 1;
  var actionUrl = "record-process/listing-products.php";
  // var formData = $(this).serialize();
  // console.log(formData);
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: {
      priceRange: "priceRange",
      maxPrice: maxPrice,
      minPrice: minPrice,
      pageNo: pageNo,
    },
    // dataType: 'json',
    success: function (data) {
      data = JSON.parse(data);

      console.log(data);
      var url = "listing.php"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
      $(".changeFilter").load(url + " #filterProductId");
      $("#currentPage").val(pageNo);
      // $("#listingProducts").html(data.result);
      $("#totalPages").val(data.totalPages);
      $("#totalProducts").html(data.totalProducts);
      $("#recordFrom").html(data.recordFrom);
      $("#recordTo").html(data.recordTo);
      paginationBlocks(pageNo);
    },
  });
}

window.onload = function () {
  // Initialize Sliders
  let sliderSections = document.getElementsByClassName("range-slider");
  for (let x = 0; x < sliderSections.length; x++) {
    let sliders = sliderSections[x].getElementsByTagName("input");
    for (let y = 0; y < sliders.length; y++) {
      if (sliders[y].type === "range") {
        sliders[y].oninput = getVals;
        // Manually trigger event first time to display values
        sliders[y].oninput();
      }
    }
  }
};
/*----------------------------
    slider-range here
------------------------------ */

//////////// Order BY Listing Products /////////////
function orderBy(val) {
  pageNo = 1;
  console.log(val);
  actionUrl = "record-process/listing-products.php";
  // formData = $(this).serialize();
  console.log("formData");
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: { orderByVal: val, pageNo: pageNo },
    // dataType: 'json',
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);
      var url = "listing.php"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
      $(".changeFilter").load(url + " #filterProductId");
      $("#currentPage").val(pageNo);
      // $("#listingProducts").html(data.result);
      $("#totalPages").val(data.totalPages);
      $("#totalProducts").html(data.totalProducts);
      $("#recordFrom").html(data.recordFrom);
      $("#recordTo").html(data.recordTo);
      paginationBlocks(pageNo);
    },
  });
}
//////////// Order BY Listing Products /////////////

//Fetch filter Producta
//////////// Filter Listing Products /////////////
function checkboxFilter(element, type, classtypeId) {
  pageNo = 1;
  condition = element.value;
  if (element.checked) {
    action = "addFilter";
  } else {
    action = "removeFilter";
  }

  console.log(condition);
  console.log(classtypeId);

  $.ajax({
    url: "record-process/listing-products.php",
    type: "POST",
    data: {
      action: action,
      type: type,
      condition: condition,
      pageNo: pageNo,
      classtypeId: classtypeId,
    },
    // dataType: 'json',
    success: function (data) {
      // alert(data);
      data = JSON.parse(data);
      console.log(data);
      $("#currentPage").val(pageNo);
      // $("#listingProducts").html(data.result);
      $("#totalPages").val(data.totalPages);
      $("#totalProducts").html(data.totalProducts);
      $("#recordFrom").html(data.recordFrom);
      $("#recordTo").html(data.recordTo);
      var url = "listing.php"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
      $(".changeFilter").load(url + " #filterProductId");
      $(".filterSlider").load(url + " #refreshSlider");
      paginationBlocks(pageNo);
    },
  });
}
//////////// Filter Listing Products /////////////

//Fetch pagination
////////// Pagination //////////
function paginationBlocks(block) {
  var list = "";
  var totalPage = $("#totalPages").val();
  var currentPage = $("#currentPage").val();

  // totalPage=10;
  // block=3

  if (totalPage < 6) {
    block = 3;
  }
  block = parseInt(block);
  block_2 = block - 2;
  block_1 = block - 1;
  block1 = block + 1;
  block2 = block + 2;

  if (totalPage > 5) {
    if (block > 3) {
      list += "<li";
      list += ' class="previous" onclick="paginationBlocks(' + block_1 + ')"';
      list += "><a><<</a></li>";
    }

    if (block != 1) {
      if (block != 2) {
        list += "<li";
        list +=
          block_2 == currentPage
            ? ' class="current"'
            : ' onclick="loadPage(' + block_2 + ')"';
        list += "><a>" + block_2 + "</a></li>";
      }

      list += "<li";
      list +=
        block_1 == currentPage
          ? ' class="current"'
          : ' onclick="loadPage(' + block_1 + ')"';
      list += "><a>" + block_1 + "</a></li>";
    }

    list += "<li";
    list +=
      block == currentPage
        ? ' class="current"'
        : ' onclick="loadPage(' + block + ')"';
    list += "><a>" + block + "</a></li>";

    if (block != totalPage) {
      list += "<li";
      list +=
        block1 == currentPage
          ? ' class="current"'
          : ' onclick="loadPage(' + block1 + ')"';
      list += "><a>" + block1 + "</a></li>";l

      if (block + 1 != totalPage) {
        list += "<li";
        list +=
          block2 == currentPage
            ? ' class="current"'
            : ' onclick="loadPage(' + block2 + ')"';
        list += "><a>" + block2 + "</a></li>";
      }
    }

    if (block + 2 < totalPage) {
      list += "<li";
      list += ' class="next" onclick="paginationBlocks(' + block1 + ')"';
      list += "><a>>></a></li>";
    }
  } else {
    for (i = 1; i <= totalPage; i++) {
      list += "<li";
      list +=
        i == currentPage
          ? ' class="current"'
          : ' onclick="loadPage(' + i + ')"';
      list += "><a>" + i + "</a></li>";
    }
  }

  $("#pagination-blocks").html(list);
}

function loadPage(pageNo) {
  console.log(pageNo);
  let actionUrl = "record-process/listing-products.php";
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: { pageNo: pageNo },
    success: function (data) {
      console.log(data);
      data = JSON.parse(data);
      $("#currentPage").val(pageNo);
      // $("#listingProducts").html(data.result);
      $("#totalPages").val(data.totalPages);
      $("#totalProducts").html(data.totalProducts);
      $("#recordFrom").html(data.recordFrom);
      $("#recordTo").html(data.recordTo);
      var url = "listing.php"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
      $(".changeFilter").load(url + " #filterProductId");
      $(".filterSlider").load(url + " #refreshSlider");
      paginationBlocks(pageNo);
    },
  });
}

$(document).ready(function () {
  paginationBlocks(3);
});

/////////// Set Product Cart ID Value ///////////
function setCartId(id) {
  $("#cartProductId").val(id);
}
/////////// Set Product Cart ID Value ///////////

/////////// Get Product By ID Value ///////////
function getProductById() {
  // console.log(randomString(15));
  productId = $("#cartProductId").val();
//   window.location.href =
//     "product-detail.php?" +
//     randomString(20) +
//     "=" +
//     randomString(20) +
//     "&product_id=" +
//     productId +
//     "&" +
//     randomString(20) +
//     "=" +
//     randomString(20);
}
/////////// Set Product Cart ID Value ///////////

//Submit Review
$("#addReview").on("submit", function (e) {
  e.preventDefault();

  var productId = $("#reviewProductId").val();
  var formData = new FormData(this);

  let actionUrl = "ajax/add-review.php";
  console.log(formData);
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    cache: false,
    // dataType: 'json',
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);

      if (data.status == "logInErr") {
        window.location.href =
          "account.php?" +
          randomString(20) +
          "=" +
          randomString(20) +
          "&url=" +
          data.url +
          "&" +
          randomString(20) +
          "=" +
          randomString(20);
      } else {
        var url = data.url; //please insert the url of the your current page here, we are assuming the url is 'index.php'
        $(".reviewDiv").load(url + " #setReview");
        $("#addReview")[0].reset();
        $("#snackbar").html(data.result);
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function () {
          x.className = x.className.replace("show", "");
        }, 3000);
        //  }
        $("#review_comment").val("");
      }
    },
  });
});

// ////////// Get Reviews Products ////////////
// function getReviews(productId) {

//     console.log(productId);
//     let actionUrl = 'record-process/get-reviews.php';
//     $.ajax({
//         url: actionUrl,
//         type: 'POST',
//         data: { productId: productId },
//         success: function (data) {
//             //  console.log(data);
//             $("#reviewsDiv").html(data);
//         }
//     })
// }
// ////////// Get Reviews Products ////////////

$(".addProductToCart").on("submit", function (e) {
  e.preventDefault();

  console.log("adding...");

  var fromId = this.id;

  formData = $("#" + fromId).serialize() + "&action=" + "add";
  console.log(formData);

  let actionUrl = "ajax/addToCart.php";
  console.log("formData");
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: formData,
    // dataType: 'json',
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);

      $("#" + fromId + "Button").html("Already Added");
      $(".cart-total").html(
        currency +
          data.cartSubTotalAmount +
          '<i class="fa fa-angle-down"></i></span>'
      );
      $(".cart-add").html(data.totalItemInCart);
      var url = "header.php"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
      $(".mini_cart").load(url + " #cartDiv");
      var x = document.getElementById("snackbar");
      x.className = "show";
      setTimeout(function () {
        x.className = x.className.replace("show", "");
      }, 3000);
    },
  });
});

// Change cart quantity
/////////// On Change Item Quantity ///////////////
function changeItemQuantity(productId, quantity, size) {
  // console.log(productId);
  console.log(quantity);
  divId = "";
  let actionUrl = "ajax/addToCart.php";
  // console.log('formData');
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: {
      action: "add",
      productId: productId,
      quantity: quantity,
      productSize: size,
    },
    // dataType: 'json',
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);
      var url = "cart.php"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
      $("#productsTableInner").load(url + " #productsTable");

      $(".cart-total").html(
        currency +
          data.cartSubTotalAmount +
          '<i class="fa fa-angle-down"></i></span>'
      );
      $(".cart-add").html(data.totalItemInCart);
      var url = "cart_header.php"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
      $(".mini_cart").load(url);
      var x = document.getElementById("snackbar");
      x.className = "show";
      setTimeout(function () {
        x.className = x.className.replace("show", "");
      }, 3000);
    },
  });
}
/////////// On Change Item Quantity ///////////////

///////// Clear Cart //////////
function clearCart() {
  confirmDialog("Are You sure! You want to clear cart?", function () {
    let actionUrl = "ajax/clearCart.php";
    $.ajax({
      url: actionUrl,

      success: function (data) {
        data = JSON.parse(data);

        console.log(data);
        var url = "cart.php"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
        $(".cartPage").load(url + " #resetCart");

        // $(".cart-total").html('<i class="fa fa-rupee"></i>' + data.cartSubTotalAmount + '<i class="fa fa-angle-down"></i></span>');
        // $(".cart-add").html(data.totalItemInCart);
        var url1 = "header.php"; //please insert the url of the your current page here, we are assuming the url is 'index.php'
        $(".mini_cart").load(url1 + " #cartDiv");
        $("#snackbarDefault").html(data.result);
        var x = document.getElementById("snackbarDefault");
        x.className = "show";
        setTimeout(function () {
          x.className = x.className.replace("show", "");
        }, 3000);
      },
    });
  });
}
///////// Clear Cart //////////

//input validation For registration

$("input").keyup(function () {
  $("#" + this.name + "ErrMsg").html(
    "<div class='err_msg' id='" + this.name + "ErrMsg'></div>"
  );
});

$(".phone").on("keyup", function (e) {
  var phno = $(this).val();
  var regexPattern = /^[0-9]+$/; // regular expression pattern
  $text = regexPattern.test(phno);
  if (!$text || phno.length < 10) {
    $("#" + this.id + "ErrMsg").html(
      "<div class='err_msg' id='" +
        this.id +
        "ErrMsg'>Please Enter only 10 digit number</div>"
    );
    $(".userRegBtn").hide();
  } else {
    $(".userRegBtn").show();
  }
});

$(".password").on("keyup", function (e) {
  $(this).prop("type", "password");
  var value = $(this).val();
  if (value != "") {
    var regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,15}$/;
    var isValid = regex.test(value);
    if (!isValid) {
      $(".userRegBtn").hide();
      $("#" + this.id + "ErrMsg").html(
        "<div class='err_msg' id='" +
          this.id +
          "ErrMsg'>Password must between 6 to 15 characters which contain at least one numeric digit, one uppercase and one lowercase letter</div>"
      );
    } else {
      $(".userRegBtn").show();
    }
  }
});

$(".password").on("keyup", function (e) {
  confirmPasswordValidationFn();
});

$(".confirmPassword").on("keyup", function (e) {
  confirmPasswordValidationFn();
});
////////// Confirm Password Validation //////////
function confirmPasswordValidationFn() {
  // function START
  let password = $(".password").val();
  let rePassword = $(".confirmPassword").val();
  if (rePassword != "") {
    if (password == rePassword) {
      $("#confirmNewPasswordErrMsg").html(
        '<span class="err_msg" id="confirmNewPasswordErrMsg"></span>'
      );
    } else {
      $("#confirmNewPasswordErrMsg").html(
        '<div class="err_msg" id="confirmNewPasswordErrMsg" style="color: tomato;">Password and confirm password fields do not match</div>'
      );
    }
  }
} // function END

//Login/Register Submit from
//Edit Profile
//Change Password
var spinner = $("#loader");
$(".formSubmit").on("submit", function (e) {
  // alert("hi");
  console.log("FormSubmit");
  var fromId = this.id;
  e.preventDefault();
  spinner.show();
  actionUrl = "ajax/user.php";
  formData = $("#" + fromId).serialize();
  console.log(formData);
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: formData,
    // dataType: 'json',
    success: function (data) {
      spinner.hide();
      data = JSON.parse(data);
      console.log(data);
      if (data.status == "failed") {
        //console.log('saasd');
        for (var key in data.errMessage) {
          $("#" + key + "ErrMsg").html(
            "<div class='err_msg' id='" +
              key +
              "ErrMsg'>" +
              data.errMessage[key] +
              "</div>"
          );
          console.log(key);
        }

        title = "Oops!";
        msg = data.result;
        type = "info";
        showAlert(title, msg, type);
      } else {
        color = data.status == "formMsg" ? "#f00" : "#008000";
        $("#" + fromId + "Msg").html(
          "<div style='color:" +
            color +
            ";' id='" +
            fromId +
            "Msg'>" +
            data.result +
            "</div>"
        );

        if (data.status == "registered" || data.status == "notVerified") {
          $(".account1").hide();
          $("#userInfo").val(data.mobileNumber);
          $("#checkout-login").attr("style", "display:none");
          $("#checkout_signup").attr("style", "display:none");
          $(".otpVerify").attr("style", "display:block");
          timer(60);

          // $('#checkout_login').hide();
          // $('#checkout_signup').hide();
        }

        if (data.status == "otpSent") {
          $("#userInfo").val(data.mobileNumber);
          $(".otpVerify").css("display", "block");
          timer(60);
          $("html, body").animate(
            {
              scrollTop: $(".otpVerify").offset().top,
            },
            1000
          );
        }
        if (data.status == "logIn") {
          if (data.url == "reload") {
            location.reload();
          } else {
            window.location.href = data.url;
          }
        }
        title = "";
        msg = data.result;
        type = "info";
        showAlert(title, msg, type);

        // alert(data.result);
        // $("#snackbarDefault").html(data.result);
        // var x = document.getElementById("snackbarDefault");
        // x.className = "show";
        // setTimeout(function () {
        //   x.className = x.className.replace("show", "");
        // }, 3000);
      }
    },
  });
});

///////// Update Address Book //////////
function updateAddressBook() {
  console.log("asasas");

  let actionUrl = "record-process/address-book.php";
  $.ajax({
    url: actionUrl,

    success: function (data) {
      console.log(data);
      $("#shippingAddresses").html(data);
    },
  });
}
///////// Update Address Book //////////

////////// Timer Count Down ////////////
let timerOn = true;

function timer(remaining) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;

  m = m < 10 ? "0" + m : m;
  s = s < 10 ? "0" + s : s;
  document.getElementById("timer").innerHTML = m + ":" + s;
  remaining -= 1;

  if (remaining >= 0 && timerOn) {
    setTimeout(function () {
      timer(remaining);
    }, 1000);
    return;
  }

  if (!timerOn) {
    // Do validate stuff here
    return;
  }

  // Do timeout stuff here

  $("#timer").html('<a onClick="resendOTP();">Resend OTP</a>');
}
////////// Timer Count Down ////////////

$("#verifyOtpForm").on("submit", function (e) {
  e.preventDefault();
  actionUrl = "ajax/verify-otp.php";
  formData = $("#verifyOtpForm").serialize();
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: formData,
    // dataType: 'json',
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);

      color = data.status == "failed" ? "#f00" : "#008000";
      $("#verifyOtpFormMsg").html(
        "<div style='color:" +
          color +
          ";' id='verifyOtpFormMsg'>" +
          data.message +
          "</div>"
      );

      // $('#verifyOtpForm')[0].reset();

      $(".codeBox").val("");

      if (data.message == "") {
        data.message = "Error Occur please try again!";
      }

      // $("#snackbarDefault").html(data.message);
      // var x = document.getElementById("snackbarDefault");
      // x.className = "show";
      // setTimeout(function () {
      //   x.className = x.className.replace("show", "");
      // }, 3000);

      title = "";
      msg = data.message;
      type = "info";
      showAlert(title, msg, type);

      if (data.status == "success") {
        $(".account1").show();
        $(".otpVerify").hide();
        $("#modal-checkout").hide();
        if (data.redirect == 1) {
          setTimeout(() => {
            window.location.href = data.url;
          }, 1000);
        } else {
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        }
      }
    },
  });
});

function resendOTP() {
  userInfo = $("#userInfo").val();
  let actionUrl = "ajax/re-send-otp.php";
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: { userInfo: userInfo },
    success: function (data) {
      timer(60);
      $("#verifyOtpForm").reset();
    },
  });
}

$("#coupanForm").on("submit", function (e) {
  e.preventDefault();
  actionUrl = "ajax/apply-coupan.php";
  formData = $("#coupanForm").serialize();
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: formData,
    // dataType: 'json',
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);

      // for(var key in data.errMessage){
      color = data.status == "failed" ? "#f00" : "#008000";
      $("#ErrMsg").html(
        "<div class='err_msg' style='color:" +
          color +
          ";' id='formMsg'>" +
          data.message +
          "</div>"
      );

      // }

      if (data.status == "success") {
        $(".coupanCodeInput").prop("readonly", true);
        $("#coupanCodeButton").prop("disabled", true);
        $("#coupanAppliedDiv").show();
        $("#coupanAppliedDiv").html(
          "Coupon Applied <b>(Save)</b> <span>- " +
            currency +
            data.savePrice +
            "</span>"
        );
        $("#totalAmount").html(currency + data.totalPrice);
      }
    },
  });
});

// temperary data session

$("#loginbtnmdl").on("click", function (e) {
  e.preventDefault();
  actionUrl = "ajax/temp_data.php";
  formData = $("#placeOrder,#addressDetailsForm,#coupanForm").serialize();
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: formData,
    // dataType: 'json',
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);
    },
  });
});
// payment method
$("input[name=paymentmethod]").on("change", function () {
  console.log("changed");
  var payMethod = $(this).val();
  $("#paymentMethodInp").val(payMethod);
});

$("#paySubmitButton").on("click", function () {
  $("#pymentMethodForm").submit();
});

//Order Placed
$(document).on("submit", "#pymentMethodForm", function (e) {
  e.preventDefault();
  console.log("submit");
  // if($('#paymentMethodInp').val() == 'payWithPaytm')
  // {
  //     $("#placeOrder").attr('action', 'ajax/checkout-cb-2.php');
  //     $("#addressDetailsForm").attr('action', 'ajax/checkout-cb-2.php');
  //     $("#coupanForm").attr('action', 'ajax/checkout-cb-2.php');

  //     $("#coupanForm").submit();
  //     $("#addressDetailsForm").submit();
  // }
  // else{
  // alert("hiii");

  $("#paySubmitButton").attr("disabled", true);
  actionUrl = "ajax/checkout-cb.php";
  formData = $(
    "#placeOrder,#addressDetailsForm,#coupanForm,#pymentMethodForm"
  ).serialize();
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: formData,
    // dataType: 'json',
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);

      if (data.status == "inputErr") {
        for (var key in data.errMessage) {
          if (key == "newBillingAddressType") {
            title = "";
            msg = data.errMessage[key];
            type = "info";
            showAlert(title, msg, type);
          } else {
            $("#" + key + "ErrMsg").html(
              "<div class='err_msg' id='" +
                key +
                "ErrMsg'>" +
                data.errMessage[key] +
                "</div>"
            );
          }
        }
      } else if (data.status == "failed") {
        title = "";
        msg = data.result;
        type = "info";
        showAlert(title, msg, type);
      } else {
        if (data.status == "cod") {
          title = "Success";
          msg = data.result;
          type = "info";
          showAlert(title, msg, type);

          setTimeout(() => {
            window.location.href =
            "order-success.php?" +
            randomString(20) +
            "=" +
            randomString(20) +
            "&id=" +
            data.orderId +
            "&" +
            randomString(20) +
            "=" +
            randomString(20);
          }, 1000);
          
        } else if (data.status == "CCGateway") {
          // console.log('here'); return false;

          var orderPrice = data["order_details"]["orderprice"];
          var orderId = data["order_details"]["order_id"];
          var currency = data["order_details"]["order_id"];
          console.log(data);
          merchant_id = "913702";
          document.body.innerHTML = `<form method="post" action="./ccavenue/ccavRequestHandler.php" name="f1">
         
         <input type="hidden" name="tid" id="tid" value="${orderId}" />
         <input type="hidden" name="order_id" id="order_id" value="${orderId}"/>
         <input  type="hidden" name="merchant_id" value="${merchant_id}"/>
         <input type="hidden" name="amount" value="${orderPrice}">
         <input type="hidden" name="currency" value="INR">
         <input type="hidden" name="language" value="EN"/>

         <input type="hidden" title="62344" name="redirect_url" value="http://localhost/blantic/order-success.php"/>
         <input type="hidden" name="cancel_url" value="http://localhost/blantic/order-success.php"/>
                   </form>`;
          document.f1.submit();
        }

   

        // $("#snackbarDefault").html(data.result);
        // var x = document.getElementById("snackbarDefault");
        // x.className = "show";
        // setTimeout(function () {
        //   x.className = x.className.replace("show", "");
        // }, 3000);
      }

      $("#paySubmitButton").attr("disabled", false);
    },
  });

  // }
});

function loginWithOtp() {
  mobileNumber = $("#logInMobileNumber").val();
  if (mobileNumber != "") {
    $("#logInPassword").val("LogInWithOTP");
    $("#lg_btn").click();
  } else {
    $("#logInMobileNumberErrMsg").html("Please Enter Mobile Number!");
  }
}

//address
function removeAddress(addressId) {
  confirmDialog("Are You sure! You want to remove?", function () {
    // var x = confirm('Are you sure?');
    // if (x == true) {
    // $("#confirmModal").modal('hide');
    actionUrl = "ajax/address.php";
    console.log("formData");
    $.ajax({
      url: actionUrl,
      type: "POST",
      data: { action: "remove", addressId: addressId },
      // dataType: 'json',
      success: function (data) {
        data = JSON.parse(data);
        console.log(data);
        $("#snackbarDefault").html(data.result);
        var x = document.getElementById("snackbarDefault");
        x.className = "show";
        setTimeout(function () {
          x.className = x.className.replace("show", "");
        }, 3000);
        $(".myaccount-address").load("dashboard.php  #changeAddress");
        //updateAddressBook();
      },
    });
  });
}

function editAddress(addressId) {
  actionUrl = "ajax/address.php";

  $.ajax({
    url: actionUrl,
    type: "POST",
    data: { action: "edit", addressId: addressId },
    // dataType: 'json',
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);
      $("#new_address_form").attr("style", "display:block");
      $("#shippingAddress").val("edit");
      $("#shippingAddressId").val(data.id);
      $("#newAddressType").val(data.type);
      $("#newAddressFirstName").val(data.firstName);
      $("#newAddressLastName").val(data.lastName);
      $("#newAddressFlat").val(data.flat);
      $("#newAddressStreet").val(data.street);
      $("#newAddressLocality").val(data.locality);
      // $('#newAddressCountry option[value="'+data.country+'"]');
      // $('#newAddressState option[value="'+data.state+'"]').select();
      // $('#id option[value=theOptionValue]').prop('selected', 'selected').change();
      // $('#newAddressState option[value='+data.state+']').prop("selected", "selected").change();
      // $("#newAddressCountry").val(data.country);
      // $('#meetingDay').val('no-data');
      // $('#meetingDay').trigger('change');

      $("#newAddressState").val(data.state);
      $("#newAddressState").trigger("change");
      $("#newAddressCity").val(data.city);
      $("#newAddressZipCode").val(data.zipCode);
      $("#newAddressMobile").val(data.phone);
      $("#newAddressEmail").val(data.email);

      //$("#addNewAddressButton").click();
    },
  });
}

$("#new_address_form").on("submit", function (e) {
  e.preventDefault();
  actionUrl = "ajax/user.php";
  formData = $("#new_address_form").serialize();
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: formData,
    // dataType: 'json',
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);
      if (data.status == "failed") {
        for (var key in data.errMessage) {
          $("#" + key + "ErrMsg").html(
            "<div class='err_msg' id='" +
              key +
              "ErrMsg'>" +
              data.errMessage[key] +
              "</div>"
          );
          console.log(key);
        }
      } else {
        color = data.status == "formMsg" ? "#f00" : "#008000";
        $("#new_address_formMsg").html(
          "<div style='color:" +
            color +
            ";' id='new_address_formMsg'>" +
            data.result +
            "</div>"
        );

        $("#snackbarDefault").html(data.result);
        var x = document.getElementById("snackbarDefault");
        x.className = "show";
        setTimeout(function () {
          x.className = x.className.replace("show", "");
        }, 3000);
        $(".myaccount-address").load("dashboard.php  #changeAddress");

        $("#contactFormSubmit")[0].reset();
        if (data.status == "success") {
          $("#new_address_form").attr("style", "display:none");
        }
      }
    },
  });
});

$("#cancelOrder").on("submit", function (e) {
  e.preventDefault();

  confirmDialog("Are You sure! You want to cancel order?", function () {
    actionUrl = "ajax/cancel-order.php";
    formData = $("#cancelOrder").serialize();
    $.ajax({
      url: actionUrl,
      type: "POST",
      data: formData,
      // dataType: 'json',
      success: function (data) {
        data = JSON.parse(data);
        console.log(data);

        location.reload();
      },
    });
  });
});
////////// Cancel Order ///////////

//Contact Form Submit

$("#contactFormSubmit").on("submit", function (e) {
  e.preventDefault();
  actionUrl = "ajax/contact-form.php";
  formData = $(this).serialize();

  $.ajax({
    url: actionUrl,
    type: "POST",
    data: formData,
    // dataType: 'json',
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);
      if (data.status == "inputErr") {
        for (var key in data.errMessage) {
          $("#" + key + "ErrMsg").html(
            "<div class='err_msg' id='" +
              key +
              "ErrMsg'>" +
              data.errMessage[key] +
              "</div>"
          );
        }
      } else {
        $("#snackbarDefault").html(data.result);
        var x = document.getElementById("snackbarDefault");
        x.className = "show";
        setTimeout(function () {
          x.className = x.className.replace("show", "");
        }, 3000);
        $("#contactFormSubmit")[0].reset();
      }
    },
  });
});

//For subscribe
$("#subscribeForm").on("submit", function (e) {
  e.preventDefault();

  formData = $(this).serialize();

  let actionUrl = "ajax/add-subscribe.php";
  console.log("formData");
  $.ajax({
    url: actionUrl,
    type: "POST",
    data: formData,
    success: function (data) {
      data = JSON.parse(data);
      console.log(data);

      $("#snackbar").html(data.result);
      var x = document.getElementById("snackbar");
      x.className = "show";
      setTimeout(function () {
        x.className = x.className.replace("show", "");
      }, 3000);
      //  }
      $("#mc-email").val("");
    },
  });
});

$(document).on("click", "#closeModal", function () {
  console.log("fajks");
  $("#alertBox").removeClass("show");
  $("#alertBox").hide();
});
