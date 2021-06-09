function update_profile_info() {
  $("#profile-email-error").text("");
  $("#profile-username-error").text("");
  $("#profile-message").text("");

  new_username = $("#new_username").val();
  new_email = $("#new_email").val();
  new_info = $("#new_info").val();
  $.ajax({
    type: "POST",
    url: "/profile/update_profile",
    data: {
      new_username: new_username,
      new_email: new_email,
      new_info: new_info,
    },
    success: function (result) {
      var result = jQuery.parseJSON(result);

      if (result.status == true) {
        $("#profile-message").text("Успешно обновлено");
      } else {
        $("#profile-email-error").text(result.errors.email_err);
        $("#profile-username-error").text(result.errors.username_err);
      }
    },
  });
}

$(document).ready(function () {
  $("#update-user-info").click(function () {
    update_profile_info();
  });
});
