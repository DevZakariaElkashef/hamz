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
            <a href="#" class="nav-link  rounded p-2">{{ __('main.commission') }}</a>
        </li>
    </ul>
</div>
