@extends('admin.index')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
  
// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-single').select2();
    $(document).on('click','.save_and_continue',function () {
       var form_data=$('#product_form').serialize();
       $.ajax({
           url:'{{aurl('products/'.$product->id)}}',
           dataType:'json',
           type:'post',
           data:form_data,
           beforeSend:function () {
               $('.loading_save_c').removeClass('hidden');
               $('.validate_message').html('');
               $('.success_message').html('').addClass('hidden');
               $('.error_message').addClass('hidden');
           },
           success:function (data) {
              if (data.status== true) {
                  $('.loading_save_c').addClass('hidden');
                  $('.success_message').html('<h1>'+data.message+'</h1>').removeClass('hidden');
              }
           },
           error(response){
               $('.loading_save_c').addClass('hidden');
               var error_li='';
               $.each(response.responseJSON.errors,function (index,value) {
                   error_li +='<li>'+value+'</li>';
               });
               $('.validate_message').html(error_li);
               $('.error_message').removeClass('hidden');

           }
       });
        return false;
    });
});

</script>
@endpush 


<div class="box">
  <div class="box-header">
    <h3 class="box-title">{{ $title }}</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    {!! Form::open(['url'=>aurl('products'),'method'=>'put','files'=>true,'id'=>'product_form']) !!}
<a class="btn btn-success save" href="#">         {{ trans('admin.save') }} <i class="fa fa-floppy-o"></i></a>
<a class="btn btn-primary save_and_continue" href="#">{{ trans('admin.save_continue') }} <i class="fa fa-floppy-o ">
        <i class="fa fa-spin fa-spinner loading_save_c hidden">

        </i>
    </i></a>
<a class="btn btn-info copy_products" href="#">   {{ trans('admin.copy_products') }} <i class="fa fa-copy"></i></a>
<a class="btn btn-danger delete" href="#">        {{ trans('admin.delete') }}      <i class="fa fa-trash"></i></a>
<hr/>
      <div class="alert alert-danger error_message hidden">
          <ul class="validate_message">

          </ul>
      </div>
      <div class="alert alert-success success_message hidden">

      </div>
<hr/>

 <ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#product_info"> {{ trans('admin.product_info') }}  <i class="fa fa-info"></i></a></li>
  <li><a data-toggle="tab" href="#department">          {{ trans('admin.department') }}    <i class="fa fa-list"></i>    </a></li>
    <li><a data-toggle="tab" href="#product_setting">    {{ trans('admin.product_setting') }}  <i class="fa fa-cog fa-spin"></i></a></li>

  <li><a data-toggle="tab" href="#product_media">       {{ trans('admin.product_media') }}  <i class="fa fa-photo"></i></a></li>
  <li><a data-toggle="tab" href="#product_size_weight"> {{ trans('admin.product_size_weight') }} <i class="fa fa-info-circle "></i></a></li>
  <li><a data-toggle="tab" href="#product_other_data">  {{ trans('admin.product_other_data') }} <i class="fa fa-database"></i></a></li>
 </ul>

<div class="tab-content">

 @include('admin.products.tabs.product_info')
@include('admin.products.tabs.product_setting')
@include('admin.products.tabs.department')
@include('admin.products.tabs.product_media')
@include('admin.products.tabs.product_size_weight')
@include('admin.products.tabs.product_other_data')
 
</div>
<hr>
<a class="btn btn-success save" href="#">         {{ trans('admin.save') }} <i class="fa fa-floppy-o"></i></a>
<a class="btn btn-primary save_and_continue" href="#">{{ trans('admin.save_continue') }} <i class="fa fa-floppy-o "></i></a>
<a class="btn btn-info copy_products" href="#">   {{ trans('admin.copy_products') }} <i class="fa fa-copy"></i></a>
<a class="btn btn-danger delete" href="#">        {{ trans('admin.delete') }}      <i class="fa fa-trash"></i></a>

 

 
     {!! Form::close() !!}
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
@endsection
