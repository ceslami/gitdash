var CommitActivityGraphView = Marionette.ItemView.extend({
    template: '#commit-graph',

    onShow: function() {
        var self = this;

        this.collection = new CommitActivity();
        this.collection.fetch().then(function() {
            self.drawGraph()
        });
    },

    drawGraph: function() {
        var self = this,
            data = [],
            totals = [],
            commit_data = this.collection.models;

        _.each(commit_data, function(el, i) {
            _.each(el.get('commits'), function(el1, i1) {
                if(!i) {
                    totals[i1] = el1;
                } else {
                    totals[i1] += el1;
                }
            })
        });

        _.each(totals, function(el, i) {
            data.push({
                frequency: el,
                letter: i+''
            })
        });

        $(".commit-history-graph").html('').animate({
            opacity: '0'
        }, 300, function() {
            self.drawBarGraph(data);
        });
    },

    drawBarGraph: function(data) {
        var margin = {top: 20, right: 20, bottom: 30, left: 40},
            width = 960 - margin.left - margin.right,
            height = 350 - margin.top - margin.bottom;

        var x = d3.scale.ordinal()
            .rangeRoundBands([0, width], .2);

        var y = d3.scale.linear()
            .range([height, 0]);

        var xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom")
            .tickFormat(function (d) { return d%7 ? '' : (21-d)+' days ago'; });;

        var yAxis = d3.svg.axis()
            .scale(y)
            .orient("left");

        var svg = d3.select(".commit-history-graph").append("svg")
                    .attr('viewBox', '0 0 960 350')
                    .attr('preserveAspectRatio', 'xMidYMid')
                    .attr("width", width + margin.left + margin.right)
                    .attr("height", height + margin.top + margin.bottom)
                  .append("g")
                    .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

        x.domain(data.map(function(d) { return d.letter; }));
        y.domain([0, d3.max(data, function(d) { return d.frequency; })]);

        svg.append("g")
          .attr("class", "x axis")
          .attr("transform", "translate(0," + height + ")")
          .call(xAxis);

        svg.append("g")
          .attr("class", "y axis")
          .call(yAxis)
        .append("text")
          .attr("transform", "rotate(-90)")
          .attr("y", 6)
          .attr("dy", ".71em")
          .style("text-anchor", "end")
          .text("Commits");

        svg.selectAll(".bar")
          .data(data)
        .enter().append("rect")
          .attr("class", "bar")
          .attr("x", function(d) { return x(d.letter); })
          .attr("width", x.rangeBand())
          .attr("y", function(d) { return y(d.frequency); })
              .attr("height", function(d) { return height - y(d.frequency); });


        function type(d) {
          d.frequency = +d.frequency;
          return d;
        }

        $(".commit-history-graph").animate({
            opacity: '1'
        }, 300);
    }
});



