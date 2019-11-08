function enableInput(e) {
  $("*[aria-describedby='" + e.id + "']").attr("disabled", false).focus()
}

function handleImageChange(_this) {
  //set file name to texbox
  $("#viewproductimageref").val(_this.files[0].name)
  //preview image
  var reader = new FileReader();

  reader.onload = function () {
    $("#productimagepreview").attr("src", reader.result)
  }
  reader.readAsDataURL(_this.files[0])
  $("#productimageedit").attr("disabled", false)
}

function updateField(data, callback) {
  $.ajax("viewproduct.php", {
    method: "POST",
    data: data
  })
    .then(function (res) {
      callback(res)
    })
    .catch(function (err) {
      console.error(err)
      $("body").showAlert({
        type: "warning",
        body: "Something happened on our side. Please reload your browser for better experience"
      })
    })
}

jQuery(function () {

  //update productname
  $("#viewproductname").on("blur", function (e) {
    if (!$(e.target).val()) return $(e.target).val(_defaultvalues["name"])
    if ($(e.target).val() == _defaultvalues["name"]) return
    $(e.target).attr("disabled", true)
    updateField({
      PName: $(e.target).val(),
      ProductId: $("#productid").val()
    }, function (res) {
      console.log(res)
      var json = JSON.parse(res)
      if (json.response) {
        $("body").showAlert({
          type: "success",
          body: "Name updated."
        })
      }

      $(e.target).val(_defaultvalues["name"])
    })
  })

  //update brand
  $("#viewproductbrand").on("blur", function (e) {
    if (!$(e.target).val()) return $(e.target).val(_defaultvalues["brand"])
    if ($(e.target).val() == _defaultvalues["brand"]) return
    $(e.target).attr("disabled", true)
    updateField({
      PBrand: $(e.target).val(),
      ProductId: $("#productid").val()
    }, function (res) {
      var json = JSON.parse(res)
      if (json.response) {
        return $("body").showAlert({
          type: "success",
          body: "Brand updated."
        })
      }

      $(e.target).val(_defaultvalues["brand"])
    })
  })

  //update quantity
  $("#viewproductquantity").on("blur", function (e) {
    if (!$(e.target).val()) return $(e.target).val(_defaultvalues["quantity"])
    if ($(e.target).val() == _defaultvalues["quantity"]) return
    $(e.target).attr("disabled", true)
    updateField({
      PQuantity: $(e.target).val(),
      ProductId: $("#productid").val()
    }, function (res) {
      var json = JSON.parse(res)
      if (json.response) {
        return $("body").showAlert({
          type: "success",
          body: "Quantity updated."
        })
      }

      $(e.target).val(_defaultvalues["brand"])
    })
  })


  //update quantity
  $("#viewproductprice").on("blur", function (e) {
    if (!$(e.target).val()) return $(e.target).val(_defaultvalues["price"])
    if ($(e.target).val() == _defaultvalues["price"]) return
    $(e.target).attr("disabled", true)
    updateField({
      PPrice: $(e.target).val(),
      ProductId: $("#productid").val()
    }, function (res) {
      var json = JSON.parse(res)
      if (json.response) {
        return $("body").showAlert({
          type: "success",
          body: "Quantity updated."
        })
      }

      $(e.target).val(_defaultvalues["brand"])
    })
  })

  //update sizes
  $("#viewproductsizes").on("blur", function (e) {
    if (!$(e.target).val()) return $(e.target).val(_defaultvalues["sizes"])
    if ($(e.target).val() == _defaultvalues["sizes"]) return
    $(e.target).attr("disabled", true)
    updateField({
      PSizes: $(e.target).val(),
      ProductId: $("#productid").val()
    }, function (res) {
      var json = JSON.parse(res)
      if (json.response) {
        return $("body").showAlert({
          type: "success",
          body: "Sizes updated."
        })
      }

      $(e.target).val(_defaultvalues["sizes"])
    })
  })

  //update colors
  $("#viewproductcolors").on("blur", function (e) {
    if (!$(e.target).val()) return $(e.target).val(_defaultvalues["colors"])
    if ($(e.target).val() == _defaultvalues["colors"]) return
    $(e.target).attr("disabled", true)
    updateField({
      PColors: $(e.target).val(),
      ProductId: $("#productid").val()
    }, function (res) {
      var json = JSON.parse(res)
      if (json.response) {
        return $("body").showAlert({
          type: "success",
          body: "Colors updated."
        })
      }

      $(e.target).val(_defaultvalues["colors"])
    })
  })

  //update image
  $("#productimageedit").on("click", function (e) {
    var formdata = new FormData();
    formdata.append("PImage", document.querySelector("#viewproductimage").files[0])
    formdata.append("ProductId", $("#productid").val())

    $.ajax("viewproduct.php", {
      method: "POST",
      data: formdata,
      cache: false,
      processData: false,
      contentType: false
    })
      .then(function (res) {
        var json = JSON.parse(res)
        if (json.response) {
          $(e.target).attr("disabled", true)
          $("#viewproductimage").val("")
          $("#viewproductimageref").val("")
          return $("body").showAlert({
            type: "success",
            body: "Image Updated."
          })
        }

        if (json.error) {
          return $("body").showAlert({
            type: "danger",
            body: `Error: ${json.error}`
          })
        }
      })
      .catch(function (err) {
        $("body").showAlert({
          type: "error",
          body: "Something happened on our side. Please reload the browser for better experience."
        })
      })
  })
})