var doughnutChart;
var barChart;

function get_filtered_spendings() {
  var today = new Date().toISOString().slice(0, 10);

  first_date = $("#first-date").val();
  last_date = $("#last-date").val();

  if (!first_date) {
    first_date = "2020-01-01";
  }
  if (!last_date) {
    last_date = today;
  }


  current_spending_category_id = $("#new_spending_category").val();
  
  current_spending_source_id = $('.source-select__btn.active').data('source-id');

  current_spending_subcategory_id = $("#new_spending_subcategory").val();

  min_max_sum = document.querySelector('#spendings-amount').getAttribute("data-value");

  var [min_value, max_value] = min_max_sum.split(',');



  // console.log("first date " + first_date);
  // console.log("last date " + last_date)
  // console.log("category id " + current_spending_category_id)
  // console.log("source id " + current_spending_source_id)
  // console.log("subcategory id " + current_spending_subcategory_id)
  // console.log("min " + min_value)
  // console.log("max " + max_value)

  $.ajax({
    type: "POST",
    url: "/profile/get_filtered_spendings",
    data: {
      first_date: first_date,
      last_date: last_date,
      spending_category_id: current_spending_category_id,
      spending_subcategory_id: current_spending_subcategory_id,
      spending_source_id: current_spending_source_id,
      min_sum: min_value,
      max_sum: max_value
    },
    success: function (result) {
      $(".all-spendings-list").empty();
      $(".filtered-spendings-card").show();
      var result = jQuery.parseJSON(result);
      // useful
      // console.log(JSON.stringify(result, null, 2))

      if (result.status == false) {
        $(".bar-card").hide();
        $(".doughnut-card").hide();
        $(".filtered-spendings-card").hide();
      } else {
        $(".bar-card").show();
        $(".doughnut-card").show();

        delete result.status;

        //to array of objects
        var data = Object.values(result);

        Object.values(result).forEach(val => {
          new_spending_element = create_new_spending_element(
            val.sum,
            val.spending_date,
            val.name,
            val.category_name,
            val.subcategory_name,
            val.id,
            val.source_name
          );
          $(".all-spendings-list").prepend(new_spending_element);
        });

        // $("#filtered-list").empty();
        data.forEach((element) => {
          element["sum"] = parseInt(element["sum"], 10);
        });

        const dataForPiechart = Array.from(
          data.reduce(
            (m, { category_name, sum }) =>
              m.set(category_name, (m.get(category_name) || 0) + sum),
            new Map()
          ),
          ([category_name, sum]) => ({
            category_name,
            sum,
          })
        );

        //Reduce для того чтобы передать в функции отрисовки PieChart
        var rawSpendingsData = dataForPiechart.reduce(function (
          accum,
          currentVal
        ) {
          accum[currentVal.category_name] = currentVal.sum;
          return accum;
        },
        {});

        var spendingsValues = [];
        var spendingsLabels = [];

        for (const [key, value] of Object.entries(rawSpendingsData)) {
          spendingsLabels.push(key);
          spendingsValues.push(value);
        }
        

        var doughnutPieData = {
          datasets: [
            {
              data: spendingsValues,
              backgroundColor: [
                "rgba(255, 99, 132, 0.5)",
                "rgba(54, 162, 235, 0.5)",
                "rgba(255, 206, 86, 0.5)",
                "rgba(75, 192, 192, 0.5)",
                "rgba(153, 102, 255, 0.5)",
                "rgba(255, 159, 64, 0.5)",
              ],
              borderColor: [
                "rgba(255,99,132,1)",
                "rgba(54, 162, 235, 1)",
                "rgba(255, 206, 86, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(153, 102, 255, 1)",
                "rgba(255, 159, 64, 1)",
              ],
            },
          ],
          labels: spendingsLabels,
        };

        var doughnutPieOptions = {
          responsive: true,
          animation: {
            animateScale: true,
            animateRotate: true,
          },
        };

        var options = {
          scales: {
            yAxes: [
              {
                ticks: {
                  beginAtZero: true,
                },
              },
            ],
          },
          legend: {
            display: false,
          },
          elements: {
            point: {
              radius: 0,
            },
          },
        };

        if ($("#doughnutChart").length) {
          if (doughnutChart) {    doughnutChart.destroy();  }

          var doughnutChartCanvas = $("#doughnutChart").get(0).getContext("2d");

          doughnutChart = new Chart(doughnutChartCanvas, {
            type: "doughnut",
            data: doughnutPieData,
            options: doughnutPieOptions,
          });
       

          
        }

        if ($("#barChart").length) {
          if (barChart) {    barChart.destroy();  }

          var barChartCanvas = $("#barChart").get(0).getContext("2d");

          barChart = new Chart(barChartCanvas, {
            type: "bar",
            data: doughnutPieData,
            options: options,
          });

          // barChart.destroy();
        }
      }
    },
  });
}

$(function () {

  $(".bar-card").hide();
  $(".doughnut-card").hide();
  $(".filtered-spendings-card").hide();

  $("#spendings-amount").slider({});

  $('#radioBtn a').on('click', function(){
    var sel = $(this).data('source-id');

    $('.source-select__btn').removeClass('active').addClass('notActive');
    $(this).removeClass('notActive').addClass('active');
  })

  "use strict";
  var data = {
    labels: ["2013", "2014", "2014", "2015", "2016", "2017"],
    datasets: [
      {
        label: "# of Votes",
        data: [10, 19, 3, 5, 2, 3],
        backgroundColor: [
          "rgba(255, 99, 132, 0.2)",
          "rgba(54, 162, 235, 0.2)",
          "rgba(255, 206, 86, 0.2)",
          "rgba(75, 192, 192, 0.2)",
          "rgba(153, 102, 255, 0.2)",
          "rgba(255, 159, 64, 0.2)",
        ],
        borderColor: [
          "rgba(255,99,132,1)",
          "rgba(54, 162, 235, 1)",
          "rgba(255, 206, 86, 1)",
          "rgba(75, 192, 192, 1)",
          "rgba(153, 102, 255, 1)",
          "rgba(255, 159, 64, 1)",
        ],
        borderWidth: 1,
        fill: false,
      },
    ],
  };
  var dataDark = {
    labels: ["2013", "2014", "2014", "2015", "2016", "2017"],
    datasets: [
      {
        label: "# of Votes",
        data: [10, 19, 3, 5, 2, 3],
        backgroundColor: [
          "rgba(255, 99, 132, 0.2)",
          "rgba(54, 162, 235, 0.2)",
          "rgba(255, 206, 86, 0.2)",
          "rgba(75, 192, 192, 0.2)",
          "rgba(153, 102, 255, 0.2)",
          "rgba(255, 159, 64, 0.2)",
        ],
        borderColor: [
          "rgba(255,99,132,1)",
          "rgba(54, 162, 235, 1)",
          "rgba(255, 206, 86, 1)",
          "rgba(75, 192, 192, 1)",
          "rgba(153, 102, 255, 1)",
          "rgba(255, 159, 64, 1)",
        ],
        borderWidth: 1,
        fill: false,
      },
    ],
  };
  var multiLineData = {
    labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
    datasets: [
      {
        label: "Dataset 1",
        data: [12, 19, 3, 5, 2, 3],
        borderColor: ["#587ce4"],
        borderWidth: 2,
        fill: false,
      },
      {
        label: "Dataset 2",
        data: [5, 23, 7, 12, 42, 23],
        borderColor: ["#ede190"],
        borderWidth: 2,
        fill: false,
      },
      {
        label: "Dataset 3",
        data: [15, 10, 21, 32, 12, 33],
        borderColor: ["#f44252"],
        borderWidth: 2,
        fill: false,
      },
    ],
  };
  var options = {
    scales: {
      yAxes: [
        {
          ticks: {
            beginAtZero: true,
          },
        },
      ],
    },
    legend: {
      display: false,
    },
    elements: {
      point: {
        radius: 0,
      },
    },
  };
  var doughnutPieData = {
    datasets: [
      {
        data: [30, 40, 30],
        backgroundColor: [
          "rgba(255, 99, 132, 0.5)",
          "rgba(54, 162, 235, 0.5)",
          "rgba(255, 206, 86, 0.5)",
          "rgba(75, 192, 192, 0.5)",
          "rgba(153, 102, 255, 0.5)",
          "rgba(255, 159, 64, 0.5)",
        ],
        borderColor: [
          "rgba(255,99,132,1)",
          "rgba(54, 162, 235, 1)",
          "rgba(255, 206, 86, 1)",
          "rgba(75, 192, 192, 1)",
          "rgba(153, 102, 255, 1)",
          "rgba(255, 159, 64, 1)",
        ],
      },
    ],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: ["Pink", "Blue", "Yellow"],
  };
  var doughnutPieOptions = {
    responsive: true,
    animation: {
      animateScale: true,
      animateRotate: true,
    },
  };

  // Adding actions on clicks
  $("#filter-dates").click(function () {
    get_filtered_spendings();
  });

  $("#get-statistics").click(function () {
    get_filtered_spendings();
  });

  display_subcategories({parent_category_id : $('#new_spending_category').children().first().val()});
  document.getElementById('new_spending_category').addEventListener('change', function() {
    display_subcategories({parent_category_id : this.value});
  });

});
