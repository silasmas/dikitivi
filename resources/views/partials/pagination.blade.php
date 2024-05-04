
        @if ($lastPage > 1)
                        <div class="pagination-style mt-30">
                            <ul>
                                <li>
                                    <a role="button" class="prev{{ !request()->has('page') ? ' d-none' : '' }}" onclick="event.preventDefault(); window.location.replace('{{ route(\Request::route()->getName()) . (request()->has('page') || request()->get('page') == '1' ? '' : '?page=' . request()->get('page') - 1) }}');">
                                        <i class="zmdi zmdi-chevron-left"></i>
                                    </a>
                                </li>
            @for ($i = 1; $i <= $lastPage; $i++)
                                <li><a class="{{ request()->get('page') == $i ? 'active disabled' : ($i == 1  && !request()->has('page') ? 'active disabled' : '') }}" href="?page={{ $i }}">{{ $i }}</a></li>
            @endfor
                                <li>
                                    <a role="button" class="next{{ request()->get('page') == $lastPage ? ' d-none' : '' }}" onclick="event.preventDefault(); window.location.replace('{{ route(\Request::route()->getName()) . '?page=' . (request()->has('page') ? request()->get('page') + 1 : request()->get('page') + 2) }}');">
                                        <i class="zmdi zmdi-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
        @endif
