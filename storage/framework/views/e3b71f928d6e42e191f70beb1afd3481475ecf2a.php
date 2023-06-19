<?php $__env->startSection('title',"Change Decrease"); ?>



<?php $__env->startSection('breadcrumb'); ?>

<a href="<?php echo e(url('/application-list')); ?>">Change Decrease</a>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('css'); ?>

<link href="<?php echo e(url('public/')); ?>/assets/vendors/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />

<style type="text/css">

	.btn.btn-primary.open_reason_popup,

	.btn.btn-primary.open_reason_popup:hover,

	.btn.btn-primary.open_reason_popup:focus,

	.btn.btn-primary.reset-action,

	.btn.btn-primary.reset-action:hover,

	.btn.btn-primary.reset-action:focus {

	    padding: 0;

	    background-color: transparent !important;

	    color: #0472ca !important;

	    border: 0px;

	    margin: 0px 3px;

	    text-decoration: underline !important;

	    font-size: 11px;

	    font-weight: 500;

	}

	i.fas.fa-check-circle {

		color: #000;

	    font-size: 12px;

	    display: inline-block;

	    margin: 0px 3px;

	}

</style>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

<?php echo $__env->make('admin.layout.flash', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="m-portlet m-portlet--mobile">

	<div class="m-portlet__head">

		<div class="m-portlet__head-caption">

			<div class="m-portlet__head-title">

				<h3 class="m-portlet__head-text">

					Change Decrease

				</h3>

			</div>

		</div>

		<?php if(auth()->check() && auth()->user()->hasAnyRole("collector|admin|partner")): ?>

		<div class="m-portlet__head-tools">

			<ul class="m-portlet__nav">



			</ul>

		</div>

		<?php endif; ?>

	</div>

	<div class="m-portlet__body">

		<input type="hidden" name="_token" id="token" value="<?php echo e(csrf_token()); ?>">



		<?php

		$partner1 = "";

		if(isset($_GET['partner']) && !empty($_GET['partner'])){

		$partner1 = $_GET['partner'];

	}

	$status1 = "";

	if(isset($_GET['status']) && !empty($_GET['status'])){

	$status1 = $_GET['status'];

}

?>





<!--begin: Datatable -->

<table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">

	<thead>

		<tr>

			<th><input type="text" class="form-control text-filter m-input" id="code" name="code" placeholder="Code"></th>

			<th>

				<select class="form-control select-filter m-input" id="age" name="age">

					<option value="">Select Age Group</option>

					<option value="Form 6-11">6-11</option>

					<option value="Form 12-17">12-17</option>

				</select>

			</th>

			<th>

				<select class="form-control select-filter m-input" id="pre_test_date" name="pre_test_date">

					<option value="">Select Pre Test Date</option>

					<?php for($m=1; $m<=12; ++$m): ?>

					<option value="<?php echo e(date('m', mktime(0, 0, 0, $m, 1))); ?>"><?php echo e(date('F', mktime(0, 0, 0, $m, 1))); ?></option>

					<?php endfor; ?>

				</select>

			</th>

			<th>

				<select class="form-control select-filter m-input" id="post_test_date" name="post_test_date">

					<option value="">Select Post Test Date</option>

					<?php for($m=1; $m<=12; ++$m): ?>

					<option value="<?php echo e(date('m', mktime(0, 0, 0, $m, 1))); ?>"><?php echo e(date('F', mktime(0, 0, 0, $m, 1))); ?></option>

					<?php endfor; ?>

				</select>

			</th>

			<th></th>

			<th></th>

			<th>

				<select name="partner" id="gouv" class="form-control select-filter m-input">

					<option value=""><?php echo e(trans('messages.select_gouvarnate')); ?></option>

					<?php $__currentLoopData = $governate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gov): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

					<option value="<?php echo e($gov->id); ?>"><?php echo e(ucfirst($gov->name)); ?></option>

					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</select>

			</th>

			<th>

				<select name="partner" id="caza" class="form-control select-filter m-input">

					<option value="">Select Caza</option>

					<?php $__currentLoopData = $caza; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $caz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

					<option value="<?php echo e($caz->id); ?>"><?php echo e(ucfirst($caz->name)); ?></option>

					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</select>

			</th>

			<th>

				<?php if(auth()->check() && auth()->user()->hasRole('admin')): ?>

				<select name="partner" id="partner" class="form-control select-filter m-input">

					<option value="">Select Partner</option>

					<?php $__currentLoopData = $partners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $partner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

					<option value="<?php echo e($partner->user_id); ?>" <?php echo e($partner1 == $partner->user_id ? "selected" : ""); ?>><?php echo e(ucfirst($partner->name)); ?></option>

					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</select>

				<?php endif; ?>

			</th>

			<th>

				<?php if(auth()->check() && auth()->user()->hasAnyRole('admin|partner')): ?>

				<select name="collector" id="collector" class="form-control select-filter m-input">

					<option value="">Select collector</option>

					<?php $__currentLoopData = $collectors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

					<option value="<?php echo e($col->user_id); ?>"><?php echo e(ucfirst($col->firstname)); ?> <?php echo e(ucfirst($col->lastname)); ?></option>

					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

				</select>

				<?php endif; ?>

			</th>



			<th></th>

		</tr>

		<tr>

			<th>Code</th>

			<th>Category</th>

			<th>Pre-Test Date</th>

			<th>Post-Test Date</th>

			<th>Pre Test Score</th>

			<th>Post Test Score</th>

			<th>Govermont</th>

			<th>Caza</th>

			<th>Partner</th>

			<th>Collector Name</th>

			<th>Action</th>

		</tr>

	</thead>

</table>

</div>

</div>





<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">

	<div class="modal-dialog modal-dialog-centered">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title" id="myModalLabel">  </h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">

					<span aria-hidden="true">×</span>

				</button>

			</div>

			<div class="modal-body">



				<form action="javascript:;"  id="reason_form" name="reason_form" method="post">

					<?php echo csrf_field(); ?>

					<input type="hidden" name="application_id" id="application_id">

					<span>
						<b>Decrease Reason</b> (Please select maximum two reasons)
					</span><br>
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
								<input type="checkbox" value="Change in the family personnel status (Death, Divorce, .)" name="reason_option[]"><?php echo e(trans('messages.family_personal_status')); ?>

									<span></span>
								</label>
							</div>
							<div class="col-md-12">
								<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
								<input type="checkbox" value="Change in the family economic status" name="reason_option[]"><?php echo e(trans('messages.family_economic_status')); ?>

									<span></span>
								</label>
							</div>
							<div class="col-md-12">
								<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
								<input type="checkbox" value="Child faced with Bullying" name="reason_option[]"><?php echo e(trans('messages.child_faced_bulying')); ?>

									<span></span>
								</label>
							</div>
							<div class="col-md-12">
								<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
								<input type="checkbox" value="Family violence and neglect from parents" name="reason_option[]"><?php echo e(trans('messages.family_violence')); ?>

									<span></span>
								</label>
							</div>
							<div class="col-md-12">
								<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
								<input type="checkbox" value="No obvious or concrete reasons reported" name="reason_option[]"><?php echo e(trans('messages.concreate_reasons_reported')); ?>

									<span></span>
								</label>
							</div>
							<div class="col-md-12">
								<label class="m-checkbox m-checkbox--bold m-checkbox--state-brand">
									<input type="checkbox" value="Others" name="reason_option[]"><?php echo e(trans('messages.others')); ?>

									<span></span>
								</label>
							</div>
						</div>
						<!-- <select class="form-control select-filter m-input" id="reason_option" name="reason_option[]" multiple="">
							<option value="Change in the family personnel status (Death, Divorce, .)"><?php echo e(trans('messages.family_personal_status')); ?></option>
							<option value="Change in the family economic status"><?php echo e(trans('messages.family_economic_status')); ?></option>
							<option value="Child faced with Bullying"><?php echo e(trans('messages.child_faced_bulying')); ?></option>
							<option value="Family violence and neglect from parents"><?php echo e(trans('messages.family_violence')); ?></option>
							<option value="No obvious or concrete reasons reported"><?php echo e(trans('messages.concreate_reasons_reported')); ?></option>
							<option value="Others"><?php echo e(trans('messages.others')); ?></option>

						</select> -->

					</div>

					<div class="form-group">

						<textarea class="form-control" rows="5" id="reason_details" name="reason_details" placeholder="More Details"></textarea>

					</div>

					<div class="form-group text-right">

						<button type="button" class="btn btn-default reset_button">Reset</button>

						<button type="submit" class="btn btn-default submit_button">Submit</button>

					</div>

				</form>



			</div>

      <!-- <div class="modal-footer">

        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

        <button type="button" class="btn btn-primary">Save changes</button>

    </div> -->

</div>

</div>

</div>





<div class="modal fade" id="basicModal1" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">

	<div class="modal-dialog modal-dialog-centered">

		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title" id="myModalLabel1">  </h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">

					<span aria-hidden="true">×</span>

				</button>

			</div>

			<div class="modal-body">



				<div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<h3 class="m-portlet__head-text" id="rea_option1">
								</h3>
							</div>
						</div>
					</div>
					<div class="m-portlet__body" id="rea_desc1">
					</div>
				</div>


			</div>



</div>

</div>

</div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script src="<?php echo e(url('public/')); ?>/assets/vendors/custom/datatables/datatables.bundle.js" type="text/javascript"></script>

<script>

	$(function() {

		datatables();

		$('.text-filter').keyup(function(){

			datatables();

			$(this).focus();

		})

		$('.select-filter').change(function(){

			datatables();

			$(this).focus();

		})

		$(document).on('click', '.open_reason_popup', function (e) {


			$(document).find('input[name="reason_option[]"]').removeAttr('disabled');
			document.getElementById("reason_form").reset();

			var application_id = $(this).attr('data-id');

			var application_code = $(this).attr('data-code');

			var application_option = $(this).attr('data-dropdown');

			var res = application_option.split(" | ");
			for (var i = res.length - 1; i >= 0; i--) {
				$(document).find('input[value="'+res[i]+'"]').prop("checked", true);
			}
			if(res.length > 1){
				$(document).find('input[name="reason_option[]"]:unchecked').attr('disabled','disabled');
			}
			var application_reason_details = $(this).attr('data-details');

			$('#application_id').val(application_id);

			$('#myModalLabel').text('Change Decrease :  ' + application_code);

			$('#reason_option').val(res);

			$('#reason_details').val(application_reason_details);

			$('#basicModal').modal('show');

		});





			$(document).on('click', '.open_reason_view', function (e) {

			var application_id = $(this).attr('data-id');

			var application_code = $(this).attr('data-code');

			var application_option = $(this).attr('data-dropdown');

			var application_reason_details = $(this).attr('data-details');



			$('#myModalLabel1').text('Change Decrease :  ' + application_code);

			$('#rea_option1').text(application_option);

			$('#rea_desc1').text(application_reason_details);

			$('#basicModal1').modal('show');

		});



			$('input[name="reason_option[]"]').click(function(){
				var total =$(document).find('input[name="reason_option[]"]:checked').length;
	            if(total > 2){
		            $(this). prop("checked", false);
		            $(document).find('input[name="reason_option[]"]:unchecked').attr('disabled','disabled');
	            }else if(total < 2){
		            $(document).find('input[name="reason_option[]"]:unchecked').removeAttr('disabled');
	            }else if(total == 2){
		            $(document).find('input[name="reason_option[]"]:unchecked').attr('disabled','disabled');

	            }
	        });





		$("form[name='reason_form']").validate({

			rules: {

				'reason_option[]': "required",

				reason_details: "required",

			},

			messages: {

				        // reason_option: "",

				        // reason_details: "",



				    },

				    submitHandler: function(form) {

				    	$.ajax({

				    		type: 'POST',

				    		url: "<?php echo e(Route('reason-from')); ?>",

				    		data: {

				    			_token: '<?php echo csrf_token(); ?>',

				    			application_id: $('#application_id').val(),

				    			reason_option: $('input[name="reason_option[]"]:checked').serialize(),

				    			reason_details: $('#reason_details').val(),

				    		},

				    		success: function(data) {

				    			alert('Change Decrease Application  Successfully');

				    			$('#basicModal').modal('hide');

				    			datatables();

				    		}

				    	});

				    	form.submit();

				    }

				});



		$(document).on('click', '.reset_button', function (e) {

			$.ajax({

				type: 'POST',

				url: "<?php echo e(Route('reason-from')); ?>",

				data: {

					_token: '<?php echo csrf_token(); ?>',

					application_id: $('#application_id').val(),

					reason_option: '',

					reason_details: '',

				},

				success: function(data) {



					alert('Change Decrease Application  Reset  Successfully');

					$('#basicModal').modal('hide');

					datatables();

				}

			});

		});

	});



	function datatables(){

		$('#m_table_1').DataTable({

			processing: true,

			serverSide: true,

			ordering:true,

			destroy: true,

			searching:false,

			 columnDefs: [

		            { width: 70, targets: 10 }

		        ],

			ajax: {

				url: '<?php echo route('loadChangeDecrease'); ?>',

				method: 'post',

				data: {

					"_token": $('#token').val(),

					"code": $('#code').val(),

					"age": $('#age').val(),

					"pre_test_date": $('#pre_test_date').val(),

					"post_test_date": $('#post_test_date').val(),

					"partner": $('#partner').val(),

					"collector": $('#collector').val(),

					"gouv": $('#gouv').val(),

					"caza": $('#caza').val(),

				}

			},

			columns: [

			{ data: 'code', name: 'code' },

			{ data: 'age_name', name: 'age_name' },

			{ data: 'pre_test_date', name: 'pre_test_date' },

			{ data: 'post_test_date', name: 'post_test_date' },

			{ data: 'pre_test_score', name: 'pre_test_score' },

			{ data: 'post_test_score', name: 'post_test_score' },

			{ data: 'gover_nate_name', name: 'gover_nate_name' },

			{ data: 'caza_name', name: 'caza_name' },

			{ data: 'partner_name', name: 'partner_name' },

			{ data: 'collector_name', name: 'collector_name' },

			{ data: 'action', name: 'action' },

			]

		});

	}


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/hqpyj8xflnii/public_html/prod/resources/views/admin/changedecrease/list.blade.php ENDPATH**/ ?>