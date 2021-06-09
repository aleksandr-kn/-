function create_new_category_element(
  current_category_id,
  current_category_name
) {
  new_category = document.createElement("tr");
  new_category.classList.add("category-list__item");
  new_category.setAttribute("data-category-id", current_category_id);

  //id
  new_category_td = document.createElement("td");
  new_category_td.textContent = current_category_id;
  new_category.appendChild(new_category_td);

  //name
  new_category_td = document.createElement("td");
  new_category_td.textContent = current_category_name;
  new_category.appendChild(new_category_td);

  //color
  new_category_td = document.createElement("td");
  new_category_td.textContent = "colorful progress bar here";
  new_category.appendChild(new_category_td);

  //delete button
  new_category_td = document.createElement("td");
  new_category_delete_button = document.createElement("button");
  new_category_delete_button.setAttribute(
    "data-category-id",
    current_category_id
  );
  new_category_delete_button.classList.add(
    "btn",
    "btn-outline-secondary",
    "btn-fw",
    "delete-category"
  );
  new_category_delete_button.textContent = "Удалить";
  new_category_delete_button.onclick = function () {
    delete_category($(this).data("category-id"));
  };
  new_category_td.appendChild(new_category_delete_button);
  new_category.appendChild(new_category_td);

  new_category.onclick = function () {
    ///
    display_category_settings({id : $(this).data("category-id")});
  };
  return new_category;
}

function create_new_subcategory_element(
  subcategory_element
) {
  new_subcategory = document.createElement("tr");
  new_subcategory.classList.add("subcategory-list__item");
  new_subcategory.setAttribute("data-subcategory-id", subcategory_element.id);

  //id
  new_subcategory_td = document.createElement("td");
  new_subcategory_td.textContent = subcategory_element.id;
  new_subcategory.appendChild(new_subcategory_td);

  //name
  new_subcategory_td = document.createElement("td");
  new_subcategory_td.textContent = subcategory_element.name;
  new_subcategory.appendChild(new_subcategory_td);

  //color
  new_subcategory_td = document.createElement("td");
  new_subcategory_td.textContent = "Проценты";
  new_subcategory.appendChild(new_subcategory_td);

  //delete button
  new_subcategory_td = document.createElement("td");
  new_subcategory_delete_button = document.createElement("button");
  new_subcategory_delete_button.setAttribute(
    "data-subcategory-id",
    subcategory_element.id
  );
  new_subcategory_delete_button.classList.add(
    "btn",
    "btn-gradient-danger",
    "btn-sm",
    "delete-subcategory"
  );
  new_subcategory_delete_button.textContent = "Удалить";
  new_subcategory_delete_button.onclick = function () {
    delete_subcategory({id : $(this).data("subcategory-id")});
  };
  new_subcategory_td.appendChild(new_subcategory_delete_button);
  new_subcategory.appendChild(new_subcategory_td);
  return new_subcategory;
}

function delete_category(current_category_id) {
  $.ajax({
    type: "POST",
    url: "/profile/delete_category",
    data: {
      category_to_delete_id: current_category_id,
    },
    success: function (result) {
      var result = JSON.parse(result);
      if (result.status == true) {
        $(
          '.category-list__item[data-category-id="' + current_category_id + '"]'
        ).remove();
      } else {
        $(".category-error").html(
          "К сожалению не удалось удалить, попробуйте позже."
        );
      }
    },
  });
}

function add_new_subcategory(subcategory_info) {
  current_subcategory_name = $("#new-subcategory-name").val();
  current_subcategory_parent_id = subcategory_info.parent_category_id

  $.ajax({
    type: "POST",
    url: "/profile/add_subcategory",
    data: {
      new_subcategory_name: current_subcategory_name,
      new_subcategory_parent_id: current_subcategory_parent_id
    },
    success: function (result) {
      console.log(result)
      var result = JSON.parse(result);

      if (result.status == true) {
        current_subcategory_id = result.inserted_id;

        new_category = create_new_subcategory_element(
          {id: current_subcategory_id, name: current_subcategory_name}
        );

        $(".subcategory-list").prepend(new_category);
      } else {
        $(".category-error").html(
          "Ошибка при добавлении подкатегории, попробуйте позже."
        );
      }
    },
  });

  $("#new-subcategory-name").val("");
}

function delete_subcategory(current_subcategory) {
  $.ajax({
    type: "POST",
    url: "/profile/delete_subcategory",
    data: {
      subcategory_to_delete_id: current_subcategory.id,
    },
    success: function (result) {
      console.log(result)
      var result = JSON.parse(result);
      if (result.status == true) {
        $(
          '.subcategory-list__item[data-subcategory-id="' + current_subcategory.id + '"]'
        ).remove();
      } else {
        $(".subcategory-error").html(
          "К сожалению не удалось удалить, попробуйте позже."
        );
      }
    },
  });
}

function add_new_category() {
  current_category_name = $("#new-category-name").val();
  $.ajax({
    type: "POST",
    url: "/profile/add_category",
    data: {
      new_category_name: current_category_name,
    },
    success: function (result) {
      var result = JSON.parse(result);

      if (result.status == true) {
        current_category_id = result.inserted_id;

        new_category = create_new_category_element(
          current_category_id,
          current_category_name
        );

        $(".category-list").prepend(new_category);
      } else {
        $(".category-error").html(
          "Ошибка при добавлении категории, попробуйте позже."
        );
      }
    },
  });

  $("#new-category-name").val("");
}

function display_category_settings(category_info) {
  $('.subcategories-card__name').text(category_info.name);
  document.getElementById('add-new-subcategory').setAttribute('data-category-id', category_info.id);
  $.ajax({
    type: "POST",
    url: "/profile/get_subcategories",
    data: {
      parent_id: category_info.id,
    },
    success: function (result) {
     
      var result = JSON.parse(result);
      
      if (result.status == true) {
        delete result.status;
        $('.subcategory-list').empty();
        
        Object.values(result).forEach(val => {
          new_subcategory_element = create_new_subcategory_element(val);
          $(".subcategory-list").prepend(new_subcategory_element);
        });

      } else {
        
        $('.subcategory-list').empty();
      }
    },
  });
}

/* <li class="subcategory-list__item">
  <div class="form-check">
    <label class="form-check-label">
        Meeting
      with Alisa
      <i class="input-helper"></i></label>
  </div>
  <i class="remove mdi mdi-close-circle-outline"></i>
</li> */

$(document).ready(function () {
  $("#add-new-category").click(function () {
    add_new_category();
  });

  $(".delete-category").click(function () {
    delete_category($(this).data("category-id"));
  });

  $(".category-list__item").click(function() {
    display_category_settings({id : $(this).data("category-id"), name : $(this).children().eq(1).html()});
  })

  $("#add-new-subcategory").click(function() {
    // console.log("jquery "+$(this).data("category-id")) ??????????? always the same values??????
    add_new_subcategory({parent_category_id : this.getAttribute("data-category-id")})
  })
  
});
