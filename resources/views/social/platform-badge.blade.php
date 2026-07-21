@if($platform === 'Facebook')
    <span class="badge bg-label-primary d-inline-flex align-items-center gap-1">
        <i class="ti tabler-brand-facebook fs-6"></i> Facebook
    </span>
@elseif($platform === 'Instagram')
    <span class="badge bg-label-danger d-inline-flex align-items-center gap-1" style="background-color: rgba(234, 84, 85, 0.08) !important; color: #ff4c9f !important;">
        <i class="ti tabler-brand-instagram fs-6"></i> Instagram
    </span>
@elseif($platform === 'Twitter')
    <span class="badge bg-label-dark d-inline-flex align-items-center gap-1">
        <i class="ti tabler-brand-x fs-6"></i> Twitter / X
    </span>
@else
    <span class="badge bg-label-info d-inline-flex align-items-center gap-1">
        <i class="ti tabler-brand-linkedin fs-6"></i> LinkedIn
    </span>
@endif
