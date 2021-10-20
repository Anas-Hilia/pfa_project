@extends('layouts.app')

@section('template_title')
	{!! trans('titles.exceeded') !!}
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10  offset-md-1">
				<div class="card card-default ">
					<div class="card-header bg-danger text-white">{!! trans('titles.exceeded') !!}</div>
					<div class="card-body">
						<p>
							{!! trans('auth.tooManyEmails', ['email' => '<strong>'.$email.'</strong>', 'hours' => '<strong>'.$hours.'</strong>']) !!}
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
