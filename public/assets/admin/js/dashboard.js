// $(function () {
//   // =====================================
//   // Profit
//   // =====================================
//   var chart = {
//     series: [
//       {
//         name: "Earnings this month:",
//         data: [355, 390, 300, 350, 390, 180, 355, 390],
//       },
//       {
//         name: "Expense this month:",
//         data: [280, 250, 325, 215, 250, 310, 280, 250],
//       },
//     ],

//     chart: {
//       type: "bar",
//       height: 335,
//       offsetX: -15,
//       toolbar: { show: false },
//       foreColor: "#adb0bb",
//       fontFamily: "inherit",
//       sparkline: { enabled: false },
//     },

//     colors: ["#5D87FF", "#49BEFF"],

//     plotOptions: {
//       bar: {
//         horizontal: false,
//         columnWidth: "35%",
//         borderRadius: [6],
//         borderRadiusApplication: "end",
//         borderRadiusWhenStacked: "all",
//       },
//     },
//     markers: { size: 0 },

//     dataLabels: {
//       enabled: false,
//     },

//     legend: {
//       show: false,
//     },

//     grid: {
//       borderColor: "rgba(0,0,0,0.1)",
//       strokeDashArray: 3,
//       xaxis: {
//         lines: {
//           show: false,
//         },
//       },
//     },

//     xaxis: {
//       type: "category",
//       categories: [
//         "16/08",
//         "17/08",
//         "18/08",
//         "19/08",
//         "20/08",
//         "21/08",
//         "22/08",
//         "23/08",
//       ],
//       labels: {
//         style: { cssClass: "grey--text lighten-2--text fill-color" },
//       },/* ============================================================
//       dashboard.js
//       Path: public/assets/admin/js/dashboard.js
//       Depends on: apexcharts.min.js (loaded before this file)
//       ============================================================ */

//    window.addEventListener('load', function () {

//        /* ── Helper: safely get el ── */
//        function el(id) { return document.getElementById(id); }

//        /* ════════════════════════════════════════
//           1. ORDERS SPARKLINE
//        ════════════════════════════════════════ */
//        if (el('ordersSparkline')) {
//            new ApexCharts(el('ordersSparkline'), {
//                series: [{ data: window.dashData ? window.dashData.ordersTrend : [2,5,3,8,6,10,7,12,9,17] }],
//                chart:  { type: 'area', height: 60, sparkline: { enabled: true }, toolbar: { show: false } },
//                stroke: { curve: 'smooth', width: 2.5 },
//                fill:   { type: 'gradient', gradient: { opacityFrom: .35, opacityTo: 0.02 } },
//                colors: ['#5d87ff'],
//                tooltip:{ theme: 'dark', x: { show: false } }
//            }).render();
//        }

//        /* ════════════════════════════════════════
//           2. MONTHLY REVENUE BAR CHART
//        ════════════════════════════════════════ */
//        if (el('revenueChart')) {
//            var revenueData    = window.dashData ? window.dashData.monthlyRevenue : [0,0,0,0,0,430];
//            var revenueLabels  = window.dashData ? window.dashData.monthlyLabels  : ['Oct','Nov','Dec','Jan','Feb','Mar'];

//            new ApexCharts(el('revenueChart'), {
//                series: [{ name: 'Revenue ($)', data: revenueData }],
//                chart: {
//                    type: 'bar', height: 260,
//                    toolbar: { show: false },
//                    fontFamily: 'Plus Jakarta Sans, sans-serif'
//                },
//                plotOptions: { bar: { borderRadius: 7, columnWidth: '45%' } },
//                colors: ['#5d87ff'],
//                xaxis: {
//                    categories: revenueLabels,
//                    labels: { style: { fontSize: '12px', colors: '#7c8fac' } }
//                },
//                yaxis: {
//                    labels: {
//                        formatter: function (v) { return '$' + v; },
//                        style: { fontSize: '12px', colors: '#7c8fac' }
//                    }
//                },
//                dataLabels: { enabled: false },
//                grid:   { borderColor: '#e5eaf2', strokeDashArray: 4 },
//                tooltip:{ theme: 'dark', y: { formatter: function (v) { return '$' + v; } } }
//            }).render();
//        }

//        /* ════════════════════════════════════════
//           3. CONTENT SPLIT DONUT (Images vs Videos)
//        ════════════════════════════════════════ */
//        if (el('contentDonut')) {
//            var totalImages = window.dashData ? window.dashData.totalImages : 180;
//            var totalVideos = window.dashData ? window.dashData.totalVideos : 3;

//            new ApexCharts(el('contentDonut'), {
//                series: [totalImages, totalVideos],
//                chart: {
//                    type: 'donut', height: 260,
//                    fontFamily: 'Plus Jakarta Sans, sans-serif'
//                },
//                labels: ['Images', 'Videos'],
//                colors: ['#13deb9', '#fa896b'],
//                legend: { position: 'bottom', fontSize: '12px' },
//                plotOptions: {
//                    pie: {
//                        donut: {
//                            size: '65%',
//                            labels: {
//                                show: true,
//                                name:  { fontSize: '13px', fontWeight: 700, color: '#7c8fac' },
//                                value: { fontSize: '22px', fontWeight: 800, color: '#2a3547',
//                                    formatter: function (v) { return v; }
//                                },
//                                total: {
//                                    show: true, label: 'Total',
//                                    color: '#7c8fac', fontSize: '12px',
//                                    formatter: function (w) {
//                                        return w.globals.seriesTotals.reduce(function (a, b) { return a + b; }, 0);
//                                    }
//                                }
//                            }
//                        }
//                    }
//                },
//                dataLabels: { enabled: false },
//                stroke:  { width: 2 },
//                tooltip: { theme: 'dark' }
//            }).render();
//        }

//        /* ════════════════════════════════════════
//           4. TOP CATEGORIES BAR CHART
//        ════════════════════════════════════════ */
//        if (el('categoryBar')) {
//            var catLabels = window.dashData ? window.dashData.categoryLabels : ['Nature','Travel','Business','Abstract'];
//            var catCounts = window.dashData ? window.dashData.categoryCounts : [142, 28, 7, 6];

//            new ApexCharts(el('categoryBar'), {
//                series: [{ name: 'Files', data: catCounts }],
//                chart: {
//                    type: 'bar', height: 260,
//                    toolbar: { show: false },
//                    fontFamily: 'Plus Jakarta Sans, sans-serif'
//                },
//                plotOptions: { bar: { borderRadius: 7, columnWidth: '50%', distributed: true } },
//                colors: ['#5d87ff', '#13deb9', '#ffae1f', '#fa896b', '#7c6fcd', '#2a3547'],
//                xaxis: {
//                    categories: catLabels,
//                    labels: { style: { fontSize: '12px', colors: '#7c8fac' } }
//                },
//                yaxis: {
//                    labels: { style: { fontSize: '12px', colors: '#7c8fac' } }
//                },
//                dataLabels: { enabled: false },
//                grid:   { borderColor: '#e5eaf2', strokeDashArray: 4 },
//                legend: { show: false },
//                tooltip:{ theme: 'dark' }
//            }).render();
//        }

//        /* ════════════════════════════════════════
//           5. SUBSCRIPTION PLANS HORIZONTAL BAR
//        ════════════════════════════════════════ */
//        if (el('subBar')) {
//            var planNames  = window.dashData ? window.dashData.planNames  : ['Basic', 'Pro'];
//            var planPrices = window.dashData ? window.dashData.planPrices : [9.99, 29.99];

//            new ApexCharts(el('subBar'), {
//                series: [{ name: 'Price ($)', data: planPrices }],
//                chart: {
//                    type: 'bar', height: 130,
//                    toolbar: { show: false },
//                    fontFamily: 'Plus Jakarta Sans, sans-serif'
//                },
//                plotOptions: { bar: { horizontal: true, borderRadius: 6, barHeight: '55%', distributed: true } },
//                colors: ['#5d87ff', '#ffae1f', '#13deb9', '#fa896b'],
//                xaxis: {
//                    categories: planNames,
//                    labels: { style: { fontSize: '12px', colors: '#7c8fac' } }
//                },
//                yaxis: {
//                    labels: { style: { fontSize: '12px', colors: '#7c8fac' } }
//                },
//                dataLabels: {
//                    enabled: true,
//                    formatter: function (v) { return '$' + v; },
//                    style: { fontSize: '11px' }
//                },
//                grid:   { borderColor: '#e5eaf2', strokeDashArray: 4 },
//                legend: { show: false },
//                tooltip:{ theme: 'dark', y: { formatter: function (v) { return '$' + v; } } }
//            }).render();
//        }

//        /* ════════════════════════════════════════
//           6. PLAN LIST (rendered below subBar)
//        ════════════════════════════════════════ */
//        if (el('planList') && window.dashData && window.dashData.plans) {
//            var listEl = el('planList');
//            window.dashData.plans.forEach(function (p) {
//                var statusClass = p.active ? 'active' : 'inactive';
//                var statusText  = p.active ? 'Active' : 'Inactive';
//                listEl.innerHTML +=
//                    '<div class="plan-row">'
//                    + '<span class="plan-name">'  + p.name   + '</span>'
//                    + '<span class="plan-clips">' + p.clips  + ' clips</span>'
//                    + '<span class="plan-price">' + p.price  + '</span>'
//                    + '<span class="pill ' + statusClass + '">' + statusText + '</span>'
//                    + '</div>';
//            });
//        }

//    }); // end window load
//     },

//     yaxis: {
//       show: true,
//       min: 0,
//       max: 400,
//       tickAmount: 4,
//       labels: {
//         style: {
//           cssClass: "grey--text lighten-2--text fill-color",
//         },
//       },
//     },
//     stroke: {
//       show: true,
//       width: 3,
//       lineCap: "butt",
//       colors: ["transparent"],
//     },

//     tooltip: { theme: "light" },

//     responsive: [
//       {
//         breakpoint: 600,
//         options: {
//           plotOptions: {
//             bar: {
//               borderRadius: 3,
//             },
//           },
//         },
//       },
//     ],
//   };

//   // var chart = new ApexCharts(document.querySelector("#chart"), chart);
//   // chart.render();

//   // =====================================
//   // Breakup
//   // =====================================
//   var breakup = {
//     color: "#adb5bd",
//     series: [38, 40, 25],
//     labels: ["2022", "2021", "2020"],
//     chart: {
//       height: 125,
//       type: "donut",
//       fontFamily: "Plus Jakarta Sans', sans-serif",
//       foreColor: "#adb0bb",
//     },
//     plotOptions: {
//       pie: {
//         startAngle: 0,
//         endAngle: 360,
//         donut: {
//           size: "75%",
//         },
//       },
//     },
//     stroke: {
//       show: false,
//     },

//     dataLabels: {
//       enabled: false,
//     },

//     legend: {
//       show: false,
//     },
//     colors: ["#5D87FF", "#ecf2ff", "#F9F9FD"],

//     responsive: [
//       {
//         breakpoint: 991,
//         options: {
//           chart: {
//             width: 150,
//           },
//         },
//       },
//     ],
//     tooltip: {
//       theme: "dark",
//       fillSeriesColor: false,
//     },
//   };

//   // var chart = new ApexCharts(document.querySelector("#breakup"), breakup);
//   // chart.render();

//   // =====================================
//   // Earning
//   // =====================================
//   var earning = {
//     chart: {
//       id: "sparkline3",
//       type: "area",
//       height: 60,
//       sparkline: {
//         enabled: true,
//       },
//       group: "sparklines",
//       fontFamily: "Plus Jakarta Sans', sans-serif",
//       foreColor: "#adb0bb",
//     },
//     series: [
//       {
//         name: "Earnings",
//         color: "#49BEFF",
//         data: [25, 66, 20, 40, 12, 58, 20],
//       },
//     ],
//     stroke: {
//       curve: "smooth",
//       width: 2,
//     },
//     fill: {
//       colors: ["#f3feff"],
//       type: "solid",
//       opacity: 0.05,
//     },

//     markers: {
//       size: 0,
//     },
//     tooltip: {
//       theme: "dark",
//       fixed: {
//         enabled: true,
//         position: "right",
//       },
//       x: {
//         show: false,
//       },
//     },
//   };
//   // new ApexCharts(document.querySelector("#earning"), earning).render();
// });

/* ============================================================
   dashboard.js
   Path: public/assets/admin/js/dashboard.js
   Depends on: apexcharts.min.js (loaded before this file)
   ============================================================ */

/* ============================================================
   dashboard.js
   Path: public/assets/admin/js/dashboard.js
   ============================================================ */

/* ============================================================
   dashboard.js
   Path: public/assets/admin/js/dashboard.js
   ============================================================ */

window.addEventListener("load", function () {
  var ORANGE = "#ff8000";
  var ORANGE2 = "#ff8000";
  var ORANGE3 = "#fff3e6";
  var ORANGE4 = "#fa896b";
  var ORANGE5 = "#13deb9";
  var GREEN = "#13deb9";
  var RED = "#fa896b";
  var YELLOW = "#ffae1f";
  var PURPLE = "#7c6fcd";
  var MUTED = "#737373";
  var BORDER = "#ffcc80";
  var BG = "#f5f5f5";
  var FONT = "Plus Jakarta Sans, sans-serif";

  function el(id) {
    return document.getElementById(id);
  }

  /* ── 1. Orders Sparkline (Total Orders card) ── */
  if (el("monthly-earning")) {
    new ApexCharts(el("monthly-earning"), {
      series: [
        {
          data: window.dashData
            ? window.dashData.ordersTrend
            : [1, 3, 2, 5, 4, 7, 5, 9, 6, 10],
        },
      ],
      chart: {
        type: "area",
        height: 56,
        sparkline: { enabled: true },
        toolbar: { show: false },
      },
      stroke: { curve: "smooth", width: 2.5 },
      fill: {
        type: "gradient",
        gradient: { opacityFrom: 0.3, opacityTo: 0.02 },
      },
      colors: [ORANGE],
      tooltip: { theme: "dark", x: { show: false } },
    }).render();
  }

  /* ── 2. Monthly Revenue Bar ── */
  if (el("revenueChart")) {
    var rev = window.dashData
      ? window.dashData.monthlyRevenue
      : [0, 0, 0, 0, 0, 430];
    var labels = window.dashData
      ? window.dashData.monthlyLabels
      : ["Oct", "Nov", "Dec", "Jan", "Feb", "Mar"];
    new ApexCharts(el("revenueChart"), {
      series: [{ name: "Revenue ($)", data: rev }],
      chart: {
        type: "bar",
        height: 260,
        toolbar: { show: false },
        fontFamily: FONT,
      },
      plotOptions: { bar: { borderRadius: 7, columnWidth: "45%" } },
      colors: [ORANGE],
      xaxis: {
        categories: labels,
        labels: { style: { fontSize: "12px", colors: MUTED } },
      },
      yaxis: {
        labels: {
          formatter: function (v) {
            return "$" + v.toFixed(2);
          },
          style: { fontSize: "12px", colors: MUTED },
        },
      },
      dataLabels: { enabled: false },
      grid: { borderColor: BORDER, strokeDashArray: 4 },
      fill: {
        type: "gradient",
        gradient: {
          shade: "light",
          type: "vertical",
          shadeIntensity: 0.3,
          gradientToColors: [ORANGE2],
          opacityFrom: 1,
          opacityTo: 0.7,
        },
      },
      tooltip: {
        theme: "dark",
        y: {
          formatter: function (v) {
            return "$" + v;
          },
        },
      },
    }).render();
  }

  /* ── 3. Content Donut ── */
  if (el("contentDonut")) {
    var imgs = window.dashData ? window.dashData.totalImages : 180;
    var vids = window.dashData ? window.dashData.totalVideos : 3;
    new ApexCharts(el("contentDonut"), {
      series: [imgs, vids],
      chart: { type: "donut", height: 260, fontFamily: FONT },
      labels: ["Images", "Videos"],
      colors: [ORANGE5, ORANGE4],
      legend: { position: "bottom", fontSize: "12px" },
      plotOptions: {
        pie: {
          donut: {
            size: "65%",
            labels: {
              show: true,
              name: { fontSize: "13px", fontWeight: 700, color: MUTED },
              value: {
                fontSize: "22px",
                fontWeight: 800,
                color: "#121212",
                formatter: function (v) {
                  return v;
                },
              },
              total: {
                show: true,
                label: "Total",
                color: MUTED,
                fontSize: "12px",
                formatter: function (w) {
                  return w.globals.seriesTotals.reduce(function (a, b) {
                    return a + b;
                  }, 0);
                },
              },
            },
          },
        },
      },
      dataLabels: { enabled: false },
      stroke: { width: 2 },
      tooltip: { theme: "dark" },
    }).render();
  }

  /* ── 4. Subscription Plans Horizontal Bar ── */
  if (el("subBar")) {
    var pNames = window.dashData ? window.dashData.planNames : ["Basic", "Pro"];
    var pPrices = window.dashData ? window.dashData.planPrices : [9.99, 29.99];
    new ApexCharts(el("subBar"), {
      series: [{ name: "Price ($)", data: pPrices }],
      chart: {
        type: "bar",
        height: 130,
        toolbar: { show: false },
        fontFamily: FONT,
      },
      plotOptions: {
        bar: {
          horizontal: true,
          borderRadius: 6,
          barHeight: "55%",
          distributed: true,
        },
      },
      colors: [ORANGE, ORANGE2, YELLOW, RED],
      xaxis: {
        categories: pNames,
        labels: { style: { fontSize: "12px", colors: MUTED } },
      },
      yaxis: { labels: { style: { fontSize: "12px", colors: MUTED } } },
      dataLabels: {
        enabled: true,
        formatter: function (v) {
          return "$" + v;
        },
        style: { fontSize: "11px" },
      },
      grid: { borderColor: BORDER, strokeDashArray: 4 },
      legend: { show: false },
      tooltip: {
        theme: "dark",
        y: {
          formatter: function (v) {
            return "$" + v;
          },
        },
      },
    }).render();
  }

  /* ── 5. Plan List ── */
  if (el("planList") && window.dashData && window.dashData.plans) {
    var listEl = el("planList");
    window.dashData.plans.forEach(function (p) {
      var activeStyle = p.active
        ? "background:#fff3e6;color:#ff8000;"
        : "background:#f1f4f8;color:#737373;";
      listEl.innerHTML +=
        '<div class="db-plan-row">' +
        '<span class="db-plan-name">' +
        p.name +
        "</span>" +
        '<span class="db-plan-clips">' +
        p.clips +
        " clips</span>" +
        '<span class="db-plan-price">' +
        p.price +
        "</span>" +
        '<span style="display:inline-flex;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:700;' +
        activeStyle +
        '">' +
        (p.active ? "Active" : "Inactive") +
        "</span>" +
        "</div>";
    });
  }

  /* ── 6. Top Categories Bar ── */
  if (el("categoryBar")) {
    var cLabels = window.dashData
      ? window.dashData.categoryLabels
      : ["Nature", "Travel", "Business", "Abstract"];
    var cCounts = window.dashData
      ? window.dashData.categoryCounts
      : [142, 28, 7, 6];
    new ApexCharts(el("categoryBar"), {
      series: [{ name: "Files", data: cCounts }],
      chart: {
        type: "bar",
        height: 260,
        toolbar: { show: false },
        fontFamily: FONT,
      },
      plotOptions: {
        bar: { borderRadius: 7, columnWidth: "50%", distributed: true },
      },
      colors: [ORANGE, ORANGE2, YELLOW, RED, PURPLE, GREEN],
      xaxis: {
        categories: cLabels,
        labels: { style: { fontSize: "12px", colors: MUTED } },
      },
      yaxis: { labels: { style: { fontSize: "12px", colors: MUTED } } },
      dataLabels: { enabled: false },
      grid: { borderColor: BORDER, strokeDashArray: 4 },
      legend: { show: false },
      tooltip: { theme: "dark" },
    }).render();
  }
}); // end load
