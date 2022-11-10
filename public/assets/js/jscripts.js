
var site_url = $('#url').val();
var page_name = $('#page_name').val();
var token = $('#tokenInput').val();
var page = $('#page').val();

var loads = "<div class='auto-load text-center mt-50 mb-40'><svg version='1.1' id='L9' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' height='60' viewBox='0 0 100 100' enable-background='new 0 0 0 0' xml:space='preserve'><path fill='#000' d='M73,50c0-12.7-10.3-23-23-23S27,37.3,27,50 M30.9,50c0-10.5,8.5-19.1,19.1-19.1S69.1,39.5,69.1,50'><animateTransform attributeName='transform' attributeType='XML' type='rotate' dur='1s' from='0 50 50' to='360 50 50' repeatCount='indefinite' /></path></svg><span style='margin-left:-10px'>Loading...</span></div>";



  $('body').on('click', '.view_all', function (){
    var lga_name = $(this).attr('lga_name');
    var lga_id = $(this).attr('lga_id');

    $('.lga_names').html(lga_name+" LGA");
    $(".data_table").html(loads);

    var datastring='lga_id='+lga_id
    +'&lga_name='+lga_name
    +'&_token='+token;

    $.ajax({
      url : site_url + "/fetch_ward_details",
      type: 'POST',
      //dataType: 'json',
      data: datastring,
      success:function(data){
        $('.data_table').html(data.data);
      },error : function(data){
        
      }
    });
  });



  $('body').on('change', '.state', function(e) {  
    var state_id = $(this).val();
    if(state_id == ""){
      $('.lga').hide();
      return;
    }
    $('.lga').show();

    var datastring='state_id='+state_id
    +'&_token='+token;
  
    $(".lga").html('<option>Searching LGA...</option>');
    $.ajax({
      type : "POST",
      url : site_url + "/display_lgas",
      data : datastring,
      cache : false,
      success : function(data){
        if(data == 0){
          $(".lga").empty();
        }else{
          $(".lga").empty().append(data);
        }
      }
    });
  });


  $('body').on('change', '.lga', function(e) {  
    var lga = $(this).val();
    var state = $('.state').val();

    if(page != "home"){
      if(lga == "" || state == ""){
        $('.search_result').hide();
        return;
      }
      $('.search_result').show();
      return;
    }
    
    if(lga == ""){
      $('.ward').hide();
      return;
    }
    $('.ward').show();

    var datastring='lga='+lga
    +'&_token='+token;
  
    $(".ward").html('<option>Searching Wards...</option>');
    $.ajax({
      type : "POST",
      url : site_url + "/display_wards",
      data : datastring,
      cache : false,
      success : function(data){
        if(data == 0){
          $(".ward").empty();
        }else{
          $(".ward").empty().append(data);
        }
      }
    });
  });

  
  $('body').on('change', '.ward', function(e) {  
    var ward = $(this).val();
    var lga = $('.lga').val();
    var state = $('.state').val();
    if(ward == "" || lga == "" || state == ""){
      $('.search_btn').hide();
      return;
    }
    $('.search_btn').show();
  });
  

  $('body').on('click', '.search_btn', function(e) {
    $("#tbl_search").dataTable().fnDestroy();
    var self = this;

    var state = $('.state').val();
    var lga = $('.lga').val();
    var ward = $('.ward').val();

    if(state == "" || lga == "" || ward == ""){
      return;
    }
    $(self).attr('disabled', true).css({'opacity': '0.4', 'color': '#ccc'});

    var table = $('#tbl_search').DataTable({
      processing: true,
      serverSide: false,
      paging: true,
      orderClasses: false,
      pageLength: 20,

      ajax: {
        url: site_url + "/display_table_result",
        type:'POST',
        data:{
          'state': $('.state').val(),
          'lga': $('.lga').val(),
          'ward': $('.ward').val(),
          '_token': token
        },
      },

      columns: [
        // {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
        {data: 'polling_unit_id', name: 'polling_unit_id'},
        {data: 'polling_unit_name', name: 'polling_unit_name'},
        {data: 'polling_unit_number', name: 'polling_unit_number'}
      ],
    });

    setTimeout(function(){
      $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'});

      var count = $('#tbl_search').DataTable().rows().eq(0).length;
      $('.count_items div').html(count + ' Polling Units Available');
    },2000);
  });

  
  $('body').on('click', '.search_result', function(e) {
    var self = this;
    var state = $('.state').val();
    var lga = $('.lga').val();

    var state_name = $(".state").find(':selected').data('value1');
    var state_lga = $(".lga").find(':selected').data('value1');

    $(".card-details").html(loads);

    var datastring='state='+state
    +'&lga='+lga
    +'&state_name='+state_name
    +'&state_lga='+state_lga
    +'&_token='+token;
    
    $.ajax({
      type : "POST",
      url : site_url + "/fetch_results",
      data: datastring,
      success : function(data){
  
        $(".card-details").html(data.data);
        $(self).removeAttr('disabled').css({'opacity': 1, 'color': '#fff'});
  
      },error : function(data){
          $(self).removeAttr('disabled').css({'opacity': 1, 'color': '#fff'});
          $(".errs").show().html('Poor Network Connection!').removeClass('alert-success1').addClass('alert-danger');
      }
    });

  });

  
  $(".enter_score").click(function(){
    var self = this;
    var results = "";
    $(self).attr('disabled', true).css({'opacity': '0.4', 'color': '#ccc'});
    $(".alert_msg").hide();
    
    $.ajax({
      type : "POST",
      url : site_url + "/enter_score",
      data: $(".form_score").serialize(),
      success : function(data){
        $.each(data, function(){
          results += this + "<br>";
        });

        if(data.status == "success"){
          $(".form_score")[0].reset();
          $('.btn_sweet').click();
        }else{
          $(".alert_msg").show().html(results);
        }
        $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'});

        setTimeout(function(){
          $(".alert_msg").fadeOut('fast');
        },4000);

      },error : function(data, timeouts){
        $(self).removeAttr('disabled').css({'opacity': '1', 'color': '#fff'});
        $(".alert_msg").show().html('Poor Network Connection!');

        setTimeout(function(){
          $(".alert_msg").fadeOut('fast');
        },4000);
      }
    });
  });



  
  $('body').on('click', '.textbox-action', function(e) {
    $("html, body").animate({scrollTop: $('.section-bar').offset().top-120 }, 500);
  });


  $('body').on('keyup', '.txtsearchs', function(e) {
    var searchTerm = $('.txtsearchs').val();
    if(searchTerm != "")
      $('.close-icon').fadeIn('fast');
    else
      $('.close-icon').fadeOut('fast');
  });
  


  $('body').on('click', '.close-icon', function(e) {
    e.preventDefault();
    $('.txtsearchs').val('');
    $('.txtsearchs').focus();
    $(this).fadeOut('fast');
    
    $('.dataTables_filter input').val('');
    $('.dataTables_filter input').trigger('keyup');
  });



  $('body').on('keyup', '.txtsearchs', function (e) {
    var txtsearchs = $(this).val();
    $('.txtsearchs1').val(txtsearchs);
    $('.dataTables_filter input').val(txtsearchs);
    $('.dataTables_filter input').trigger('keyup');
  });




  $('body').on('keyup', '.txtsearchs1', function(e) {
    var searchTerm = $(this).val();
    $('.txtsearchs').val(searchTerm);
    if(searchTerm != "")
      $('.close-icon').fadeIn('fast');
    else
      $('.close-icon').fadeOut('fast');
  });


  $('body').on('click', '.close-icon1', function(e) {
    e.preventDefault();
    $('.txtsearchs1').val('');
    $('.txtsearchs1').focus();
    $(this).fadeOut('fast');
    
    $('.dataTables_filter input').val('');
    $('.dataTables_filter input').trigger('keyup');
  });

