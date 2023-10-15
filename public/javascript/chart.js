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

// ACCOUNTING


function clearAllCharts() {
	Chart.helpers.each(Chart.instances, function (instance) {
	  instance.destroy();
	});
     }

// CirculatingMoney
// CurrentTime
// DailyTransactions{CashIn: Array(7), CashOut: Array(7)}
// RecentActivities(10) [{…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}]
// RecentCashIn(10) [{…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}, {…}]
// RecentTransactions[]
// TotalCashIn(24) [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
// TotalOrdersInMerchants(24) [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
// TotalSalesInMerchants(24) [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
// TotalTransactions(24

export function SetAccountingChart(parameters){

	clearAllCharts();

	const chart1 = document.getElementById('chart-total-cash-in').querySelector('canvas').getContext('2d');
	const chart2 = document.getElementById('chart-total-orders-merchants').querySelector('canvas').getContext('2d');
	const chart3 = document.getElementById('chart-total-sales-merchants').querySelector('canvas').getContext('2d');
	const chart4 = document.getElementById('chart-total-transactions-today').querySelector('canvas').getContext('2d');
	const chart5 = document.getElementById('chart-cashin-total-history').querySelector('canvas').getContext('2d');
	const chart6 = document.getElementById('chart-money-in-circulation').querySelector('canvas').getContext('2d');

	document.getElementById('chart-total-cash-in').parentNode.querySelector('.chart-number').innerHTML = 
	'₱ ' + parameters.TotalCashIn.reduce((accumulator, currentValue) => {return accumulator + parseFloat(currentValue);}, 0);
	document.getElementById('chart-total-orders-merchants').parentNode.querySelector('.chart-number').innerHTML = 
	'' + parameters.TotalOrdersInMerchants.reduce((accumulator, currentValue) => {return accumulator + parseFloat(currentValue);}, 0) + ' orders' ;
	document.getElementById('chart-total-sales-merchants').parentNode.querySelector('.chart-number').innerHTML = 
	'₱ ' + parameters.TotalSalesInMerchants.reduce((accumulator, currentValue) => {return accumulator + parseFloat(currentValue);}, 0);
	document.getElementById('chart-total-transactions-today').parentNode.querySelector('.chart-number').innerHTML = 
	'' + parameters.TotalTransactions.reduce((accumulator, currentValue) => {return accumulator + parseFloat(currentValue);}, 0) + ' Transactions';

	setChart(
		chart1,
		'line',
		options_MiniLineChart,
		'Total Cash-In',
		['0','1','4','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],
		parameters.TotalCashIn,
		'#F9AE28'
	);

	setChart(
		chart2,
		'line',
		options_MiniLineChart,
		'Total Cash-In',
		['0','1','4','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],
		parameters.TotalOrdersInMerchants,
		'#F9AE28'
	);

	setChart(
		chart3,
		'line',
		options_MiniLineChart,
		'Total Cash-In',
		['0','1','4','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],
		parameters.TotalSalesInMerchants,
		'#F9AE28'
	);

	setChart(
		chart4,
		'line',
		options_MiniLineChart,
		'Total Cash-In',
		['0','1','4','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],
		parameters.TotalTransactions,
		'#F9AE28'
	);

	const data = {
		labels: ['6 days', '5 days', '4 days', '3 days', '2 days', 'Yesterday', 'Today'],
		datasets: [
			{
				label: 'Cash-In',
				data: parameters.DailyTransactions.CashIn,
				borderColor: '#F9AE28',
				backgroundColor: 'rgba(249, 174, 40, 0.2)',
				fill: true,
			},
			{
				label: 'Success',
				data: parameters.DailyTransactions.CashOut,
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
				beginAtZero: true,
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
}
