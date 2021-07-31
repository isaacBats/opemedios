function Graph(config) {
    this.graph = config.el;
    this.types = config.types || [];

    this._initTypes();
}

Graph.prototype._initTypes = function() {
    this.types.forEach( chart => {
        chart.run(this.graph);
    });
}

export default Graph;
