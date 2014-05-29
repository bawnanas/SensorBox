$(document).ready(function(){

 	yAxisOptions = [],
 	colors = Highcharts.getOptions().colors;

	$('.headerbar').click( function(event){
		$.getJSON( 'single_room', { room_name: event.target.id  } )
			.done(function( data ) {
  				seriesOptions = [];
 				 //console.log(data);

 				// console.log(data.length);

  				if (data.length <= 0)
  				{
  					alert("There are no devices associated with this room.");
				}

				else
				{
					for(var i = 0; i < data.length; ++i)
 					{
 						seriesOptions[i] = 
 						{
							name: data[i][0],
							data: data[i][1]
						};
					}

					createChart(event.target.id, seriesOptions);
				}

			})
			.fail(function( jqxhr, textStatus, error ) {
  				var err = textStatus + ', ' + error;
  				alert( "Request Failed: " + err);
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
