import Graph from '../graphs/Graph.js';
import ChartLine from '../graphs/ChartLine.js';

const divGraph = document.getElementById('canvas-graph');

const graphs = new Graph({ el: divGraph, types: [
    new ChartLine({ datos: {} }),
]});