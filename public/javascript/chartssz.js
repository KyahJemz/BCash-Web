export default class ChartHelper {

    constructor () {
        this.element = element;
    }




    setLabels(labels){
        this.labels = labels;
    }

    setLabels(labels){
        this.labels = labels;
    }

    createChart(){
        new Chart(this.element);
    }

    refreshChart(){
        new Chart(this.element);
    }


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
    



}