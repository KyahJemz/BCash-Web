import Helper from './helper.js';

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

function clearAllCharts() {
	Chart.helpers.each(Chart.instances, function (instance) {
	  instance.destroy();
	});
}

// ACCOUNTING
export function SetAccountingChart(parameters){

	const helper = new Helper();

	clearAllCharts();

	const chart1 = document.getElementById('chart-total-cash-in').querySelector('canvas').getContext('2d');
	const chart2 = document.getElementById('chart-total-orders-merchants').querySelector('canvas').getContext('2d');
	const chart3 = document.getElementById('chart-total-sales-merchants').querySelector('canvas').getContext('2d');
	const chart4 = document.getElementById('chart-total-transactions-today').querySelector('canvas').getContext('2d');
	const chart5 = document.getElementById('chart-cashin-total-history').querySelector('canvas').getContext('2d');
	const chart6 = document.getElementById('chart-money-in-circulation').querySelector('canvas').getContext('2d');

	const chart7 = document.getElementById('chart-recent-transactions');
	const chart8 = document.getElementById('chart-recent-cashin');
	const chart9 = document.getElementById('chart-recent-activities');

	chart7.innerHTML = '';
	parameters.RecentActivities.forEach(element => {
		chart7.innerHTML = chart7.innerHTML +`
			<li>
				${element.Action === 'Add' ? `<div style="background-image: url('../public/images/icons/bolt.png');" class="mark"></div>` 
				: element.Action === 'Edit' ? `<div style="background-image: url('../public/images/icons/edit.png');" class="mark"></div>` 
				: element.Action === 'Delete' ? `<div style="background-image: url('../public/images/icons/delete.png');" class="mark"></div>` 
				: ''
				}
				<div>
					<p class="name">name</p>
					<p class="date">date</p>
				</div>
				<div>
					<p class="amount">₱ </p>
					<p class="type">type</p>
				</div>
			</li>
		`;
	});		

	chart8.innerHTML = '';
	parameters.RecentCashIn.forEach(element => {
		chart8.innerHTML = chart8.innerHTML + `
			<li>
				${element.Action === 'Add' ? `<div style="background-image: url('../public/images/icons/bolt.png');" class="mark"></div>` 
				: element.Action === 'Edit' ? `<div style="background-image: url('../public/images/icons/edit.png');" class="mark"></div>` 
				: element.Action === 'Delete' ? `<div style="background-image: url('../public/images/icons/delete.png');" class="mark"></div>` 
				: ''
				}
				<div>
					<p class="name">${element.Firstname} ${element.Lastname}</p>
					<p class="date">${element.Timestamp}</p>
				</div>
				<div>
					<p class="amount">₱ ${helper.formatNumber(element.TotalAmount)}</p>
					<p class="type">${element.TransactionType}</p>
				</div>
			</li>
		`;
	});		

	chart9.innerHTML = '';
	parameters.RecentActivities.forEach(element => {
		chart9.innerHTML = chart9.innerHTML + `
			<li>
				${element.Action === 'Add' ? `<div style="background-image: url('../public/images/icons/bolt.png');" class="mark"></div>` 
				: element.Action === 'Edit' ? `<div style="background-image: url('../public/images/icons/edit.png');" class="mark"></div>` 
				: element.Action === 'Delete' ? `<div style="background-image: url('../public/images/icons/delete.png');" class="mark"></div>` 
				: ''
				}
				<div>
					<p class="name">${element.Account_Address}</p>
					<p class="date">${element.Task}</p>
				</div>
			</li>`;
		});

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
		labels: ['Users', 'Guests', 'Merchants'],
		datasets: [{
			data: [
				parameters.CirculatingMoney.UsersTotal,
				parameters.CirculatingMoney.GuestsTotal,
				parameters.CirculatingMoney.MerchantsTotal
			],
			backgroundColor: [
				'rgba(255, 99, 132, 0.8)',
				'rgba(54, 162, 235, 0.8)',
				'rgba(255, 206, 86, 0.8)',
			],
			hoverBackgroundColor: [
				'rgba(255, 99, 132, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)',
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

// ADMINISTRATOR
export function SetAdministratorChart(parameters){

	const helper = new Helper();

	clearAllCharts();

	const chart1 = document.getElementById('chart-1').querySelector('canvas').getContext('2d');
	const chart2 = document.getElementById('chart-2').querySelector('canvas').getContext('2d');
	const chart3 = document.getElementById('chart-3').querySelector('canvas').getContext('2d');

	const chart4 = document.getElementById('chart-4').querySelector('canvas').getContext('2d');
	const chart5 = document.getElementById('chart-5').querySelector('canvas').getContext('2d');

	const chart6 = document.getElementById('chart-6');
	const chart7 = document.getElementById('chart-7');
	const chart8 = document.getElementById('chart-8');

	chart6.innerHTML = '';
	parameters.RecentAdminActivities.forEach(element => {
		chart6.innerHTML = chart6.innerHTML +`
			<li>
				${element.Action === 'Add' ? `<div style="background-image: url('../public/images/icons/bolt.png');" class="mark"></div>` 
				: element.Action === 'Edit' ? `<div style="background-image: url('../public/images/icons/edit.png');" class="mark"></div>` 
				: element.Action === 'Delete' ? `<div style="background-image: url('../public/images/icons/delete.png');" class="mark"></div>` 
				: ''
				}
				<div>
					<p class="name">${element.Account_Address}</p>
					<p class="date">${element.Task}</p>
				</div>
			</li>`;
	});		

	chart7.innerHTML = '';
	parameters.RecentAdminActivities.forEach(element => {
		chart7.innerHTML = chart7.innerHTML + `
			<li>
				${element.Action === 'Add' ? `<div style="background-image: url('../public/images/icons/bolt.png');" class="mark"></div>` 
				: element.Action === 'Edit' ? `<div style="background-image: url('../public/images/icons/edit.png');" class="mark"></div>` 
				: element.Action === 'Delete' ? `<div style="background-image: url('../public/images/icons/delete.png');" class="mark"></div>` 
				: ''
				}
				<div>
					<p class="name">${element.Account_Address}</p>
					<p class="date">${element.Task}</p>
				</div>
			</li>`;
	});		

	chart8.innerHTML = '';
	parameters.RecentUsersActivities.forEach(element => {
		chart8.innerHTML = chart8.innerHTML + `
			<li>
				${element.Action === 'Add' ? `<div style="background-image: url('../public/images/icons/bolt.png');" class="mark"></div>` 
				: element.Action === 'Edit' ? `<div style="background-image: url('../public/images/icons/edit.png');" class="mark"></div>` 
				: element.Action === 'Delete' ? `<div style="background-image: url('../public/images/icons/delete.png');" class="mark"></div>` 
				: ''
				}
				<div>
					<p class="name">${element.Account_Address}</p>
					<p class="date">${element.Task}</p>
				</div>
			</li>`;
		});

	document.getElementById('chart-1').parentNode.querySelector('.chart-number').innerHTML = 
	'₱ ' + parameters.TotalCashInsPerHour.reduce((accumulator, currentValue) => {return accumulator + parseFloat(currentValue);}, 0);
	document.getElementById('chart-2').parentNode.querySelector('.chart-number').innerHTML = 
	'' + parameters.TotalPurchasesPerHour.reduce((accumulator, currentValue) => {return accumulator + parseFloat(currentValue);}, 0) + ' orders' ;
	document.getElementById('chart-3').parentNode.querySelector('.chart-number').innerHTML = 
	'₱ ' + parameters.TotalTransfersPerHour.reduce((accumulator, currentValue) => {return accumulator + parseFloat(currentValue);}, 0);
	
	setChart(
		chart1,
		'line',
		options_MiniLineChart,
		'Total Cash-In',
		['0','1','4','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],
		parameters.TotalCashInsPerHour,
		'#F9AE28'
	);

	setChart(
		chart2,
		'line',
		options_MiniLineChart,
		'Total Cash-In',
		['0','1','4','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],
		parameters.TotalPurchasesPerHour,
		'#F9AE28'
	);

	setChart(
		chart3,
		'line',
		options_MiniLineChart,
		'Total Cash-In',
		['0','1','4','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],
		parameters.TotalTransfersPerHour,
		'#F9AE28'
	);

	const data = {
		labels: ['0','1','4','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],
		datasets: [
			{
				label: 'Transaction',
				data: parameters.EveryHourTransactions,
				borderColor: '#F9AE28',
				backgroundColor: 'rgba(249, 174, 40, 0.2)',
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

	new Chart(chart4, {
		type: 'line',
		data: data,
		options: options
	});

	const data1 = {
		labels: parameters.NumberOfActors.labels,
		datasets: [{
			data: parameters.NumberOfActors.numbers,
			backgroundColor: [
				'rgba(255, 99, 132, 0.8)',
				'rgba(54, 162, 235, 0.8)',
				'rgba(255, 206, 86, 0.8)',
				'rgba(255, 99, 132, 0.8)',
				'rgba(54, 162, 235, 0.8)',
				'rgba(255, 206, 86, 0.8)',
				'rgba(255, 99, 132, 0.8)',
			],
			hoverBackgroundColor: [
				'rgba(255, 99, 132, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(255, 99, 132, 1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(255, 99, 132, 1)',
			],
		}]
	};

	new Chart(chart5, {
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

// MERCHANT ADMIN
export function SetMerchantAdminChart(parameters){

	const helper = new Helper();

	clearAllCharts();
	
	const chart1 = document.getElementById('chart-1').querySelector('canvas').getContext('2d');
	const chart2 = document.getElementById('chart-2').querySelector('canvas').getContext('2d');
	const chart3 = document.getElementById('chart-3').querySelector('canvas').getContext('2d');
	const chart4 = document.getElementById('chart-4').querySelector('canvas').getContext('2d');

	document.getElementById('chart-1').parentNode.querySelector('.chart-number').innerHTML = 
	'' + parameters.TotalOrdersPerHour.reduce((accumulator, currentValue) => {return accumulator + parseFloat(currentValue);}, 0) + ' orders' ;
	document.getElementById('chart-2').parentNode.querySelector('.chart-number').innerHTML = 
	'₱ ' + parameters.TotalSalesPerHour.reduce((accumulator, currentValue) => {return accumulator + parseFloat(currentValue);}, 0);

	const chart5 = document.getElementById('chart-5');
	const chart6 = document.getElementById('chart-6');
	
	chart6.innerHTML = '';
	parameters.RecentPurchases.forEach(element => {
		chart6.innerHTML = chart6.innerHTML + `
			<li>
				<img src="../public/images/icons/money.png" alt="" >
				<div>
					<p class="name">${element.Firstname} ${element.Lastname}</p>
					<p class="date">${element.Timestamp}</p>
				</div>
				<div>
					<p class="amount">₱ ${helper.formatNumber(element.TotalAmount)}</p>
					<p class="type">${element.TransactionType}</p>
				</div>
			</li>
		`;
	});		

	chart5.innerHTML = '';
	parameters.RecentMerchantActivities.forEach(element => {
		chart5.innerHTML = chart5.innerHTML + `
			<li>
				${element.Action === 'Add' ? `<div style="background-image: url('../public/images/icons/bolt.png');" class="mark"></div>` 
				: element.Action === 'Edit' ? `<div style="background-image: url('../public/images/icons/edit.png');" class="mark"></div>` 
				: element.Action === 'Delete' ? `<div style="background-image: url('../public/images/icons/delete.png');" class="mark"></div>` 
				: ''
				}
				<div>
					<p class="name">${element.Firstname} ${element.Lastname}</p>
					<p class="date">${element.Task}</p>
				</div>
			</li>`;
		});

	
	setChart(
		chart1,
		'line',
		options_MiniLineChart,
		'Total Cash-In',
		['0','1','4','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],
		parameters.TotalOrdersPerHour,
		'#F9AE28'
	);
	
	setChart(
		chart2,
		'line',
		options_MiniLineChart,
		'Total Cash-In',
		['0','1','4','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23'],
		parameters.TotalSalesPerHour,
		'#F9AE28'
	);
     
	const data = {
		labels: ['6 days', '5 days', '4 days', '3 days', '2 days', 'Yesterday', 'Today'],
		datasets: [
			{
				label: 'Sales',
				data: parameters.EveryDayTotalSales.Sales,
				borderColor: '#F9AE28',
				backgroundColor: 'rgba(249, 174, 40, 0.2)',
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

	new Chart(chart3, {
		type: 'line',
		data: data,
		options: options
	});
     
	const data1 = {
		labels: parameters.TopItems.Name,
		datasets: [{
			data: parameters.TopItems.Total,
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
     
	new Chart(chart4, {
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