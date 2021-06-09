

$(document).ready(function () {
  //add souce
  $("#add-new-source").click(function () {
    source_name = $('#new-source-name').val();
    source_description = $('#new-source-description').val();

    $.ajax({
      type: "POST",
      url: "/profile/add_source",
      data: {
        new_source_name: source_name,
        new_source_description: source_description,
      },
      success: function (result) {
        var result = JSON.parse(result);
        if (result.status == true) {
          window.location.reload(false); 

        } else {
          
          $(".source-error").html("Ошибка при добавлении, попробуйте позже.");
        }
      },
    });
  
    $("#new-source-name").val("");
    $("#new-source-description").val("");
  });

  $(".delete-source").click(function () {
    source_id = this.getAttribute("data-source-id");

    $.ajax({
      type: "POST",
      url: "/profile/delete_source",
      data: {
        source_to_delete_id: source_id,
      },
      success: function (result) {
        var result = JSON.parse(result);
       
        if (result.status == true) {
          window.location.reload(false); 

        } else {
          
          $(".source-error").html("Ошибка при удалении, попробуйте позже.");
        }
      },
    });
  });
});