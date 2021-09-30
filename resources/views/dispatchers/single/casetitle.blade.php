<!-- Title -->
<div class="hk-pg-header">
    <div>
        <h4 class="hk-pg-title"><span class="pg-title-icon"><span class="feather-icon"><i data-feather="target"></i></span></span>{{$case->case_number}}</h4>
    </div>
    <div class="d-flex">
        <a href="{{ route('cases.resolve.case', $case) }}" class="btn btn-success btn-wth-icon icon-wthot-bg"> <span class="icon-label"><i class="fa fa-lock"></i> </span><span class="btn-text">Resolve Case</span></a>
        
    </div>
</div>
<!-- /Title -->