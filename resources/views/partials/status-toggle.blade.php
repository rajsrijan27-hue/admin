@props([
    'id',
    'url',
    'checked' => false,
])

<div class="form-check form-switch ms-2 d-flex align-items-center">
    <input
        type="checkbox"
        role="switch"
        class="form-check-input status-toggle p-1"
        style="width: 2.4rem; height: 1.2rem; cursor: pointer;"
        data-id="{{ $id }}"
        data-url="{{ $url }}"
        {{ $checked ? 'checked' : '' }}
        title="{{ $checked ? 'Click to set Inactive' : 'Click to set Active' }}"
    >
    <span class="ms-1 small text-muted status-toggle-label">
        {{ $checked ? 'Active' : 'Inactive' }}
    </span>
</div>
