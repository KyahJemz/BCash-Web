function HighlightSelectedOption(selectElement) {
    const options = selectElement.options;
    const selectedValue = selectElement.value;
    
    for (let i = 0; i < options.length; i++) {
      const option = options[i];
      
      if (option.value === selectedValue) {
        option.classList.add('selected');
      } else {
        option.classList.remove('selected');
      }
    }
  }