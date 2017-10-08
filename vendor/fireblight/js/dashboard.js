$(function() {

    //get clinic statistics to display on dashboard
    $.ajax({
        url: site_url('patient/getClinicStats'),
        type: 'get',
        dataType: 'json',
        data: {},
        success: function (response) {
            var dataSet = [response.walk_in, response.appointment];
            $('#totalpatient').text(response.totalPatient);
            $('#weekpatient').text(response.weekVisits);
            typeChart(dataSet);
            quarterChart(response.quarterlyVisits);
        }
    });
   
  
    function quarterChart(dataSet) {
        var ctx = document.getElementById("quarterChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ["1st Quarter", "2nd Quarter", "3rd Quarter", "4th Quarter"],
                datasets: [{
                    label: 'Number of Patient',
                    data: dataSet,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                responsive: false,
                legend:{
                  display: true,
                  onClick: function(event) {
                      event.stopPropagation();
                  }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });
    }
     //initialize chart component
     function typeChart(dataSet){
        var ctx = document.getElementById("visitTypeChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Walk-In', 'Appointment'],
                datasets: [{
                    label: 'Number of Patient',
                    data: dataSet,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1,
                    fill: false
                }]
            },
            options: {
                responsive: false,
                legend:{
                  onClick: function(event){
                    event.stopPropagation();
                }
                },

            }
        });
      }

     
});