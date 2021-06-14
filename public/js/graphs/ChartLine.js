class ChartLine {

    constructor(datos) {

    }

    run(graph) {
        const labels = [
            'Lunes',
            'Martes',
            'Miercoles',
            'Jueves',
            'Viernes',
            'Sabado',
            'Domingo',
        ];

        let data = {
          labels: labels,
          datasets: [{
            label: 'Noticias en la semana',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [35, 30, 55, 24, 20, 30, 45],
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
