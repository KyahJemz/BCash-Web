export default class Helper {
	addElementClickListener(element, callback) {
		const elements = document.querySelectorAll(element);
		if (elements.length > 0) {
			elements.forEach((element) => {
				element.addEventListener('click', callback);
			});
		}
	}
	
	addElementInputistener(element, callback) {
		const elements = document.querySelectorAll(element);
		if (elements.length > 0) {
			elements.forEach((element) => {
				element.addEventListener('intput', callback);
			});
		}
	}
	
	addElementClickListenerById(element, callback) {
		const elements = document.getElementById(element);
		if (elements) {
			elements.addEventListener('click', callback);
		}
	}
	
	addElementInputListenerById(element, callback) {
		const elements = document.getElementById(element);
		if (elements) {
			elements.addEventListener('input', callback);
		}
	}

	addElementClickListenerByElement(elements, callback){
		if (elements.length > 0) {
			elements.forEach((element) => {
				element.addEventListener('click', callback);
			});
		}
	}

	formatNumber(number) {
		const formattedNumber = new Intl.NumberFormat('en-US', {
			minimumFractionDigits: 2,
			maximumFractionDigits: 2
		}).format(number);

		const parts = formattedNumber.toString().split('.');
		parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
		return parts.join('.');
	}

	getTime(timestamp){
		const dateObj = new Date(timestamp);
		
		const hours = String(dateObj.getHours()).padStart(2, '0');
		const minutes = String(dateObj.getMinutes()).padStart(2, '0');
		return `${hours}:${minutes}`;
	}

	getDate(timestamp) {
		const dateObj = new Date(timestamp);
		
		const year = dateObj.getFullYear();
		const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Months are zero-based, so we add 1
		const day = String(dateObj.getDate()).padStart(2, '0');
	     
		return `${year}-${month}-${day}`;
	}
	     
}