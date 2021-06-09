$(document).ready(function () {
  var today = new Date().toISOString().slice(0, 10);
  $("input[name='date']").val(today);
});
