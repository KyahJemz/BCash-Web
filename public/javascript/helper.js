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
}