export default class Helper {
    static formatNumber(number) {
        const formattedNumber = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(number);
    
        const parts = formattedNumber.toString().split('.');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        return parts.join('.');
    }
    
    static getTime(timestamp){
        const dateObj = new Date(timestamp);
        
        const hours = String(dateObj.getHours()).padStart(2, '0');
        const minutes = String(dateObj.getMinutes()).padStart(2, '0');
        return `${hours}:${minutes}`;
    }
    
    static getDate(timestamp) {
        const dateObj = new Date(timestamp);
        
        const year = dateObj.getFullYear();
        const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Months are zero-based, so we add 1
        const day = String(dateObj.getDate()).padStart(2, '0');
         
        return `${year}-${month}-${day}`;
    }

    static toTitleCase(input) {
        if (!input || input.length === 0) {
            return input;
        }
    
        let titleCase = '';
        let nextTitleCase = true;
    
        for (let i = 0; i < input.length; i++) {
            let char = input.charAt(i);
    
            if (char === ' ') {
                nextTitleCase = true;
            } else if (nextTitleCase) {
                char = char.toUpperCase();
                nextTitleCase = false;
            } else {
                char = char.toLowerCase();
            }
    
            titleCase += char;
        }
    
        return titleCase;
    }

    static getHiddenBalance(input) {
        const amount = parseFloat(input);
        const decimalFormat = new Intl.NumberFormat('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    
        const amountText = decimalFormat.format(amount);
    
        let modifiedString = '';
        for (let i = 0; i < amountText.length; i++) {
            const currentChar = amountText.charAt(i);
            if (/\d/.test(currentChar)) {
                modifiedString += '*';
            } else {
                modifiedString += currentChar;
            }
        }
    
        return '₱ ' + modifiedString;
    }

    static getBalance(input) {
        try {
            const amount = parseFloat(input);
            if (isNaN(amount)) {
                throw new Error("Invalid Balance");
            }
    
            const decimalFormat = new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
    
            return '₱ ' + decimalFormat.format(amount);
        } catch (error) {
            return 'Invalid Balance';
        }
    }

    static getHiddenPersonalId(input) {
        let modifiedString = '';
        for (let i = 0; i < input.length; i++) {
            const currentChar = input.charAt(i);
            if (/\d/.test(currentChar)) {
                modifiedString += '*';
            } else {
                modifiedString += currentChar;
            }
        }
        return modifiedString;
    }

    static convertTimestamp(inputTimestamp) {
        const desiredFormat = "MMM dd, yyyy h:mma";
        const inputFormat = new Intl.DateTimeFormat('en-US', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            timeZone: 'UTC'
        });
        
        const outputFormat = new Intl.DateTimeFormat('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            hour12: true
        });
    
        try {
            const date = new Date(inputTimestamp);
            const formattedDate = outputFormat.format(date);
            return formattedDate.replace(/,/g, ''); // Remove the comma after the day
        } catch (error) {
            console.error(error);
            return "";
        }
    }
}



