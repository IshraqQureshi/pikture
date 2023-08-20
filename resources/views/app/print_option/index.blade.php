@extends('layouts.app')

@section('content')
<div class="container">
    <div class="searchbar mt-0 mb-4">
        <div class="row">
            <div class="col-md-12 text-right">
                @can('create', App\Models\PrintOption::class)
                <a
                    href="{{ route('print-option.create') }}"
                    class="btn btn-primary"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="display: flex; justify-content: space-between;">
                <h4 class="card-title">
                    @lang('crud.print_option.index_title')
                </h4>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless table-hover">
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.print_option.inputs.print_type')
                            </th>
                            <th class="text-left">
                                @lang('crud.print_option.inputs.paper_type')
                            </th>
                            <th class="text-left">
                                @lang('crud.print_option.inputs.packaging')
                            </th>
                            <th class="text-left">
                                @lang('crud.print_option.inputs.price')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($print_options as $option)
                        <tr>
                            <td>{{ $option->print_type ?? '-' }}</td>
                            <td>{{ $option->paper_type ?? '-' }}</td>
                            <td>{{ $option->packaging ?? '-' }}</td>
                            <td>${{ $option->price ?? '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $option)
                                    <a
                                        href="{{ route('print-option.edit', $option) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $option)
                                    <a
                                        href="{{ route('print-option.show', $option) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $option)
                                    <form
                                        action="{{ route('print-option.destroy', $option->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-light text-danger"
                                        >
                                            <i class="icon ion-md-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(function(){
        jQuery('.qrCode').each(function(){
            const qrCodeText = jQuery(this).data('url');
            const currentElement = jQuery(this)[0];
            new QRCode(currentElement, {
                text: qrCodeText,
                width: 128,
                height: 128,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        })
    })
</script>
@endsection
