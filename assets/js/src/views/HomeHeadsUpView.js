var HomeHeadsUpView = Marionette.ItemView.extend({
    template: "#home-heads-up",
    tagName: 'article',
    className: 'song',

    regions: {
        'userPullRequests': '#user-pull-requests'
    },

    days_ago: function(timestamp, asInt) {
        var now = new Date(),
            date = new Date(timestamp),
            datediff = now.getTime() - date.getTime(),
            daysAgo = Math.floor(datediff/(1000*60*60*24));

        if(asInt) return daysAgo;
        return daysAgo ? daysAgo+' days ago' : '<24 hours ago';
    },

    onShow: function() {
        var freshness = parseInt(this.collection.stalePullRequests()*100),
            color = freshness == 100 ? '#37C737' : '#ef1e25';

        $('.chart')
            .attr('data-percent', freshness)
            .text(freshness+'%')
            .easyPieChart({
                animate: 1000,
                barColor: color
            });
        $('.user-pull-requests').html(this.collection.getPullRequestsFrom('ceslami').length ? this.collection.getPullRequestsFrom('ceslami').length : '<div style="display:block;padding:8px 0 0;color:#47CC67" class="icon-ok"></div>');
        $('.ready-to-merge').html(this.collection.getReadyToMerge().length ? this.collection.getReadyToMerge().length : '<div style="display:block;padding:8px 0 0;color:#47CC67" class="icon-ok"></div>');
        $('.uncommented').html(this.collection.getUncommented().length ? this.collection.getUncommented().length : '<div style="display:block;padding:8px 0 0;color:#47CC67" class="icon-ok"></div>');

        var margin = {top: 20, right: 20, bottom: 30, left: 40},
            width = 960 - margin.left - margin.right,
            height = 350 - margin.top - margin.bottom;

        var x = d3.scale.ordinal()
            .rangeRoundBands([0, width], .2);

        var y = d3.scale.linear()
            .range([height, 0]);

        var xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom");

        var yAxis = d3.svg.axis()
            .scale(y)
            .orient("left");

        var svg = d3.select(".commit-history").append("svg")
            .attr('viewBox', '0 0 960 350')
            .attr('preserveAspectRatio', 'xMidYMid')
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
          .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

        var data = [
            {frequency: .5, letter: 'A'},
            {frequency: .3, letter: 'B'},
            {frequency: .9, letter: 'C'},
            {frequency: .8, letter: 'D'},
            {frequency: .4, letter: 'E'},
            {frequency: .2, letter: 'F'},
            {frequency: .3, letter: 'G'}
        ];

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
    }
});
