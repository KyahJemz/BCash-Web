
  const data = {
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

  const config = {
    type: 'line',
    data: data,
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: (ctx) => 'Sales'
        },
        legend: {
            display: false,
          }
      }
    }
  };

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

  const ctx = document.getElementById('graph-daily').getContext('2d');
  new Chart(ctx, config);