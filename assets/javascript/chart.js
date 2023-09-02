class ChartHelper {

  constructor () {
      this.element = element;
  }

  setLabels(labels){
      this.labels = labels;
  }
  setDatasets(datasets){
      this.datasets = datasets;
  }

  setFill(fill){
    this.fill = fill;
  }
  setBorderColor(borderColor){
    this.borderColor = borderColor;
  }
  setBackgroundColor(backgroundColor){
    this.backgroundColor = backgroundColor;
  }
  setTension(tension){
    this.tension = tension;
  }
  setPointRadius(pointRadius){
    this.pointRadius = pointRadius;
  }
  setType(type){
    this.type = type;
  } 

  createChart(){
      new Chart(this.element);
  }

  refreshChart(){
      new Chart(this.element);
  }


}




// // ###################
// // Daily Sales
// // ###################
//   const chartDaily_Data = {
//     labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6'],
//     datasets: [
//       {
//         label: 'Sales Per Day',
//         data: [10, 20, 15, 25, 18, 30],
//         borderColor: '#DA121A',
//         backgroundColor: '#DA121A',
//         pointStyle: 'circle',
//         pointRadius: 5,
//         pointHoverRadius: 10
//       }
//     ]
//   };

//   const chartDaily_Config = {
//     type: 'line',
//     data: chartDaily_Data,
//     options: {
//       responsive: true,
//       plugins: {
//         title: {
//           display: false,
//           text: (ctx) => 'Sales'
//         },
//         legend: {
//             display: false,
//         }
//       }
//     }
//   };

//   const chartDaily = document.getElementById('graph-daily').getContext('2d');
//   new Chart(chartDaily, chartDaily_Config);

// // ###################
// // Sales Per Day
// // ###################

//   const chatOrderByItem_Data = {
//     labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6'],
//     datasets: [
//       {
//         data: [10, 20, 15, 25, 18, 30,20,100],
//         borderColor: '#DA121A',
//         backgroundColor: '#DA121A',
//         borderWidth: 0.5,
//       }
//     ]
//   };

//   const chatOrderByItem_Config = {
//     type: 'bar',
//     data: chatOrderByItem_Data,
//     options: {
//       indexAxis: 'x',
//       responsive: true,
//       plugins: {
//         title: {
//           display: false,
//           text: (ctx) => 'Sales'
//         },
//         legend: {
//           display: false,
//           }
//       },
//       elements: {
//         bar: {
//           borderWidth: 1,
//         }
//       }
//     }
//   };

//   const chatOrderByItem = document.getElementById('graph-order-by-items').getContext('2d');
//   new Chart(chatOrderByItem, chatOrderByItem_Config);

// // ###################
// // Sales Per Day
// // ###################

//   const chartSalesByCategory_Data = {
//     labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6'],
//     datasets: [
//       {
//         data: [10, 20, 15, 25, 18, 30,20,100],
//         borderColor: '#DA121A',
//         backgroundColor: '#DA121A',
//         borderWidth: 0.5,
//       }
//     ]
//   };

//   const chartSalesByCategory_Config = {
//     type: 'bar',
//     data: chartSalesByCategory_Data,
//     options: {
//       indexAxis: 'x',
//       responsive: true,
//       plugins: {
//         title: {
//           display: false,
//           text: (ctx) => 'Sales'
//         },
//         legend: {
//           display: false,
//           }
//       },
//       elements: {
//         bar: {
//           borderWidth: 1,
//         }
//       }
//     }
//   };

//   const chartSalesByCategory = document.getElementById('graph-sales-by-category').getContext('2d');
//   new Chart(chartSalesByCategory, chartSalesByCategory_Config);

// // ###################
// // Chart Events
// // ###################

//   const actions = [
//     {
//       name: 'pointStyle: circle (default)',
//       handler: (chart) => {
//         chart.data.datasets.forEach(dataset => {
//           dataset.pointStyle = 'circle';
//         });
//         chart.update();
//       }
//     }
//   ];











  // NEWWWW CHARTS


const options_MiniLineChart = {
  scales: {
    x: {
      display: false, // display text
      grid: {
        display: true // grid lines
      }
    },
    y: {
      display: false // display text
    }
  },
  plugins: {
    legend: {
      display: false // Hide the legend
    },
    tooltip: {
      enabled: false // Disable tooltips
    }
  }
}

const options_PieChart = {
  
}

const options_LineChart = {
  plugins: {
    legend: {
      display: false // Hide the legend
    },
    tooltip: {
      enabled: true // Disable tooltips
    }
  }
}






function setChart (element,type,options,title,labels,dataset,colors) {
  const data = {
    labels: labels,
    datasets: [{
      label: title,
      data: dataset,
      fill: false,
      borderColor: colors,
      backgroundColor: colors,
      tension: 0.0,
      pointRadius: 0
    }]
  };
  
  const config = {
    type: type,
    data: data,
    options: options
  };

  new Chart(element, config);
}

const chart1 = document.getElementById('chart-total-cash-in').querySelector('canvas').getContext('2d');
const chart2 = document.getElementById('chart-total-orders-merchants').querySelector('canvas').getContext('2d');
const chart3 = document.getElementById('chart-total-sales-merchants').querySelector('canvas').getContext('2d');
const chart4 = document.getElementById('chart-total-transactions-today').querySelector('canvas').getContext('2d');

setChart(
  chart1,
  'line',
  options_MiniLineChart,
  'Total Cash-In',
  ['0','1','4','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],
  [0, 0, 0, 0,0, 55, 40, 100,56, 55, 40, 100,56, 55, 40, 100,56, 55, 40, 100,56, 55, 40],
  '#F9AE28'
);

setChart(
  chart2,
  'line',
  options_MiniLineChart,
  'Total Cash-In',
  ['day1','day2','day3','day4'],
  [56, 55, 40, 100],
  '#F9AE28'
);

setChart(
  chart3,
  'line',
  options_MiniLineChart,
  'Total Cash-In',
  ['day1','day2','day3','day4'],
  [56, 55, 40, 100],
  '#F9AE28'
);


setChart(
  chart4,
  'line',
  options_MiniLineChart,
  'Total Cash-In',
  ['day1','day2','day3','day4'],
  [56, 55, 40, 100],
  '#F9AE28'
);





const chart5 = document.getElementById('chart-cashin-total-history').querySelector('canvas').getContext('2d');
const chart6 = document.getElementById('chart-money-in-circulation').querySelector('canvas').getContext('2d');

// setChart(
//   chart6,
//   'pie',
//   options_PieChart,
//   'Money In Circulation',
//   ['Users','Merchants'],
//   [70, 30],
//   ['#F9AE28','#DA121A']
// );






    const data = {
      labels: ['day 1', 'day 2', 'day 3', 'day 4', 'day 5', 'day 6', 'day 7'],
      datasets: [
        {
          label: 'Cash-In',
          data: [20, 20, 30, 40, 50,15, 34],
          borderColor: '#F9AE28',
          backgroundColor: 'rgba(249, 174, 40, 0.2)',
          fill: true,
        },
        {
          label: 'Success',
          data: [20, 10, 15, 10, 10,10,10],
          borderColor: '#DA121A',
          backgroundColor: 'rgba(218, 18, 26, 0.2)',
          fill: true,
        }
      ]
    };

    const options = {
      scales: {
        x: {
          beginAtZero: true
        },
        y: {
          beginAtZero: true, // Enable stacking on the y-axis
        }
      }
    };

    new Chart(chart5, {
      type: 'line',
      data: data,
      options: options
    });






    const data1 = {
      labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple'],
      datasets: [{
        data: [12, 19, 3, 5, 2],
        backgroundColor: [
          'rgba(255, 99, 132, 0.8)',
          'rgba(54, 162, 235, 0.8)',
          'rgba(255, 206, 86, 0.8)',
          'rgba(75, 192, 192, 0.8)',
          'rgba(153, 102, 255, 0.8)',
        ],
        hoverBackgroundColor: [
          'rgba(255, 99, 132, 1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
        ],
      }]
    };

    new Chart(chart6, {
      type: 'pie',
      data: data1,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        title: {
          display: true,
          text: 'Advanced Pie Chart',
        },
        tooltips: {
          callbacks: {
            label: (tooltipItem, data) => {
              const label = data.labels[tooltipItem.index];
              const value = data.datasets[0].data[tooltipItem.index];
              return `${label}: ${value}`;
            },
          },
        },
        legend: {
          display: true,
          position: 'bottom',
          labels: {
            fontColor: 'black',
          },
        },
      },
    });