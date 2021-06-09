function display_subcategories(subcategory_info) {

  $.ajax({
    type: "POST",
    url: "/profile/get_subcategories",
    data: {
      parent_id: subcategory_info.parent_category_id,
    },
    success: function (result) {
     
      var result = JSON.parse(result);

      if (result.status == true) {
        delete result.status;
        $('#new_spending_subcategory').empty();
        
        Object.values(result).forEach(val => {
          new_subcategory_element = create_new_subcategory_select_option(val);
          $("#new_spending_subcategory").append(new_subcategory_element);
          $(".subcategories-wrap").show();
        });

      } else {
        $('#new_spending_subcategory').empty();
      }
    },
  });
}

function create_new_subcategory_select_option(subcategory_element) {
  new_subcategory = document.createElement("option");
  new_subcategory.setAttribute("value", subcategory_element.id);
  new_subcategory.textContent = subcategory_element.name;
  return new_subcategory;
}

function create_new_spending_element(
  current_spending_amount,
  current_date,
  current_spending_name,
  current_spending_category_name,
  current_spending_subcategory_name,
  current_spending_id,
  current_source_name
) {
  //td
  new_spending = document.createElement("tr");
  new_spending.classList.add("spending-item");
  new_spending.setAttribute("data-spending-id", current_spending_id);

  //amount
  new_spending_td = document.createElement("td");
  new_spending_td.textContent = current_spending_amount;
  new_spending.appendChild(new_spending_td);

  //description
  new_spending_td = document.createElement("td");
  new_spending_td.textContent = current_spending_name;
  new_spending.appendChild(new_spending_td);

  //status
  new_spending_td = document.createElement("td");
  new_spending_td.textContent = current_source_name;
  // new_spending_label = document.createElement("label");
  // new_spending_label.textContent = "Выполнена";
  // new_spending_label.classList.add("badge", "badge-gradient-success");
  // new_spending_td.appendChild(new_spending_label);
  new_spending.appendChild(new_spending_td);

  //date
  new_spending_td = document.createElement("td");
  new_spending_td.textContent = current_date;
  new_spending.appendChild(new_spending_td);

  //category_name
  new_spending_td = document.createElement("td");
  new_spending_td.textContent = current_spending_category_name;
  new_spending.appendChild(new_spending_td);

  //subcategory_name
  new_spending_td = document.createElement("td");
  new_spending_td.textContent = current_spending_subcategory_name;
  new_spending.appendChild(new_spending_td);

  //delete button
  new_spending_td = document.createElement("td");
  new_spending_delete_button = document.createElement("button");
  new_spending_delete_button.setAttribute(
    "data-spending-id",
    current_spending_id
  );
  new_spending_delete_button.classList.add(
    "btn",
    "btn-outline-secondary",
    "btn-fw",
    "delete-spending"
  );
  new_spending_delete_button.textContent = "Удалить";
  new_spending_delete_button.onclick = function () {
    delete_spending($(this).data("spending-id"));
  };

  new_spending_td.appendChild(new_spending_delete_button);
  new_spending.appendChild(new_spending_td);

  return new_spending;
}

function delete_spending(current_spending_id) {
  $.ajax({
    type: "POST",
    url: "/profile/delete_spending",
    data: {
      spending_to_delete_id: current_spending_id,
    },
    success: function (result) {
      var result = JSON.parse(result);
      if (result.status == true) {
        $(
          '.spending-item[data-spending-id="' + current_spending_id + '"]'
        ).remove();
      } else {
        $(".spendings-error").html(
          "К сожалению не удалось удалить, попробуйте позже."
        );
      }
    },
  });
}