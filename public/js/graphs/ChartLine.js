class ChartLine {

    constructor(datos) {

    }

    run(graph) {
        
        const labels = [
                'Domingo',
                'Lunes',
                'Martes',
                'Miercoles',
                'Jueves',
                'Viernes',
                'Sabado',
            ];
        let fechas = [];
        let datos = [];
        $.get('/api/v2/cliente/notas-por-dia', function (notes){
            // labels.forEach((label) => {
            //     datos.push(0);
            //     if()
            // });
            notes.forEach(el => {
                let numDay = new Date(el.day).getDay();
                // labels.forEach((label) => {
                //     if(label == labels[numDay]) {
                //         datos.push(el.total);
                //     } else {
                //         datos.push(0);
                //     }
                // });
                fechas.push(labels[numDay]);
                datos.push(el.total);
            });
        });
        console.log(datos, fechas);
        let data = {
          labels: fechas,
          datasets: [{
            label: 'Noticias en la semana',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            // data: [35, 30, 55, 24, 20, 30, 45],
            data: datos,
          }]
        };

        const config = {
          type: 'line',
          data,
          options: {}
        };

        this.graph = graph;
        return new Chart(
            this.graph,
            config
        );
    }
}

export default ChartLine;
