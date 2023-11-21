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
}

