<div class="col-md-6">
<div class="form-group">
	<label form="sizes" class="col-md-3">{{trans('admin.size_id')}}</label>
	<div class="col-md-9" >
		{!! Form::select('size_id',$sizes,$product->size_id,['class'=>'form-control','placeholder'=>trans('admin.size_id')])!!}
	</div>
</div><!--form-group-->
<div class="form-group">
	<label form="sizes" class="col-md-3">{{trans('admin.size')}}</label>
	<div class="col-md-9" >
		{!! Form::text('size',$product->size,['class'=>'form-control','placeholder'=>trans('admin.size')])!!}
	</div>
</div><!--form-group-->
</div><!--col-md-6-->
<!----------------------------------------------------------------->
<div class="col-md-6">

<div class="form-group">
	<label form="sizes" class="col-md-3">{{trans('admin.weight_id')}}</label>
	<div class="col-md-9" >
		{!! Form::select('weight_id',$weights,$product->weight_id,['class'=>'form-control','placeholder'=>trans('admin.weight_id')])!!}
	</div>
</div><!--form-group-->

<div class="form-group">
	<label form="sizes" class="col-md-3">{{trans('admin.weight')}}</label>
	<div class="col-md-9" >
		{!! Form::text('weight',$product->weight,['class'=>'form-control','placeholder'=>trans('admin.weight')])!!}
	</div>
</div><!--form-group-->

</div><!--col-md-6-->
<div class="clearfix"></div>
