 @extends("admin_layouts.app")
@section('wrapper')
<div class="page-wrapper">
    <div class="page-content">
<div style="text-align:center">
<h4>Pdf viewer testing</h4>
   <h1>PDF Example with iframe</h1>
    <iframe src="{{url('uploads/pdf/'.$pdf_name)}}" frameborder="0" scrolling="no"width="100%" height="500px">
    </iframe>
  </div>
    </div>
</div>
@endsection

@section('javascript')

<script type="text/javascript">


</script>
@endsection 


