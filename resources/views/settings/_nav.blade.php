<div class="nav-align-left">
    <ul class="nav nav-pills flex-column border-0">
        <li class="nav-item mb-2">
            <a href="{{ route('applications.index') }}"
                class="nav-link {{ isActiveRoute('applications.index') ? ' active bg-primary text-white' : 'text-muted' }} rounded p-2">{{ __('main.General') }}</a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('abouts.index') }}" class="nav-link {{ isActiveRoute('abouts.index') ? ' active bg-primary text-white' : 'text-muted' }} rounded p-2">{{ __('main.about_us') }}</a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('terms.index') }}" class="nav-link {{ isActiveRoute('terms.index') ? ' active bg-primary text-white' : 'text-muted' }}  rounded p-2">{{ __('main.term_and_conditions') }}</a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('commission.index') }}" class="nav-link {{ isActiveRoute('commission.index') ? ' active bg-primary text-white' : 'text-muted' }} rounded p-2">{{ __('main.commission') }}</a>
        </li>
        <li class="nav-item mb-2">
            <a href="{{ route('commission_auth.index') }}" class="nav-link {{ isActiveRoute('commission_auth.index') ? ' active bg-primary text-white' : 'text-muted' }} rounded p-2">{{ __('main.commission_auth') }}</a>
        </li>
    </ul>
</div>
