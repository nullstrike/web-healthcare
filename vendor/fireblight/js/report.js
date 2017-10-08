$(function() {
  $('.ui.simple.dropdown').dropdown();



    var reportTable = $('#reportTable').DataTable({
                      autoWidth: false,
                      ajax : {
                            url : site_url('consultation/getReports'),
                            type: 'post'
                      },
                      columnDefs: [
                            {
                              data: null,
                              defaultContent: "<button data-action='print_diag' class='ui icon button mini blue'><i class='treatment large icon'></i> Diagnosis</button> <button data-action='print_pres' class='ui icon button mini red'><i class='first aid large icon'></i> Prescription</button> <button data-action='print_res' class='ui icon button mini green'><i class='money large icon'></i> Receipt</button>" ,
                              targets: -1
                            },

                       ],
                       columns: [
                        {
                         width: "5%",
                         targets: 0
                        },
                        {
                         width: "45%",
                         targets: 1
                        },
                        {
                         width: "20%",
                         targets: 2
                        },
                        {
                         width: "30%",
                         targets: 3
                        },

                  ]
    });



    $('#reportTable tbody').on('click', 'td button ', function(){
          var action = $(this).data('action');
          var id = reportTable.rows($(this).parents('tr')).data()[0][0];
          var date  = moment().format('MMMM DD, YYYY');
          $('[data-name=date_printed]').text(date);
          $('div').removeClass('reveal-report');

          switch(action)
          {
                case 'print_diag' : $.ajax({
                                          url: site_url('consultation/getDiagnosis/' + id),
                                          dataType: 'json',
                                          success: function(data){
                                              $.each(data[0],function(name,val){
                                                    $('[data-name=' + name + ']').text(val);
                                                    if (name === 'bloodtype' && val === 'Unspecified'){
                                                      val = 'n/a';
                                                      $('[data-name=' + name + ']').text(val);
                                                    }
                                                    if (name === 'date') {
                                                          var consult_date = moment(val).format('MMMM DD, YYYY');
                                                          $('[data-name=date]').text(consult_date);
                                                    }
                                              });
                                          },
                                          complete: function(text){
                                                $('#report-diagnosis').addClass('grid reveal-report');
                                                print();
                                          }

                                    });
                                    break;

                case 'print_pres' : $.ajax({
                                          url: site_url('consultation/getPrescription/' + id),
                                          dataType: 'json',
                                          success: function(data){
                                          $.each(data[0],function(name,val){
                                                $('[data-name=' + name + ']').text(val);
                                                if (name === 'date') {
                                                      var consult_date = moment(val).format('MMMM DD, YYYY');
                                                      $('[data-name=date]').text(consult_date);
                                                }
                                          })
                                          },
                                          complete: function(text){
                                                $('#report-prescription').addClass('reveal-report');
                                                print();
                                          }
                                    });

                                    break;

                case 'print_res'  : $.ajax({
                                          url: site_url('consultation/getReceipt/' + id),
                                          dataType: 'json',
                                          success: function(data){
                                          $.each(data[0],function(name,val){
                                                $('[data-name=' + name + ']').text(val);
                                                if (name === 'date') {
                                                      var consult_date = moment(val).format('MMMM DD, YYYY');
                                                      $('[data-name=date]').text(consult_date);
                                                }
                                          })
                                          },
                                          complete: function(text){
                                                $('#report-receipt').addClass('reveal-report');
                                                print();
                                          }
                                    });
                                    break;

                default           : break;
          }
    });


//     $(document).on('click', '[data-action="print_diag"]', function(){
//       console.log(this);
//     });

});
