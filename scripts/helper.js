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
}