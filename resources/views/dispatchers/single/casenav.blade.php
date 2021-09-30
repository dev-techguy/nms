<div class="bg-white shadow-bottom">
    <div class="container">
        <ul class="nav nav-light nav-tabs" role="tablist">
            <li class="nav-item">
                <a href="{{ route('cases.dispatch.details', $case) }}" 
                   class="d-flex h-60p align-items-center nav-link {{$active=='details'?'active':''}}">Details</a>
            </li>
            <!--<li class="nav-item">
                <a href="{{ route('cases.dispatch.hospital-level', $case) }}" 
                   class="d-flex h-60p align-items-center nav-link {{$active=='hospital-level'?'active':''}}">Hospital Level</a>
            </li>-->
            <li class="nav-item">
                <a href="{{ route('cases.dispatch.hospital', $case) }}" 
                   class="d-flex h-60p align-items-center nav-link {{$active=='hospital'?'active':''}}">Hospital</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('cases.dispatch.responders', $case) }}" 
                   class="d-flex h-60p align-items-center nav-link {{$active=='responders'?'active':''}}">Responders</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('cases.dispatch.tasks', $case) }}" 
                   class="d-flex h-60p align-items-center nav-link {{$active=='tasks'?'active':''}}">Tasks</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('cases.dispatch.report', $case) }}" 
                   class="d-flex h-60p align-items-center nav-link {{$active=='report'?'active':''}}">Challenges/Comments</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('cases.dispatch.alternate-hospital', $case) }}" 
                   class="d-flex h-60p align-items-center nav-link {{$active=='alternate-hospital'?'active':''}}">Alternative Health Facility</a>
            </li>
        </ul>
    </div>	
</div>