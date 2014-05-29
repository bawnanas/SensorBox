 $(document).ready(function() 
 {

 	var seriesOptions = [],
 	yAxisOptions = [],
 	devices = [],
 	seriesCounter = 0,
 	colors = Highcharts.getOptions().colors;


 $.getJSON('all_temperature_data', function(data){

 	//console.log(data);
 	
 	//4d array... just uncomment and check the logs >< ...(sorry)
 	// console.log(data);
 	// console.log('one complete series -> data[0]: ' + data[0]);
 	// console.log(typeof(data[0]));
 	// console.log('name: ' + data[0][0]);
 	// console.log(typeof(data[0][0]));

 	// var name = data[0][0];

 	// console.log('all readings from series => data[0][1]: ' + data[0][1]);
 	// console.log(typeof(data[0][1]));

 	// var t_data = data[0][1];

 	// console.log('single reading => data[0][1][0]: ' + data[0][1][0]);
 	// console.log(typeof(data[0][1][0]));

 	// console.log('single time => data[0][1][0][0]: ' + data[0][1][0][0]);
 	// console.log(typeof(data[0][1][0][0]));

 	// console.log('single temp => data[0][1][0][1]: ' + data[0][1][0][1]);
 	// console.log(typeof(data[0][1][0][1])); 

 	for(var i = 0; i < data.length; ++i)
 	{
 		seriesOptions[i] = 
 		{
			name: data[i][0],
			data: data[i][1]
		};
	}

		createChart('All Devices', seriesOptions);
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

	    	// min:50, 
	    	// max: 100,

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














