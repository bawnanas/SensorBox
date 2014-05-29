
$(document).ready(function(){

	// yAxisOptions = [],
	// colors = Highcharts.getOptions().colors;

	$('.port').click( function(event){
		$.getJSON( 'single_port', { port_name: event.target.id  } )
		.done(function( data ) {
			//console.log(data);

		// create the chart
		chart = new Highcharts.StockChart({
			chart : {
				renderTo : 'temperatures_over_time'
			},

			rangeSelector : {
				selected : 1
			},

			title : {
				text : 'temperatures by day'
			},

			series : [{
				type : 'candlestick',
				name : 'deltas',
				data : data,
				dataGrouping : {
					units : [
						['day', // unit name
						[1] // allowed multiples
						], [
						'month', 
						[1, 2, 3, 4, 6]]
						]
					}
				}]
			});
	});

	});
});




// create the chart when all data is loaded
function createChart(room_name, seriesOptions) {

	chart = new Highcharts.StockChart({
		chart: {
			renderTo: 'temperatures_over_time'
		},

		title : {
			text : room_name
		},

		rangeSelector: {
			buttons: [{
				type: 'hour',
				count: 3,
				text: '3h'
			},{
				type: 'day',
				count: 1,
				text: '1d'
			}, {
				type: 'week',
				count: 1,
				text: '1w'
			}, {
				type: 'month',
				count: 1,
				text: '1m'
			}, {
				type: 'month',
				count: 6,
				text: '6m'
			}, {

				type: 'all',
				text: 'All'
			}],

	        //which button to start with initially
	        selected:0
	    },

	    credits: { enabled: false },

	    legend: {
	    	enabled: true,
	    	align: 'right',
	    	backgroundColor: '#FCFFC5',
	    	borderColor: 'black',
	    	borderWidth: 2,
	    	layout: 'vertical',
	    	verticalAlign: 'top',
	    	y: 100,
	    	shadow: true
	    },

	    yAxis : {
	    	title : {
	    		text : 'temperatures'
	    	},

	    	min:50, 
	    	max: 100,

	    	style: {
	    		color: '#313030',
	    		font: '12px Helvetica',
	    		fontWeight: 'bold'
	    	},

	    	plotBands: [{
	    		from: 50,
	    		to: 67,
	    		color: 'rgba(102, 255, 51, 0.3)',
	    		label: {
	    			text: 'optimal',
	    		}
	    	}, {
	    		from: 67,
	    		to: 80,
	    		color: 'rgba(234, 234, 24, 0.3)',
	    		label: {
	    			text: 'warning'
	    		}
	    	}, {
	    		from: 80,
	    		to: 90,
	    		color: 'rgba(255, 0, 0, .5)',
	    		label: {
	    			text: 'Alert'
	    		}
	    	}, { 
	    		from: 90,
	    		to: 1000,
	    		color: 'rgba(255, 0, 0, 1)',
	    		label: {
	    			text: 'CRITICAL',
	    		}
	    	}]
	    },
	    plotOptions: {
	    	line: { 
	    		allowPointSelect: true 
	    	}
	    },	    
	    
	    series: seriesOptions
	}); 
}
