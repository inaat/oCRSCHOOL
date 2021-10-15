@if($status=='UPCOMING')
<div class="col">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
        <div class="btn-group" role="group">
            <button type="button" class="btn-badge  badge  rounded-pill text-white bg-info p-2 text-uppercase px-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">UPCOMING</button>
            <ul class="dropdown-menu">
                <li>
                <a data-href="{{action('SessionController@activateSession', [$id])}}" class="dropdown-item session_activate">Activate</a></li>

                </li>
                
            </ul>
        </div>
    </div>
</div>
@elseif($status=='ACTIVE')
<div class="col">
    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
        <div class="btn-group" role="group">
            <button type="button" class="btn badge  rounded-pill text-white bg-success p-2 text-uppercase px-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">ACTIVE</button>
            <ul class="dropdown-menu">
                <li>
                <a data-href="{{action('SessionController@activateSession', [$id])}}" class="dropdown-item session_activate">Mark Passed</a></li>

                </li>
                
            </ul>
        </div>
    </div>
</div>
@else
<div class="badge btn-badge  rounded-pill text-white bg-danger p-2 text-uppercase px-3">Passed</div>
@endif