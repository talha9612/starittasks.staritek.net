$(document).ready(function() {
  // // For Font Type
  // var status = $('.font-1').prop('checked') == true ?1:0;
  // if(status == 1){
  //     $('#page_top').addClass('top_dark');
  // }else{
  //     $('#page_top').removeClass('top_dark');
  // }
  // // End Here Font Type
  // For Top Header Dark Mode
  var status = $('.btn-pageheader').prop('checked') == true ?1:0;
  if(status == 1){
      $('#page_top').addClass('top_dark');
  }else{
      $('#page_top').removeClass('top_dark');
  }
  // Header End Here //
  // For Min Sidebar Dark Mode
  var status = $('.btn-min_sidebar').prop('checked') == true ?1:0;
  if(status == 1){
      $('#header_top').addClass('dark');
  }else{
      $('#header_top').removeClass('dark');
  }
  // Header End Here //
  // For Sidebar Dark Mode
  var status = $('.btn-sidebar').prop('checked') == true ?1:0;
  if(status == 1){
    $(document.body).addClass('sidebar_dark');
  }else{
      $(document.body).removeClass('sidebar_dark');
  }
  // Header End Here //
  // For Body Dark Mode
  var status = $('.btn-darkmode').prop('checked') == true ?1:0;
  if(status == 1){
      $(document.body).addClass('dark-mode');
  }else{
      $(document.body).removeClass('dark-mode');
  }
  // Body End Here //
  // For Box Shadow 
  var status = $('.btn-boxshadow').prop('checked') == true ?1:0;
  if(status == 1){
      $('.card').addClass('box_shadow');
  }else{
      $('.card').removeClass('box_shadow');
  }
  // Box Shadow End Here //
});
// For Top Header Dark Mode
$('.btn-pageheader').on('change',function(){
  var status = $(this).prop('checked') == true ?1:0;
  var status_id = $(this).data('id');
  $.ajax({
  type:'GET',
  dataType:'JSON',
  url:'/admin/admin-change-topheader-setting',
  data:{
      'status':status,
      'status_id':status_id
  },
  success:function(data){
      if(status == 1){
          $('#page_top').addClass('top_dark');
      }else{
          $('#page_top').removeClass('top_dark');
      }
  }
  });
});
// Header End Here //
// For Min Sidebar Dark Mode
$('.btn-min_sidebar').on('change',function(){
  var status = $(this).prop('checked') == true ?1:0;
  var status_id = $(this).data('id');
  $.ajax({
  type:'GET',
  dataType:'JSON',
  url:'/admin/admin-change-minsidebar-setting',
  data:{
      'status':status,
      'status_id':status_id
  },
  success:function(data){
      if(status == 1){
          $('#header_top').addClass('dark');
      }else{
          $('#header_top').removeClass('dark');
      }
  }
  });
});
// Min Sidebar End Here //
// For Sidebar Dark Mode
$('.btn-sidebar').on('change',function(){
  var status = $(this).prop('checked') == true ?1:0;
  var status_id = $(this).data('id');
  $.ajax({
  type:'GET',
  dataType:'JSON',
  url:'/admin/admin-change-sidebar-setting',
  data:{
      'status':status,
      'status_id':status_id
  },
  success:function(data){
    if(status == 1){
        $(document.body).addClass('sidebar_dark');
      }else{
          $(document.body).removeClass('sidebar_dark');
      }
  }
  });
});
// Sidebar End Here //
// For Body Dark Mode
$('.btn-darkmode').on('change',function(){
  var status = $(this).prop('checked') == true ?1:0;
  var status_id = $(this).data('id');
  $.ajax({
  type:'GET',
  dataType:'JSON',
  url:'/admin/admin-change-theme-setting',
  data:{
      'status':status,
      'status_id':status_id
  },
  success:function(data){
      if(status == 1){
          $(document.body).addClass('dark-mode');
      }else{
          $(document.body).removeClass('dark-mode');
      }
  }
  });
});
// Body End Here //
// For Top Box Shadow
$('.btn-boxshadow').on('change',function(){
  var status = $(this).prop('checked') == true ?1:0;
  var status_id = $(this).data('id');
  $.ajax({
  type:'GET',
  dataType:'JSON',
  url:'/admin/admin-change-boxshadow-setting',
  data:{
      'status':status,
      'status_id':status_id
  },
  success:function(data){
    if(status == 1){
        $('.card').addClass('box_shadow');
    }else{
        $('.card').removeClass('box_shadow');
    }
  }
  });
});
// box Shadown End Here //
// ///////////////Change Users Status////////////
$('.admin-change-status-user').on('change',function(){
    var status = $(this).prop('checked') == true ?1:0;
    var status_id = $(this).data('id');
   
    $.ajax({
      type:'GET',
      dataType:'JSON',
      url:'/admin/admin-change-status-user',
      data:{
        "_token": "{{ csrf_token() }}",
        'status':status,
        'status_id':status_id
      },
      success:function(data){
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: data.success,
            showConfirmButton: false,
            timer: 1500
          })
      }
    });
  });
//  Check Email Validation

    $('#check-email').on('keyup', function() {
        //ajax request
        $.ajax({
            method:'get',
            url: "/admin/checkEmail",
            data: {
                'email' : $('#check-email').val()
            },
            dataType: 'json',
            success: function(data) {
                if(data == true) {
                    $('#check-email').addClass('is-invalid');
                    $('#check-email').removeClass('is-valid');
                }
                else {
                    $('#check-email').removeClass('is-invalid');
                    $('#check-email').addClass('is-valid');
                }
            },
            error: function(data){
                //error
            }
        });
    });
//////////////////Change Users Status////////////
$('.admin-task-approved').on('change',function(){
    var status = $(this).prop('checked') == true ?1:0;
    var status_id = $(this).data('id');
    $.ajax({
      type:'GET',
      dataType:'JSON',
      url:'/admin/admin-approved-task',
      data:{
        'status':status,
        'status_id':status_id
      },
      success:function(data){
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: data.success,
            showConfirmButton: false,
            timer: 1500
          })
      }
    });
  });
  //////////////////Change Users Status////////////
$('.task-shows-ceo').on('change',function(){
    var task_view_ceo = $(this).prop('checked') == true ?1:0;
    var status_id = $(this).data('id');
    $.ajax({
      type:'GET',
      dataType:'JSON',
      url:'/admin/admin-shows-task-ceo',
      data:{
        'status':task_view_ceo,
        'status_id':status_id
      },
      success:function(data){
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: data.success,
            showConfirmButton: false,
            timer: 1500
          })
      }
    });
  });