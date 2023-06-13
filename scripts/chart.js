
// ###################
// Daily Sales
// ###################
  const chartDaily_Data = {
    labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6'],
    datasets: [
      {
        label: 'Sales Per Day',
        data: [10, 20, 15, 25, 18, 30],
        borderColor: 'gold',
        backgroundColor: 'yellow',
        pointStyle: 'circle',
        pointRadius: 5,
        pointHoverRadius: 10
      }
    ]
  };

  const chartDaily_Config = {
    type: 'line',
    data: chartDaily_Data,
    options: {
      responsive: true,
      plugins: {
        title: {
          display: false,
          text: (ctx) => 'Sales'
        },
        legend: {
            display: false,
          }
      }
    }
  };

  const chartDaily = document.getElementById('graph-daily').getContext('2d');
  new Chart(chartDaily, chartDaily_Config);

// ###################
// Sales Per Day
// ###################

  const chatOrderByItem_Data = {
    labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6'],
    datasets: [
      {
        data: [10, 20, 15, 25, 18, 30],
        borderColor: 'black',
        backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)'],
        borderWidth: 0.5,
      }
    ]
  };

  const chatOrderByItem_Config = {
    type: 'bar',
    data: chatOrderByItem_Data,
    options: {
      indexAxis: 'y',
      responsive: true,
      plugins: {
        title: {
          display: false,
          text: (ctx) => 'Sales'
        },
        legend: {
          display: false,
          }
      },
      elements: {
        bar: {
          borderWidth: 1,
        }
      }
    }
  };

  const chatOrderByItem = document.getElementById('graph-order-by-items').getContext('2d');
  new Chart(chatOrderByItem, chatOrderByItem_Config);

// ###################
// Sales Per Day
// ###################

  const chartSalesByCategory_Data = {
    labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6'],
    datasets: [
      {
        data: [10, 20, 15, 25, 18, 30],
        backgroundColor: ['rgba(255, 99, 132, 0.5)', 'rgba(54, 162, 235, 0.5)', 'rgba(255, 206, 86, 0.5)', 'rgba(75, 192, 192, 0.5)', 'rgba(153, 102, 255, 0.5)'],
        borderColor: 'black',
        borderWidth: 0.5,
      }
    ]
  };

  const chartSalesByCategory_Config = {
    type: 'pie',
    data: chartSalesByCategory_Data,
    options: {
      responsive: true,
      plugins: {
        title: {
          display: false,
          text: (ctx) => 'Sales'
        },
        legend: {
            display: true,
          }
      }
    }
  };

  const chartSalesByCategory = document.getElementById('graph-sales-by-category').getContext('2d');
  new Chart(chartSalesByCategory, chartSalesByCategory_Config);

// ###################
// Chart Events
// ###################

  const actions = [
    {
      name: 'pointStyle: circle (default)',
      handler: (chart) => {
        chart.data.datasets.forEach(dataset => {
          dataset.pointStyle = 'circle';
        });
        chart.update();
      }
    }
  ];